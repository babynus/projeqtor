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
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  require_once "../tool/formatter.php";
  scriptLog('   ->/view/objectStream.php');
  global $print,$user;
  if (! isset($objectClass) ) $objectClass=RequestHandler::getClass('objectClass');
  if (! isset($objectId)) $objectId=RequestHandler::getId('objectId');
  $obj=new $objectClass($objectId);
  $canUpdate=securityGetAccessRightYesNo('menu' . $objectClass, 'update', $obj) == "YES";
  if ($obj->idle == 1) {
    $canUpdate=false;
  }
  $noData=htmlGetNoDataMessage($objectClass);
  $enterTextHere = '<p style="color:red;">'.i18n("textareaEnterText").'</p>';
  // get the modifications (from request)
  $note=new Note();
  $notes=$note->getSqlElementsFromCriteria(array('refType'=>$objectClass,'refId'=>$objectId));
  $ress=new Resource($user->id);
  $userId=$note->idUser;
  $userName=SqlList::getNameFromId('User', $userId);
  $creationDate=$note->creationDate;
  $updateDate=$note->updateDate;
  if ($updateDate == null) {
    $updateDate='';
  }
  if (!$objectId) {
    echo $noData; 
    exit;
  }
  $countIdNote=count($notes);
  $onlyCenter=(RequestHandler::getValue('onlyCenter')=='true')?true:false;
?>
<!-- Titre et listes de notes -->

<?php if (!$onlyCenter) {?>
<div class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
	<div id="activityStreamTop" dojoType="dijit.layout.ContentPane" region="top" style="text-align:center" class="dijitAccordionTitle">
	  <span class="title" ><?php echo i18n("titleStream");?></span>
	</div>
	<div id="activityStreamCenter" dojoType="dijit.layout.ContentPane" region="center">
	  <script type="dojo/connect" event="onLoad" args="evt">
        scrollInto();
	  </script>
<?php }?>	
	  <table id="objectStream" style="width:100%;"> 
	    <?php foreach ( $notes as $note ) {
	      echo activityStreamDisplayNote ($note,"objectStream");
	    };?>
	  </table>
	   <div id="scrollToBottom" type="hidden"></div>
<?php if (!$onlyCenter) {?>   
<?php if($countIdNote==0){echo i18n("noNote");}	?>  
	</div>
	<div id="activityStreamBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:70px;overflow-x:hidden;">
	  <form id='noteFormStream' name='noteFormStream' onSubmit="return false;" >
       <input id="noteId" name="noteId" type="hidden" value="" />
       <input id="noteRefType" name="noteRefType" type="hidden" value="<?php echo $objectClass;?>" />
       <input id="noteRefId" name="noteRefId" type="hidden" value="<?php echo $objectId;?>" />
       <input id="noteEditorTypeStream" name="noteEditorTypeStream" type="hidden" value="<?php echo getEditorType();?>" />
       <div style="width:99%;">
         <textarea rows="4"  name="noteNoteStream" id="noteNoteStream" dojoType="dijit.form.SimpleTextarea"
         style="width:98%;height:60px;overflow-x:hidden;overflow-y:auto;border:1px solid grey;margin-top:2px;" onfocus="focusStream();"><?php echo i18n("textareaEnterText");?></textarea>
       </div>
     </form>
    
   </div>
</div>
<?php }?>