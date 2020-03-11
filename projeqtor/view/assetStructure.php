<?php
use PhpOffice\PhpPresentation\Shape\Line;
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
include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';
?>
<script type="text/javascript" src="js/projeqtor.js?version=<?php echo $version.'.'.$build;?>"></script> <?php 
$id = RequestHandler::getId('id');
$obj = new Asset($id);
$currentLine = $id;

echo '<table id="assetStructure" align="left" width="100%" style="min-width:400px">';
echo '<TR class="ganttHeight" style="height:32px">';
echo '  <TD class="reportTableHeader" style="width:20%;border-left:0px; text-align: center;">' . i18n('colName') . '</TD>';
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:13%;"  ><div class="amountTableHeaderDiv">' . i18n('colAssetType') . '</div></TD>' ;
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:12%;" ><div class="amountTableHeaderDiv">' . i18n('colBrand') . '</div></TD>' ;
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:15%;" ><div class="amountTableHeaderDiv">' . i18n('colModel') . '</div></TD>' ;
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:10%;" ><div class="amountTableHeaderDiv">' . i18n('colUser') . '</div></TD>' ;
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:10%;" ><div class="amountTableHeaderDiv">' . i18n('colSerialNumber') . '</div></TD>' ;
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:10%;" ><div class="amountTableHeaderDiv">' . i18n('colInventoryNumber') . '</div></TD>' ;
echo '  <TD class="reportTableHeader amountTableHeaderTD" style="width:10%;" ><div class="amountTableHeaderDiv">' . i18n('colIdStatus') . '</div></TD>' ;
echo '</TR>';
echo '</table>';

echo '<div id="assetStructureListDiv" style="position:relative;height:600px;width:100%;min-width:400px;">';
echo '<table id="dndassetStructureList" id="dndassetStructure" align="left" width="100%" style="table-layout:fixed;">';
$parentAsset=array();
$subAsset=array();

$parentAsset=$obj->getParentAsset();
$subAsset=$obj->getRecursiveSubAsset();

$level=0;
foreach ($parentAsset as $parentId=>$parentName) {
  $level++;
  showAsset($parentId,$parentName,$level,'top');
}
$level++;
showAsset($obj->id,$obj->name,$level,'current');
showSubItems($subAsset,$level+1);


echo "</table>";
echo '</div>';

function showSubItems($subItems,$level){
  if (!$subItems) return;
  foreach ($subItems as $item) {
    showAsset($item['id'],$item['name'],$level,'sub');
    if (isset($item['subItems']) and is_array($item['subItems'])) {
      showSubItems($item['subItems'],$level+1);
    }
  }
}


function showAsset($id,$name,$level,$position) {
  global $showVersionsForAll, $showProjectsLinked, $showClosedItems, $currentLine;
  $rowType  = "row";
  $display='';
  $compStyle="";
  
  $padding=30;
  $name="#$id - $name";
  $style="";
  $current=($position=='current');
  $item=new Asset($id);
  $isElementary = $item->isElementary();
  $limitedSubAsset = array();
  if( !$isElementary) {
    $rowType = "group";
    $asset = new Asset();
    $subList = $asset->getSqlElementsFromCriteria(array('idAsset'=>$id));
    foreach ($subList as $id=>$obj){
      $limitedSubAsset[]=$obj->id;
    }
    $subBudget=array();
    getSubAssetList($subList, $subBudget);
      $class = 'ganttExpandOpened';
  }
  if($currentLine==$item->id){
    $style='background-color:#ffffaa;';
  }
  echo '<TR id="assetStructureRow_'.$item->id.'" height="40px" '.$display.'>';
  echo '  <TD class="ganttName reportTableData" style="'.$style.'width:20%;max-width:20%;border-right:0px;' . $compStyle . '">';
  echo '    <span>';
  echo '      <table><tr>';
  echo '<TD>';
  if(!$isElementary){
    echo '     <div id="group_'.$item->id.'" class="'.$class.'"';
    echo '      style="'.$style.'margin-left:'.($level*$padding).'px; position: relative; z-index: 100000;   width:16px; height:13px;"';
    echo '      onclick="expandAssetGroup(\''.$item->id.'\',\''.implode(',', $limitedSubAsset).'\',\''.implode(',', $subBudget).'\');">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
  }else{
    echo '     <div id="group_'.$item->id.'" ';
    echo '      style="'.$style.' margin-left:'.($level*$padding).'px; "position: relative; z-index: 100000; width:16px; height:13px;"';
  }
  echo '</TD>';
  echo '       <TD style="'.$style.'padding-bottom:5px;"><div class="amountTableDiv">#'.htmlEncode($item->id).'  '.htmlEncode($item->name). '</div></TD>' ;
  echo '      </tr></table>';
  echo '    </span>';
  echo '  </TD>';
  echo '  <TD class="ganttName reportTableData amountTableTD" style="'.$style.'width:13%;overflow:auto;"><div class="amountTableDiv">' .SqlList::getNameFromId('Type', $item->idAssetType). '</div></TD>' ;
  echo '  <TD class="ganttName reportTableData amountTableTD" style="'.$style.'width:12%;overflow:auto;"><div class="amountTableDiv">' .SqlList::getNameFromId('Brand', $item->idBrand). '</div></TD>' ;
  echo '  <TD class="ganttName reportTableData amountTableTD" style="'.$style.'width:15%;overflow:auto;"><div class="amountTableDiv">' .SqlList::getNameFromId('Model', $item->idModel). '</div></TD>' ;
  echo '  <TD class="ganttName reportTableData amountTableTD" style="'.$style.'width:10%;overflow:auto;"><div class="amountTableDiv">' .SqlList::getNameFromId('Affectable', $item->idAffectable). '</div></TD>' ;
  echo '  <TD class="ganttName reportTableData amountTableTD" style="'.$style.'width:10%;overflow:auto;"><div class="amountTableDiv">' .htmlEncode($item->serialNumber). '</div></TD>' ;
  echo '  <TD class="ganttName reportTableData amountTableTD" style="'.$style.'width:10%;overflow:auto;"><div class="amountTableDiv">' .htmlEncode($item->inventoryNumber). '</div></TD>' ;
  $objStatus=new Status($item->idStatus);
  echo '  <TD class="ganttName  reportTableData amountTableTD" style="width:10%;"><div style="height:100%; overflow:auto;" class="amountTableDiv">'.colorNameFormatter($objStatus->name."#split#".$objStatus->color).'</div></TD>' ;
  
  
  
}


function getSubAssetList($subList, &$subBudget){
  foreach ($subList as $id=>$obj){
    $subBudget[]=$obj->id;
    $asset = new Asset();
    $resubList = $asset->getSqlElementsFromCriteria(array('idAsset'=>$obj->id));
    getSubAssetList($resubList, $subBudget);
  }
}