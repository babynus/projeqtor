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
?>
<div id="statusBarDiv" dojoType="dijit.layout.ContentPane" region="top" style="height:43px; position:absolute !important;top:30px;left:250px;border-bottom:3px solid var(--color-dark);">
  <div id="menuBarVisibleDiv" style="height:auto;width:auto;  top: 0px; left:248px; z-index:0;">
    <div style="width: 100%;left: 0px; top:1px; overflow:hidden; z-index:0">
	    <div name="menubarContainer" id="menubarContainer" style="height:43px;width:auto; position: relative; left:0px; overflow:hidden;z-index:0">
	      <table style="height:43px;"><tr>
    	       <td style="padding-left:10px;"><?php echo formatNewGuiButton('Add', 22, true);?></td>
    	       <td style="padding-left:5px;" onclick="menuNewGuiFilter('menuBarCustom');"><?php echo formatNewGuiButton('Favoris', 22, true);?></td>
    	       <td style="padding-left:5px;" onclick="menuNewGuiFilter('menuBarItem');"><?php echo formatNewGuiButton('Recent', 22, true);?></td>
    	       <td><div style="padding-left:10px;vertical-align:middle;width:1px;height:22px;border-right:1px solid var(--color-dark);"></div></td>
    	       <?php drawAllNewGuiMenus($menuList);?>
    	       <td style="top: 7px;right: 15px;position: absolute;">
       	          <table style="height:22px;width:10px">
       	            <tr><td style="font-size:11px;color: var(--color-dark);">▲</td></tr>
   	                <tr><td style="font-size:11px;color: var(--color-dark);">▼</td></tr>
       	          </table>
    	       </td>
    	   </tr></table>
  	    </div>
    </div>
  </div>
<button id="menuBarMoveLeft" dojoType="dijit.form.Button" showlabel="false" style="display:none"></button>
<button id="menuBarMoveRight" dojoType="dijit.form.Button" showlabel="false"  style="display:none"></button>
</div>