<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
* Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
* Contributors : -
*
* This file is part of ProjeQtOr.
*
* ProjeQtOr is free software: you can redistribute it and/or modify it under
* the terms of the GNU General Public License as published by the Free
* Software Foundation, either version 3 of the License, or (at your option)
* any later version.
*
* ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
* WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
* more details.
*
* You should have received a copy of the GNU General Public License along with
* ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
*
* You can get complete code of ProjeQtOr, other resource, help and information
* about contributors at http://www.projeqtor.org
*
*** DO NOT REMOVE THIS NOTICE ************************************************/
require_once('_securityCheck.php');
class Plugin extends SqlElement {
    public $id;
    public $name;
    public $description;
    public $zipFile;
    public $isDeployed;
    public $deploymentDate;
    public $deploymentVersion;
    public $compatibilityVersion;
    public $pluginVersion;
    public $idle;
    
    function __construct() {
    }
    
    function __destruct() {
      parent::__destruct();
    }
    
    static function getFromName($name) {
      return SqlElement::getSingleSqlElementFromCriteria('Plugin', array('name'=>$name, 'idle'=>'0'));
    }
    
    public function load($file) {
      global $globalCatchErrors;
      traceLog("New plugin found : ".$file['name']);
      $this->name=str_replace('.zip','',$file['name']);
      $pos=strpos(strtolower($this->name),'_v');
      if ($pos) $this->name=substr($this->name,0,$pos);
      $this->zipFile=$file['path'];
      $plugin=$this->name;
      
      $result="OK";
      // unzip plugIn files
      $zip = new ZipArchive;
      $globalCatchErrors=true;
      $res = $zip->open($this->zipFile);
      if ($res === TRUE) {
        $res=$zip->extractTo(self::getDir());
        $zip->close();
      } 
      if ($res !== TRUE) {
        $result=i18n('pluginUnzipFail', array(self::unrelativeDir($this->zipFile), self::unrelativeDir(self::getDir()) ));
        errorLog("Plugin::load() : $result");
        return $result;
      }
      traceLog("Plugin unzipped succefully");
      
      $descriptorFileName=self::getDir()."/$plugin/pluginDescriptor.xml";
      if (! is_file($descriptorFileName)) {
        $result=i18n('pluginNoXmlDescriptor',array(self::unrelativeDir($descriptorFileName),$plugin));
        errorLog("Plugin::load() : $result");
        return $result;
      }
      $descriptorXml=file_get_contents($descriptorFileName);
      $parse = xml_parser_create();
      xml_parse_into_struct($parse, $descriptorXml, $value, $index);
      xml_parser_free($parse);
    
      foreach($value as $ind=>$prop) {
        if ($prop['tag']=='PROPERTY') {
          //print_r($prop);
          $name='plugin'.ucfirst($prop['attributes']['NAME']);
          $value=$prop['attributes']['VALUE'];
          $$name=$value;
        }
        if ($prop['tag']=='FILE') {
          if (isset($prop['attributes']) and is_array($prop['attributes'])) {
            $attr=$prop['attributes'];
            $fileName=(isset($attr['NAME']))?$attr['NAME']:null;
            $fileTarget=(isset($attr['TARGET']))?$attr['TARGET']:null;
            $fileAction=(isset($attr['ACTION']))?$attr['ACTION']:null;
            if ($fileName and $fileTarget and ($fileAction=='move' or $fileAction=='copy')) {
              $res=copy(self::getDir()."/$plugin/$fileName","$fileTarget/$fileName");
              if (! $res) {
                $result=i18n('pluginErrorCopy',array($fileName,$fileTarget,$plugin));
                errorLog("Plugin::load() : $result");
                return $result;
              } else {
                if ($fileAction=='move') {
                  $res=kill(self::getDir()."/$plugin/$fileName");
                  if (! $res) {
                    $result=i18n('pluginErrorMove',array($fileName,$plugin));
                    errorLog("Plugin::load() : $result");
                  }
                }
              }
            }
          }
        }
      }
      // TODO : check version compatibility
      $globalCatchErrors=false;
      
      if (isset($pluginName)) $this->name=$pluginName;
      if (isset($pluginDescription)) $this->description=$pluginDescription;
      if (isset($pluginVersion)) $this->pluginVersion=$pluginVersion;
      if (isset($pluginCompatibility)) $this->compatibilityVersion=$pluginCompatibility;
      
      traceLog("Plugin descriptor information :");
      traceLog(" => name : $this->name");
      traceLog(" => description : $this->description");
      traceLog(" => version : $this->pluginVersion");
      traceLog(" => compatibility : $this->compatibilityVersion");
      
      // Update database for plugIn
      if (isset($pluginSql) and $pluginSql) {
        $sqlfile=self::getDir()."/$plugin/$pluginSql";
        if (! is_file($sqlfile)) {
          $result="cannot find Sql file $sqlfile for plugin $plugin";
          errorLog("Plugin::load() : $result");
          return $result;
        }
        // Run Sql defined in Descriptor
        // !IMPORTANT! to be able to call runScrip, the calling script must include "../db/maintenanceFunctions.php"
        $nbErrors=runScript(null,$sqlfile);
        traceLog("Plugin updated database with $nbErrors errors from script $sqlfile");
        // TODO : display error and decide action (stop / continue)
        deleteDuplicate(); // Avoid dupplicate for habilitation, ....
      }
      
      // TODO : move files if needed
      
      // Delete zip
      kill($this->zipFile);
      // set previous version to idle (if exists)
      $old=self::getFromName($this->name);
      if ($old->id) {
        $old->idle=1;
        $old->save();
      }
      // Save deployment data
      $this->deploymentVersion=Parameter::getGlobalParameter('dbVersion');
      $this->deploymentDate=date('Y-m-d');
      $this->isDeployed=1;
      $this->idle=0;
      $resultSave=$this->save();
      traceLog("Plugin $plugin V".$this->pluginVersion. " completely deployed");
      if (isset($pluginReload) and $pluginReload) {
        return 'RELOAD';
      }
      return "OK";
    }
    
