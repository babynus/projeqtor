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
  // get the modifications (from request)
  $note=new Note();
  $notes=$note->getSqlElementsFromCriteria(array('refType'=>$objectClass,'refId'=>$objectId));
  $ress=new Resource($user->id);
  $userId=$note->idUser;
  $userName=SqlList::getNameFromId('User', $userId);
  debugLog("voici le userid de objstream".$userId);
  debugLog("voici le username de objstream".$userName);
  $creationDate=$note->creationDate;
  $updateDate=$note->updateDate;
  debugLog("voici le creationdate de objstream".$creationDate);
  debugLog("voici le updateDate de objstream".$updateDate);
  if ($updateDate == null) {
    $updateDate='';
  }
  $detailHeight=600;
  $detailWidth=1010;
  //// A CHANGER ////
  $achanger = "a commenté dans";
  $ticket = new Ticket();
  foreach ( $notes as $note ) {
    $userNameFormatted = '<span style="color:blue">'.$userName.'</span>';
    $ticketName = '<span style="color:blue">'.$note->refType.' #'.$note->refId.'</span>';
  }
  
  if (!$objectId) echo $noData;
?>
<?php if ($objectId){?>
<!-- Titre et listes de notes -->
<div>
  <span style="color:black;" class="title" ><?php echo i18n("titleStream");?></span>
</div>

<div id="activityStream" style="height:100%;display:inline;" >
  <table id="objectStream"> 
    <?php foreach ( $notes as $note ) { ?>
      <?php if ($user->id == $note->idUser or $note->idPrivacy == 1 or ($note->idPrivacy == 2 and $ress->idTeam == $note->idTeam)) {?>
        <tr style="height:50px;">
          <td class="noteData" style="width:100%">
            <div style="float:left;">
              <?php
                echo formatUserThumb($note->idUser, null, 'Creator',32);
                echo formatPrivacyThumb($note->idPrivacy, $note->idTeam);
              ?>
            </div>
      <div style="overflow-x:auto;" >
      <?php 
        $strDataHTML=$note->note;
	      if (! isTextFieldHtmlFormatted($strDataHTML)) {
	      	$strDataHTML=htmlEncode($strDataHTML,'plainText');
	      } else {
	      	$strDataHTML=preg_replace('@(https?://([-\w\.]<+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $strDataHTML);
	      }
	    echo '<div>'.$userNameFormatted.'&nbsp'.$achanger.'&nbsp'.$ticketName.'</div>';
      echo '<div style="color:black;background-color:#DFF2FF;height:20px;margin-top:2px;">'.$strDataHTML.'</div>&nbsp';
      echo '<div>'.$note->creationDate.'</div>';
      ?>
      </div>
      </td>
      <td class="noteData" style="width:10%;">
        <?php
          if ($canUpdate) echo  '<div style="margin-top:17px;" ><a onClick="removeNote(' . htmlEncode($note->id) . ');" title="' . i18n('removeNote') . '" > '.formatSmallButton('Remove').'</a></div>';
        ?>
        
      </td>        
        </tr>      
     <?php };?>
    <?php };?>
  </table>
</div>

<div style="border:2px solid black;margin-top:100%;" ><form id='noteFormStream' name='noteFormStream' onSubmit="return false;" >
         <input id="noteId" name="noteId" type="hidden" value="<?php echo $note->id;?>" />
         <input id="noteRefType" name="noteRefType" type="hidden" value="<?php echo $note->refType;?>" />
         <input id="noteRefId" name="noteRefId" type="hidden" value="<?php echo $note->refId;?>" />
         <input id="noteEditorTypeStream" name="noteEditorTypeStream" type="hidden" value="<?php echo getEditorType();?>" />
         <?php if ((getEditorType()=="CK" or getEditorType()=="CKInline") && $canUpdate) { ?> 
         <div><textarea dojoType="dijit.form.Textarea" name="noteNoteStream" id="noteNoteStream" onKeyPress="if(event.keyCode==13) return saveNoteStream()" style="width:100%;height:50px;overflow-x:auto;overflow-y:auto;">
          <?php
          echo "entrez votre texte ici ";
          ?></textarea></div>
        <?php } else if (getEditorType()=="text" && $canUpdate){
        	if (isTextFieldHtmlFormatted($note->note)) {
          	$text=new Html2Text($note->note);
          	$val=$text->getText();
          } else {
            $val=str_replace(array("\n",'<br>','<br/>','<br />'),array("","\n","\n","\n"),$note->note);
          }?>
          <textarea dojoType="dijit.form.Textarea" 
          id="noteNoteStream" name="noteNoteStream"
          maxlength="4000"
          class="input"
          style="width:100%;height:100px;bottom:0;overflow:auto;position:absolute;"
          onClick="dijit.byId('noteNoteStream').setAttribute('class','');"><?php echo $val;?></textarea>
        <?php } else {?>
          <textarea dojoType="dijit.form.Textarea" type="hidden"
           id="noteNoteStream" name="noteNoteStream"
           style="display:none;"><?php echo htmlspecialchars($note->note);?></textarea>    
           <div data-dojo-type="dijit.Editor" id="streamNoteEditor"
             data-dojo-props="onChange:function(){top.dojo.byId('noteNoteStream').value=arguments[0];}
              ,plugins:['removeFormat','bold','italic','underline','|', 'indent', 'outdent', 'justifyLeft', 'justifyCenter', 
                        'justifyRight', 'justifyFull','|','insertOrderedList','insertUnorderedList','|']
              ,onKeyDown:function(event){top.onKeyDownFunction(event,'streamNoteEditor',this);}
              ,onBlur:function(event){top.editorBlur('streamNoteEditor',this);}
              ,extraPlugins:['dijit._editor.plugins.AlwaysShowToolbar','foreColor','hiliteColor']"
              style="color:#606060 !important; background:none;padding:3px 0px 3px 3px;margin-right:2px;width:100%;height:100px;bottom:0;overflow:auto;position:absolute;"
             	class="input"><?php 
                if (!isTextFieldHtmlFormatted($note->note)) {
			          	echo formatPlainTextForHtmlEditing($note->note,'single');
			          } else {
			          	echo $note->note;
			          }?></div>
        <?php }?>
        <?php if($canUpdate){?>
         <table width="100%"><tr height="25px">
            <td width="33%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="notePrivacyPublic"><?php echo i18n('public');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="notePrivacy" id="notePrivacyPublic" value="1" <?php if ($note->idPrivacy==1) echo "checked";?> />
            </td>
            <td width="34%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="notePrivacyTeam"><?php echo i18n('team');?>&nbsp;</label>
              <?php $res=new Resource(getSessionUser()->id);
                    $hasTeam=($res->id and $res->idTeam)?true:false;
              ?>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="notePrivacy" id="notePrivacyTeam" value="2" <?php if ($note->idPrivacy==2) echo "checked"; if (!$hasTeam) echo ' disabled ';?> />
            </td>
            <td width="33%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="notePrivacyPrivate"><?php echo i18n('private');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="notePrivacy" id="notePrivacyPrivate" value="3" <?php if ($note->idPrivacy==3) echo "checked";?> />
            </td>
          </tr></table>
        <?php };?>
       </form></div>
<?php };?>
