<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/
require_once "../tool/projeqtor.php";
if (! array_key_exists('refType',$_REQUEST)) {
 throwError('Parameter refType not found in REQUEST');
}
$objectClass=$_REQUEST['refType'];
Security::checkValidClass($objectClass);

if (! array_key_exists('refId',$_REQUEST)) {
 throwError('Parameter refId not found in REQUEST');
}
$objectId=$_REQUEST['refId'];
$obj=new $objectClass($objectId); // Note: $objectId is checked in base SqlElement constructor to be numeric value.
$crit=array('refType'=>$objectClass,'refId'=>$objectId);
$we=SqlElement::getSingleSqlElementFromCriteria('WorkElement', $crit);
$arrayWork=array();
$crit=array('idWorkElement'=>$we->id);
$w=new Work();
$list=$w->getSqlElementsFromCriteria($crit);
$totalWork=0;
foreach ($list as $w) {
  $key=$w->day.'#'.$w->idResource;
  if (! isset($arrayWork[$key])) $arrayWork[$key]=array('id'=>$w->id, 'date'=>$w->workDate, 'idResource'=>$w->idResource,'work'=>0);
  $arrayWork[$key]['work']+=$w->work;
  $totalWork+=$w->work;
}
$key=date('Ymd').'#'.getSessionUser()->id;
if (! isset($arrayWork[$key])) { 
  $arrayWork[$key]=array('id'=>'', 'date'=>date('Y-m-d'), 'idResource'=>getSessionUser()->id,'work'=>0);
}
if (isset($_REQUEST['work'])) {
  $newWork=Work::convertImputation($_REQUEST['work']); // Note: implicit conversion to numeric value do to arithmetic operation
  if ($newWork>$totalWork) { $arrayWork[$key]['work']=$newWork-$totalWork;}
}
$arrayWork[]=array('id'=>'', 'date'=>null, 'idResource'=>null,'work'=>0);
$keyDownEventScript=NumberFormatter52::getKeyDownEvent(); 
?>
<form id="dialogDispatchWorkForm" name="dialogDispatchWorkForm" action="">
<input type="hidden" name="dispatchWorkObjectClass" value="<?php echo $objectClass;?>" />
<input type="hidden" name="dispatchWorkObjectId" value="<?php echo $objectId;?>" />
<input type="hidden" name="dispatchWorkElementId" value="<?php echo $we->id;?>" />
<table>
<thead>
<tr><td class="tabLabel"><?php echo i18n('colDate');?></td><td>&nbsp;</td>
    <td class="tabLabel"><?php echo i18n('colResource');?></td><td>&nbsp;</td>
    <td class="tabLabel" colspan="2"><?php echo i18n('colWork');?></td></tr>
</thead>
<tbody id="dialogDispatchTable">
<tr><td colspan="6">&nbsp;</td></tr>
<?php $total=0;$cpt=0;
$user=getSessionUser();
$crit=array('scope'=>'imputation', 'idProfile'=>$user->getProfile($obj));
$habilitation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther', $crit);
$scope=new AccessScope($habilitation->rightAccess);
$code=$scope->accessCode;
foreach($arrayWork as $key=>$work) {
  $cpt++;?>
  
<tr>
 <td>
 <input type="hidden" name="dispatchWorkId[]" value="<?php echo $work['id'];?>" />
 <div id="dispatchWorkDate_<?php echo $cpt;?>" name="dispatchWorkDate[]"
           dojoType="dijit.form.DateTextBox" invalidMessage="<?php echo i18n('messageInvalidDate');?> " 
           type="text" maxlength="10" style="width:100px; text-align: center;" class="input"
           hasDownArrow="true" constraints="{datePattern:'<?php echo $_SESSION['browserLocaleDateFormatJs'];?>'}"
           value="<?php echo $work['date']?>"></div></td>
 <td>&nbsp;</td>
 <td><select dojoType="dijit.form.FilteringSelect" class="input" style="width:150px;"
      id="dispatchWorkResource_<?php echo $cpt;?>" name="dispatchWorkResource[]">
     <?php 
     if ($code=="PRO" or $code=="ALL") {
        htmlDrawOptionForReference('idResource', $work['idResource'], $obj, false, 'idProject', $obj->idProject);
     } else {
       echo '<OPTION value="'.htmlEncode($user->id).'">'.SqlList::getNameFromId('User', $user->id).'</OPTION>';    
     }?>
     </select>
 </td>
 <td>&nbsp;</td>
 <td style="word-space:nowrap;width:52px">
   <div dojoType="dijit.form.NumberTextBox" class="input" style="width:50px;" value="<?php echo Work::displayImputation($work['work'])?>"
    onchange="updateDispatchWorkTotal();" name="dispatchWorkValue[]" 
    id="dispatchWorkValue_<?php echo $cpt;?>">
    <?php echo $keyDownEventScript;?>  
     </div></td>
 <td style="width:1px;text-align:left;">&nbsp;<?php echo Work::displayShortImputationUnit();?></td>
</tr> 
<?php $total+=$work['work'];
}?>
</tbody>
<tfoot>
<tr><td colspan="6">&nbsp;</td></tr>
<td class="tabLabel" colspan="3"><?php echo i18n('sum');?></td>
<td>&nbsp;</td>
<td style="word-space:nowrap">
  <div dojoType="dijit.form.NumberTextBox" id="dispatchWorkTotal" name="dispatchWorkTotal" readonly class="input" style="width:50px;" value="<?php echo Work::displayImputation($total)?>">
     </div></td>
<td>&nbsp;<?php echo Work::displayShortImputationUnit();?></td>
<tr><td colspan="5">&nbsp;</td></tr>
</tfoot>
</table>
<table width="100%">
 <tr>
   <td style="width: 95%;" align="center">
     <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogDispatchWork').hide();">
       <?php echo i18n("buttonCancel");?>
     </button>
     <button id="dialogDispatchWorkSubmit" dojoType="dijit.form.Button" type="submit" 
       onclick="protectDblClick(this);dispatchWorkSave();return false;" >
       <?php echo i18n("buttonOK");?>
     </button>
   </td>
   <td>
   <img class="roundedButtonSmall" src="css/images/smallButtonAdd.png" onClick="addDispatchWorkLine('<?php echo Work::displayShortWorkUnit();?>');" title="<?php echo  i18n('addLine');?>" />
   </td>
 </tr>      
</table>
</form>
