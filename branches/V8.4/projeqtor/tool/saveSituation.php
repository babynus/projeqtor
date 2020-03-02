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
 * Save a situation : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projeqtor.php";

// Get the situation info
if (! array_key_exists('situationRefType',$_REQUEST)) {
  throwError('situationRefType parameter not found in REQUEST');
}
$refType=$_REQUEST['situationRefType'];
Security::checkValidClass($refType);

if ($refType=='TicketSimple') {
  $refType='Ticket';    
}
if (! array_key_exists('situationRefId',$_REQUEST)) {
  throwError('situationRefId parameter not found in REQUEST');
}
$refId=$_REQUEST['situationRefId'];
if (! array_key_exists('situationSituation',$_REQUEST)) {
  throwError('situationSituation parameter not found in REQUEST');
}

$situationSituation=$_REQUEST['situationSituation'];
$situationComment=null;
if (array_key_exists('situationComment',$_REQUEST)) {
  $situationComment=$_REQUEST['situationComment'];
}

$situationId=null;
if (array_key_exists('situationId',$_REQUEST)) {
  $situationId=$_REQUEST['situationId'];
}
$situationId=trim($situationId);
if ($situationId=='') {
  $situationId=null;
}

$idProject=null;
if (array_key_exists('idProject',$_REQUEST)) {
	$idProject=$_REQUEST['idProject'];
}

$idRessource=null;
if (array_key_exists('ressource',$_REQUEST)) {
	$idRessource=$_REQUEST['ressource'];
}

$situationType=null;
if ($refType=='CallForTender' or $refType=='Tender' or $refType=='ProviderOrder' or $refType=='ProviderBill') {
  $situationType='expense';
}else{
  $situationType='income';
}

$date = RequestHandler::getValue('situationDate');
$time = RequestHandler::getValue('situationTime');

$dateTime = $date.' '.substr($time, 1);

Sql::beginTransaction();
// get the modifications (from request)
if($situationId){
  $situation=new Situation($situationId);
}else{
  $situation=new Situation();
}

$user=getSessionUser();
$situation->idUser=$user->id;
$situation->refId=$refId;
$situation->refType=$refType;
$situation->idProject = $idProject;
$situation->idResource=$idRessource;
$situation->name=$situationSituation;
$situation->situationType=$situationType;
$situation->date = $dateTime;
$situation->comment=$situationComment;

$result=$situation->save();

// Message of correct saving
displayLastOperationStatus($result);
?>