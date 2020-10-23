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
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/refreshMenuBarList.php');

$defaultMenu = RequestHandler::getValue('menuFilter');
$idRow = Parameter::getUserParameter('idFavoriteRow');

?>
<div id="anotherMenubarList" name="anotherMenubarList" style="width:90%;position:absolute !important;z-index:9999999;left:113px;">
<?php 
$top = 20; 
for($i=1; $i<=5; $i++){
  $idDiv = "menuBarDndSource$i";
  $idInput = "idFavoriteRow$i";?>
  <div id="<?php echo 'anotherBar'.$i;?>" class="anotherBar" style="margin-top: 5px;height: 43px;width:100%;border: 1px solid var(--color-dark);border-radius: 5px;background: white;
  <?php if($defaultMenu == 'menuBarCustom' and $idRow == $i)echo 'display:none;';?>">
    <input type="hidden" id="<?php echo $idInput;?>" name="<?php echo $idInput;?>" value="<?php echo $i;?>">
    <table style="width:100%;">
         <tr>
          <td class="anotherBarDiv" id="<?php echo $idDiv;?>" jsId="<?php echo $idDiv;?>" name="<?php echo $idDiv;?>" style="height: 43px;width:100%;padding-top:5px;"
          dndType="menuBar"  dojoType="dojo.dnd.Source" data-dojo-props="accept: ['menuBar']">
          <?php Menu::drawAllNewGuiMenus($defaultMenu, null, 0, $i, true);?>
            <?php if($defaultMenu == 'menuBarCustom' and $idRow != $i){ ?>
              <div class="sectionBadge" style="top:<?php echo $top;?>px;width: 12px;right:10px;"><?php echo $i;?></div>
            <?php 
                $top += 50;
              }
            ?>
          </td>
         </tr>
    </table>
    </div>
<?php }?>
</div>