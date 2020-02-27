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
require_once "../tool/projeqtor.php";
include_once('../tool/formatter.php');
scriptLog('   ->/view/hierarchicalBudgetView.php');

$objectClass='Budget';
$obj=new $objectClass();
$table=$obj->getDatabaseTableName();
$hiddenRow = array();

if ( array_key_exists('print',$_REQUEST) ) {
	$print=true;
}


$showFullAmount = false;
if(sessionValueExists('showFullAmount')){
  $amount = getSessionValue('showFullAmount');
  if($amount=='true'){
  	$showFullAmount = true;
  }else{
  	$showFullAmount=false;
  }
}else{
  $amount = Parameter::getGlobalParameter('ImputOfAmountProvider');
  if($amount == 'HT'){
  	$showFullAmount=false;
  }else{
  	$showFullAmount=true;
  }
}

$currency = Parameter::getGlobalParameter('currency');

$querySelect ='';
$queryFrom='';
$queryWhere='';
$queryOrderBy='';
$idTab=0;

$querySelect .= " * ";
$queryFrom .= $table;
//$queryWhere='idBudget is Null';
$queryOrderBy .= " bbssortable ";

// constitute query and execute
$query='select ' . $querySelect
. ' from ' . $queryFrom
//. ' where ' . $queryWhere
. ' order by ' . $queryOrderBy;
$result=Sql::query($query);

// Header
echo '<table id="dndHierarchicalBudgetList" dojoType="dojo.dnd.Source" jsId="dndSourceTableBudget" id="dndSourceTableBudget" align="left" width="100%" style="">';
echo '<TR class="ganttHeight" style="height:32px">';
echo '  <TD class="reportTableHeader" style="width:10px; border-right: 0px;"></TD>';
echo '  <TD class="reportTableHeader" style="border-left:0px; text-align: left;">' . i18n('colBudget') . '</TD>';
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colEstimateAmount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colInitialAmount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colUpdate1Amount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colUpdate2Amount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colUpdate3Amount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colUpdate4Amount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colUpdatedAmount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colEngagedAmount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colAvailableAmount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colBilledAmount') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:90px" nowrap>' . i18n('colLeftAmount') . '</TD>' ;
echo '</TR>';

function getSubBudgetList($subList, &$subBudget){
	foreach ($subList as $id=>$obj){
      $subBudget[]=$obj->id;
      $budget = new Budget();
      $resubList = $budget->getSqlElementsFromCriteria(array('idBudget'=>$obj->id));
      getSubBudgetList($resubList, $subBudget);
	}
}

