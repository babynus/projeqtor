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
if (! isset ( $objectClass ))
  $objectClass = RequestHandler::getClass ( 'objectClass' );
if (! isset ( $objectId ))
  $objectId = RequestHandler::getId ( 'objectId' );
  // get the modifications (from request)
$note = new Note ();
$notes=$note->getSqlElementsFromCriteria(null,false);
$ress = new Resource ( $user->id );
$userId = $note->idUser;
$userName = SqlList::getNameFromId ( 'User', $userId );
$creationDate = $note->creationDate;
$updateDate = $note->updateDate;
if ($updateDate == null) {
  $updateDate = '';
}
$countIdNote = count ( $note );
if ($countIdNote == 0) {
  echo i18n ( "noNote" );
  exit ();
}
$onlyCenter = (RequestHandler::getValue ( 'onlyCenter' ) == 'true') ? true : false;
$user = getSessionUser ();
$addParam=addParametersNoteFlux();
if($addParam!=""){
  $addParam=', "paramAdd":"'.$addParam.'"';
}
?>
<div dojo-type="dijit.layout.BorderContainer" class="container" style="overflow-y:auto;">
	<input type="hidden" name="objectClassManual" id="objectClassManual"
		value="Note Flux" />
	<div dojo-type="dijit.layout.ContentPane" id="parameterButtonDiv"
		class="listTitle" style="z-index: 3; overflow: visible" region="top">
		<div id="resultDiv" region="top"
			style="padding: 5px; padding-bottom: 20px; max-height: 100px; padding-left: 300px; z-index: 999"></div>

		<table width="100%">
			<tr height="32px">
				<td width="50px" align="center"><?php echo formatIcon('NoteFlux', 32, null, true);?></td>
				<td><span class="title"><?php echo i18n('menuNoteFlux');?>&nbsp;</span>
				</td>
			</tr>
		</table>

	</div>
		<div dojo-type="dijit.layout.ContentPane" region="center" >
		<div
			style="width: 97%; margin: 0 auto; height: 90px; padding-bottom: 15px; border-bottom: 1px solid #CCC;">
			<table width="100%" class="dashboardTicketMain">
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td align="left"><a
									onClick="changeParamNoteFlux('noteFluxAllNotes=0')"
									href="#"><?php echo i18n("dashboardTicketMainAllIssues").addSelected("noteFluxAllNotes",0);?></a></td>
							</tr>
							<tr>
								<td align="left"><a
									onClick="changeParamNoteFlux('noteFluxAllNotes=2')"
									href="#"><?php echo i18n("dashboardTicketMainUnclosed").addSelected("noteFluxAllNotes",2);?></a></td>
							</tr>
							<tr>
								<td align="left"><a
									onClick="changeParamNoteFlux('noteFluxAllNotes=1')"
									href="#"><?php echo i18n("dashboardTicketMainUnresolved").addSelected("noteFluxAllNotes",1);?></a></td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<table>
							<tr>
								<td align="left"><a
									onClick="changeParamDashboardTicket('dashboardTicketMainRecent=1')"
									href="#"></a></td>
							</tr>
							<tr>
								<td align="left"><a
									onClick="changeParamDashboardTicket('dashboardTicketMainRecent=2')"
									href="#"></a></td>
							</tr>
							<tr>
								<td align="left"><a
									onClick="changeParamDashboardTicket('dashboardTicketMainRecent=3')"
									href="#"></a></td>
							</tr>
						</table>
         </td>
					<td valign="top">
						<table>
							<tr>
								<td align="left"><a
									onClick="changeParamDashboardTicket('dashboardTicketMainToMe=1')"
									href="#"></a></td>
							</tr>
							<tr>
								<td align="left"><a
									onClick="changeParamDashboardTicket('dashboardTicketMainToMe=2')"
									href="#"></a></td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<table>
							<tr>
								<td align="left"><a
									onClick="changeParamDashboardTicket('dashboardTicketMainUnresolved=1')"
									href="#"></a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
</div>


	<!-- Titre et listes de notes -->
	<table id="objectStream" style="width: 100%;"> 
	   <?php foreach ($notes as $note) {?>
	    <?php
      $userId = $note->idUser;
      $userName = SqlList::getNameFromId ( 'User', $userId );
      $userNameFormatted = '<span style="color:blue"><strong>' . $userName . '</strong></span>';
      $idNote = '<span style="color:blue">' . $note->id . '</span>';
      $ticketName = '<span style="color:blue">' . $note->refType . ' #' . $note->refId . '</span>';
      $colCommentStream = i18n ( 'addComment', array (
          $idNote,
          $ticketName 
      ) );
      ?>
	  <tr style="height: 100%;">
			<td class="noteData" style="width: 100%;">
				<div style="float: left;">
	              <?php
      echo formatUserThumb ( $note->idUser, $userName, 'Creator', 32 );
      echo formatPrivacyThumb ( $note->idPrivacy, $note->idTeam );
      ?>
	            </div>
				<div style="overflow-x: hidden; padding-left: 4px;">
	    <?php
      $strDataHTML = nl2br ( $note->note );
      echo '<div>' . $userNameFormatted . '&nbsp' . $colCommentStream . '</div>';
      echo '<div style="color:white;margin-top:4px;word-break:break-all;min-width:188px;position:relative;" class="dijitSplitter">' . $strDataHTML . '</div>&nbsp';
      echo '<div style="margin-top:6px;">' . formatDateThumb ( $note->creationDate, null, "left" ) . '</div>';
      echo '<div style="margin-top:11px;">' . $note->creationDate . '</div>';
      ?>
	    <?php };?>
	      </div>
			</td>
		</tr>
	</table>
	<div id="scrollToBottom" type="hidden"></div>
</div>

<?php 
function addSelected($param,$value){
  if(Parameter::getUserParameter($param)!=null){
    if(Parameter::getUserParameter($param)==$value){
      return "&nbsp;&nbsp;<img src=\"css/images/iconSelect.png\"/>";
    }
  }
}

function addParametersNoteFlux(){
  $user=getSessionUser();
  $allNotes="0";
  $result="";

  if(isset($_REQUEST['noteFluxAllNotes'])){
    Parameter::storeUserParameter("noteFluxAllNotes", $_REQUEST['noteFluxAllNotes']);
  }
  if(Parameter::getUserParameter("noteFluxAllNotes")!=null){
    $allNotes=Parameter::getUserParameter("noteFluxAllNotes");
  }else{
    Parameter::storeUserParameter("noteFluxAllNotes", $allNotes);
  }
  if($allNotes=="1")$result.=" AND note.refId=5 ";
  //if($allNotes=="2")$result.=" AND $prefix.idle=0 ";
  debugLog($result);
  return $result;
}
?>