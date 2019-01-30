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
require_once('_securityCheck.php');
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";

class ImputationValidation{
	public $id;
	public $idUser;
	public $idProject;

	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct($id=NULL, $withoutDependentObjects=false) {

	}
	/** ==========================================================================
	 * Destructor
	 * @return void
	 */
	function __destruct() {}
	
	static function drawUserWorkList($idUser, $idTeam){
	  $user=getCurrentUserId();
	  $resource = new User($idUser);
	  $team = new Team($idTeam);
	  $result="";
	  $imputationUnitType = Parameter::getGlobalParameter('imputationUnit');
	  $imputationUnit = substr(i18n(Parameter::getGlobalParameter('imputationUnit')),0, 1);
	  if($imputationUnitType == "hours"){
	    $dayTime = Parameter::getGlobalParameter('dayTime');
	  }
	  $userVisbileResourceList = getUserVisibleResourcesList(true);
	  $proj = new Project();
	  $listAdmProj = $proj->getAdminitrativeProjectList(true);
	  $result .='<div id="activityDiv" align="center" style="margin-top:20px; overflow-y:auto; width:100%;">';
	  $result .='<table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
	  $result .='   <tr class="reportHeader">';
	  $result .='     <td style="border: 1px solid grey;height:60px;width:16%;text-align:center;vertical-align:center;">'.i18n('Resource').'</td>';
	  $result .='     <td style="border: 1px solid grey;height:60px;width:16%;text-align:center;vertical-align:center;">'.i18n('colWeek').'</td>';
	  $result .='     <td style="border: 1px solid grey;height:60px;width:8%;text-align:center;vertical-align:center;">'.i18n('expectedWork').'</td>';
	  $result .='     <td style="width:20%;border: 1px solid grey;">';
	  $result .='      <table width="100%"><tr><td colspan="3" style="height:30px;text-align:center;vertical-align:center;">'.i18n('inputWork').'</td></tr>';
	  $result .='      <tr><td style="width:33%;height:30px;text-align:center;vertical-align:center;">'.i18n('operationel').'</td>';
	  $result .='      <td style="width:33%;height:30px;text-align:center;vertical-align:center;">'.i18n('administrative').'</td>';
	  $result .='      <td style="width:33%;height:30px;text-align:center;vertical-align:center;">'.i18n('sum').'</td></tr></table>';
	  $result .='     </td>';
	  $result .='     <td style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;">'.i18n('ImputationSubmit').'</td>';
	  $result .='     <td style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;">'.i18n('menuImputationValidation').'</td>';
	  $result .='   </tr>';
	  foreach ($userVisbileResourceList as $id=>$name){
	    $periodValue = new WorkPeriod();
	    $crit = array("idResource"=>$id);
	    $periodValueList = $periodValue->getSqlElementsFromCriteria($crit);
	    $res = new Resource($id);
	    $idCalendar = $res->idCalendarDefinition;
	    if(!$periodValueList)continue;
	    if(count($periodValueList) < 2){
	      $firstDay = date('Y-m-d', firstDayofWeek(substr($periodValueList[0]->periodValue, 4, 2),substr($periodValueList[0]->periodValue, 0, 4)));
	          $lastDay = lastDayofWeek(substr($periodValueList[0]->periodValue, 4, 2),substr($periodValueList[0]->periodValue, 0, 4));
	      $excepted = countDayDiffDates($firstDay, $lastDay, $idCalendar);
	      if($imputationUnitType == "hours"){
	        $excepted *= $dayTime; 
	      }
	      $work = new Work();
	      $crit = array('idResource'=>$id, 'week'=>$periodValueList[0]->periodValue);
        $critWorkList = $work->getSqlElementsFromCriteria($crit);
        $inputWork = 0;
        $inputAdm = 0;
        if($critWorkList){
        	foreach ($critWorkList as $critWork){
        		if (isset($listAdmProj[$critWork->idProject])) {
        			$inputAdm += $critWork->work;
        		}else{
        			$inputWork += $critWork->work;
        		}
        	}
        }
        if($imputationUnitType == "hours"){
        	$inputWork *= $dayTime;
        	$inputAdm *= $dayTime;
        }
	      $inputTotal = $inputWork + $inputAdm;
	      $backgroundColor = "background-color:#ff7777;";
	      if($inputTotal == $excepted)$backgroundColor = "background-color:#77ff77;";
	      $result .='   <tr>';
	      $result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:left;vertical-align:center;">';
	      $result .='     <table width="100%">';
	      $result .='       <tr><td width="40%">'.formatUserThumb($id, $name, null, 22, 'right').'</td>';
	      $result .='       <td width="60%" float="left">&nbsp'.$name.'</td></tr>';
	      $result .='     </table></td>';
	      $result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:center;vertical-align:center;">'.$periodValueList[0]->periodValue.'</td>';
	      $result .='     <td style="border: 1px solid grey;height:30px;width:8%;text-align:center;vertical-align:center;">'.$excepted.$imputationUnit.'</td>';
	      $result .='     <td style="width:20%;border: 1px solid grey;">';
    	  $result .='      <table width="100%">';
    	  $result .='        <tr><td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputWork.$imputationUnit.'</td>';
    	  $result .='        <td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputAdm.$imputationUnit.'</td>';
    	  $result .='        <td style="'.$backgroundColor.'width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputTotal.$imputationUnit.'</td></tr>';
    	  $result .='      </table>';
    	  $result .='     </td>';
    	  if($periodValueList[0]->submitted){
    	    $result .='   <td style="border: 1px solid grey;height:30px;width:20%;text-align:center;vertical-align:center;">';
    	    $result .='     <table width="100%"><tr><td style="width:5%;height:30px;">'.formatIcon('Submitted', 32, i18n('submittedWork', array($name, $periodValueList[0]->submittedDate))).'</td>';
    	    $result .='     <td style="width:61%;height:30px;">'.i18n('submittedWork', array($name, $periodValueList[0]->submittedDate)).'</td>';
    	    $result .='     <td style="width:34%;height:30px;">';
	        $result .='      <span id="buttonValid'.$periodValueList[0]->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
                  . '       <script type="dojo/method" event="onClick" >'
                  . '        '
                  . '       </script>'
                  . '     </span>';
        	$result .='     </td></tr></table></td>';
        }else{
        	$result .='   <td style="border: 1px solid grey;height:30px;width:20%;text-align:center;vertical-align:center;">';
        	$result .='     <table width="100%"><tr><td style="height:30px;width:10%;">'.formatIcon('Unsubmitted', 32, i18n('unsubmittedWork')).'</td>';
        	$result .='     <td style="height:30px;width:90%;">'.i18n('unsubmittedWork').'&nbsp'.$periodValueList[0]->submittedDate.'</td></tr></table></td>';
        }
	      $result .='   </tr>';
	    }else{
	      $firstDay = date('Y-m-d', firstDayofWeek(substr($periodValueList[0]->periodValue, 4, 2),substr($periodValueList[0]->periodValue, 0, 4)));
        $lastDay = lastDayofWeek(substr($periodValueList[0]->periodValue, 4, 2),substr($periodValueList[0]->periodValue, 0, 4));
	      $excepted = countDayDiffDates($firstDay, $lastDay, $idCalendar);
	      if($imputationUnitType == "hours"){
	      	$excepted *= $dayTime;
	      }
	      $work = new Work();
	      $crit = array('idResource'=>$id, 'week'=>$periodValueList[0]->periodValue);
        $critWorkList = $work->getSqlElementsFromCriteria($crit);
        $inputWork = 0;
        $inputAdm = 0;
        if($critWorkList){
          foreach ($critWorkList as $critWork){
      			if (isset($listAdmProj[$critWork->idProject])) {
      				$inputAdm += $critWork->work;
      			}else{
      				$inputWork += $critWork->work;
      			}
          }
        }
        if($imputationUnitType == "hours"){
        	$inputWork *= $dayTime;
        	$inputAdm *= $dayTime;
        }
	      $inputTotal = $inputWork + $inputAdm;
	      $backgroundColor = "background-color:#ff7777;";
	      if($inputTotal == $excepted)$backgroundColor = "background-color:#77ff77;";
	      $result .='   <tr>';
	      $result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:left;vertical-align:center;">';
	      $result .='     <table width="100%">';
	      $result .='       <tr><td width="40%">'.formatUserThumb($id, $name, null, 22, 'right').'</td>';
	      $result .='       <td width="60%" float="left">&nbsp'.$name.'</td></tr>';
	      $result .='     </table></td>';
	      $result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:center;vertical-align:center;">'.$periodValueList[0]->periodValue.'</td>';
	      $result .='     <td style="border: 1px solid grey;height:30px;width:8%;text-align:center;vertical-align:center;">'.$excepted.$imputationUnit.'</td>';
	      $result .='     <td style="width:20%;border: 1px solid grey;">';
	      $result .='      <table width="100%">';
	      $result .='        <tr><td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputWork.$imputationUnit.'</td>';
	      $result .='        <td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputAdm.$imputationUnit.'</td>';
	      $result .='        <td style="'.$backgroundColor.'width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputTotal.$imputationUnit.'</td></tr>';
	      $result .='      </table>';
	      $result .='     </td>';
	      if($periodValueList[0]->submitted){
	        $result .='   <td style="border: 1px solid grey;height:30px;width:20%;text-align:center;vertical-align:center;">';
	        $result .='     <table width="100%"><tr><td style="width:5%;height:30px;">'.formatIcon('Submitted', 32, i18n('submittedWork', array($name, $periodValueList[0]->submittedDate))).'</td>';
	        $result .='     <td style="width:61%;height:30px;">'.i18n('submittedWork', array($name, $periodValueList[0]->submittedDate)).'</td>';
	        $result .='     <td style="width:34%;height:30px;">';
	        $result .='      <span id="buttonValid'.$periodValueList[0]->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
                  . '       <script type="dojo/method" event="onClick" >'
                  . '        '
                  . '       </script>'
                  . '     </span>';
        	$result .='     </td></tr></table></td>';
        }else{
        	$result .='   <td style="border: 1px solid grey;height:30px;width:20%;text-align:center;vertical-align:center;">';
        	$result .='     <table width="100%"><tr><td style="height:30px;width:10%;">'.formatIcon('Unsubmitted', 32, i18n('unsubmittedWork')).'</td>';
        	$result .='     <td style="height:30px;width:90%;">'.i18n('unsubmittedWork').'&nbsp'.$periodValueList[0]->submittedDate.'</td></tr></table></td>';
        }
	      $result .='   </tr>';
	      foreach ($periodValueList as $week){
	        if($week != $periodValueList[0]){
	          $firstDay = date('Y-m-d', firstDayofWeek(substr($week->periodValue, 4, 2),substr($week->periodValue, 0, 4)));
	          $lastDay = lastDayofWeek(substr($week->periodValue, 4, 2),substr($week->periodValue, 0, 4));
	          $excepted = countDayDiffDates($firstDay, $lastDay, $idCalendar);
	          if($imputationUnitType == "hours"){
	          	$excepted *= $dayTime;
	          }
	          $work = new Work();
	          $crit = array('idResource'=>$id, 'week'=>$week->periodValue);
	          $critWorkList = $work->getSqlElementsFromCriteria($crit);
	          $inputWork = 0;
	          $inputAdm = 0;
	          if($critWorkList){
	            foreach ($critWorkList as $critWork){
          			if (isset($listAdmProj[$critWork->idProject])) {
          				$inputAdm += $critWork->work;
          			}else{
          				$inputWork += $critWork->work;
          			}
	            }
	          }
	          if($imputationUnitType == "hours"){
	          	$inputWork *= $dayTime;
	          	$inputAdm *= $dayTime;
	          }
	          $inputTotal = $inputWork + $inputAdm;
	          $backgroundColor = "background-color:#ff7777;";
	          if($inputTotal == $excepted)$backgroundColor = "background-color:#77ff77;";
  	        $result .='   <tr>';
  	        $result .='     <td style="border-left: 1px solid grey;border-rgiht: 1px solid grey;height:30px;width:16%;background-color:#DDDDDD;"></td>';
  	        $result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:center;vertical-align:center;">'.$week->periodValue.'</td>';
  	        $result .='     <td style="border: 1px solid grey;height:30px;width:8%;text-align:center;vertical-align:center;">'.$excepted.$imputationUnit.'</td>';
  	        $result .='     <td style="width:20%;border: 1px solid grey;">';
  	        $result .='      <table width="100%">';
  	        $result .='        <tr><td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputWork.$imputationUnit.'</td>';
  	        $result .='        <td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputAdm.$imputationUnit.'</td>';
  	        $result .='        <td style="'.$backgroundColor.'width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputTotal.$imputationUnit.'</td></tr>';
  	        $result .='      </table>';
  	        $result .='     </td>';
  	        if($week->submitted){
  	        	$result .='   <td style="border: 1px solid grey;height:30px;width:20%;text-align:center;vertical-align:center;">';
  	        	$result .='     <table width="100%"><tr><td style="width:5%;height:30px;">'.formatIcon('Submitted', 32, i18n('submittedWork', array($name, $week->submittedDate))).'</td>';
  	        	$result .='     <td style="width:61%;height:30px;">'.i18n('submittedWork', array($name, $week->submittedDate)).'</td>';
  	        	$result .='     <td style="width:34%;height:30px;">';
    	        $result .='      <span id="buttonValid'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
                      . '       <script type="dojo/method" event="onClick" >'
                      . '        '
                      . '       </script>'
                      . '     </span>';
  	        	$result .='     </td></tr></table></td>';
  	        }else{
  	        	$result .='   <td style="border: 1px solid grey;height:30px;width:20%;text-align:center;vertical-align:center;">';
  	        	$result .='     <table width="100%"><tr><td style="height:30px;width:10%;">'.formatIcon('Unsubmitted', 32, i18n('unsubmittedWork')).'</td>';
  	        	$result .='     <td style="height:30px;width:90%;">'.i18n('unsubmittedWork').'&nbsp'.$week->submittedDate.'</td></tr></table></td>';
  	        }
  	        $result .='   </tr>';
	        }
	      }
	    }
	  }
    $result .='</table>';
	  $result .='</div>';
	  echo $result;
	}
}