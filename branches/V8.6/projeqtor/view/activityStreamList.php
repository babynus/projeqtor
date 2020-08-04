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

/*
 * ============================================================================ Presents an object.
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog ( '   ->/view/objectStream.php' );
global $print, $user;
$user = getSessionUser ();


if (RequestHandler::isCodeSet('activityStreamNumberElement')) {
	$activityStreamNumberElement=RequestHandler::getValue("activityStreamNumberElement");
	Parameter::storeUserParameter("activityStreamNumberElement", $activityStreamNumberElement);
} else {
	$activityStreamNumberElement=Parameter::getUserParameter("activityStreamNumberElement");
}

if (RequestHandler::isCodeSet('activityStreamAuthorFilter')) {
	$paramAuthorFilter=RequestHandler::getId("activityStreamAuthorFilter");
	Parameter::storeUserParameter("activityStreamAuthorFilter", $paramAuthorFilter);
} else {
	$paramAuthorFilter=Parameter::getUserParameter("activityStreamAuthorFilter");
}

if (RequestHandler::isCodeSet('activityStreamTeamFilter')) {
  $paramTeamFilter=RequestHandler::getId("activityStreamTeamFilter");
  Parameter::storeUserParameter("activityStreamTeamFilter", $paramTeamFilter);
} else {
  $paramTeamFilter=Parameter::getUserParameter("activityStreamTeamFilter");
}

if (RequestHandler::isCodeSet('activityStreamTypeNote')) {
  $paramTypeNote=RequestHandler::getId("activityStreamTypeNote");
  Parameter::storeUserParameter("activityStreamElementType", $paramTypeNote);
} else {
  $paramTypeNote=Parameter::getUserParameter("activityStreamElementType");
}
$typeNote = SqlList::getNameFromId('Importable', $paramTypeNote,false);

if (RequestHandler::isCodeSet('activityStreamIdNote')) {
  $paramStreamIdNote=RequestHandler::getId("activityStreamIdNote");
  Parameter::storeUserParameter("activityStreamIdNote", $paramStreamIdNote);
} else {
  $paramStreamIdNote=Parameter::getUserParameter("activityStreamIdNote");
}

if (RequestHandler::isCodeSet('activityStreamNumberDays')) {
  $activityStreamNumberDays=RequestHandler::getNumeric("activityStreamNumberDays");
  Parameter::storeUserParameter("activityStreamNumberDays", $activityStreamNumberDays);
} else {
  $activityStreamNumberDays=Parameter::getUserParameter("activityStreamNumberDays");
}

if (RequestHandler::isCodeSet('activityStreamShowClosed')) {
  $activityStreamShowClosed=RequestHandler::getValue("activityStreamShowClosed");
  Parameter::storeUserParameter("activityStreamShowClosed", $activityStreamShowClosed);
} else {
  $activityStreamShowClosed=Parameter::getUserParameter("activityStreamShowClosed");
}

$activityStreamAddedRecently=null;
  if (RequestHandler::isCodeSet('activityStreamAddedRecently')) {
    $activityStreamAddedRecently=RequestHandler::getValue("activityStreamAddedRecently");
    Parameter::storeUserParameter("activityStreamAddedRecently", $activityStreamAddedRecently);
  } else {
    $activityStreamAddedRecently=Parameter::getUserParameter("activityStreamAddedRecently");
  }

$activityStreamUpdatedRecently=null;
  if (RequestHandler::isCodeSet('activityStreamUpdatedRecently')) {
    $activityStreamUpdatedRecently=RequestHandler::getValue("activityStreamUpdatedRecently");
    Parameter::storeUserParameter("activityStreamUpdatedRecently", $activityStreamUpdatedRecently);
  } else {
    $activityStreamUpdatedRecently=Parameter::getUserParameter("activityStreamUpdatedRecently");
  }
    
$paramProject=getSessionValue('project');
if(strpos($paramProject, ",")){
	$paramProject="*";
}

$note = new Note ();
$critWhere="1=1";
$where="1=1";
if (trim($paramAuthorFilter)!="") {
	$critWhere.=" and idUser=$paramAuthorFilter";
	$where.="and idUser=$paramAuthorFilter";
}

if (trim($paramTeamFilter)!="") {
	$team = new Resource();
	$teamResource=$team->getDatabaseTableName();
	$critWhere.=" and idUser in (select id from $teamResource where idTeam=$paramTeamFilter)";
	$where.="and idUser in (select id from $teamResource where idTeam=$paramTeamFilter)";
}

$import=new Importable();
$importTableName=$import->getDatabaseTableName();
if (trim($paramTypeNote)!="") {
  $critWhere.=" and refType='$typeNote'";
  $where.=" and refType='$typeNote' ";
}else{
  $where.=" and refType in (select name from $importTableName)";
}

if (trim($paramStreamIdNote)!="") {
  $critWhere.=" and refId=$paramStreamIdNote";
  $where.=" and refId=$paramStreamIdNote";
}

if ($paramProject!='*') {
	$critWhere.=" and (idProject in ".getVisibleProjectsList(true).')';
} else {
	$critWhere.=" and (idProject is null or idProject in ".getVisibleProjectsList($paramProject).')';
}


if ($activityStreamNumberDays!==""){
  if (Sql::isPgsql()) {
    if ($activityStreamAddedRecently and $activityStreamUpdatedRecently) {
      $critWhere.=" AND creationDate>=CURRENT_DATE - INTERVAL '" . intval($activityStreamNumberDays) . " day' ";
      $critWhere.=" OR updateDate>=CURRENT_DATE - INTERVAL '" . intval($activityStreamNumberDays) . " day ' ";
      $where.=" AND ((operation='update' AND colName='idStatus')  OR (operation='insert' AND colName IS NULL) OR (operation='delete'))";
      $where.=" AND operationDate>=CURRENT_DATE - INTERVAL '" . intval($activityStreamNumberDays) . " day'";
    } else if ($activityStreamAddedRecently=="added" && trim($activityStreamNumberDays)!=""){
      $critWhere.=" AND creationDate>=CURRENT_DATE -INTERVAL '" . intval($activityStreamNumberDays) . " day ' ";
      $where.=" AND (operation='insert' AND colName IS NULL ) ";
      $where.=" AND operationDate>=CURRENT_DATE -INTERVAL '" . intval($activityStreamNumberDays) . " day ' ";
    } else if ($activityStreamUpdatedRecently=="updated"){
      $critWhere.=" AND updateDate>=CURRENT_DATE - INTERVAL '" . intval($activityStreamNumberDays) . " day ' ";
      $where.=" AND ((operation='update' AND colName='idStatus') OR (operation='delete')) and operationDate>=CURRENT_DATE - INTERVAL '" . intval($activityStreamNumberDays) . " day ' ";
    }else{
      $where.=" AND ((operation='update' AND colName='idStatus')  OR (operation='insert' AND colName IS NULL ) OR (operation='delete') )";
    }   
  } else {
    if ($activityStreamAddedRecently and $activityStreamUpdatedRecently) {   
      $critWhere.=" and ( creationDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
      $critWhere.=" or updateDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) )";
      $where.=" and ((operation='update' and colName='idStatus')  or (operation='insert' and colName is null ) or (operation='delete'))";
      $where.=" and operationDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY)";
    } else if ($activityStreamAddedRecently=="added" && trim($activityStreamNumberDays)!=""){
      $critWhere.=" and creationDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
      $where.=" and (operation='insert' and colName is null )";
      $where.=" and operationDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
    } else if ($activityStreamUpdatedRecently=="updated"){
      $critWhere.=" and updateDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
      $where.=" and ((operation='update' and colName='idStatus') or (operation='delete')) and operationDate>=ADDDATE(CURDATE(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY)  ";
    }else{
      $where.=" and ((operation='update' and colName='idStatus')  or (operation='insert' and colName is null ) or (operation='delete'))";
    }
    
  }
}else{
  $where.=" and operation='update' or operation='insert' or operation='delete'";
}


if ($activityStreamShowClosed!='1') {
	$critWhere.=" and idle=0";
}
//echo '<br/>';
$order = "COALESCE (updateDate,creationDate) DESC";
$notes=$note->getSqlElementsFromCriteria(null,false,$critWhere,$order,null,null,$activityStreamNumberElement);
$history= new History();
$historyInfo=$history->getSqlElementsFromCriteria(null,null,$where,"operationDate DESC",null,null,$activityStreamNumberElement);
if($activityStreamShowClosed =='1'){
  $historyArchive=new HistoryArchive();
  $historyInfoArchive=$historyArchive->getSqlElementsFromCriteria(null,null,$where,"operationDate DESC",null,null,$activityStreamNumberElement);
  if(!empty($historyInfoArchive)){
    foreach ($historyInfoArchive as $histArch){
      foreach ($historyInfo as $hist){
        if($hist->operationDate<$histArch->operationDate){
          $historyInfoLst[]=$hist;
        }else{
          $historyInfoLst[]=$histArch;
        }
      }
    }
  }else{
    $historyInfoLst=$historyInfo;
  }
}else{
  $historyInfoLst=$historyInfo;
}

$countIdNote = count ( $notes );
$nbHistInfo= count($historyInfoLst);
if ($countIdNote == 0 and $nbHistInfo==0) {
  echo "<div style='padding:10px'>".i18n ( "noNoteToDisplay" )."</div>";
  exit ();
}
$onlyCenter = (RequestHandler::getValue ( 'onlyCenter' ) == 'true') ? true : false;
?>
<div dojo-type="dijit.layout.BorderContainer" class="container" style="overflow-y:auto;">
	<table id="objectStream" style="width: 100%;font-size:100% !important;"> 
	<?php
  	function sortNotes(&$listNotes, &$result, $parent){
  		foreach ($listNotes as $note){
  			if($note->idNote == $parent){
  				$result[] = $note;
  				sortNotes($listNotes, $result, $note->id);
  			}
  		}
  	}
	$noteDiscussionMode = Parameter::getUserParameter('userNoteDiscussionMode');
    if($noteDiscussionMode == null){
    	$noteDiscussionMode = Parameter::getGlobalParameter('globalNoteDiscussionMode');
    }
    if($noteDiscussionMode == 'YES'){
	    $result = array();
	    sortNotes($notes, $result, null);
	    $notes = $result;
    }
  	///
  	 $cp=1;
	  foreach ($notes as $note) {
        if($cp<=$activityStreamNumberElement){
          foreach ($historyInfoLst as $id=>$hist){
            if($hist->operationDate > $note->creationDate and $cp<=$activityStreamNumberElement){
              echo activityStreamDisplayHist($hist,"activityStream");
              unset($historyInfoLst[$id]);
              $cp++;
            }
          }
        if($cp<=$activityStreamNumberElement){
          activityStreamDisplayNote($note,"activityStream");
          $cp++;
        }
       }else{
        break;
       }
	 }
     if(!empty($historyInfoLst) and $cp<=$activityStreamNumberElement){
       foreach ($historyInfoLst as $id=>$hist){
         if($cp<=$activityStreamNumberElement){
          $cp++;
          echo activityStreamDisplayHist($hist,"activityStream");
         }
       }
     }
	  ?>
	</table>
	<div id="scrollToBottom" type="hidden"></div>
</div>