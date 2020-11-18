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

/* ============================================================================
 * Management of PlugIns
 */
  require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
  scriptLog('   ->/view/pluginManagement.php');
  $isIE=false;
  if (array_key_exists('isIE',$_REQUEST)) {
    $isIE=$_REQUEST['isIE'];
  }
  $user=getSessionUser();
  $idPlugin=RequestHandler::getValue('objectId');
  $urlPlugins = "http://projeqtor.org/admin/getPlugins.php";
  $currentVersion=null;
  if (ini_get('allow_url_fopen')) {
    enableCatchErrors();
    $currentVersion=file_get_contents($urlPlugins);
    disableCatchErrors();
  }
  $json = file_get_contents($urlPlugins);
  $object = json_decode($json);
  $plugins=$object->items;
  foreach ($plugins as $val){
    if($val->id==$idPlugin){
      $obj=$val;
      break;
    }
  }
?>  
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Plugin" />
<div class="container" dojoType="dijit.layout.BorderContainer">
</div>

