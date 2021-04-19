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

$paramProject=trim(RequestHandler::getId('idProject'));
$idOrganization = trim(RequestHandler::getId('idOrganization'));
$paramTeam=trim(RequestHandler::getId('idTeam'));
$paramYear=RequestHandler::getYear('yearSpinner');
$paramStartMonth = RequestHandler::getValue('monthSpinner');
$user=getSessionUser();

// Header
$headerParameters="";

if ($paramProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project', $paramProject)) . '<br/>';
}
if ($idOrganization!="") {
  $headerParameters.= i18n("colIdOrganization") . ' : ' . htmlEncode(SqlList::getNameFromId('Organization',$idOrganization)) . '<br/>';
}
if ($paramTeam!="") {
  $headerParameters.= i18n("colIdTeam") . ' : ' . htmlEncode(SqlList::getNameFromId('Team', $paramTeam)) . '<br/>';
}
if ($paramYear!="") {
  $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
}
$headerParameters.= i18n("startMonth") . ' : ' . $paramStartMonth . '<br/>';


include "header.php";
$where=getAccesRestrictionClause('Activity',false,false,true,true);
$where='('.$where.' or idProject in '.Project::getAdminitrativeProjectList().')';
if ($paramProject!='') {
  $where.=  "and idProject in " . getVisibleProjectsList(true, $paramProject) ;
}
$where.= " and year=" . $paramYear;
$monthWhere = null;
$monthWhere .=(strlen($paramStartMonth)==1)?0:'';
$monthWhere .= $paramStartMonth;
$monthWhere = $paramYear.$monthWhere;
$where .= " and month >= ". $monthWhere; 
$order="";

//VARIABLES
$nbMonth = 13 - $paramStartMonth;
$result=array();
$projects=array();
$projectsColor=array();
$resources=array();
$capacity=array();
$workDayResource=array();
$realDays=array();
$startDate = $monthWhere;
//PLANNED WORK
$planWork=new PlannedWork();
$lstPlanWork=$planWork->getSqlElementsFromCriteria(null,false, $where, $order);
$planWork=new PlannedWork();
$lstPlanWork=$planWork->getSqlElementsFromCriteria(null,false, $where, $order);
foreach ($lstPlanWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Affectable', $work->idResource);
    $capacity[$work->idResource]=SqlList::getFieldFromId('Affectable', $work->idResource, 'capacity');
    $result[$work->idResource]=array();
    $realDays[$work->idResource]=array();
    $workDayResource[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
    $projectsColor[$work->idProject]=SqlList::getFieldFromId('Project', $work->idProject, 'color');
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource])) {
    $result[$work->idResource][$work->idProject]=array();
  }
  if (! array_key_exists($work->idProject,$realDays[$work->idResource])) {
    $realDays[$work->idResource][$work->idProject]=array();
  }
  if (! array_key_exists($work->month,$result[$work->idResource][$work->idProject])) {
    $result[$work->idResource][$work->idProject][$work->month]=0;
  }
  if (! array_key_exists($work->month,$workDayResource[$work->idResource])) {
    $workDayResource[$work->idResource][$work->month]=0;
  }
  if (! array_key_exists($work->month,$realDays[$work->idResource][$work->idProject]) ) { // Do not add planned if real exists 
    $result[$work->idResource][$work->idProject][$work->month]+=$work->work;
    $workDayResource[$work->idResource][$work->month]+=$work->work;
  } else if ($work->month>date('Ym')) {
    $result[$work->idResource][$work->idProject][$work->month]+=$work->work;
    $workDayResource[$work->idResource][$work->month]+=$work->work;
    if (isset($realDays[$work->idResource][$work->idProject][$work->month])) {
      unset($realDays[$work->idResource][$work->idProject][$work->month]);
    }
  }
}

$resultPlanned = $result;
//REAL WORK
$work=new Work();
$lstWork=$work->getSqlElementsFromCriteria(null,false, $where, $order);
foreach ($lstWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Affectable', $work->idResource);
    $capacity[$work->idResource]=SqlList::getFieldFromId('Affectable', $work->idResource, 'capacity');
    $result[$work->idResource]=array();
    $realDays[$work->idResource]=array();
    $workDayResource[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
    $projectsColor[$work->idProject]=SqlList::getFieldFromId('Project', $work->idProject, 'color');
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource])) {
    $result[$work->idResource][$work->idProject]=array();
  }
  if (! array_key_exists($work->idProject,$realDays[$work->idResource])) {
    $realDays[$work->idResource][$work->idProject]=array();
  }
  if (! array_key_exists($work->month,$result[$work->idResource][$work->idProject])) {
    $result[$work->idResource][$work->idProject][$work->month]=0;
    $realDays[$work->idResource][$work->idProject][$work->month]='real';
  } 
  if (! array_key_exists($work->month,$workDayResource[$work->idResource])) {
    $workDayResource[$work->idResource][$work->month]=0;
  }
  $result[$work->idResource][$work->idProject][$work->month]+=$work->work;
  $workDayResource[$work->idResource][$work->month]+=$work->work;
}

if (!$paramYear ) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('messageNoData',array(i18n('year'))); // TODO i18n message
  echo '</div>';
}

$plannedStyle=' style="text-align:center;" ';

echo "<table width='95%' align='center'>";
echo "<tr><td><table  width='100%' align='left'><tr>";
echo "<td class='legend'>" . Work::displayWorkUnit() . "</td>";
echo "</tr>";
echo "</table>";

