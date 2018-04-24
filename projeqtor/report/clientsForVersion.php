<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : Julien PAPASIAN
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
$print = false;
if (array_key_exists('print', $_REQUEST)) {
    $print = true;
    include_once('../tool/formatter.php');
}
$paramProduct = trim(RequestHandler::getId('idProduct'));
$paramProductVersion = trim(RequestHandler::getId('idProductVersion'));
$paramListTickets = RequestHandler::getBoolean('listTickets');
$paramStatus = RequestHandler::getValue('idStatus');

$crit='1=1';
// Header
$headerParameters = "";
if ($paramProduct) {
    $headerParameters.= i18n("colIdProduct") . ' : ' . htmlEncode(SqlList::getNameFromId('Product', $paramProduct)) . '<br/>';
    $crit.=' and idProduct='.Sql::fmtId($paramProduct);
}
if ($paramProductVersion) {
    $headerParameters.= i18n("colIdProductVersion") . ' : ' . htmlEncode(SqlList::getNameFromId('ProductVersion', $paramProductVersion)) . '<br/>';
    $crit.=' and idTagetProductVersion='.Sql::fmtId($paramProductVersion);
}
if ($paramListTickets) {
  $headerParameters.= i18n("colListTickets"). '<br/>';
}
if ($paramStatus) {
  $headerParameters.= i18n("colIdStatus") . ' : ';
  $cpt=0;
  $in='(0';
  foreach($paramStatus as $status) {
    if ($cpt>0) $headerParameters.=', ';
    $headerParameters.=htmlEncode(SqlList::getNameFromId('Status', $status));
    $in.=','.$status;
    $cpt++;
  }
  $in.=')';
  $crit.=' and idStatus in '.$in;
  $headerParameters.='<br/>';
}
if (! $paramProduct && ! $paramProductVersion) {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n('messageNoData',array(i18n('Product').' / '.i18n('ProductVersion'))); 
    echo '</div>';
    exit;
}

$outMode=RequestHandler::getValue('outMode',false,'html');

if ($outMode == 'csv') {
    include_once "headerFunctions.php";
} else {
    include "header.php";
}

$ticket = new Ticket();
$other=new OtherClient();
$lstTicket=$ticket->getSqlElementsFromCriteria(null, false, $crit, 'id', true);

if (checkNoData($lstTicket))     exit;

$arrayClient=array();

foreach($lstTicket as $ticket) {
  if (property_exists('Ticket', 'idClient')) {
    addClient($ticket->idClient,$ticket);
    if (property_exists('Ticket', '_OtherClient')) {
      $lstOther=$other->getSqlElementsFromCriteria(array('refType'=>'Ticket','refId'=>$ticket->id));
      foreach($lstOther as $other) {
        addClient($other->idClient,$ticket);
      }
    }
  } else {
    $client=SqlList::getFieldFromId('Contact', $ticket->idContact, 'idClient');
    addClient($client,$ticket);
  }
}


function addClient($idClient,$ticket) {
  global $arrayClient;
  if (!$idTicket) return;
  
}




exit;
// Job definition
$where = getAccesRestrictionClause('JobDefinition', false);
//$where .= "and idJoblistDefinition = " . $joblist[0]->id;
$orderBy = " idJoblistDefinition ASC, sortOrder ASC";
$newjobDef = new JobDefinition();
$jobDefinitions = $newjobDef->getSqlElementsFromCriteria(null, false, $where, $orderBy);

