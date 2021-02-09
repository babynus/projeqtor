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

require_once "../tool/projeqtor.php";

$class = RequestHandler::getClass('class');
$jsonValue = RequestHandler::getValue('jsonValue');
$userId = getCurrentUserId();
$columnSelector = new ColumnSelector();
$mode = RequestHandler::getValue('mode');
$totalDiv = RequestHandler::getValue('totalDiv');
$list = explode("__", $jsonValue);
$delete = array_pop($list);
$order = ' sortOrder asc ';
$currentList = $columnSelector->getSqlElementsFromCriteria(array('idUser'=>$userId,'objectClass'=>$class,'hidden'=>'0'),null,$order);
if($mode=='size'){
  foreach ($list as $id=>$val){
    $list[$id]= intval(substr($val, 0 , -2));
    $list[$id] = round($list[$id]/intval($totalDiv) * 100,1);
  }
  $total = 0;
  foreach ($list as $percent){
    $total += $percent;
  }
}

Sql::beginTransaction();
foreach ($currentList as $id=>$obj){
if($mode=='move'){
   if($list[$id] != $obj->field){
     $key = array_search($obj->field, $list);
     $obj->sortOrder = $key+1;
     $obj->save();
   }
  }else{
    if($list[$id] != $obj->widthPct){
      $obj->widthPct = $list[$id];
      if($total < 100 and $obj->field=='name'){
        $obj->widthPct += abs(100-$total);
      }
      if($total > 100 and $obj->field=='name'){
        $obj->widthPct -= abs(100-$total);
        if($obj->widthPct < 10)$obj->widthPct=10;
      }
      $obj->save();
    }
  }
}
Sql::commitTransaction();
 ?>