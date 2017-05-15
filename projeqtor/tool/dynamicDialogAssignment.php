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
include_once ("../tool/projeqtor.php");
$currency=Parameter::getGlobalParameter('currency');
$currencyPosition=Parameter::getGlobalParameter('currencyPosition');
$keyDownEventScript=NumberFormatter52::getKeyDownEvent();
$idProject=RequestHandler::getId('idProject',false,null);
$refType=RequestHandler::getValue('refType',false,null);
$refId=RequestHandler::getId('refId',false,null);
$idRole=RequestHandler::getId('idRole',false,null);
$optional=RequestHandler::getValue('optional',false,null);
$idResource = RequestHandler::getId('idResource',false,null);
$rate = RequestHandler::getNumeric('rate',false,null);
$idAssignment=RequestHandler::getId('idAssignment',false,null);
$cost=RequestHandler::getValue('cost',false,null);
$assignedIdOrigin=RequestHandler::getNumeric('assignedIdOrigin',false,null);
$assignedWorkOrigin=RequestHandler::getNumeric('assignedWorkOrigin',false,null);
$unit=RequestHandler::getValue('unit',false,null);
$validatedWorkPeOld = RequestHandler::getValue('validatedWorkPe',false,null);
$assignedWorkPeOld = RequestHandler::getValue('assignedWorkPe',false,null);
$assignedWork = RequestHandler::getNumeric('assignedWork',false,true);
$realWork = RequestHandler::getNumeric('realWork',false,true);
$assignmentObj = new Assignment($idAssignment);
$validatedWorkPe = str_replace(',', '.', $validatedWorkPeOld);
$assignedWorkPe = str_replace(',', '.', $assignedWorkPeOld);
$hoursPerDay=Work::getHoursPerDay();
$delay=null;
if($refType=="Meeting" || $refType=="PeriodicMeeting") {
	$obj=new $refType($refId);
	$delay=Work::displayWork(workTimeDiffDateTime('2000-01-01T'.$obj->meetingStartTime,'2000-01-01T'.$obj->meetingEndTime));
}
$mode = RequestHandler::getValue('mode',false,true);
?>
<div id="dialogAssign" dojoType="dijit.Dialog" title="<?php echo($mode=="add")?i18n("dialogAssignment"):i18n("dialogAssignment")."#".$idAssignment;?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='assignmentForm' jsid='assignmentForm' name='assignmentForm' onSubmit="return false;">    
         <input id="assignmentId" name="assignmentId" type="hidden" value="<?php echo $idAssignment ;?>" />
         <input id="assignmentRefType" name="assignmentRefType" type="hidden" value="<?php echo $refType ;?>" />
         <input id="assignmentRefId" name="assignmentRefId" type="hidden" value="<?php echo $refId ;?>" />
         <input id="assignedIdOrigin" name="assignedIdOrigin" type="hidden" value="<?php echo $assignedIdOrigin ;?>" />
         <input id="assignedWorkOrigin" name="assignedWorkOrigin" type="hidden" value="<?php echo $assignedWorkOrigin ;?>" />
         <table>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentIdResource" ><?php echo i18n("colIdResource");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <select dojoType="dijit.form.FilteringSelect"
              <?php echo autoOpenFilteringSelect();?>
                id="assignmentIdResource" name="assignmentIdResource"
                class="input" value="<?php if($mode=='edit'){echo $idResource;}?>" 
                onChange="assignmentChangeResource();"
                missingMessage="<?php echo i18n('messageMandatory',array(i18n('colIdResource')));?>" <?php echo ($realWork!=0 && $mode=='edit')?"readonly=readonly":"";?>>
                <?php htmlDrawOptionForReference('idResource', null,null,true,'idProject',$idProject);?>
               </select>  
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentIdRole" ><?php echo i18n("colIdRole");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <select dojoType="dijit.form.FilteringSelect" 
              <?php echo autoOpenFilteringSelect();?>
                id="assignmentIdRole" name="assignmentIdRole"
                class="input" value="<?php if($mode=='edit'){echo $idRole;}?>" 
                onChange="assignmentChangeRole();" <?php echo ($realWork!=0 && $idRole)?"readonly=readonly":"";?>>                
                 <?php htmlDrawOptionForReference('idRole', null, null, true);?>            
               </select>  
             </td>
           </tr>
           <?php $pe=new PlanningElement();
           $pe->setVisibility(); ?>
           <tr <?php echo ($pe->_costVisibility=='ALL')?'':'style="display:none;"'?>>
             <td class="dialogLabel" >
               <label for="assignmentDailyCost" ><?php echo i18n("colCost");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <?php echo ($currencyPosition=='before')?$currency:''; ?>
               <div id="assignmentDailyCost" name="assignmentDailyCost" value="<?php echo ($mode=='edit')?$cost/100:'';?>" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0}" 
                 style="width:97px"            
                 readonly >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <?php echo ($currencyPosition=='after')?$currency:'';
                     echo " / ";
                     echo i18n('shortDay'); ?>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentRate" ><?php echo i18n("colRate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentRate" name="assignmentRate" value="<?php echo ($mode=='edit')?$rate:"100";?>" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:999}" 
                 style="width:97px" 
                 missingMessage="<?php echo i18n('messageMandatory',array(i18n('colRate')));?>" 
                 required="true" >
                 <?php echo $keyDownEventScript;?>
                 </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentAssignedWork" ><?php echo i18n("colAssignedWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentAssignedWork" name="assignmentAssignedWork" 
                 value="<?php if($refType=='Meeting' || $refType=='PeriodicMeeting'){ 
                                  echo $delay;
                              } else if ($mode=="edit"){
                                  echo $assignmentObj->leftWork;
                              } 
                                else { 
                                  $assignedWork = $validatedWorkPe-$assignedWorkPe;
                                  if($assignedWork < 0){
                                    echo "0";
                                  } else {
                                    echo $assignedWork ;
                                  }                             
                              } 
                 ?>" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999999.99}" 
                 style="width:97px"
                 onchange="assignmentUpdateLeftWork('assignment');"
                 onblur="assignmentUpdateLeftWork('assignment');" >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentAssignedUnit" name="assignmentAssignedUnit" value="<?php echo $unit ;?>" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px; background-color:white; color:#000000; border:0px;"/>
               <input type="hidden" id="assignmentAssignedWorkInit" name="assignmentAssignedWorkInit" value="<?php echo($mode=="edit")?$assignedWork/100:"";?>" 
                 style="width:97px"/>  
             </td>    
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentRealWork" ><?php echo i18n("colRealWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentRealWork" name="assignmentRealWork" value="<?php echo ($mode=="edit")?$assignmentObj->leftWork:"0";?>"  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999999.99}" 
                 style="width:97px" readonly >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentRealUnit" name="assignmentRealUnit" value="<?php echo $unit ;?>" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px;background-color:#FFFFFF; color:#000000; border:0px;"/>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentLeftWork" ><?php echo i18n("colLeftWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentLeftWork" name="assignmentLeftWork"                  
                 value="<?php if($refType=='Meeting' || $refType=='PeriodicMeeting'){ 
                                  echo $delay;
                              } else if($mode=="edit"){
                                  echo $assignmentObj->leftWork;
                                } else { 
                                  $assignedWork = $validatedWorkPe-$assignedWorkPe;
                                    if($assignedWork < 0){
                                      echo "0";
                                    } else {
                                      echo $assignedWork ;
                                  }
                              } 
                 ?>" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999999.99}" 
                 onchange="assignmentUpdatePlannedWork('assignment');"
                 onblur="assignmentUpdatePlannedWork('assignment');"  
                 style="width:97px" >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentLeftUnit" name="assignmentLeftUnit" value="<?php echo $unit ;?>" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px;background-color:#FFFFFF; color:#000000; border:0px;"/>
               <input type="hidden" id="assignmentLeftWorkInit" name="assignmentLeftWorkInit" value="<?php echo ($mode=="edit")?$assignmentObj->leftWork/100:"0";?>" 
                 style="width:97px"/>  
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentPlannedWork" ><?php echo i18n("colPlannedWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentPlannedWork" name="assignmentPlannedWork"                  
                 value="<?php if($refType=='Meeting' || $refType=='PeriodicMeeting'){ 
                                  echo $delay;
                              } else { 
                                  $assignedWork = $validatedWorkPe-$assignedWorkPe;
                                  if($assignedWork < 0){
                                    echo "0";
                                  } else {
                                    echo $assignedWork ;
                                  }
                              } 
                 ?>" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999999.99}" 
                 style="width:97px" readonly > 
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentPlannedUnit" name="assignmentPlannedUnit" value="<?php echo $unit;?>" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px;background-color:#FFFFFF; border:0px;"/>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentComment" ><?php echo i18n("colComment");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentComment" name="assignmentComment" value=""  
                 dojoType="dijit.form.Textarea"
                 class="input" 
                 /> 
             </td>
           </tr>
         </table>       
         
       <div id="optionalAssignmentDiv" style="<?php if ($refType=="Meeting" || $refType=="PeriodicMeeting"){echo "display:block;";}else {echo "display:none;";}?>">
        <table style="margin-left:143px;">
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <td class="dialogLabel">&nbsp;</td>     
            <td>
              <input dojoType="dijit.form.CheckBox" name="attendantIsOptional" id="attendantIsOptional" <?php echo ($mode=="edit" && $optional==1)?"checked=checked":"";?> />
              <label style="float:none" for="attendantIsOptional" ><?php echo i18n("attendantIsOptional"); ?></label>
            </td>
           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
        </table>
      </div>
         
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogAssignmentAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAssign').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" id="dialogAssignmentSubmit" type="submit" onclick="protectDblClick(this);saveAssignment();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>