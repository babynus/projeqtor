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

$historyTable = RequestHandler::getValue('historyTable');
$defaultMenu = RequestHandler::getValue('menuFilter');
$nbSkipMenu = RequestHandler::getValue('nbSkipMenu');
if(!$nbSkipMenu)$nbSkipMenu=0;
$idRow = Parameter::getUserParameter('idFavoriteRow');
$nbFavoriteRow=5;
?>
<table>
  <tr dojoType="dojo.dnd.Source" id="menuBarDndSource" jsId="menuBarDndSource" dndType="menuBar">
   <input type="hidden" id="idFavoriteRow" name="idFavoriteRow" value="<?php echo $idRow;?>">
   <div style="height:100%;width:100%;position:absolute;top:0px;" onWheel="wheelFavoriteRow(<?php echo $idRow;?>, event, <?php echo $nbFavoriteRow;?>);"></div>
   <?php Menu::drawAllNewGuiMenus($defaultMenu, $historyTable, $nbSkipMenu, $idRow, false);?>
  </tr>
</table>