function getVisibleRowList($idBudget, $subList, &$visibleRow){
	foreach ($subList as $id=>$obj){
		$col = SqlElement::getSingleSqlElementFromCriteria('Collapsed', array('scope'=>'hierarchicalBudgetRow_'.$obj->id, 'idUser'=>getCurrentUserId()));
		$colParent = SqlElement::getSingleSqlElementFromCriteria('Collapsed', array('scope'=>'hierarchicalBudgetRow_'.$obj->idBudget, 'idUser'=>getCurrentUserId()));
		if(!$colParent->id and $idBudget == $obj->idBudget){
      	   $visibleRow[$obj->id]=$obj->id;
      	   $resubList = $obj->getSqlElementsFromCriteria(array('idBudget'=>$obj->id));
      	   getVisibleRowList($idBudget, $resubList, $visibleRow);
		}else if(!$colParent->id and $idBudget != $obj->idBudget){
	  	   $visibleRow[$obj->id]=$obj->id;
		}else{
		  continue;
		}
	}
}
// Treat each line
if (Sql::$lastQueryNbRows > 0) {
	while ($line = Sql::fetchLine($result)) {
		$line=array_change_key_case($line,CASE_LOWER);
		if(!$showFullAmount){
		  $plannedAmount=$line['plannedamount'];
		  $initialAmount=$line['initialamount'];
		  $update1Amount=$line['update1amount'];
		  $update2Amount=$line['update2amount'];
		  $update3Amount=$line['update3amount'];
		  $update4Amount=$line['update4amount'];
		  $actualAmount=$line['actualamount'];
		  $actualSubAmount=$line['actualsubamount'];
		  $usedAmount=$line['usedamount'];
		  $availableAmount=$line['availableamount'];
		  $billedAmount=$line['billedamount'];
		  $leftAmount=$line['leftamount'];
		}else {
		  $plannedAmount=$line['plannedfullamount'];
		  $initialAmount=$line['initialfullamount'];
		  $update1Amount=$line['update1fullamount'];
		  $update2Amount=$line['update2fullamount'];
		  $update3Amount=$line['update3fullamount'];
		  $update4Amount=$line['update4fullamount'];
		  $actualAmount=$line['actualfullamount'];
		  $actualSubAmount=$line['actualsubfullamount'];
		  $usedAmount=$line['usedfullamount'];
		  $availableAmount=$line['availablefullamount'];
		  $billedAmount=$line['billedfullamount'];
		  $leftAmount=$line['leftfullamount'];
		}

		// pGroup : is the tack a group one ?
		$pGroup=($line['elementary']=='0')?1:0;
		$compStyle="";
		$visibleRow = array();
		$limitedSubBudget = array();
		if( $pGroup) {
			$rowType = "group";
			$compStyle="font-weight: bold; background: #E8E8E8 ;";
			$budget = new Budget();
			$subList = $budget->getSqlElementsFromCriteria(array('idBudget'=>$line['id']));
			foreach ($subList as $id=>$obj){
				$limitedSubBudget[]=$obj->id;
			}
			$subBudget=array();
			getSubBudgetList($subList, $subBudget);
			getVisibleRowList($line['id'], $subList, $visibleRow);
			$crit=array('scope'=>'hierarchicalBudgetRow_'.$line['id'], 'idUser'=>getCurrentUserId());
			$col=SqlElement::getSingleSqlElementFromCriteria('Collapsed', $crit);
			if($col->id){
				$class = 'ganttExpandClosed';
    			if(!$line['idbudget']){
    			  $hiddenRow[$line['id']]=$line['id'];
    			}
			}else{
				$class = 'ganttExpandOpened';
			}
		} else {
			$rowType  = "row";
			if(!$line['idbudget']){
			  $hiddenRow[$line['id']]=$line['id'];
			}
		}
		$hiddenRow = array_merge($hiddenRow, $visibleRow);
		$wbs=$line['bbssortable'];
		$level=(strlen($wbs)+1)/4;
		$tab="";
		$id=$line['id'];
		for ($i=1;$i<$level;$i++) {
			$tab.='<span class="ganttSep">&nbsp;&nbsp;&nbsp;&nbsp;</span>';
		}
		$display='';
		if($line['idbudget'] and !in_array($line['id'], $hiddenRow)){
		  $display='style="visibility:collapse"';
		}
		echo '<TR id="hierarchicalBudgetRow_'.$id.'" dndType="budgetHierachical" class="dojoDndItem ganttTask'.$rowType.'" height="30px" '.$display.'>';
		echo '  <TD class="ganttName reportTableData" style="border-right:0px;' . $compStyle . '">';
		echo '  <span class="dojoDndHandle handleCursor">';
		echo '  <table><tr>';
		echo '  <td class="ganttIconBackground">';
		echo    formatIcon('Budget', '16');
		echo '  </td>';
		echo '  <td><img style="margin-right:2px;width:8px" src="css/images/iconDrag.gif" /></td>';
		echo '  </tr></table>';
		echo '  </span>';
		echo '</TD>';
		echo '  <TD class="ganttName reportTableData" style="border-left:0px; text-align: left;' . $compStyle . '" nowrap>';
		echo '<div class="ganttLeftHover" style="width:100%;" onClick="dojo.byId('."'objectId'".').value='.$id.';loadContent('."'objectDetail.php'".', '."'detailDiv'".','."'listForm'".');"></div>';
		echo '  <table><tr>';
		echo '  <td>';
		if($pGroup){
			echo     '<div id="group_'.$line['id'].'" class="'.$class.'"';
			echo      'style="position: relative; z-index: 100000; width:16px; height:13px;"';
			echo     ' onclick="expandHierarchicalBudgetGroup(\''.$line['id'].'\',\''.implode(',', $limitedSubBudget).'\',\''.implode(',', $subBudget).'\',\''.implode(',', $visibleRow).'\');">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
		}
		echo '  </td>';
		echo '  <td>'.$tab . htmlEncode($line['name']).'</td>';
		echo '  <tr></table>';
		echo '</TD>';
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($plannedAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($initialAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($update1Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($update2Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($update3Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($update4Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($actualAmount). '</TD>' ;
		//echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($actualSubAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($usedAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($availableAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($billedAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;padding-right:5px">' .htmlDisplayCurrency($leftAmount). '</TD>' ;
		echo '</TR>';
	}
}
echo "</table>";
?>