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

include_once '../tool/projeqtor.php';
include_once "../tool/jsonFunctions.php";
//echo 'ticketReport.php';

if (! isset($includedReport)) {

	$paramYear='';
	if (array_key_exists('yearSpinner',$_REQUEST)) {
		$paramYear=$_REQUEST['yearSpinner'];
		$paramYear=Security::checkValidYear($paramYear);
	};

	$paramMonth='';
	if (array_key_exists('monthSpinner',$_REQUEST)) {
		$paramMonth=$_REQUEST['monthSpinner'];
		$paramMonth=Security::checkValidMonth($paramMonth);
	};

	$paramProject='';
	if (array_key_exists('idProject',$_REQUEST)) {
		$paramProject=trim($_REQUEST['idProject']);
		Security::checkValidId($paramProject);
	}

	$paramTicketType='';
	if (array_key_exists('idTicketType',$_REQUEST)) {
		$paramTicketType=trim($_REQUEST['idTicketType']);
		$paramTicketType = Security::checkValidId($paramTicketType); // only allow digits
	};

	$paramRequestor='';
	if (array_key_exists('requestor',$_REQUEST)) {
		$paramRequestor=trim($_REQUEST['requestor']);
		$paramRequestor = Security::checkValidId($paramRequestor); // only allow digits
	}

	$paramIssuer='';
	if (array_key_exists('issuer',$_REQUEST)) {
		$paramIssuer=trim($_REQUEST['issuer']);
		$paramIssuer = Security::checkValidId($paramIssuer); // only allow digits
	};

	$paramResponsible='';
	if (array_key_exists('responsible',$_REQUEST)) {
		$paramResponsible=trim($_REQUEST['responsible']);
		$paramResponsible = Security::checkValidId($paramResponsible); // only allow digits
	};

	$user=getSessionUser();

	$periodType="";
	$periodValue="";
	if (array_key_exists('periodType',$_REQUEST)) {
		$periodType=$_REQUEST['periodType']; // not filtering as data as data is only compared against fixed strings
		if (array_key_exists('periodValue',$_REQUEST))
		{
			$periodValue=$_REQUEST['periodValue'];
			$periodValue=Security::checkValidPeriod($periodValue);
		}
	}
	// Header
	$headerParameters="";
	if ($paramProject!="") {
		$headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project', $paramProject)) . '<br/>';
	}
	if ($periodType=='year' or $periodType=='month' or $periodType=='week') {
		$headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
	}
	//ADD qCazelles - Report fiscal year - Ticket #128
	if ($periodType=='year' and $paramMonth!="01") {
		if(!$paramMonth){
			$paramMonth="01";
		}
		$headerParameters.= i18n("startMonth") . ' : ' . i18n(date('F', mktime(0,0,0,$paramMonth,10))) . '<br/>';
	}
	//END ADD qCazelles - Report fiscal year - Ticket #128
	if ($periodType=='month') {
		$headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
	}
	if ($paramTicketType!="") {
		$headerParameters.= i18n("colIdTicketType") . ' : ' . SqlList::getNameFromId('TicketType', $paramTicketType) . '<br/>';
	}
	if ($paramRequestor!="") {
		$headerParameters.= i18n("colRequestor") . ' : ' . SqlList::getNameFromId('Contact', $paramRequestor) . '<br/>';
	}
	if ($paramIssuer!="") {
		$headerParameters.= i18n("colIssuer") . ' : ' . SqlList::getNameFromId('User', $paramIssuer) . '<br/>';
	}
	if ($paramResponsible!="") {
		$headerParameters.= i18n("colResponsible") . ' : ' . SqlList::getNameFromId('Resource', $paramResponsible) . '<br/>';
	}
	//END OF THAT
	include "header.php";
}
$where=getAccesRestrictionClause('Ticket',false);
// Adapt clause on filter
$arrayFilter=jsonGetFilterArray('Report_Ticket', false);
if (count($arrayFilter)>0) {
	$obj=new Ticket();
	$querySelect="";
	$queryFrom="";
	$queryOrderBy="";
	$idTab=0;
	jsonBuildWhereCriteria($querySelect,$queryFrom,$where,$queryOrderBy,$idTab,$arrayFilter,$obj);
}
if ($periodType=='year') {
	$startMonth=$paramMonth;
	if ($startMonth<10) $startMonth='0'.$startMonth;
	$start=$paramYear.'-'.$startMonth.'-01';
	$endMonth=$paramMonth-1;
	if ($endMonth<1) $endMonth=12;
	if ($endMonth<10) $endMonth='0'.$endMonth;
	$endYear=$paramYear;
	if ($paramMonth!=1) $endYear++;
	$end=$endYear.'-'.$endMonth.'-'.lastDayOfMonth(intval($endMonth),$endYear);
	$start.=' 00:00:00';
	$end.=' 23:59:59';
	$where.=" and ( handledDateTime>= '" . $start . "' and handledDateTime<='" . $end . "' )";
}
if ($paramProject!="") {
	$where.=" and idProject in " .  getVisibleProjectsList(false, $paramProject);
}
if ($paramTicketType!="") {
	$where.=" and idTicketType='" . Sql::fmtId($paramTicketType) . "'";
}
if ($paramRequestor!="") {
	$where.=" and idContact='" . Sql::fmtId($paramRequestor) . "'";
}
if ($paramIssuer!="") {
	$where.=" and idUser='" . Sql::fmtId($paramIssuer) . "'";
}
if ($paramResponsible!="") {
	$where.=" and idResource='" . Sql::fmtId($paramResponsible) . "'";
}

//END ADD qCazelles - graphTickets

$order="idUrgency";
//echo $where;
$ticket=new Ticket();
$lstTicket=$ticket->getSqlElementsFromCriteria(null,false, $where, $order);
$ticketType=new TicketType();
$lstTicketType = $ticketType->getSqlElementsFromCriteria(null, null, "1=1");
$urgency=new Urgency();
$lstUrgency = $urgency->getSqlElementsFromCriteria(null, null, "1=1");

echo '<table style="width:100%;text-align:center">';
echo '<tr>';
echo '<td class="reportTableHeader" style="width:20%">' . i18n('colIdTicketType') . '</td>';
echo '<td class="reportTableHeader" style="width:15%">'.i18n('colUrgency').'</td>';
echo '<td class="reportTableHeader" style="width:10%">'.i18n('nbHandled').'</td>';
echo '<td class="reportTableHeader" style="width:15%">'.i18n('delayHanlded').'</td>';
echo '<td class="reportTableHeader" style="width:10%">'.i18n('nbNotHanlded').'</td>';
echo '<td class="reportTableHeader" style="width:15%">'.i18n('delayNotHanlded').'</td>';
echo '<td class="reportTableHeader" style="width:10%">'.i18n('punctuality').'</td>';
echo '</tr>';
foreach ($lstUrgency as $urgency){
  foreach ($lstTicketType as $type){
    echo '<tr>';
    echo '<td class="reportTableData" style="width:20%">'.$type->name.'</td>';
    echo '<td class="reportTableData" style="width:15%">'.$urgency->name.'</td>';
    echo '<td class="reportTableData" style="width:10%"></td>';
    echo '<td class="reportTableData" style="width:15%"></td>';
    echo '<td class="reportTableData" style="width:10%"></td>';
    echo '<td class="reportTableData" style="width:15%"></td>';
    echo '<td class="reportTableData" style="width:10%"></td>';    
    echo '</tr>';
  }
}
echo '</table>';