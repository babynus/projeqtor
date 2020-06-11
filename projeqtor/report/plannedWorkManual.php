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
include_once('../tool/formatter.php');


$listResource = array();
$size=30;

PlannedWorkManual::setSize($size);
$headerParameters="";
$resourceId =trim(RequestHandler::getId('idResource'));
$idProject = trim(RequestHandler::getId('idProject'));
$yearSpinner= RequestHandler::getYear('yearSpinner');
$monthSpinner= RequestHandler::getMonth('monthSpinner');
$inIdTeam = trim(RequestHandler::getId('idTeam'));
$inIdOrga = trim(RequestHandler::getId('idOrganization'));
$onlyRes = false;

if ($resourceId!="") {
  $idResource = Security::checkValidId($resourceId);
}else {
  $idResource=getCurrentUserId();
}

if ($yearSpinner!="") {
  $paramYear=Security::checkValidYear($yearSpinner);
  $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
};
if ($monthSpinner!="") {
  $paramMonth=Security::checkValidMonth($monthSpinner);
  $headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
};
// Header
if ($idResource!="") {
  $headerParameters.= i18n("colIdResource") . ' : ' . htmlEncode(SqlList::getNameFromId('Affectable',$idResource)) . '<br/>';
}
if ($idProject!="") {
  $paramProject=Security::checkValidId($idProject);
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project', $paramProject)) . '<br/>';
}
if ($inIdOrga!="") {
  $paramOrga=Security::checkValidId($inIdOrga);
  $headerParameters.= i18n("colIdOrganization") . ' : ' . htmlEncode(SqlList::getNameFromId('Organization',$paramOrga)) . '<br/>';
}
if ($inIdTeam!="") {
  $paramTeam=Security::checkValidId($inIdTeam);
  $headerParameters.= i18n("colIdTeam") . ' : ' . SqlList::getNameFromId('Team', $paramTeam) . '<br/>';
}


include "header.php";

if ($resourceId and !$inIdTeam and !$inIdOrga) {
  $listResource[0] = $resourceId;
  $onlyRes = true;
}else{
  $res = new Resource();
  if(!$resourceId and $inIdTeam and !$inIdOrga){
    $listResourceObj = $res->getSqlElementsFromCriteria(array('idTeam'=>$inIdTeam,'idle'=>'0'),null,null,null,true);
  }elseif(!$resourceId and !$inIdTeam and $inIdOrga){
    $listResourceObj = $res->getSqlElementsFromCriteria(array('idOrganization'=>$inIdOrga,'idle'=>'0'),null,null,null,true);
  }elseif($resourceId and $inIdTeam and $inIdOrga){
    $listResourceObj = $res->getSqlElementsFromCriteria(array('id'=>$resourceId,'idTeam'=>$inIdTeam,'idOrganization'=>$inIdOrga,'idle'=>'0'),null,null,null,true);
  }elseif($resourceId and $inIdTeam and !$inIdOrga){
    $listResourceObj = $res->getSqlElementsFromCriteria(array('id'=>$resourceId,'idTeam'=>$inIdTeam,'idle'=>'0'),null,null,null,true);
  }elseif($resourceId and !$inIdTeam and $inIdOrga){
    $listResourceObj = $res->getSqlElementsFromCriteria(array('id'=>$resourceId,'idOrganization'=>$inIdOrga,'idle'=>'0'),null,null,null,true);
  }elseif(!$resourceId and $inIdTeam and $inIdOrga){
    $listResourceObj = $res->getSqlElementsFromCriteria(array('idTeam'=>$inIdTeam,'idOrganization'=>$inIdOrga,'idle'=>'0'),null,null,null,true);
  }
  if (isset($listResourceObj) and is_array($listResourceObj)) {
    foreach ($listResourceObj as $obj) {
      $listResource[]=$obj->id;
    }
  }
}


  echo' <table id="bodyPlanMan" name="bodyPlanMan"  style="margin-left:15px;">';
  echo'  <tr>';
  echo'    <td colspan="2">';       
                if(isset($idProject)){
                 if(trim($idProject)==''){
                    PlannedWorkManual::drawActivityTable(null,$yearSpinner.$monthSpinner,true);
                  }else{
                    PlannedWorkManual::drawActivityTable($idProject,$yearSpinner.$monthSpinner,true);
                  }
                }else{
                    PlannedWorkManual::drawActivityTable(null,$yearSpinner.$monthSpinner,true);
                }
  
  echo'    </td>';
  echo'  </tr>';
  echo'  <tr><td>';
  echo'     <div style="height:15px;">&nbsp;</div>';
  echo'  </td></tr>';
  echo'  <tr>';
  echo'    <td>';
  echo'       <div style="width:240px;">';
                  InterventionMode::drawList(true);
  echo'       </div>';
  echo'    </td>';
  echo'    <td >';
  echo'       <div style="min-width:1123px;margin-left:215px;top:20px;">';
                  $listMonth=array($yearSpinner.$monthSpinner);
                  if(!$onlyRes){
                    foreach ($listResource as $id=>$val){
                      $listResource[$id]=$val;
                    } 
                  }
                    PlannedWorkManual::drawTable('intervention',$listResource, $listMonth, null, true);
  echo'       </div>';
  echo'     </td>';
  echo'  </tr>';
  echo' </table>';
  
 ?>