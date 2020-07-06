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
$mode = RequestHandler::getValue('mode');
$lstProj = explode(',', RequestHandler::getValue('lstProj'));
$month= RequestHandler::getValue('month');
$currentUser=getCurrentUserId();
$res=array();
$lstCons=array();
$lock=($mode=='Locked')?$month:"";

foreach ($lstProj as $id=>$val){
  $val=($mode =='validaTionCons' or $mode=='cancelCons')?substr($val,6):$val;
  $project= new Project($val);
  $proectsSubList=$project->getSubProjectsList();
  $lstSub=array();
  foreach ($proectsSubList as $key=>$name){
    foreach ($lstProj as $idProj){
      if($key==$idProj){
       unset($proectsSubList[$key]);
      }
    }
  }
  if($mode=='cancelCons')$lstProj[$id]=$val;
  if(!empty($proectsSubList)){
    foreach ($proectsSubList as $key=>$name){
      $lstProj[]=($mode =='validaTionCons' or $mode=='cancelCons')?$month.$key:$key;
    }
  }
}


if($mode =='validaTionCons'){
  foreach($lstProj as $projId){
    $cons=SqlElement::getSingleSqlElementFromCriteria("ConsolidationValidation",array("idProject"=>substr($projId,6),"month"=>$month));
    $cons->idProject=substr($projId,6);
    $cons->idResource=$currentUser;
    $cons->month=$month;
    $cons->revenue=RequestHandler::getValue('revenue_'.$projId);;
    $cons->validatedWork=RequestHandler::getValue('validatedWork_'.$projId);
    $cons->realWork=RequestHandler::getValue('realWork_'.$projId);;
    $cons->realWorkConsumed=RequestHandler::getValue('realWorkConsumed_'.$projId);
    $cons->plannedWork=RequestHandler::getValue('plannedWork_'.$projId);
    $cons->leftWork=RequestHandler::getValue('leftWork_'.$projId);
    $cons->margin=RequestHandler::getValue('margin_'.$projId);
    $cons->validationDate=date('Y-m-d');
    $lstCons[]=$cons;
  }
}

//open transaction bdd
Sql::beginTransaction();

if($mode !='validaTionCons' and $mode!='cancelCons'){
  if($mode=='Locked'){
    foreach($lstProj as $projId){
      $lockImp=new LockedImputation();
      $lockImp->idProject=$projId;
      $lockImp->idResource=$currentUser;
      $lockImp->month=$lock;
      $lockImp->save();
    }
  }else{
    $lstProj=implode(',', $lstProj);
    $where="idProject in ($lstProj) and month ='".$month."'";
    $lockImputation=new LockedImputation();
    $lstImputLocked=$lockImputation->purge($where);
  }
}else {
  if($mode=='validaTionCons'){
    foreach ($lstCons as $cons) {
      $res[]=$cons->save();
    }
  }else {
      $lstProj=implode(',', $lstProj);
      $where="idProject in ($lstProj) and month = $month";
      $res[]=$cons->purge($where);
  }
}

// commit workPeriod
Sql::commitTransaction();
?>
