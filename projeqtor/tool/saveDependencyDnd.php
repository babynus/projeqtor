<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projeqtor.php";

// Get the link info
if (! array_key_exists('ref1Type',$_REQUEST)) {
  throwError('ref1Type parameter not found in REQUEST');
}
$ref1Type=$_REQUEST['ref1Type'];

if (! array_key_exists('ref1Id',$_REQUEST)) {
  throwError('ref1Id parameter not found in REQUEST');
}
$ref1Id=$_REQUEST['ref1Id'];

if (! array_key_exists('ref2Type',$_REQUEST)) {
  throwError('ref2Type parameter not found in REQUEST');
}
$ref2Type=$_REQUEST['ref2Type'];

if (! array_key_exists('ref2Id',$_REQUEST)) {
  throwError('ref2Id parameter not found in REQUEST');
}
$ref2Id=$_REQUEST['ref2Id'];

$dependencyDelay=0;
if (array_key_exists('dependencyDelay',$_REQUEST)) {
  $dependencyDelay=$_REQUEST['dependencyDelay'];
}
Sql::beginTransaction();
$result="";
$critPredecessor=array("refType"=>$ref1Type,"refId"=>$ref1Id);
$critSuccessor=array("refType"=>$ref2Type,"refId"=>$ref2Id);

$successor=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',$critSuccessor);
$predecessor=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',$critPredecessor);;
		
$dep=new Dependency();
$dep->successorId=$successor->id;
$dep->successorRefType=$successor->refType;
$dep->successorRefId=$successor->refId;
$dep->predecessorId=$predecessor->id;
$dep->predecessorRefType=$predecessor->refType;
$dep->predecessorRefId=$predecessor->refId;
$dep->dependencyType='E-S';
$dep->dependencyDelay=$dependencyDelay;
$result=$dep->save();
$tmpStatus=getLastOperationStatus ($result);
if ($tmpStatus=='OK') {
  if ($predecessor->plannedEndDate) {
    if ($predecessor->refType=='Milestone') {
      if ($successor->refType=='Milestone') {
        $successor->plannedEndDate=$predecessor->plannedEndDate;
        $successor->plannedStartDate=$predecessor->plannedEndDate;
      } else {
        $successor->plannedStartDate=$predecessor->plannedEndDate;
      }
    } else {
      if ($successor->refType=='Milestone') {
        $successor->plannedEndDate=addWorkDaysToDate($predecessor->plannedEndDate, 2);
        $successor->plannedStartDate=addWorkDaysToDate($predecessor->plannedEndDate, 2);
      } else {
        $successor->plannedStartDate=addWorkDaysToDate($predecessor->plannedEndDate, 2);
      }
    }
    $successor->save();
  }
}

debugLog("result=$result");
// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {	
  Sql::rollbackTransaction();
  $result=substr($result,0,strpos($result,'<input'));
  $result.='<input type="hidden" id="lastOperation" value="insert" /><input type="hidden" id="lastOperationStatus" value="ERROR" />';
	$result.='<input type="hidden" id="lastPlanStatus" value="OK" />';
  echo '<div class="messageERROR" >' . $result . '</div>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  Sql::commitTransaction();
  $result=substr($result,0,strpos($result,'<input'));
  $result.='<input type="hidden" id="lastOperation" value="insert" /><input type="hidden" id="lastOperationStatus" value="OK" />';
  $result.='<input type="hidden" id="lastPlanStatus" value="OK" />';
  echo '<div class="messageOK" >'.$result.'</div>';
} else { 
  Sql::rollbackTransaction();
  $result=substr($result,0,strpos($result,'<input'));
	$result.='<input type="hidden" id="lastOperation" value="insert" /><input type="hidden" id="lastOperationStatus" value="INVALID" />';
  $result.='<input type="hidden" id="lastPlanStatus" value="OK" />';
  echo '<div class="messageERROR" >' . $result . '</div>';
}
?>