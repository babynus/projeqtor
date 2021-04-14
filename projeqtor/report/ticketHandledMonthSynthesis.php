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
if ($paramMonth and $paramYear) {
    $firstDay = $paramYear.'-'.$paramMonth.'-01 00:00:00';
	$lastDay = $paramYear.'-'.$paramMonth.'-'.numberOfDaysOfMonth($firstDay).' 00:00:00';
	$where.=" and ( handledDateTime>= '" . $firstDay . "' and handledDateTime<='" . $lastDay . "' )";
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
//$delay = openHourDiffTime('2021-04-09 11:30:00', '2021-04-22 16:30:00', $paramProject);
//END ADD qCazelles - graphTickets

$order="idUrgency";
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
echo '<td class="reportTableHeader" style="width:15%">'.i18n('delayHandled').'</td>';
echo '<td class="reportTableHeader" style="width:10%">'.i18n('nbNotHandled').'</td>';
echo '<td class="reportTableHeader" style="width:15%">'.i18n('delayNotHandled').'</td>';
echo '<td class="reportTableHeader" style="width:10%">'.i18n('punctualityRate').'</td>';
echo '</tr>';
$result = array();
$nbTT = 0;
$nbOk = 0;
$nbKo = 0;
foreach ($lstTicket as $ticket){
	$delay = SqlElement::getSingleSqlElementFromCriteria('TicketDelay', array('idTicketType'=>$ticket->idTicketType, 'idUrgency'=>$ticket->idUrgency, 'idProject'=>$ticket->idProject, 'idMacroTicketStatus'=>1));
	if(!$delay->id){
		$delay = SqlElement::getSingleSqlElementFromCriteria('TicketDelay', array('idTicketType'=>$ticket->idTicketType, 'idUrgency'=>$ticket->idUrgency, 'idMacroTicketStatus'=>1));
	}
	if(!$delay->id)continue;
	$delayUnit = new DelayUnit($delay->idDelayUnit);
	$delayValue = 0;
	$duration = 0;
	switch ($delayUnit->code){
		case 'HH' :
			$duration = abs(strtotime($ticket->creationDateTime)-strtotime($ticket->handledDateTime));
			$delayValue = ($duration/60)/60;
			break;
		case 'OH' :
			$duration = openHourDiffTime($ticket->creationDateTime, $ticket->handledDateTime, $ticket->idProject);
			$delayValue = $duration;
			$duration = $duration*3600;
			break;
		case 'DD' :
			$duration = abs(strtotime($ticket->creationDateTime)-strtotime($ticket->handledDateTime));
			$delayValue = (($duration/60)/60)/24;
			break;
		case 'OD' :
			$duration = openHourDiffTime($ticket->creationDateTime, $ticket->handledDateTime, $ticket->idProject);
			$delayValue = $duration/24;
			$duration = $duration*3600;
			break;
	}
	$duration = round($duration);
	$delayValue = round($delayValue, 2);
	$nbTT++;
	$result[$ticket->idTicketType][$ticket->idUrgency]['Nb']=$nbTT;
	if(isset($result[$ticket->idTicketType][$ticket->idUrgency]['durationTotal'])){
	  $result[$ticket->idTicketType][$ticket->idUrgency]['durationTotal'] += $duration;
	}else{
	  $result[$ticket->idTicketType][$ticket->idUrgency]['durationTotal'] = $duration;
	}
	if($delayValue <= $delay->value){
		$nbOk++;
		if(isset($result[$ticket->idTicketType][$ticket->idUrgency]['durationOK'])){
		  $result[$ticket->idTicketType][$ticket->idUrgency]['durationOK'] += $duration;
		}else{
		  $result[$ticket->idTicketType][$ticket->idUrgency]['durationOK'] = $duration;
		}
	}else{
		$nbKo++;
	if(isset($result[$ticket->idTicketType][$ticket->idUrgency]['durationKO'])){
		  $result[$ticket->idTicketType][$ticket->idUrgency]['durationKO'] += $duration;
		}else{
		  $result[$ticket->idTicketType][$ticket->idUrgency]['durationKO'] = $duration;
		}
	}
	$result[$ticket->idTicketType][$ticket->idUrgency]['OK']=$nbOk;
	$result[$ticket->idTicketType][$ticket->idUrgency]['KO']=$nbKo;
}
foreach ($lstUrgency as $urgency){
  foreach ($lstTicketType as $type){
    echo '<tr>';
    echo '<td class="reportTableData" style="width:20%">'.$type->name.'</td>';
    echo '<td class="reportTableData" style="width:15%">'.$urgency->name.'</td>';
    $OK = (isset($result[$type->id][$urgency->id]['OK']))?$result[$type->id][$urgency->id]['OK']:0;
    echo '<td class="reportTableData" style="width:10%">'.$OK.'</td>';
    $durationOK = (isset($result[$type->id][$urgency->id]['durationOK']))?$result[$type->id][$urgency->id]['durationOK']:0;
    if($durationOK)$durationOK = $durationOK/$OK;
    $startDate = new DateTime(date("Y-m-d H:i:s"));
    $endDate = new DateTime(date("Y-m-d H:i:s", strtotime("+$durationOK seconds")));
    $durationOK = date_diff($startDate, $endDate, true);
    $durationDisplay = '';
    if($durationOK->y){
    	$durationDisplay .= $durationOK->format('%y').i18n('shortYear').' ';
    }
    if($durationOK->m){
    	$durationDisplay .= $durationOK->format('%m').i18n('shortMonth').' ';
    }
    if($durationOK->d){
    	$durationDisplay .= $durationOK->format('%d').i18n('shortDay').' ';
    }
    if($durationOK->h){
    	$durationDisplay .= $durationOK->format('%h').i18n('shortHour').' ';
    }
    if($durationOK->i){
    	$durationDisplay .= $durationOK->format('%i').i18n('shortMinute').' ';
    }
    echo '<td class="reportTableData" style="width:15%">'.$durationDisplay.'</td>';
    $KO = (isset($result[$type->id][$urgency->id]['KO']))?$result[$type->id][$urgency->id]['KO']:0;
    echo '<td class="reportTableData" style="width:10%">'.$KO.'</td>';
    $durationKO = (isset($result[$type->id][$urgency->id]['durationKO']))?$result[$type->id][$urgency->id]['durationKO']:0;
    if($durationKO)$durationKO = $durationKO/$KO;
    $startDate = new DateTime(date("Y-m-d H:i:s"));
    $endDate = new DateTime(date("Y-m-d H:i:s", strtotime("+$durationKO seconds")));
    $durationKO = date_diff($startDate, $endDate, true);
    $durationDisplay = '';
    if($durationKO->y){
    	$durationDisplay .= $durationKO->format('%y').i18n('shortYear').' ';
    }
    if($durationKO->m){
    	$durationDisplay .= $durationKO->format('%m').i18n('shortMonth').' ';
    }
    if($durationKO->d){
    	$durationDisplay .= $durationKO->format('%d').i18n('shortDay').' ';
    }
    if($durationKO->h){
    	$durationDisplay .= $durationKO->format('%h').i18n('shortHour').' ';
    }
    if($durationKO->i){
    	$durationDisplay .= $durationKO->format('%i').i18n('shortMinute').' ';
    }
    echo '<td class="reportTableData" style="width:15%">'.$durationDisplay.'</td>';
    $ponctuality = 0;
    $NB = (isset($result[$type->id][$urgency->id]['Nb']))?$result[$type->id][$urgency->id]['Nb']:0;
    if($OK)$ponctuality = ($OK/$NB)*100;
    echo '<td class="reportTableData" style="width:10%">'.$ponctuality.' %</td>';
    echo '</tr>';
  }
}
echo '</table>';