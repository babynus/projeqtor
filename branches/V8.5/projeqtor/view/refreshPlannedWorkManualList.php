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
scriptLog('   ->/view/refrehPlannedWorkManualList.php'); 

$idProject = trim(RequestHandler::getId('idProjectPlannedInt'));
$yearSpinner= RequestHandler::getYear('yearPlannedWorkManual');
$monthSpinner= RequestHandler::getMonth('monthPlannedWorkManual');
$displayNothing = false;$onlyRes=false;
$listResource = array();
$resourceId = trim(RequestHandler::getId('userName'));
$inIdTeam = trim(RequestHandler::getId('idTeamPlannedWorkManual'));
$inIdOrga = trim(RequestHandler::getId('idOrganizationPlannedWorkManual'));
if ($resourceId and !$inIdTeam and !$inIdOrga) {
  $listResource[0] = $resourceId;
  $onlyRes = true;
}else{
  $res = new Resource();
  if(!$resourceId and $inIdTeam and !$inIdOrga){
    $listResource = $res->getSqlElementsFromCriteria(array('idTeam'=>$inIdTeam,'idle'=>'0'));
  }elseif(!$resourceId and !$inIdTeam and $inIdOrga){
    $listResource = $res->getSqlElementsFromCriteria(array('idOrganization'=>$inIdOrga,'idle'=>'0'));
  }elseif($resourceId and $inIdTeam and $inIdOrga){
    $listResource = $res->getSqlElementsFromCriteria(array('id'=>$resourceId,'idTeam'=>$inIdTeam,'idOrganization'=>$inIdOrga,'idle'=>'0'));
  }elseif($resourceId and $inIdTeam and !$inIdOrga){
    $listResource = $res->getSqlElementsFromCriteria(array('id'=>$resourceId,'idTeam'=>$inIdTeam,'idle'=>'0'));
  }elseif($resourceId and !$inIdTeam and $inIdOrga){
    $listResource = $res->getSqlElementsFromCriteria(array('id'=>$resourceId,'idOrganization'=>$inIdOrga,'idle'=>'0'));
  }elseif(!$resourceId and $inIdTeam and $inIdOrga){
    $listResource = $res->getSqlElementsFromCriteria(array('idTeam'=>$inIdTeam,'idOrganization'=>$inIdOrga,'idle'=>'0'));
  }else{
    $displayNothing = true;
  }
}


?>
      <div id="activityTable" name="activityTable" style="margin:20px;">
        <?php if(!$displayNothing){
                PlannedWorkManual::drawActivityTable($idProject); 
              }?>
      </div>
      <div id="plannedWorkManualInterventionDiv"  name="plannedWorkManualInterventionDiv" style="margin:20px;">
        <table>
          <tr>
            <td style="padding-right:20px;">
              <?php  
              //MODALITES
              if(!$displayNothing){
                if(!$onlyRes){
                  foreach ($listResource as $id=>$val){
                    $listResource[$id]=$val->id;
                  }
                }
                InterventionMode::drawList();
                $listMonth=array($yearSpinner.$monthSpinner);
                $size=30;
                PlannedWorkManual::setSize($size); 
               } ?>
            </td>
            <td>
              <?php //TAB RESOURCES
              if(!$displayNothing){
                PlannedWorkManual::drawTable('intervention',$listResource, $listMonth, false); 
              }?>
            </td>
          </tr>
        </table>  
      </div>
