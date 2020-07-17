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
foreach ($lstProj as $id=>$pro){
  if($pro==''){
    unset ($lstProj[$id]);
  }
}
$month= RequestHandler::getValue('month');
$all= RequestHandler::getValue('all');
$currentUser=getCurrentUserId();
$res=array();
$lstCons=array();
$lock=($mode=='Locked')?$month:"";

//___get Recursive Sub Projects___//
foreach ($lstProj as $id=>$val){  
  $val=($mode =='validaTionCons' or $mode=='cancelCons' and $all=='false')?substr($val,6):$val;
  $project= new Project($val);
  $proectsSubList=$project->getRecursiveSubProjectsFlatList();
  $lstSub=array();
  foreach ($proectsSubList as $key=>$name){
    foreach ($lstProj as $idProj){
      if(((($mode =='validaTionCons' or $mode=='cancelCons') and $all=='false') or ($mode !='validaTionCons' or $mode!='cancelCons')) and $key==$idProj){
       unset($proectsSubList[$key]);
      }else if(((($mode =='validaTionCons' or $mode=='cancelCons') and $all=='true')) and $month.$key==$idProj){
        unset($proectsSubList[$key]);
      }
    }
  }
  if(($mode =='validaTionCons' or $mode=='cancelCons') and $all=='false')$lstProj[$id]=$val;
  if(!empty($proectsSubList)){
    foreach ($proectsSubList as $key=>$name){
      $lstProj[]=((($mode =='validaTionCons' or $mode=='cancelCons') and $all=='false') or ($mode !='validaTionCons' or $mode!='cancelCons')  )?$key:$month.$key;
    }
  }
}
//==============//

if($mode =='validaTionCons'){
  $lstImpLocked=array();
  foreach($lstProj as $projId){
    $projId=($all=='false')?$projId:substr($projId, 6);
    $cons=SqlElement::getSingleSqlElementFromCriteria("ConsolidationValidation",array("idProject"=>$projId,"month"=>$month));
    $cons->idProject=$projId;
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
    $critArray=array('idProject'=>$projId,'month'=>$month);
    $lockedImp=SqlElement::getSingleSqlElementFromCriteria('LockedImputation', $critArray);
    if($lockedImp->id!='')$lstImpLocked[]=$lockedImp->id;
  }
}
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
      $cons->save();
    }
    if(!empty($lstImpLocked)){
      $lockedImpProjects= new LockedImputation();
      $lstImpLocked=implode(',', $lstImpLocked);
      $clause="id in ($lstImpLocked) and month = $month";
      $res=$lockedImpProjects->purge($clause);
    }
  }else {
      $cons=new ConsolidationValidation();
      $lstProj=implode(',', $lstProj);
      $where="idProject in ($lstProj) and month = $month";
      $cons->purge($where);
  }
}
Sql::commitTransaction();
?>