$aDefLines = array();
$aDefLinesCount =array();
foreach ($jobDefinitions as $jobDef) {
    if (!array_key_exists($jobDef->id, $aDefLines)) {
        $aDefLines[$jobDef->id] = array('name' => $jobDef->name,
            'title' => $jobDef->title,
            'daysBeforeWarning' => $jobDef->daysBeforeWarning,
            'nbcheck' => 0,
        		'jobListId' => $jobDef->idJoblistDefinition
        );
    }
    if (!array_key_exists($jobDef->idJoblistDefinition, $aDefLinesCount)) {
    	$aDefLinesCount[$jobDef->idJoblistDefinition]=1;
    } else {
    	$aDefLinesCount[$jobDef->idJoblistDefinition]+=1;
    }
}
// Get list of checkboxes of activities
$where = getAccesRestrictionClause('Job', false);
$where .= " and refType = 'Activity' ";
//$where .= " and idJoblistDefinition = " . $joblist[0]->id;
$newJob = new Job();
$lstJobs = $newJob ->getSqlElementsFromCriteria(null, false, $where, null);
$result = array(); // Preparation of result lines
foreach ($lstJobs as $oJob) {
    $result[$oJob->refId][$oJob->idJobDefinition] = $oJob;
}
// title
if ($outMode == 'csv') {
    echo chr(239) . chr(187) . chr(191); // Microsoft Excel requirement
    echo i18n('colIdActivity') . ';';
    foreach ($aDefLines as $aLine) {
        echo htmlencode($aLine['name']) . ';';
    }
    echo i18n('sum') . ';';
    echo i18n('colComment');
    echo "\n";
} else {
    echo '<table align="center" style="width: 95%">';
    echo '<tr>';
    echo '<td class="reportTableHeader">' . i18n('Activity') . '</td>';
    foreach ($aDefLines as $aLine) {
        echo '<th class="reportTableHeader" style="width: 60px" title="' . htmlencode($aLine['title']) . '"><span>' . htmlencode($aLine['name']) . '</span></th>';
    }
    echo '<td class="reportTableHeader">' . i18n('sum') . '</td>';
    echo '<td class="reportTableHeader">' . i18n('colComment') . '</td>';
    echo '</tr>';
}

usort($lstActivity, 'compareWbs');
$status = array('done' => '#a5eda5',
    'warning' => '#edb584',
    'alert' => '#eda5a5',
    'blank' => '#FFFFFF');
