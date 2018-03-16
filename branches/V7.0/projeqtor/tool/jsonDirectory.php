<?PHP
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

/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projeqtor.php"; 
    scriptLog('   ->/tool/jsonList.php');
    echo '{"identifier":"id",' ;
    echo 'label: "name",';
    echo ' "items":[';
    
    $arrayDir=getSubdirectories(null);
    debugLog($arrayDir);
    displayDirectories($arrayDir,0);
    echo ' ] }';
    
    function getSubdirectories($id) {
      $result=array();
    	$dirParent=new DocumentDirectory($id);
    	$dirList=$dirParent->getSqlElementsFromCriteria(array('idDocumentDirectory'=>$id),false,null,'location asc');
    	$id=($id)?$id:0;
    	$show=false;
    	if ($dirParent->idProject==null) {
    	  $show=true;
    	} else {
    	  $doc=new Document();
    	  $doc->id=1;
    	  $doc->idProject=$dirParent->idProject;
    	  $right=securityGetAccessRightYesNo('menuDocument','read',$doc);
    	  if ($right=='YES') {
    	    $show=true;
    	    if ($dirParent->idDocumentDirectory) setParentVisibility($result,$dirParent->idDocumentDirectory,true);
    	  }
    	}
      $result[$id]=array('name'=>$dirParent->name,'show'=>$show,'children'=>array(),'parent'=>$dirParent->idDocumentDirectory);
      foreach ($dirList as $dir) {
        $result[$id]['children'][]=$dir->id;
        $result=array_merge_preserve_keys($result,getSubdirectories($dir->id));
      }   
      return $result;
    }
    
    function displayDirectories($arrayDir,$indice) {
      $nbRows=0;
      foreach ($arrayDir[$indice]['children'] as $id) {
        $dir=$arrayDir[$id];
        if ($dir['show']==false) continue;
        if ($nbRows>0) echo ', ';
        echo '{id:"' . $id . '", name:"'. str_replace('"', "''",$dir['name']). '", type:"folder"';
        echo ', children : [';
        displayDirectories($arrayDir,$id);
        echo ' ]';
        echo '}' ;
        $nbRows+=1;
      }
    }
    
    function setParentVisibility(&$arrayDir,$id,$show) {
      if (!isset($arrayDir[$id])) return;
      $arrayDir[$id]['show']=$show;
      if ($arrayDir[$id]['parent']) {
        setParentVisibility($arrayDir[$id]['parent'],$show);
      }
    }
?>
