<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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
include_once ("../tool/projeqtor.php");
$keyDownEventScript=NumberFormatter52::getKeyDownEvent();
$mode = RequestHandler::getValue('mode',false,null);
$idProviderOrder=RequestHandler::getValue('idProviderOrder',false,null);
$idProviderTerm=RequestHandler::getValue('id',false,null);
$line="";
if($idProviderTerm){
  $line=new ProviderTerm($idProviderTerm);
}
?>
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='affectationResourceTeamForm' name='providerTermForm' onSubmit="return false;">
        <input id="mode" name="mode" type="hidden" value="<?php echo $mode;?>" />
         <table>
           <tr>
            <td class="dialogLabel" >
               <label for="providerTermDate" ><?php echo i18n("colStartDate");?>&nbsp;:&nbsp;</label>
            </td>
            <td>
               <div id="providerTermDate" name="providerTermDate"
                dojoType="dijit.form.DateTextBox" required="true" hasDownArrow="false"   
                constraints="{datePattern:browserLocaleDateFormatJs}"
                <?php if (isset($readOnly['startDate'])) echo " readonly ";?>
                type="text" maxlength="10"  style="width:100px; text-align: center;" class="input"
                missingMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                invalidMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                value="<?php if($line){echo $line->startDate;}?>">
                
               </div>
            </td>
           </tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="providerTermAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogProviderTerm').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogProviderTermSubmit" onclick="protectDblClick(this);saveProviderTerm();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
