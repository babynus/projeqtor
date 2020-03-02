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
require_once "../tool/formatter.php";

if (! array_key_exists('objectClass',$_REQUEST)) {
  throwError('Parameter objectClass not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('objectId',$_REQUEST)) {
  throwError('Parameter objectId not found in REQUEST');
}
$objectId=$_REQUEST['objectId'];
Security::checkValidId($objectId);

$object = new $objectClass($objectId);
$situationId=null;
if (array_key_exists('situationId',$_REQUEST)) {
  $situationId=$_REQUEST['situationId'];
  Security::checkValidId($situationId);
}

if ($situationId) {
  $situation=new Situation($situationId);
} else {
  $situation=new Situation();
  $situation->refType=$objectClass;
  $situation->refId=$objectId;
}
$detailHeight=600;
$detailWidth=1010;
if (sessionValueExists('screenWidth') and getSessionValue('screenWidth')) {
  $detailWidth = round(getSessionValue('screenWidth') * 0.60);
}
if (sessionValueExists('screenHeight')) {
  $detailHeight=round(getSessionValue('screenHeight')*0.60);
}
if($situation->date){
  $dateTime = explode(' ', $situation->date);
  $date = $dateTime[0];
  $time = $dateTime[1];
}else{
  $date = date('Y-m-d');
  $time = date('H:i:s');
}
?>
<div >
  <table style="width:100%;">
    <tr>
      <td>
        <form id='situationForm' name='situationForm' onSubmit="return false;" >
         <input id="situationId" name="situationId" type="hidden" value="<?php echo $situation->id;?>" />
         <input id="situationRefType" name="situationRefType" type="hidden" value="<?php if($situationId){echo $situation->refType;}else{echo $objectClass;}?>" />
         <input id="situationRefId" name="situationRefId" type="hidden" value="<?php if($situationId){echo $situation->refId;}else{echo $object->id;}?>" />
         <input id="situationType" name="situationType" type="hidden" value="<?php echo $situation->situationType;?>" />
         <input id="idProject" name="idProject" type="hidden" value="<?php if($situationId){echo $situation->idProject;}else{echo $object->idProject;}?>" />
         <input id="situationEditorType" name="situationEditorType" type="hidden" value="<?php echo getEditorType();?>" />
        <table>
          <tr>
            <td>
              <div>
                <label class="dialogLabel" for="dialogSituationPredefinedSituation" ><?php echo i18n("colPredefinedSituation");?> : </label>
                <select id="dialogSituationPredefinedSituation" name="dialogSituationPredefinedSituation" dojoType="dijit.form.FilteringSelect"
                <?php echo autoOpenFilteringSelect();?>
                onchange="situationSelectPredefinedText(this.value);"
                class="input" style="width:345px">
                 <option value=""></option>
                 <?php
                 ?>
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <label class="dialogLabel" for="situationSituation"><?php echo i18n('colSituation');?> : </label>
              <input id="situationSituation" name="situationSituation" value="<?php echo $situation->name;?>" 
                   dojoType="dijit.form.TextBox" class="input" style="width:345px"/>
            </td>
          </tr>
          <tr>
           <td>
            <label class="dialogLabel" for="ressource"><?php echo i18n('colResponsible');?> : </label>
            <select dojoType="dijit.form.FilteringSelect" class="input" 
              style="width: 150px;" name="ressource" id="ressource"
              <?php echo autoOpenFilteringSelect();?> value="<?php echo $situation->idResource;?>">
                <option value=""></option>
                <?php
                 $specific='imputation';
                 include '../tool/drawResourceListForSpecificAccess.php';?>  
            </select>
           </td>
          </tr>
          <tr>
            <td>
              <label class="dialogLabel" for="situationDate"><?php echo i18n('colDate');?> : </label>
              <div id="situationDate" name="situationDate" dojoType="dijit.form.DateTextBox" invalidMessage="<?php echo i18n('messageInvalidDate'); ?>" type="text" maxlength="10"
              <?php if (sessionValueExists('browserLocaleDateFormatJs')) {
                echo ' constraints="{datePattern:\''.getSessionValue('browserLocaleDateFormatJs').'\'}" ';
              }?>
              style="width:82px;text-align: center;margin-right:-3px;margin-top:1px;" class="inputrequired generalColClass" value="<?php echo $date;?>" hasDownArrow="false">
              </div>
              <div id="situationTime" name="situationTime" dojoType="dijit.form.TimeTextBox" invalidMessage="<?php echo i18n('messageInvalidTime'); ?>" type="text" maxlength="8"
              <?php if (sessionValueExists('browserLocaleTimeFormat')) {
                echo ' constraints="{timePattern:\''.getSessionValue('browserLocaleTimeFormat').'\'}" ';
              }?>
              style="width:64px;text-align: center;" class="inputrequired generalColClass" value="T<?php echo $time;?>" hasDownArrow="false">
              </div>
            <td>
          </tr>
          <tr>
            <td>
              <label class="dialogLabel" for="situationComment"><?php echo i18n('colComment');?> : </label><br/><br/>
         <?php if (getEditorType()=="CK" or getEditorType()=="CKInline") {?>
          <textarea style="width:<?php echo $detailWidth;?>px; height:<?php echo $detailHeight;?>px"
          name="situationComment" id="situationComment"><?php
          if (!isTextFieldHtmlFormatted($situation->comment)) {
          	echo formatPlainTextForHtmlEditing($situation->comment);
          } else {
          	echo htmlspecialchars($situation->comment);
          } ?></textarea>
        <?php } else if (getEditorType()=="text"){
        	if (isTextFieldHtmlFormatted($situation->comment)) {
          	$text=new Html2Text($situation->comment);
          	$val=$text->getText();
          } else {
            $val=str_replace(array("\n",'<br>','<br/>','<br />'),array("","\n","\n","\n"),$situation->comment);
          }?>
          <textarea dojoType="dijit.form.Textarea" 
          id="situationComment" name="situationComment"
          style="max-width:<?php echo $detailWidth;?>px;height:<?php echo $detailHeight;?>px;max-height:<?php echo $detailHeight;?>px"
          maxlength="4000"
          class="input"
          onClick="dijit.byId('situationComment').setAttribute('class','');"><?php echo $val;?></textarea>
        <?php } else {?>
          <textarea dojoType="dijit.form.Textarea" type="hidden"
           id="situationComment" name="situationComment"
           style="display:none;"><?php echo htmlspecialchars($situation->comment);?></textarea>    
           <div data-dojo-type="dijit.Editor" id="situationCommentEditor"
             data-dojo-props="onChange:function(){window.top.dojo.byId('situationComment').value=arguments[0];}
              ,plugins:['removeFormat','bold','italic','underline','|', 'indent', 'outdent', 'justifyLeft', 'justifyCenter', 
                        'justifyRight', 'justifyFull','|','insertOrderedList','insertUnorderedList','|']
              ,onKeyDown:function(event){window.top.onKeyDownFunction(event,'situationCommentEditor',this);}
              ,onBlur:function(event){window.top.editorBlur('situationCommentEditor',this);}
              ,extraPlugins:['dijit._editor.plugins.AlwaysShowToolbar','foreColor','hiliteColor']"
              style="color:#606060 !important; background:none;padding:3px 0px 3px 3px;margin-right:2px;width:<?php echo $detailWidth;?>px;overflow:auto;"
              class="input"><?php 
                if (!isTextFieldHtmlFormatted($situation->comment)) {
			          	echo formatPlainTextForHtmlEditing($situation->comment,'single');
			          } else {
			          	echo $situation->comment;
			          }?></div>
        <?php }?>
            </td>
          </tr>
        </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogSituationAction">
        <button class="mediumTextButton"  dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogSituation').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton"  id="dialogSituationSubmit" dojoType="dijit.form.Button" type="submit" onclick="protectDblClick(this);saveSituation();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>