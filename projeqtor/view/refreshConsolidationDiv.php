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

/* ============================================================================
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/refreshSubmitValidateDiv.php'); 

$projId = RequestHandler::getValue('proj');
$reelIdProj=substr($projId,6);
$month = RequestHandler::getValue('month');
$mode=RequestHandler::getValue('mode');
$curUser=getSessionUser();
$idUser=$curUser->id;
$prof=$curUser->idProfile;
$ass=SqlElement::getSingleSqlElementFromCriteria('Affectation',array("idProject"=>$reelIdProj,"idResource"=>$idUser));
$profAss=$ass->idProfile;

if($mode!='validaTionCons' and $mode!='cancelCons'){
  $critArray= array('idProject'=>$projId,'month'=>$month);
  $lock = SqlElement::getSingleSqlElementFromCriteria('LockedImputation', array("idProject"=>$reelIdProj,"month"=>$month));
  $lock=($mode=="UnLocked")?'':$lock->month;
  $res = ConsolidationValidation::drawLockedDiv($projId, $month, $lock,false,(($profAss!='' and $profAss!=$prof)?$profAss:$prof));
}else if ($mode=='validaTionCons' or $mode=='cancelCons'){
  $consValPproj=SqlElement::getSingleSqlElementFromCriteria("ConsolidationValidation",array("idProject"=>$reelIdProj,"month"=>$month));
  $res = ConsolidationValidation ::drawValidationDiv($consValPproj,$projId,$month,false,(($profAss!='' and $profAss!=$prof)?$profAss:$prof));
}
echo $res;
?>
