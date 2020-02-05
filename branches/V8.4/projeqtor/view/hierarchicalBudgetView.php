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
$print=false;
if ( array_key_exists('print',$_REQUEST) ) {
	$print=true;
}

$accessRightRead=securityGetAccessRight('menuProject', 'read');
$imputOfAmountProvider = Parameter::getGlobalParameter('ImputOfAmountProvider');
$currency = Parameter::getGlobalParameter('currency');

$querySelect ='';
$queryFrom='';
$queryWhere='';
$queryOrderBy='';
$idTab=0;

$querySelect .= " * ";
$queryFrom .= $table;
$queryOrderBy .= " bbssortable ";

// constitute query and execute
$query='select ' . $querySelect
. ' from ' . $queryFrom
. ' order by ' . $queryOrderBy;
$result=Sql::query($query);

// Header
echo '<table id="budgetTable" dojoType="dojo.dnd.Source" align="left" width="70%" style="margin-top:1%">';
echo '<TR class="ganttHeight" style="height:32px">';
echo '  <TD class="reportTableHeader" style="width:10px; border-right: 0px;"></TD>';
echo '  <TD class="reportTableHeader" style="width:200px; border-left:0px; text-align: left;">' . i18n('colTask') . '</TD>';
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colValidated') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colAssigned') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colReal') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colLeft') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colReassessed') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('progress') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colValidated') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colAssigned') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colReal') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colLeft') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('colReassessed') . '</TD>' ;
echo '  <TD class="reportTableHeader" style="width:50px" nowrap>' . i18n('progress') . '</TD>' ;
echo '</TR>';

// Treat each line
if (Sql::$lastQueryNbRows > 0) {
	while ($line = Sql::fetchLine($result)) {
		$line=array_change_key_case($line,CASE_LOWER);
		if($imputOfAmountProvider == 'HT'){
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
		}else if($imputOfAmountProvider == 'TCC'){
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
		if( $pGroup) {
			$rowType = "group";
			$compStyle="font-weight: bold; background: #E8E8E8 ;";
		} else {
			$rowType  = "row";
		}
		$wbs=$line['bbssortable'];
		$level=(strlen($wbs)+1)/4;
		$tab="";
		$id=$line['id'];
		for ($i=1;$i<$level;$i++) {
			$tab.='<span class="ganttSep">&nbsp;&nbsp;&nbsp;&nbsp;</span>';
		}
		echo '<TR id="budgetRow_'.$id.'" dndType="budgetHierachical" class="dojoDndItem ganttTask'.$rowType.'" height="30px" onClick="loadContent('."'objectDetail.php?objectClass=Budget&objectId=$id'".', '."'detailDiv'".','."'listForm'".')">';
		echo '  <TD class="ganttName reportTableData" style="border-right:0px;' . $compStyle . '">'.formatIcon('Budget', 16);
		if($pGroup){
		  echo     '<div id="group_'.$line['id'].'" class="ganttExpandClosed"';
		  echo      'style="position: relative; z-index: 100000; width:16px; height:13px;"';
		  echo     ' onclick="">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
		}
		echo '</TD>';
		echo '  <TD class="ganttName reportTableData" style="border-left:0px; text-align: left;' . $compStyle . '" nowrap>' . $tab . htmlEncode($line['name']) . '</TD>';
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($plannedAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($initialAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($update1Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($update2Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($update3Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($update4Amount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($actualAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($actualSubAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($usedAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($availableAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($billedAmount). '</TD>' ;
		echo '  <TD class="ganttName reportTableData" style="' . $compStyle . ';text-align:right;">' .htmlDisplayCurrency($leftAmount). '</TD>' ;
		echo '</TR>';
	}
}
echo "</table>";
?>