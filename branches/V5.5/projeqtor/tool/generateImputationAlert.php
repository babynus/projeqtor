<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/
require_once("../tool/projeqtor.php");

function generateImputationAlert() {
  debugLog("RUNNING AT ".date("H:i:s"));
  
  $endDate=date('Y-m-d');
  // imputationAlertGenerationDay => managed by CRON
  // imputationAlertGenerationHour => managed by CRON
  $controlDay=Parameter::getGlobalParameter('imputationAlertControlDay');
  if (!$controlDay) return;
  if ($controlDay=='next') {
    $endDate=addDaysToDate($endDate, 1);
  } else if ($controlDay=='previous') {
    $endDate=addDaysToDate($endDate, -1);
  } // else = current => nothing to do
    
  $numberOfDays=Parameter::getGlobalParameter('imputationAlertControlNumberOfDays');
  if ($numberOfDays=="" or $numberOfDays==null) return;
  $startDate=addDaysToDate($endDate, (-1)*$numberOfDays);
    
  $sendToResource=Parameter::getGlobalParameter('imputationAlertSendToResource');
  $sendToProjectLeader=Parameter::getGlobalParameter('imputationAlertSendToProjectLeader');

  $lstResource=SqlList::getList('Resource');
  $lstProject=SqlList::getList('Project');
  
  $lstRes=array();
  foreach ($lstResource as $id=>$name) {
    $lstRest[$id]=array(
        'name'=>$name, 
        'full'=>false, 
        'days'=>array(), 
        'capacity'=>SqlList::getFieldFromId('Resource', $id, 'capacity'),
        'projects'=>array()
    );
    $tmpDate=$startDate;
    while ($tmpDate<=$endDate) {
      $lstRest['days'][$tmpDate]=array(
          'open'=>isOpenDay($tmpDate,SqlList::getFieldFromId('Resource', $id, 'idCalendar')),
          'work'=>0
      );
      $tmpDate=addDaysToDate($tmpDate, 1);
    }
  }
  
  $where="workDate>='$startDate' and workDate<='$endDate'";
  $wk=new Work();
  $workList=$wk->getSqlElementsFromCriteria(null,false,$where);
  foreach ($workList as $wk) {
    $lstRest[$wk->idResource]['day'][$wk->workDate][$work]+=$wk->work;
  }
  debugLog($workList);
  
  
  traceLog("FINISHED AT ".date("H:i:s"));
}