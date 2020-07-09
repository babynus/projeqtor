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
$id = RequestHandler::getId('id');
$workUnit = new WorkUnit($id);
$idCatalog=RequestHandler::getValue('id',false,null);
$detailHeight=50;
$detailWidth=500;
$result = "";
$complexity = new Complexity();
$listComplexity = $complexity->getSqlElementsFromCriteria(array('idCatalog'=>$idCatalog));
$nbComplexities = count($listComplexity);
if(!$nbComplexities)$nbComplexities=1;
$tdWitdh = (85/$nbComplexities);
if($tdWitdh>10)$tdWitdh=10;
?>
<div>
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='workUnitForm' name='workUnitForm' onSubmit="return false;">
        <input id="idCatalog" name="idCatalog" type="hidden" value="<?php echo $idCatalog;?>" />
        <input id="mode" name="mode" type="hidden" value="<?php echo $mode;?>" />
         <table>
          <tr>
             <td class="dialogLabel" >
               <label for="WUReference" ><?php echo i18n("colReference");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input dojoType="dijit.form.Textarea" id="WUReference" name="WUReference" type="hidden" value="<?php echo htmlEncode($workUnit->reference);?>"/>
                    <textarea  style="width:<?php echo $detailWidth;?>; height:<?php echo $detailHeight;?>"
                    name="WUReferences" id="WUReferences"><?php echo htmlspecialchars($result);?></textarea>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="WUDescription" ><?php echo i18n("colDescription");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
					     <input id="WUDescription" name="WUDescription" type="hidden" value="<?php echo htmlEncode($workUnit->description);?>"/>
                    <textarea  style="width:<?php echo $detailWidth;?>; height:<?php echo $detailHeight;?>"
                    name="WUDescriptions" id="WUDescriptions"><?php echo htmlspecialchars($result);?></textarea>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="WUIncoming" ><?php echo i18n("colIncoming");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <input id="WUIncoming" name="WUIncoming" type="hidden" value="<?php echo htmlEncode($workUnit->entering);?>"/>
                    <textarea  style="width:<?php echo $detailWidth;?>; height:<?php echo $detailHeight;?>"
                    name="WUIncomings" id="WUIncomings"><?php echo htmlspecialchars($result);?></textarea>
             </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          <tr>
             <td class="dialogLabel" >
               <label for="WULivrable" ><?php echo i18n("colLivrable");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="WULivrable" name="WULivrable" type="hidden" value="<?php echo htmlEncode($workUnit->deliverable);?>"/>
                    <textarea style="width:<?php echo $detailWidth;?>; height:<?php echo $detailHeight;?>"
                    name="WULivrables" id="WULivrables"><?php echo htmlspecialchars($result);?></textarea>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          <tr>
             <td class="dialogLabel" >
               <label for="ValidityDateWU" ><?php echo i18n("colValidityDate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="ValidityDateWU" name="ValidityDateWU"
                dojoType="dijit.form.DateTextBox" required="true" hasDownArrow="false"   
                constraints="{datePattern:browserLocaleDateFormatJs}"
                type="text" maxlength="10"  style="width:100px; text-align: center;" class="input" value="">
               </div>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr> <td></td><td>
           <table style="width:98%">
              <tr> 
                <td  style="width:15%" class="assignHeader"><?php echo i18n("colComplexity");?></td>
                <?php foreach ($listComplexity as $comp){ ?>
                <td style="width:<?php echo $tdWitdh;?>%" class="assignHeader" > <?php echo $comp->name; ?> </td>
                <?php } ?>
              </tr>
              <tr>
                <td style="width:15%" class="assignData" > <?php echo i18n('charge'); ?> </td>
                <?php foreach ($listComplexity as $comp){ ?>
                <td style="width:<?php echo $tdWitdh;?>%"  class="assignData">
                <input dojoType="dijit.form.TextBox" id="charge<?php echo $comp->id;?>" name="charge<?php echo $comp->id;?>" type="number" style="width: 100%" class="input"  value="" />
                </td>
                <?php } ?>
              </tr>
              <tr>
                <td style="width:15%" class="assignData"> <?php echo i18n('price'); ?> </td>
                <?php foreach ($listComplexity as $comp){ ?>
                <td style="width:<?php echo $tdWitdh;?>%" class="assignData">
                <input dojoType="dijit.form.TextBox" id="price<?php echo $comp->id;?>" name="price<?php echo $comp->id;?>" type="number" style="width: 100%" class="input"  value="" />
                </td>
                <?php } ?>
              </tr>
              <tr>
                <td style="width:15%" class="assignData"> <?php echo i18n('duration'); ?> </td>
                <?php foreach ($listComplexity as $comp){ ?>
                <td style="width:<?php echo $tdWitdh;?>%" class="assignData"> 
                <input dojoType="dijit.form.TextBox" id="duration<?php echo $comp->id;?>" name="duration<?php echo $comp->id;?>" type="number" style="width: 100%" class="input"  value="" />
                 </td>
                <?php } ?>
             </tr>
            </table>
            </td>
            </tr>
            </table>
        </form>
      </td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
      <td align="center">
        <input type="hidden" id="workUnitAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogWorkUnit').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogWorkUnitSubmit" onclick="protectDblClick(this);saveWorkUnit();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  </table>
</div>