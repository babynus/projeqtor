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
if($defaultMenu == 'menuBarCustom'){
  $idRow = Parameter::getUserParameter('idFavoriteRow');
  $startRow = $idRow+1;
}else{
  $idRow = 1;
  $startRow = $idRow;
}

?>
<table style="width:100%;"><tr>
<td style="width:7%;">
  <div style="margin-top: 5px;height: 100%;width:100%;border: 1px solid var(--color-dark);border-radius: 5px;background: white;overflow:hidden;">
    <div></div>
  </div>
</td>
<td style="width:90%;">
<div id="anotherMenubarList" name="anotherMenubarList" style="width:100%;z-index:9999999;">
<?php
$nbFavoriteRow = 5; 
for($i=$startRow; $i<=($idRow+4); $i++){
  if($i > 5){
    $idAnotherRow = $i-5;
  }else{
    $idAnotherRow = $i;
  }
  $idDiv = "menuBarDndSource$idAnotherRow";
  $idInput = "idFavoriteRow$idAnotherRow";
  ?>
  <div id="<?php echo 'anotherBar'.$idAnotherRow;?>" class="anotherBar" style="overflow:hidden;margin-top: 5px;height: 43px;width:100%;border: 1px solid var(--color-dark);border-radius: 5px;background: white;">
    <input type="hidden" id="<?php echo $idInput;?>" name="<?php echo $idInput;?>" value="<?php echo $idAnotherRow;?>">
    <table style="width:100%;height:100%;" onWheel="wheelFavoriteRow(<?php echo $idRow;?>, event, <?php echo $nbFavoriteRow;?>);" oncontextmenu="event.preventDefault();editFavoriteRow(false);">
         <tr>
         <td style="font-weight: bold;font-size: 13pt;text-align: center;color: var(--color-dark);width: 2.5%;border-right: 1px solid var(--color-dark);">
          <?php echo $idAnotherRow; ?>
         </td>
          <td class="anotherBarDiv" id="<?php echo $idDiv;?>" jsId="<?php echo $idDiv;?>" name="<?php echo $idDiv;?>" style="height:100%;width:97.5%;"
          dndType="menuBar"  dojoType="dojo.dnd.Source" data-dojo-props="accept: ['menuBar'], horizontal: true">
          <?php Menu::drawAllNewGuiMenus('menuBarCustom', null, 0, $idAnotherRow);?>
          </td>
         </tr>
    </table>
    </div>
<?php }?>
</div>
</td>
<td style="width:3%;"></td>
</tr></table>