// title
echo '<table width="100%" align="left">';
echo '<tr>';
echo '<td class="reportTableHeader" rowspan="2">' . i18n('Resource') . '</td>';
echo '<td class="reportTableHeader" rowspan="2">' . i18n('Project') . '</td>';
echo '<td colspan="' . ($nbMonth) . '" class="reportTableHeader">' . i18n('month')  . '</td>';
echo '<td class="reportTableHeader" rowspan="2" width=50px;>' . i18n('sum'). '</td>';
echo '<td  width="10%" rowspan="2"  class="reportTableHeader" >' . i18n('colNotPlannedWork'). '</td>';
echo '</tr>';
echo '<tr>';
$month=array();

 for($i=$paramStartMonth; $i<=12;$i++) {
   $style = "";
    echo '<td class="reportTableColumnHeader" ' . $style . '>' . $i . '</td>';
  }
  
echo '</tr>';
$globalSum=array();
for ($i=$paramStartMonth; $i<=12;$i++) {
  $globalSum[$startDate+$i-1]=0;
}
asort($resources);
if($idOrganization){
  $orga = new Organization($idOrganization);
  $listResOrg=$orga->getResourcesOfAllSubOrganizationsListAsArray();
  foreach ($resources as $idR=>$nameR){
    if(! in_array($idR, $listResOrg))unset($resources[$idR]);
  }
}
foreach ($resources as $idR=>$nameR) {
  $sumNpw=0;
    $res=new ResourceAll($idR);//florent ticket #5038
  if (!$paramTeam or $res->idTeam==$paramTeam) {
	  $sum=array();
	  for ($i=$paramStartMonth; $i<=12;$i++) {
	    $sum[$startDate+$i-1]=0;
	  }
	  echo '<tr height="20px">';
	  echo '<td class="reportTableLineHeader" style="width:100px;" rowspan="'. (count($result[$idR])+1) . '">' . htmlEncode($nameR) . '</td>';
	  $sortProject=array();
	  foreach ($result[$idR] as $id=>$name) {
	    $sortProject[SqlList::getFieldFromId('Project', $id, 'sortOrder').'#'.$id]=$name;
	  }
	  ksort($sortProject);
	  $tmpprojects=array();
	  foreach ($sortProject as $sortId=>$name) {
	    $split=explode('#', $sortId);
	    $tmpprojects[$split[1]]=$name;
	  }
	  foreach ($tmpprojects as $idP=>$proj) {
	    if (array_key_exists($idP, $projects)) {
	      echo '<td class="reportTableData" style="width:150px;text-align: left;">' . htmlEncode($projects[$idP]) . '</td>';
	      $lineSum=0;
	      for ($i=$paramStartMonth; $i<=12;$i++) {
	        $day=$startDate+$i-1;
	        $style="";
	        $ital=false;
	        echo '<td class="reportTableData" ' . $style . ' valign="top">';
	        if (array_key_exists($day,$result[$idR][$idP])) {
	          echo ($ital)?'<i>':'';
	          echo Work::displayWork($result[$idR][$idP][$day]);
	          echo ($ital)?'</i>':'';
	          $sum[$day]+=$result[$idR][$idP][$day];
	          $globalSum[$day]+=$result[$idR][$idP][$day];
	          $lineSum+=$result[$idR][$idP][$day];
	        }
	        echo '</td>';
	      }
	      echo '<td class="reportTableColumnHeader">' . Work::displayWork($lineSum) . '</td>';
	      $ass= new Assignment();
	      $crit=array('idResource'=>$idR, 'idProject'=>$idP);
	      $npw=$ass->sumSqlElementsFromCriteria('notPlannedWork',$crit);
	      $sumNpw+=$npw;
	      echo '<td class="reportTableData">'.Work::displayWork($npw).'</td>';
	      echo '</tr><tr>';
	    }
	  }
	  echo '<td class="reportTableLineHeader" >' . i18n('sum') . '</td>';
	  $lineSum=0;
	  for ($i=$paramStartMonth; $i<=12;$i++) {
	    $style='';
	    $day=$startDate+$i-1;
	    $sumDay=$sum[$startDate+$i-1];
	    $day=$startDate+$i-1;
	    $day=substr($day,0,4).'-'.substr($day,4,2).'-'.substr($day,6,2);
	    if ($res->getCapacityPeriod($day)<$sumDay) {
	      $style=' style="color:#a05050 !important;font-weight:bold"';
	    }
	    echo '<td class="reportTableColumnHeader" ' . $style . ' >' . Work::displayWork($sumDay) . '</td>';
	    $lineSum+=$sum[$startDate+$i-1];
	  	}
	  echo '<td class="reportTableHeader">' . Work::displayWork($lineSum) . '</td>';
	  echo '<td class="reportTableHeader">' . Work::displayWork($sumNpw) . '</td>';
	  echo '</tr>';
	  
  }
}

echo '<tr><td colspan="' . ($nbMonth+3) . '">&nbsp;</td></tr>';
echo '<tr><td class="reportTableHeader" colspan="2">' . i18n('sum') . '</td>';
$lineSum=0;
for ($i=$paramStartMonth; $i<=12;$i++) {
  $style='';
  echo '<td class="reportTableHeader" ' . $style . '>' . Work::displayWork($globalSum[$startDate+$i-1]) . '</td>';
  $lineSum+=$globalSum[$startDate+$i-1];
}
echo '<td class="reportTableHeader">' . Work::displayWork($lineSum) . '</td>';
echo '</tr>';
echo '</table>';
echo '</td></tr></table>';

echo '<br/><br/>';

