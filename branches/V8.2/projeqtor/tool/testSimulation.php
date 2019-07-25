<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

require_once "../tool/projeqtor.php";
//Parameter
$idResource = RequestHandler::getId('idResource');


$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$newPwd = substr( str_shuffle( $chars ), 0, 6);

//test creation ligne 
$requestedDate = date('Y-m-d H:i:s');

Sql::beginTransaction();
$dataCloning = new DataCloning();
$dataCloning->versionCode = $version;
$dataCloning->idResource = $idResource;
$dataCloning->requestedDate = $requestedDate;
$dataCloning->calculNextTime();
$dataCloning->name = $newPwd;
//end test 

//COPY FOLDER and CODE
// si origine  alors changer le dossier 
$dir_source = '../../projeqtorV8.2';
$dir_dest = '../../projeqtorV8.2/simulation/'.$newPwd;

$dataCloning->$nameDir;
$dataCloning->save();
Sql::commitTransaction();

//create folder
mkdir($dir_dest, 0777,true);

$dir_iterator = new RecursiveDirectoryIterator($dir_source, RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

// SplFileInfo::getPerms verifier les droits

// tool/parameterlocation
$exceptionPath = array(".settings","simulation",".svn","deploy","test",".externalToolBuilders","api","db","manual","attach","cron","documents","import","logs","\files\report");
$exceptionFile = array("simulation","deploy","test","api","db","manual");
foreach($iterator as $element){
    //parameter php 
    if($element->getBasename()=="parameters.php" AND (str_replace("plugin", '', $element->getPath()) == $element->getPath()) AND (str_replace("simulation", '', $element->getPath()) == $element->getPath())){
      $parameterPhp  = $dir_dest . DIRECTORY_SEPARATOR . str_replace("parameters.php", "parameters_".$newPwd.".php",$iterator->getSubPathName());
      copy($element,$parameterPhp);
      //modifier le nom de la bd
      $parameterPhp2 = "../".str_replace("parameters.php", "parameters_".$newPwd.".php",$iterator->getSubPathName());
      $paramContext = file_get_contents($parameterPhp);
      $paramContext = str_replace($paramDbName,$newPwd, $paramContext);
      $paramContext .= "\n";
      $paramContext .= '$simuIndex="'.$newPwd.'";';
      file_put_contents($parameterPhp, $paramContext);
      continue;
    }
    //exception
    if((str_replace($exceptionPath, '', $element->getPath()) != $element->getPath()) OR (substr($element->getBasename(),0,1)==".") OR (in_array($element->getBasename(), $exceptionFile)) ){
      continue;
    }
    //end exception
    if($element->isDir()){
      mkdir($dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
    } else{
      if(($element->getBasename()=="parametersLocation.php")){
        $paramLocation =  $dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
      }
      copy($element, $dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
    }
}

//Param Location
kill($paramLocation);
if (! writeFile(' ',$paramLocation)) {
  showError("impossible to write \'$paramLocation\' file, cannot write to such a file : check access rights");
}
kill($paramLocation);
writeFile('<?php ' . "\n", $paramLocation);
writeFile('$parametersLocation = \'' . $parameterPhp2 . '\';', $paramLocation);

//BD
$newPwd = 'simu_'.$newPwd;
//connexion
// if (origin){  
//  connectTestSimu(simu_origin)
//}else{
$PDO=Sql::getConnection();
//}
//creer la DB
$requete= "CREATE DATABASE IF NOT EXISTS `".$newPwd."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
$PDO->prepare($requete)->execute();
$sql = 'SHOW TABLE STATUS';
$result_tables = $PDO->query($sql);
$sql = "";

//Connect new bd
$connexion = connectTestSimu($newPwd);
// sla
$exceptionTable = array("alert","attachment","audit","auditsummary","cronautosendreport","cronexecution","datacloning","history","kpihistory"
                        ,"kpivalue","language","mail","mailtosend","message","messagelegal","messagelegalfollowup","notification","notificationdefinition"
                        ,"projecthistory","statusmail","subscription","translationaccessright","translationcode","translationlanguage","translationvalue");
$test= true;
if($test){
  foreach($result_tables as $row) {
      // CREATE ..
      $result_create = $PDO->query('SHOW CREATE TABLE `'. $row['Name'] .'`');
      foreach ($result_create as $row){
        $obj_create = $row;
        $sql .= $obj_create['Create Table'] .";\n";
      }
      if($sql){
        $connexion->prepare($sql)->execute();
        $sql = "";
      }

      if(str_replace($exceptionTable,'',$row[0]) != $row[0]){
        continue;
      }
      // INSERT ...
      $sqlInsert = "";
      $result_insert = $PDO->query('SELECT * FROM `'. $row[0] .'`');
      //$sql .= "\n";
      $cpt = 0;
      
      foreach ($result_insert as $rowInsert){
        $cpt++;
        $virgule = false;
        $sqlInsert .= 'INSERT INTO `'. $row[0] .'` VALUES (';
        foreach($rowInsert as $fld=>$val) {
          if(is_numeric($fld))continue;
          $sqlInsert .= ($virgule ? ',' : '');
          if(is_null($val)) {
            $sqlInsert .= 'NULL';
          } else {
            $sqlInsert .= '\''. insert_clean($val) . '\'';
          }
          $virgule = true;
        } // for
        $sqlInsert .= ')' .";\n";
        if($cpt > 100){
          $connexion->prepare($sqlInsert)->execute();
          $sqlInsert = "";
          $cpt = 0;
        }
      }
      
      if($sqlInsert){
        $connexion->prepare($sqlInsert)->execute();
      }
  }
}

//FONCTIONS
function connectTestSimu($dbName){
  $dbType=Parameter::getGlobalParameter('paramDbType');
  $dbHost=Parameter::getGlobalParameter('paramDbHost');
  $dbPort=Parameter::getGlobalParameter('paramDbPort');
  $dbUser=Parameter::getGlobalParameter('paramDbUser');
  $dbPassword=Parameter::getGlobalParameter('paramDbPassword');
  //$dbName=Parameter::getGlobalParameter('paramDbName');

  if ($dbType != "mysql" and $dbType != "pgsql") {
    $logLevel=Parameter::getGlobalParameter('logLevel');
    if ($logLevel>=3) {
      echo htmlGetErrorMessage("SQL ERROR : Database type unknown '" . $dbType . "' \n");
    } else {
      echo htmlGetErrorMessage("SQL ERROR : Database type unknown");
    }
    errorLog("SQL ERROR : Database type unknown '" . $dbType . "'");
    $lastConnectError="TYPE";
    exit;
  }
  enableCatchErrors();
  if ($dbType == "mysql") {
    ini_set('mysql.connect_timeout', 10);
  }
  try {
    $sslArray=array();
    $sslKey=Parameter::getGlobalParameter("SslKey");
    if($sslKey and !file_exists($sslKey)){
      traceLog("Error for SSL Key : file $sslKey do not exist");
      $sslKey=null;
    }
     
    $sslCert=Parameter::getGlobalParameter("SslCert");
    if($sslCert and !file_exists($sslCert)){
      traceLog("Error for SSL Certification : file $sslCert do not exist");
      $sslCert=null;
    }

    $sslCa=Parameter::getGlobalParameter("SslCa");
    if($sslCa and !file_exists($sslCa)){
      traceLog("Error for SSL Certification Authority : file $sslCa do not exist");
      $sslCa=null;
    }

    if($sslKey and $sslCert and $sslCa){
      $sslArray=array(
          PDO::MYSQL_ATTR_SSL_KEY  => $sslKey,
          PDO::MYSQL_ATTR_SSL_CERT => $sslCert,
          PDO::MYSQL_ATTR_SSL_CA   => $sslCa
      );
    }
    $sslArray[PDO::ATTR_ERRMODE]=PDO::ERRMODE_SILENT;
    $dsn = $dbType.':host='.$dbHost.';port='.$dbPort.';dbname='.$dbName;
    $connexion = new PDO($dsn, $dbUser, $dbPassword, $sslArray);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($dbType == "mysql" and isset($enforceUTF8) and $enforceUTF8) {
      $connexion->query("SET NAMES utf8");
    }
  }catch (PDOException $e) {
    echo htmlGetErrorMessage($e->getMessage( )).'<br />';
  }
  if ($dbType == "mysql") {
    ini_set('mysql.connect_timeout', 60);
  }
  disableCatchErrors();
  $lastConnectError=NULL;
  return $connexion;
}

function insert_clean($string) {
  // Ne pas changer l'ordre du tableau !!!
  $s1 = array( "\\"	, "'"	, "\r", "\n", );
  $s2 = array( "\\\\"	, "''"	, '\r', '\n', );
  return str_replace($s1, $s2, $string);
}