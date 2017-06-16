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
 * Copy an object as a new one (of the same class) : call corresponding method in SqlElement Class
 */

require_once "../tool/projeqtor.php";

$obj=SqlElement::getCurrentObject(null,null,true,false);
$valueCopy = RequestHandler::getValue('copyOption');
$toName = RequestHandler::getValue('copyToNameDoc');


  $obj->name=$toName;
  Sql::beginTransaction();
  // copy from existing object
  $newObj=$obj->copy();
  // save the new object to session (modified status)
  $result=$newObj->_copyResult;
  unset($newObj->_copyResult);

if($valueCopy == 'lastVersionRef'){
  $vd=new DocumentVersion();
  $crit=array('idDocument'=>$obj->id);
  $list=$vd->getSqlElementsFromCriteria($crit);
  foreach ($list as $vd) {
    if($vd->isRef){
      $vd->idDocument=$newObj->id;
      $vd->id=null;
      $vd->name = $vd->name;
      $vd->save();
    }
  }
}

if($valueCopy == 'lastVersion'){
  $vd=new DocumentVersion();
  $crit=array('idDocument'=>$obj->id);
  $list=$vd->getSqlElementsFromCriteria($crit,null,false,'id DESC',null,false,1);
  foreach ($list as $vd) {
    $vd->idDocument=$newObj->id;
    $vd->id=null;
    $vd->name = $vd->name;
    $vd->save();
  }
}

if($valueCopy == 'allVersion'){
  $vd=new DocumentVersion();
  $crit=array('idDocument'=>$obj->id);
  $list=$vd->getSqlElementsFromCriteria($crit);
  foreach ($list as $vd) {
    $vd->idDocument=$newObj->id;
    $vd->id=null;
    $vd->name = $vd->name;
    $vd->save();
  }
}

// Message of correct saving
$status = displayLastOperationStatus($result);
if ($status == "OK") {
  if (! array_key_exists('comboDetail', $_REQUEST)) {
    SqlElement::setCurrentObject ($newObj);
  }
}

?>