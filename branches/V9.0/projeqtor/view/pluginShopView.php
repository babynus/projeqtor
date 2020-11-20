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
  
  $userLang = getSessionValue('currentLocale');
  $lang = "en";
  if(substr($userLang,0,2)=="fr")$lang="fr";
  $pluginName=($lang=='fr')?$obj->nameFr:$obj->nameEn;
  $shortDec=($lang=='fr')?$obj->shortDescFr:$obj->shortDescEn;
  $longDesc=($lang=='fr')?$obj->longDescFr:$obj->longDescEn;
  $page=($lang=='fr')?$obj->pageFr:$obj->pageEn;
  $userManual=$obj->userManual;
  debugLog($obj);
?>  
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Plugin" />
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="pluginShopDiv" class="listTitle" dojoType="dijit.layout.ContentPane" region="top" style="z-index:3;overflow:visible">
        <table width="100%">
        <tr height="70px" style="vertical-align: middle;">
          <td style="text-align:center;font-size:16px;"><span class="title" style="text-decoration: underline;"><?php echo $pluginName;?>&nbsp;</span>        
          </td>
          <td width="10px" >&nbsp;
          </td>
          <td width="50px"> 
          </td>
          <td>  
          </td>
        </tr>
      </table>
  </div>
  <div dojoType="dijit.layout.ContentPane" region="center" style="overflow-y:auto;margin-top:9%;margin-left:10%;">
    <div class="container" dojoType="dijit.layout.BorderContainer">
      <div dojoType="dijit.layout.ContentPane" region="top" style="height:48px" >
        <span class="listTitle" style="font-size:14px;font-weight:bold;" ><?php echo $shortDec;?></span>
      </div>
      <div dojoType="dijit.layout.ContentPane" region="center" >
        <div class="longDescPlugin" ><?php echo $longDesc;?></div>
      </div>
      <div dojoType="dijit.layout.ContentPane" region="right" style="width:20%;text-align:center;">
       <div class="roundedVisibleButton roundedButton generalColClass" title="<?php echo('technicalDoc'); ?>" style="height:35px;width:70%;margin:20%;" onclick="directionExternalPage('<?php echo $userManual?>')">
             <div style="float:left;position: relative;padding:10px;"><span style="top:12px;"><?php echo i18n('technicalDoc');?></span></div>
             <div style="float:right;position: relative;margin-top: 2px;margin-right: 2px;" class="imageColorNewGui iconPdf iconSize32"></div>            
        </div>
        <div class="roundedVisibleButton roundedButton generalColClass" title="<?php echo('goToThePage'); ?>" style="height:35px;width:70%;margin:20%;" onclick="directionExternalPage('<?php echo $page?>')">
             <div style="float:left;position: relative;padding:10px;"><span style="top:12px;"><?php echo i18n('goToThePage');?></span></div>
             <div style="float:right;position: relative;" class="imageColorNewGui iconGoto iconSize32"></div>            
        </div>
      </div>
    </div>
  </div>
</div>