    static function getDir() {
      return "../plugin"; 
    }
    
    static function getZipList($oneOnlyFile=null) {
      $error='';
      $dir=self::getDir();
      if (! is_dir($dir)) {
        traceLog ("Plugin->getList() - directory '$dir' does not exist");
        $error="Plugin->getList() - directory '$dir' does not exist";
      }
      if (! $error) {
        $handle = opendir($dir);
        if (! is_resource($handle)) {
          traceLog ("Plugin->getList() - Unable to open directory '$dir' ");
          $error="Plugin->getList() - Unable to open directory '$dir' ";
        }
      } 
      $files=array();
      while (!$error and ($file = readdir($handle)) !== false) {
        if ($file == '.' || $file == '..' || $file=='index.php') {
          continue;
        }
        $filepath = ($dir == '.') ? $file : $dir . '/' . $file;
        if (is_link($filepath)) {
          continue;
        }
        if ($oneOnlyFile and $oneOnlyFile!=$file) {
          continue;
        }
        if (is_file($filepath) and strtolower(substr($file,-4))=='.zip') {
          $fileDesc=array('name'=>$file,'path'=>$filepath);
          $dt=filemtime ($filepath);
          $date=date('Y-m-d H:i',$dt);
          $fileDesc['date']=$date;
          $fileDesc['size']=filesize($filepath);
          $files[]=$fileDesc;
        }
      }
      if (! $error) closedir($handle);
      return $files;
    }
    
    public static function getActivePluginList() {
      // Retreive list from database
      $plugin=new Plugin();
      $pluginList=$plugin->getSqlElementsFromCriteria(array('idle'=>'0'));
      return $pluginList;
    }
    
    public static function getInstalledPluginNames() {
      $dir=self::getDir();
      if (! is_dir($dir)) {
        traceLog ("Plugin->getInstalledPluginNames() - directory '$dir' does not exist");
        return array();
      }
      $handle = opendir($dir);
      if (! is_resource($handle)) {
        return array();
      }
      $files=array();
      while ( ($file = readdir($handle)) !== false) {
        $filepath = ($dir == '.') ? $file : $dir . '/' . $file;
        if (is_dir($filepath)) {
          $files[]=$file;
        }
      }
      closedir($handle);
      return $files;
    } 
    
    public static function includeAllFiles () {
      $list=self::getActivePluginList();
      foreach ($list as $plugin) {
        $plugin->includeFiles();
      }
    }
    
    public function includeFiles() {
      $root=self::getDir().'/'.$this->name.'/'.$this->name;
      // Javascript
      $jsFile=$root.'.js';
      if (file_exists($jsFile)) {
        echo '<script type="text/javascript" src="'.$jsFile.'?version='.$this->pluginVersion.'" ></script>';
      }
      // CSS (style sheet)
      $cssFile=$root.'.css';
      if (file_exists($cssFile)) {
        echo '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" />';
      }
    }

    public static function unrelativeDir($dir) {
      return str_replace('../','/',$dir);
    }
}
 