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

/** ============================================================================
 * Save consolidation validation.
 */

require_once "../tool/projeqtor.php";

//parameter
$lstProj = explode(',', RequestHandler::getValue('lstProj'));
$mode = RequestHandler::getValue('mode');
$month= RequestHandler::getValue('month');
$currentUser=getCurrentUserId();
$res=array();
//open transaction bdd
Sql::beginTransaction();

if($mode == 'Locked' or $mode=='UnLocked'){
  switch ($mode){
  	case 'Locked':
  	  $lock=$month;
  	  break;
  	case 'UnLocked':
  	  $lock="";
  	  break;
  }
  foreach($lstProj as $projId){
    $proj=new Project($projId);
    $proj->locked=$lock;
    $proj->save();
  }
}else {
  foreach ($lstProj as $proj) {
    $cons= new ConsolidationValidation();
    $cons->idProject=$proj->id;
    $cons->idResource=$currentUser;
    $cons->month=$month;
    $cons->revenue="";
    $cons->validatedWork="";
    $cons->realWork="";
    $cons->realWorkConsumed="";
    $cons->plannedWork="";
    $cons->leftWork="";
    $cons->margin="";
    $cons->validationDate=date('Y-m-d');
  }
}

// commit workPeriod
Sql::commitTransaction();
?>