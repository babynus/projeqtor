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
scriptLog('   ->/tool/saveResourceCapacity.php');

$idResource= RequestHandler::getId('idResource');
$capacity = RequestHandler::getValue('resourceCapacity');
$start = RequestHandler::getValue('resourceCapacityStartDate');
$end = RequestHandler::getValue('resourceCapacityEndDate');
$description = RequestHandler::getValue('resourceCapacityDescription');
$idle = RequestHandler::getBoolean('resourceCapacityIdle');
if($idle){
  $idle = 1;
}else{
  $idle = 0;
}
$mode = RequestHandler::getValue('mode');
Sql::beginTransaction();
$result = "";

if($mode == 'edit'){
  $idResourceCapacity = RequestHandler::getId('idResourceCapacity');
  $resourceCapacity = new ResourceCapacity($idResourceCapacity);
  $resourceCapacity->idResource = $idResource;
  $resourceCapacity->capacity = $capacity;
  $resourceCapacity->description = nl2brForPlainText($description);
  $resourceCapacity->idle = $idle;
  $resourceCapacity->startDate = $start;
  $resourceCapacity->endDate = $end;
  $res=$resourceCapacity->save();
}else{
  $resourceCapacity = new ResourceCapacity();
  $resourceCapacity->idResource = $idResource;
  $resourceCapacity->capacity = $capacity;
  $resourceCapacity->description = nl2brForPlainText($description);
  $resourceCapacity->idle = $idle;
  $resourceCapacity->startDate = $start;
  $resourceCapacity->endDate = $end;
  $res=$resourceCapacity->save();
}
if($result == ""){
  $result = getLastOperationStatus($res);
}
if ($result == "OK") {
	if(sessionTableValueExist('capacityPeriod', $idResource)){
		unsetSessionTable('capacityPeriod', $idResource);
	}
}

// Message of correct saving
displayLastOperationStatus($res);

?>