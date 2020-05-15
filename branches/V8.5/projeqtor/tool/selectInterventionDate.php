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

/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projeqtor.php";

$date=RequestHandler::getDatetime('date');
$resource=RequestHandler::getId('resource');
$period=RequestHandler::getValue('period');
if ($period!='AM' and $period!='PM') {
  traceLog("saveInterventionDate.php incorrect period '$period'");
  exit;
}
$idMode=RequestHandler::getValue('idMode');
if ($idMode and $idMode!='none' and ! is_numeric($idMode)) {
  traceLog("saveInterventionDate.php incorrect idMode '$idMode'");
  exit;
}
$letterMode=RequestHandler::getValue('letterMode');
if ($letterMode!='none' and strlen($letterMode)>3) {
  traceLog("saveInterventionDate.php incorrect letterMode '$letterMode'");
  exit;
}
$pwm=SqlElement::getSingleSqlElementFromCriteria('PlannedWorkManual', array('workDate'=>$date,'idResource'=>$resource,'period'=>$period));
Sql::beginTransaction();
if (!$pwm->id) {
  $pwm->setDates($date);
  $pwm->idResource=$resource;
}
if ($idMode!='none' and $idMode) {
  if ($pwm->idInterventionMode==$idMode) {$pwm->idInterventionMode=null;}
  else {$pwm->idInterventionMode=$idMode;}
}
$pwm->inputUser=getCurrentUserId();
$pwm->inputDateTime=date('Y-m-d H:i:s');
if (!$pwm->idInterventionMode and !$pwm->refType and !$pwm->refId) {
  $result=$pwm->delete();
} else {
  $result=$pwm->save();
}

// Message of correct saving
displayLastOperationStatus($result);
?>