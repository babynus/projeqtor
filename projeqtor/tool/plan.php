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
 * Run planning
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/plan.php');
if (! array_key_exists('idProjectPlan',$_REQUEST)) {
  //throwError('idProjectPlan parameter not found in REQUEST');
  $idProjectPlan=array(" ");
} else {
  $idProjectPlan=$_REQUEST['idProjectPlan']; // validated to be numeric in SqlElement base constructor
  Security::checkValidId($idProjectPlan);
}

if (! array_key_exists('startDatePlan',$_REQUEST)) {
  throwError('startDatePlan parameter not found in REQUEST');
}
$startDatePlan=trim($_REQUEST['startDatePlan']);
Security::checkValidDateTime($startDatePlan);

$infinitecapacity=false;
if (array_key_exists('infinitecapacity',$_REQUEST)) {
	$infinitecapacity=true;
}
traceLog("infinitecapacity: $infinitecapacity");
// Moved transaction at end of procedure (out of script plan.php) to minimize lock possibilities
// Sql::beginTransaction();

projeqtor_set_time_limit(600);
$result=PlannedWork::plan($idProjectPlan, $startDatePlan,true,$infinitecapacity);

// Message of correct saving

// Moved transaction at end of procedure (out of script plan.php) to minimize lock possibilities
//displayLastOperationStatus($result);
?>