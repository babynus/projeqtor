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
$readOnly = false;
$keyDownEventScript=NumberFormatter52::getKeyDownEvent();
$currency=Parameter::getGlobalParameter('currency');
$currencyPosition=Parameter::getGlobalParameter('currencyPosition');
$mode = RequestHandler::getValue('mode',false,null);
$id = RequestHandler::getId('id');
$obj = new Activity($id);
$idWorkUnit = RequestHandler::getId('idWorkUnit');
$idActivityWorkUnit = RequestHandler::getId('idActivityWorkUnit');
$idComplexity = RequestHandler::getId('idComplexity');
$idWorkCommand = RequestHandler::getId('idWorkCommand');
$quantity = RequestHandler::getNumeric('quantity');
$minQuantity = 1;
$commandAmount = RequestHandler::getNumeric('commandAmount');
$paramEnableWorkUnit = Parameter::getGlobalParameter('enableWorkCommandManagement');

if($mode=='edit'){
  $actWorkUnit = new ActivityWorkUnit($idActivityWorkUnit);
  $idWorkUnit = $actWorkUnit->idWorkUnit;
  $idComplexity = $actWorkUnit->idComplexity;
  $quantity = $actWorkUnit->quantity;
  $idWorkCommand = $actWorkUnit->idWorkCommand;
  $complexityVal = SqlElement::getSingleSqlElementFromCriteria('ComplexityValues', array('idWorkUnit'=>$idWorkUnit,'idComplexity'=>$idComplexity));
  $commandAmount = $complexityVal->price*$quantity;
}
?>
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='activityWorkUnitForm' name='activityWorkUnitForm' onSubmit="return false;">
        <input id="mode" name="mode" type="hidden" value="<?php echo $mode;?>" />
        <input id="id" name="id" type="hidden" value="<?php echo $id;?>" />
        <input id="idActivityWorkUnit" name="idActivityWorkUnit" type="hidden" value="<?php echo $idActivityWorkUnit;?>" />
         <table>
          <tr>
             <td class="dialogLabel"  >
               <label for="workCommandWorkUnit" ><?php echo i18n("colIdWorkUnit") ?>&nbsp;<?php if(!isNewGui()){?>:<?php }?>&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect"
              <?php echo autoOpenFilteringSelect();?>
                id="workCommandWorkUnit" name="workCommandWorkUnit" <?php if($readOnly==true){?>readOnly<?php }?>
                class="input" required="required" style="border-left:3px solid red !important;"
                onChange="activityWorkUnitChangeIdWorkUnit();" 
                missingMessage="<?php echo i18n('messageMandatory',array(i18n('colIdWorkUnit')));?>" >
                 <?php htmlDrawOptionForReference('idWorkUnit',$idWorkUnit, $obj, false); ?>
               </select> 
             </td>
           </tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="workCommandComplexity" ><?php echo i18n("colIdComplexity") ?>&nbsp;<?php if(!isNewGui()){?>:<?php }?>&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect"
              <?php echo autoOpenFilteringSelect();?>
                id="workCommandComplexity" name="workCommandComplexity"
                class="input" required="required" style="border-left:3px solid red !important;"
                onChange="activityWorkUnitChangeIdComplexity();"  <?php if($mode!="edit"){?>readOnly<?php }?>  <?php if($mode=="edit" and $readOnly==true){?>readOnly<?php }?> 
                missingMessage="<?php echo i18n('messageMandatory',array(i18n('idComplexity')));?>" >
                 <?php htmlDrawOptionForReference('idComplexity',$idComplexity, $obj, false); ?>
               </select> 
             </td>
           </tr>
            <tr>
             <td class="dialogLabel" >
               <label for="workCommandQuantity" ><?php echo i18n("colQuantity");?>&nbsp;<?php if(!isNewGui()){?>:<?php }?>&nbsp;</label>
             </td>
             <td>
               <div dojoType="dijit.form.NumberTextBox" 
                  id="workCommandQuantity" name="workCommandQuantity"
                  style="width:100px;border-left:3px solid red !important;" required="required" 
                  invalidMessage="<?php echo i18n('quantityCanBeInferiorThan',$minQuantity);?>" 
                  onChange="activityWorkUnitChangeQuantity();" <?php if($mode!="edit"){?>readOnly<?php }?> constraints="{min:<?php echo $minQuantity;?>}"
                  class="input"  value="<?php echo $quantity; ?>">
                  <?php echo $keyDownEventScript;?>  
               </div>
             </td>
            </tr>
            <?php if($paramEnableWorkUnit=='true'){ ?>
      <tr>
          <td class="dialogLabel"  >
               <label for="billedWorkCommandWorkCommand" ><?php echo i18n("workCommand") ?>&nbsp;<?php if(!isNewGui()){?>:<?php }?>&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect"
              <?php echo autoOpenFilteringSelect();?>
                id="billedWorkCommandWorkCommand" name="billedWorkCommandWorkCommand"
                class="input"  <?php if($mode!="edit"){?>readOnly<?php }?>>
                 <?php htmlDrawOptionForReference('idWorkCommand',$idWorkCommand, $obj, false);  ?>
               </select> 
             </td>
           </tr>
    <?php } ?>
            <tr>
             <td class="dialogLabel" >
               <label for="workCommandAmount" ><?php echo i18n("colAmount");?>&nbsp;<?php if(!isNewGui()){?>:<?php }?>&nbsp;</label>
             </td>
             <td>
             <?php if ($currencyPosition=='before') echo $currency;?>
               <input dojoType="dijit.form.NumberTextBox" 
                id="workCommandAmount" name="workCommandAmount"
                readonly 
                style="width:100px;"
                class="input"  value="<?php echo $commandAmount;?>">  
               </input> 
               <?php if ($currencyPosition=='after') echo $currency;?>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="workUnitAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogActivityWorkUnit').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogActivityWorkUnitSubmit" onclick="protectDblClick(this);saveActivityWorkUnit();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
