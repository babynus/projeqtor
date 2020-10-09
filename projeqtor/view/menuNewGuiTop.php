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
 * Presents left menu of application. 
 */
  require_once "../tool/projeqtor.php";
  
$iconSize=22;
$idRow = Parameter::getUserParameter('idFavoriteRow');
if(!$idRow)$idRow=1;
$nbFavoriteRow=5;
?>
<div id="statusBarDiv" dojoType="dijit.layout.ContentPane" region="top" style="height:43px; position:absolute !important;top:30px;left:250px;border-bottom:3px solid var(--color-dark);" onWheel="switchFavoriteRow(<?php echo $idRow;?>, event, <?php echo $nbFavoriteRow;?>);">
  <div id="menuBarVisibleDiv" style="height:auto;width:auto;  top: 0px; left:248px; z-index:0;">
    <div id="contentMenuBar" class="contentMenuBar" style="width:100%;left: 0px; top:1px; overflow:hidden; z-index:0">
	    <div  name="menubarContainer" id="menubarContainer" style="height:43px;width:auto; position: relative; left:0px; overflow:hidden;z-index:0">
	      <table style="height:43px;"><tr>
	           <td>
	             <div name="menuBarButtonDiv" id="menuBarButtonDiv">
	               <table>
        	           <tr>
        	             <td style="padding-left:10px;"><?php echo formatNewGuiButton('Add', 22, true);?></td>
    	                 <td class="<?php if($defaultMenu=='menuBarCustom')echo 'imageColorNewGuiSelected';?>" id="favoriteButton" title="<?php echo i18n('Favorite');?>" style="padding-left:5px;" onclick="menuNewGuiFilter('menuBarCustom', null);"><?php echo formatNewGuiButton('Favoris', 22, true);?></td>
    	                 <td class="<?php if($defaultMenu=='menuBarRecent')echo 'imageColorNewGuiSelected';?>" id="recentButton" title="<?php echo i18n('Recent');?>" style="padding-left:5px;" onclick="menuNewGuiFilter('menuBarRecent', null);"><?php echo formatNewGuiButton('Recent', 22, true);?></td>
        	             <td><div style="padding-left:10px;vertical-align:middle;width:1px;height:22px;border-right:1px solid var(--color-dark);"></div></td>
        	           </tr>
      	           </table>    
	             </div>
	           </td>
    	       <td>
    	         <div name="menuBarListDiv" id="menuBarListDiv" dojoType="dojo.dnd.Source">
    	             <div style="height:100%;width:100%;position:absolute !important;top:0px;" onWheel="switchFavoriteRow(<?php echo $idRow;?>, event, <?php echo $nbFavoriteRow;?>);"></div>
        	         <table>
        	           <tr>
        	             <?php Menu::drawAllNewGuiMenus($defaultMenu, null, 0, $idRow);?>
        	           </tr>
        	         </table>
    	         </div>
    	       </td>
    	       <td>
    	       <div id="favoriteSwitch">
    	         <table>
      	           <tr>
      	             <td id="favoriteSwitchRow" style="top: 7px;right: 25px;position: absolute;<?php if($defaultMenu == 'menuBarRecent')echo 'display:none';?>">
         	          <table style="height:22px;width:10px">
         	            <tr><td style="font-size:12px;color: var(--color-dark);cursor:pointer;" onClick="switchFavoriteRow(<?php echo $idRow;?>, 'up', <?php echo $nbFavoriteRow;?>);" >▲</td></tr>
     	                <tr><td style="font-size:12px;color: var(--color-dark);cursor:pointer;" onClick="switchFavoriteRow(<?php echo $idRow;?>, 'down', <?php echo $nbFavoriteRow;?>);" >▼</td></tr>
         	          </table>
    	             </td>
    	             <td id="favoriteCountRow" style="top:10px;right:5px;position:absolute;color: var(--color-dark);<?php if($defaultMenu == 'menuBarRecent')echo 'display:none';?>">
    	               <div id="favoriteCountRowDiv" class="sectionBadge" style="top: 3px;width: 12px;right:0px;"><?php echo $idRow;?></div>
    	             </td>
        	       </tr>
    	         </table>
  	           </div>     
    	       <td>
    	   </tr></table>
  	    </div>
    </div>
  </div>
<button id="menuBarMoveLeft" dojoType="dijit.form.Button" showlabel="false" style="display:none"></button>
<button id="menuBarMoveRight" dojoType="dijit.form.Button" showlabel="false"  style="display:none"></button>
</div>