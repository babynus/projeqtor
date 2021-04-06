<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : 
 *  => g.miraillet : Fix #1502
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
 * Save some information to session (remotely).
 */
require_once "../tool/projeqtor.php";

$lstDocumentsRight=(RequestHandler::isCodeSet('lstDocRight'))?explode(',', RequestHandler::getValue('lstDocRight')):false;
$operation=(RequestHandler::isCodeSet('operation'))?RequestHandler::getValue('operation'):false;
if(!$lstDocumentsRight  or !$operation)return;
sort($lstDocumentsRight);
$status="NO_CHANGE";
Sql::beginTransaction();

foreach ($lstDocumentsRight as $id=>$idDocRight){
  if(RequestHandler::isCodeSet('documentRight_'.$idDocRight)){
    $val=RequestHandler::getValue('documentRight_'.$idDocRight);
    $DocRight=new DocumentRight($idDocRight);
    if($operation=='save'){
      $DocRight->idAccessMode=$val;
      $result=$DocRight->save();
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }else{
      traceHack("saveDocumentRight.php called for deleted item but user has not write access");
      exit;
    }
  }
}

if ($status=='ERROR') {
	Sql::rollbackTransaction();
  echo '<div class="messageERROR" >' . $errors . '</div>';
} else if ($status=='WARNING'){ 
	Sql::commitTransaction();
  echo '<div class="messageWARNING" >' . i18n('messageDocumentsRightsSaved') . ' - ' .$errors .'</div>';
  $status='INVALID';
} else if ($status=='CONTROL'){ 
	Sql::commitTransaction();
  echo '<div class="messageWARNING" >' .$errors .'</div>';
  $status='INVALID';
} else if ($status=='OK'){ 
	Sql::commitTransaction();
  echo '<div class="messageOK" >' . i18n('messageDocumentsRightsSaved') . '</div>';
} else {
	Sql::rollbackTransaction();
  echo '<div class="messageNO_CHANGE" >' . i18n('messageDocumentsRightsNoChangeSaved') . '</div>';
}
echo '<input type="hidden" id="lastOperation" name="lastOperation" value="save">';
echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="' . $status .'">';

?>