$totalChecked = 0;
$nbActivitiesDone = 0;
$dToday = new DateTime();
foreach ($lstActivity as $activity) {
    if ($outMode == 'csv') {
        echo $activity->name . ';';
    } else {
        echo '<tr style="height: 30px">';
        echo '<td class="reportTableLineHeader pointer" onclick="gotoElement(\'Activity\',' . $activity->id . ');">' . htmlencode($activity->name) . '</td>';
    }
    // If there are checked boxes
    if (array_key_exists($activity->id, $result)) {
        $iCount = 0;
        foreach ($aDefLines as $sKey => $aLine) {
            if ($outMode == 'csv') {
                if (isset($result[$activity->id][$sKey])) {
                    if ($result[$activity->id][$sKey]->value) {
                        echo 'X';
                        
                        ++$iCount;
                        ++$aDefLines[$sKey]['nbcheck'];
                    } elseif (!is_null($result[$activity->id][$sKey]->creationDate)) {
                        echo htmlFormatDate(substr($result[$activity->id][$sKey]->creationDate, 0, 10));
                    }
                    echo ';';
                } else {
                    echo ';';
                }
            } else {
                $color = $status['blank'];
                $title = '';
                if (isset($result[$activity->id][$sKey])) {
                    if ($result[$activity->id][$sKey]->value) {
                        $color = $status['done'];
                        ++$iCount;
                        ++$aDefLines[$sKey]['nbcheck'];
                    } else {
                        if ($result[$activity->id][$sKey]->value) {
                            $color = $status['done'];
                        } elseif (!is_null($result[$activity->id][$sKey]->creationDate) && $result[$activity->id][$sKey]->creationDate < $dToday->format('Y-m-d')) {
                            $color = $status['alert'];
                        } elseif (!is_null($result[$activity->id][$sKey]->creationDate) && $aLine['daysBeforeWarning'] > 0) {
                            $warningDate = new DateTime($result[$activity->id][$sKey]->creationDate);
                            $warningDate->modify('-' . $aLine['daysBeforeWarning'] . ' days');
                            if ($warningDate < $dToday) {
                                $color = $status['warning'];
                            }
                        }
                    }
                    if (!is_null($result[$activity->id][$sKey]->idUser)) {
                        $title .= 'By ' . SqlList::getNameFromId('User', $result[$activity->id][$sKey]->idUser) . "\n";
                    }
                    if (isset($result[$activity->id][$sKey]) && $result[$activity->id][$sKey]->value && !is_null($result[$activity->id][$sKey]->checkTime)) {
                        $title .= 'On ' . htmlFormatDate($result[$activity->id][$sKey]->checkTime) . "\n";
                    }
                    if (!is_null($result[$activity->id][$sKey]->creationDate)) {
                        $title .= 'Due for ' . htmlFormatDate(substr($result[$activity->id][$sKey]->creationDate, 0, 10)) . "\n";
                    }
                    if (!is_null($result[$activity->id][$sKey]->comment) && !empty($result[$activity->id][$sKey]->comment)) {
                        $title .= "————————\n" . $result[$activity->id][$sKey]->comment;
                    }
                }
                echo '<td class="reportTableData" style="background-color: ' . $color . '" title="' . $title . '">' . ((isset($result[$activity->id][$sKey]) && !is_null($result[$activity->id][$sKey]->comment) && !empty($result[$activity->id][$sKey]->comment)) ? '<big>*</big>' : '&nbsp;') . '</td>';
            }
        }
        if ($outMode == 'csv') {
            echo round((($iCount / count($aDefLines)) * 100), 2) . ';';
        } else {
            echo '<td class="reportTableLineHeader" style="text-align: right">' . round((($iCount / count($aDefLines)) * 100), 2) . ' %</td>';
        }
        $totalChecked += $iCount;
        if ($iCount == count($aDefLines)) {
            ++$nbActivitiesDone;
        }
    } else {
        for ($i = 0; $i < count($aDefLines); ++$i) {
            if ($outMode == 'csv') {
                echo ';';
            } else {
                echo '<td class="reportTableData">&nbsp;</td>';
            }
        }
        if ($outMode == 'csv') {
            echo '0;';
        } else {
            echo '<td class="reportTableLineHeader" style="text-align: right">0 %</td>';
        }
    }
    if ($outMode == 'csv') {
        //echo mb_strtoupper(str_replace("\n", " / ", htmlTransformRichtextToPlaintext($activity->description, 'UTF-8')));
        echo formatAnyTextToPlainText(html_entity_decode($activity->description));
        echo "\n";
    } else {
        //echo '<td class="reportTableLineHeader">' . mb_strtoupper($activity->description, 'UTF-8') . '</td>';
      echo '<td class="reportTableLineHeader">' . $activity->description . '</td>';
        echo '</tr>';
    }
}
if ($outMode == 'csv') {
    echo i18n('sum') . ';';
    foreach ($aDefLines as $aLine) {
        echo round((($aLine['nbcheck'] / count($lstActivity)) * 100), 2) . ';';
    }
    echo round((($totalChecked / (count($aDefLines) * count($lstActivity))) * 100), 2) . ';';
    echo $nbActivitiesDone . ' / ' . count($lstActivity) . ' done';
} else {
    echo '<tr><td class="reportTableHeader">' . i18n('sum') . '</td>';
    foreach ($aDefLines as $aLine) {
        echo '<td class="reportTableHeader">' . round((($aLine['nbcheck'] / count($lstActivity)) * 100), 2) . ' %</td>';
    }
    if (count($aDefLines) and count($lstActivity)) {
      $tot=round((($totalChecked / (count($aDefLines) * count($lstActivity))) * 100), 2);
    } else {
    	$tot='';
    }
    echo '<td class="reportTableHeader">' . $tot . ' %</td>';
    echo '<td class="reportTableHeader">' . $nbActivitiesDone . ' / ' . count($lstActivity) . ' done</td></tr>';
    echo '</table>';
}

// FUNCTIONS
function compareWbs($a, $b) {
	return version_compare($a->ActivityPlanningElement->wbs, $b->ActivityPlanningElement->wbs);
}