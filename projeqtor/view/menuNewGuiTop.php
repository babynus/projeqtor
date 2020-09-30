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
<div id="statusBarDiv" dojoType="dijit.layout.ContentPane" region="top" style="height:auto; position:absolute !important;top:30px;left:250px;">
  <table width="100%">
    <tr>
      <td width="85%">
        <table width="100%">
          <!-- <tr width="50%">
            <td>   
              <div id="newGuiBarDiv" dojoType="dijit.layout.ContentPane" region="top" style="height:32px;overflow:unset;">
              <nav class="NewGuiTabBar">
               <ul class="NewGuiTabBarList" style="list-style-type: none;">
                  <li class="NewGuiTab NewGuiTabSelected"><a href="#">Favoris</a></li>
                  <li class="NewGuiTab"><a href="#">Récents</a></li>
                 <li class="NewGuiTab" style="margin-right: 10px;"><a href="#">Personnel</a></li>
                  <li class="NewGuiTab"><a href="#">Flux d'activité</a></li>
                </ul>
              </nav>
              </div>
            </td>
          </tr> -->
          <tr>
            <td width="100%">       
              <div id="menuBarVisibleDiv" style="height:32px;width:<?php echo ($cptAllMenu*56);?>px;  top: 0px; left:248px; z-index:0;padding: 0px 0px 12px 0px;border-bottom:1px solid lightgrey;">
                <div style="width: 100%;left: 0px; top:1px; overflow:hidden; z-index:0">
            	    <div name="menubarContainer" id="menubarContainer" style="width:<?php echo ($cptAllMenu*56);?>px; position: relative; left:0px; overflow:hidden;z-index:0">
            	      <table><tr>
            	       <td></td>
            	       <?php drawAllNewGuiMenus($menuList);?>
            	     </tr></table>
            	    </div>
                </div>
              </div>
            </td>
          </tr>  
        </table>
        <button id="menuBarMoveLeft" dojoType="dijit.form.Button" showlabel="false" style="display:none"></button>
        <button id="menuBarMoveRight" dojoType="dijit.form.Button" showlabel="false"  style="display:none"></button>
      </td>
    </tr>
  </table>
</div>