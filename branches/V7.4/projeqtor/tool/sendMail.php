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
 * Chek login/password entered in connection screen
 */
  require_once "../tool/projeqtor.php"; 
  scriptLog('   ->/tool/sendMail.php');  
  $title="";
  $msg="";
  $dest="";
  $typeSendMail="";
  if (array_key_exists('className',$_REQUEST)) {
    $typeSendMail=$_REQUEST['className'];
  } else if (array_key_exists('objectClassName',$_REQUEST)) {
    $typeSendMail=$_REQUEST['objectClassName'];
  }
  $result="";
  if ($typeSendMail=="User") {
    $login=$_REQUEST['name'];
    $dest=$_REQUEST['email'];
    $userMail=SqlElement::getSingleSqlElementFromCriteria('User', array('name'=>$login));
    $title=$userMail->parseMailMessage(Parameter::getGlobalParameter('paramMailTitleUser'));  
    $msg=$userMail->parseMailMessage(Parameter::getGlobalParameter('paramMailBodyUser'));
    // Format title and message
    $result=(sendMail($dest,$title,$msg))?'OK':'';
    
    //Damian
  }else if($typeSendMail=="Imputation"){
    $action = RequestHandler::getValue('action');
    if($action == 'submit'){
      $ProjectLeaderParam = Parameter::getGlobalParameter('submitAlertSendToProjectLeader');
      $TeamManagerParam = Parameter::getGlobalParameter('submitAlertSendToTeamManager');
      $OrganismManagerParam = Parameter::getGlobalParameter('submitAlertSendToOrganismManager');
      $rangeType = RequestHandler::getValue('rangeType');
      $rangeValue = RequestHandler::getValue('rangeValue');
      $rangeValue = substr($rangeValue, 0, 4).'-'.substr($rangeValue, 4, 2);
      $resource = new Resource(RequestHandler::getId('resource'));
      $message= i18n('messageAlertSubmitedWork',array($resource->name,i18n($rangeType),$rangeValue));
      $title = '['.Parameter::getGlobalParameter('paramDbDisplayName').']'.i18n('ImputationSubmit');
      $mailDest = array();
      $alertDest = array();
      
      //Project Leader
      switch ($ProjectLeaderParam) {
      	case 'ALERT' :
      	  $listIdProfile = array();
      	  $idResourceTab = array();
      	  $listProj = array();
      	  $profile = new Profile();
      	  $listProfile = $profile->getSqlElementsFromCriteria(array('profileCode'=>'PL'));
      	  foreach ($listProfile as $profile){
      	  	$listIdProfile[$profile->id] = $profile->id;
      	  }
      	  $object = array(new Work(), new PlannedWork());
      	  foreach ($object as $work){
      	  	$res = $work->getSqlElementsFromCriteria(array('week'=>$rangeValue));
      	  	foreach ($res as $elt){
      	  		if(!isset($listProj[$elt->idProject])){
      	  			$listProj[$elt->idProject] = $elt->idProject;
      	  		}
      	  	}
      	  }
      	  foreach ($listProj as $idProject){
      	  	$aff = new Affectation();
      	  	$where = ' idProject ='.$idProject.' and idProfile in '.transformListIntoInClause($listIdProfile);
      	  	$affListIdResource = $aff->getSqlElementsFromCriteria(null,false,$where);
      	  	foreach ($affListIdResource as $affRes){
      	  		$idResourceTab[$affRes->idResource]=$affRes->idResource;
      	  	}
      	  }
      	  foreach ($idResourceTab as $resId){
      	  	$projectLeader = new Resource($resId);
      	  	if(!isset($alertDest[$resId])){
      	  		$alertDest[$resId] = $resId;
      	  	}
      	  }
      		break;
      	case 'MAIL' :
      	  $listIdProfile = array();
      	  $idResourceTab = array();
      	  $listProj = array();
      	  $profile = new Profile();
      	  $listProfile = $profile->getSqlElementsFromCriteria(array('profileCode'=>'PL'));
      	  foreach ($listProfile as $profile){
      	  	$listIdProfile[$profile->id] = $profile->id;
      	  }
      	  $object = array(new Work(), new PlannedWork());
      	  foreach ($object as $work){
      	  	$res = $work->getSqlElementsFromCriteria(array('week'=>$rangeValue));
      	  	foreach ($res as $elt){
      	  		if(!isset($listProj[$elt->idProject])){
      	  			$listProj[$elt->idProject] = $elt->idProject;
      	  		}
      	  	}
      	  }
      	  foreach ($listProj as $idProject){
      	  	$aff = new Affectation();
      	  	$where = ' idProject ='.$idProject.' and idProfile in '.transformListIntoInClause($listIdProfile);
      	  	$affListIdResource = $aff->getSqlElementsFromCriteria(null,false,$where);
      	  	foreach ($affListIdResource as $affRes){
      	  		$idResourceTab[$affRes->idResource]=$affRes->idResource;
      	  	}
      	  }
      	  foreach ($idResourceTab as $resId){
      	  	$projectLeader = new Resource($resId);
      	  	if(!isset($mailDest[$resId])){
      	  		$mailDest[$resId] = $projectLeader->email;
      	  	}
      	  }
      		break;
      	case 'ALERT&MAIL' :
      	  $listIdProfile = array();
      	  $idResourceTab = array();
      	  $listProj = array();
      	  $profile = new Profile();
      	  $listProfile = $profile->getSqlElementsFromCriteria(array('profileCode'=>'PL'));
      	  foreach ($listProfile as $profile){
      	    $listIdProfile[$profile->id] = $profile->id;
      	  }
    			$object = array(new Work(), new PlannedWork());
    			foreach ($object as $work){
    				$res = $work->getSqlElementsFromCriteria(array('week'=>$rangeValue));
    				foreach ($res as $elt){
    					if(!isset($listProj[$elt->idProject])){
    						$listProj[$elt->idProject] = $elt->idProject;
    					}
    				}
    			}
    			foreach ($listProj as $idProject){
    			   $aff = new Affectation();
    			   $where = ' idProject ='.$idProject.' and idProfile in '.transformListIntoInClause($listIdProfile);
    			   $affListIdResource = $aff->getSqlElementsFromCriteria(null,false,$where);
    			   foreach ($affListIdResource as $affRes){
    			     $idResourceTab[$affRes->idResource]=$affRes->idResource;
    			   }
    			}
    			foreach ($idResourceTab as $resId){
    			  $projectLeader = new Resource($resId);
    			  if(!isset($mailDest[$resId])){
    					$mailDest[$resId] = $projectLeader->email;
    				}
    				if(!isset($alertDest[$resId])){
    					$alertDest[$resId] = $resId;
    				}
    			}
      		break;
      	case 'NONE' :
      		break;
      }
      
      //Team Manager
      switch ($TeamManagerParam) {
      	case 'ALERT' :
    			$idTeam = $resource->idTeam;
    			$team = new Team($idTeam);
    			if(!isset($alertDest[$team->idResource])){
    				$alertDest[$team->idResource] = $team->idResource;
    			}
      		break;
      	case 'MAIL' :
    			$idTeam = $resource->idTeam;
    			$team = new Team($idTeam);
    			$manager = new User($team->idResource);
    			if(!isset($mailDest[$manager->id])){
    				$mailDest[$manager->id] = $manager->email;
    			}
      		break;
      	case 'ALERT&MAIL' :
    			$idTeam = $resource->idTeam;
    			$team = new Team($idTeam);
    			if(!isset($alertDest[$team->idResource])){
    				$alertDest[$team->idResource] = $team->idResource;
    			}
    			$manager = new User($team->idResource);
    			if(!isset($mailDest[$manager->id])){
    				$mailDest[$manager->id] = $manager->email;
    			}
      		break;
      	case 'NONE' :
      		break;
      }
      
      //Organism Manager
      switch ($OrganismManagerParam) {
      	case 'ALERT' :
    			$idOrganization = $resource->idOrganization;
    			$organization = new Organization($idOrganization);
    			if(!isset($alertDest[$organization->idResource])){
    				$alertDest[$organization->idResource] = $organization->idResource;
    			}
      		break;
      	case 'MAIL' :
    			$idOrganization = $resource->idOrganization;
    			$organization = new Organization($idOrganization);
    			$organisManager = new User($organization->idResource);
    			if(!isset($mailDest[$organisManager->id])){
    				$mailDest[$organisManager->id] = $organisManager->email;
    			}
      		break;
      	case 'ALERT&MAIL' :
    			$idOrganization = $resource->idOrganization;
    			$organization = new Organization($idOrganization);
    			if(!isset($alertDest[$organization->idResource])){
    				$alertDest[$organization->idResource] = $organization->idResource;
    			}
    			$organisManager = new User($organization->idResource);
    			if(!isset($mailDest[$organisManager->id])){
    				$mailDest[$organisManager->id] = $organisManager->email;
    			}
      		break;
      	case 'NONE' :
      		break;
      }
      $mailDest = array_flip($mailDest);//remove duplicate
      $mailDest = array_flip($mailDest);
      foreach ($mailDest as $mail){
      	$result = sendMail($mail, $title, $message);
      }
      foreach ($alertDest as $id){
      	$alert = new Alert();
      	$alert->idUser=$id;
      	$alert->alertInitialDateTime = date('Y-m-d H:i:s');
      	$alert->alertDateTime = date('Y-m-d H:i:s');
      	$alert->message = $message;
      	$alert->title = $title;
      	$alert->alertType = 'INFO';
      	$result = $alert->save();
      }
    }
  } else if ($typeSendMail=="Meeting") {
    if (array_key_exists('id',$_REQUEST)) {
      $id=$_REQUEST['id'];
      $meeting=new Meeting($id);
      $dest=$meeting->sendMail();
      $result=($dest!='')?'OK':'';
    }
  } else if ($typeSendMail=="Document") {
  	$id=$_REQUEST['id'];
  	$doc=new Document($id);
  	$dest=$doc->sendMailToApprovers(true);
  	$result=($dest!='' and $dest!='0')?'OK':'';
  } else if ($typeSendMail=="Mailable") {
  	$class=$_REQUEST['mailRefType'];
	  Security::checkValidClass($class);
  	if ($class=='TicketSimple') {$class='Ticket';}
  	$id=$_REQUEST['mailRefId'];
  	$mailToContact=(array_key_exists('dialogMailToContact', $_REQUEST))?true:false;
    $mailToUser=(array_key_exists('dialogMailToUser', $_REQUEST))?true:false;
    $mailToAccountable=(array_key_exists('dialogMailToAccountable', $_REQUEST))?true:false;
    $mailToResource=(array_key_exists('dialogMailToResource', $_REQUEST))?true:false;
    $mailToSponsor=(array_key_exists('dialogMailToSponsor', $_REQUEST))?true:false;
    $mailToProject=(array_key_exists('dialogMailToProject', $_REQUEST))?true:false;
    $mailToProjectIncludingParentProject=(array_key_exists('dialogMailToProjectIncludingParentProject', $_REQUEST))?true:false;
    $mailToLeader=(array_key_exists('dialogMailToLeader', $_REQUEST))?true:false;
    $mailToManager=(array_key_exists('dialogMailToManager', $_REQUEST))?true:false;
    $mailToAssigned=(array_key_exists('dialogMailToAssigned', $_REQUEST))?true:false;
    $mailToSubscribers=(array_key_exists('dialogMailToSubscribers', $_REQUEST))?true:false;
    $mailToOther=(array_key_exists('dialogMailToOther', $_REQUEST))?true:false;
    $otherMail=(array_key_exists('dialogOtherMail', $_REQUEST))?$_REQUEST['dialogOtherMail']:'';
    $otherMail=str_replace('"','',$otherMail);
    $message=(array_key_exists('dialogMailMessage', $_REQUEST))?$_REQUEST['dialogMailMessage']:'';  
    $saveAsNote=(array_key_exists('dialogMailSaveAsNote', $_REQUEST))?true:false;
    $idEmailTemplate = RequestHandler::getId('idEmailTemplate');//damian
    $obj=new $class($id);
    $directStatusMail=new StatusMail();
    $directStatusMail->mailToContact=$mailToContact;
    $directStatusMail->mailToUser=$mailToUser;
    $directStatusMail->mailToAccountable=$mailToAccountable;
    $directStatusMail->mailToResource=$mailToResource;
    $directStatusMail->mailToSponsor=$mailToSponsor;
    $directStatusMail->mailToProject=$mailToProject;
    $directStatusMail->mailToProjectIncludingParentProject=$mailToProjectIncludingParentProject;
    $directStatusMail->mailToLeader=$mailToLeader;
    $directStatusMail->mailToManager=$mailToManager;
    $directStatusMail->mailToSubscribers=$mailToSubscribers;
    $directStatusMail->mailToOther=$mailToOther;
    $directStatusMail->mailToAssigned=$mailToAssigned;
    $directStatusMail->otherMail=$otherMail;
    $directStatusMail->message=htmlEncode($message,'html'); // Attention, do not save this status mail
    $directStatusMail->idEmailTemplate=$idEmailTemplate;//damian
    $resultMail=$obj->sendMailIfMailable(false,false,$directStatusMail,false,false,false,false,false,false,false,false,false);
    if (! $resultMail or ! is_array($resultMail)) {
    	$result="NO";
    	$dest="";
    } else {
    	$result=$resultMail['result'];
      $dest=$resultMail['dest'];
    }
  }
  if ($result=="OK") {
    if ($typeSendMail=="Mailable" and $saveAsNote) {
      $note=new Note();
      $note->refType=$class;
      $note->refId=$id;
      $note->idUser=getSessionUser()->id;
      $note->creationDate=date('Y-m-d H:i:s');
      $note->note=i18n('mailSentTo',array($dest))." :<br/>".nl2br($message);
      $note->save();
    }
    echo '<div class="messageOK" >' . i18n('mailSentTo',array($dest)) . '</div>';
    echo '<input type="hidden" id="lastOperation" value="mail" />';
    echo '<input type="hidden" id="lastOperationStatus" value="OK" />';
  } else if ($result=="NO" or $dest=='0') {
    echo '<div class="messageWARNING" >' .i18n('noEmailReceiver') . '</div>';
    echo '<input type="hidden" id="lastOperation" value="mail" />';
    echo '<input type="hidden" id="lastOperationStatus" value="OK" />';
  } else {
    echo '<div class="messageERROR" >' . i18n('noMailSent',array($dest, $result)) . '</div>';
    echo '<input type="hidden" id="lastOperation" value="mail" />';
    echo '<input type="hidden" id="lastOperationStatus" value="ERROR" />';
  }
?>