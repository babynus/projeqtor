<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
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
scriptLog('   ->/tool/saveAffectation.php');
// Get the info
if (! array_key_exists('affectationId',$_REQUEST)) {
  throwError('affectationId parameter not found in REQUEST');
}
$id=($_REQUEST['affectationId']);

$idTeam=null;
if (array_key_exists('affectationIdTeam',$_REQUEST)) {
	$idTeam=$_REQUEST['affectationIdTeam'];
}

if (! array_key_exists('affectationProject',$_REQUEST)) {
  throwError('affectationProject parameter not found in REQUEST');
}
$project=($_REQUEST['affectationProject']);

if (! array_key_exists('affectationResource',$_REQUEST) and !$idTeam) {
  throwError('affectationResource parameter not found in REQUEST');
}
$resource=($_REQUEST['affectationResource']);

if (! array_key_exists('affectationRate',$_REQUEST)) {
  throwError('affectationRate parameter not found in REQUEST');
}
$rate=($_REQUEST['affectationRate']);

$startDate="";
if (array_key_exists('affectationStartDate',$_REQUEST)) {
	$startDate=($_REQUEST['affectationStartDate']);;
}

$endDate="";
if (array_key_exists('affectationEndDate',$_REQUEST)) {
	$endDate=($_REQUEST['affectationEndDate']);;
}

$idle=false;
if (array_key_exists('affectationIdle',$_REQUEST)) {
  $idle=1;
}
Sql::beginTransaction();
if (! $idTeam) {
	$affectation=new Affectation($id);
	
	$affectation->idProject=$project;
	$affectation->idResource=$resource;
	
	$affectation->idle=$idle;
	$affectation->rate=$rate;
	$affectation->startDate=$startDate;
	$affectation->endDate=$endDate;
	$result=$affectation->save();
} else {
	$crit=array('idTeam'=>$idTeam);
	$ress=new Resource();
	$list=$ress->getSqlElementsFromCriteria($crit, false);
	$nbAff=0;
	foreach ($list as $ress) {
		$affectation=new Affectation($id);
    $affectation->idProject=$project;
    $affectation->idResource=$ress->id;
    $affectation->idle=$idle;
    $affectation->rate=$rate;
    $affectation->startDate=$startDate;
    $affectation->endDate=$endDate;
    $res=$affectation->save();
    if (stripos($res,'id="lastOperationStatus" value="OK"')>0 ) {
      $nbAff++;
	  }
	}
	if ($nbAff) {
    $result='<b>' . i18n('menuAffectation') . ' ' . i18n('resultInserted') . ' : ' . $nbAff . '</b>';
    $result .= '<input type="hidden" id="lastSaveId" value="" />';
    $result .= '<input type="hidden" id="lastOperation" value="insert" />';
    $result .= '<input type="hidden" id="lastOperationStatus" value="OK" />';
	} else {
		$result=i18n('Affectation') . ' ' . i18n('resultInserted') . ' : 0';
    $result .= '<input type="hidden" id="lastSaveId" value="" />';
    $result .= '<input type="hidden" id="lastOperation" value="control" />';
    $result .= '<input type="hidden" id="lastOperationStatus" value="INVALID" />';
	}
}

// Message of correct saving
displayLastOperationStatus($result);
?>