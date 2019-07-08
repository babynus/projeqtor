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

scriptLog('dynamicDialogAddDataCloning.php');
$user = getSessionUser();
$dataCloning = new DataCloning();
$dataCloningMaxCount = 3;
$dataCloningCount = $dataCloning->countSqlElementsFromCriteria(array("idResource"=>$user->id, "idle"=>"0"));
$plannedDate = date('Y-m-d');
?>
  <table>
    <tr>
      <td>
        <form dojoType="dijit.form.Form" id='dataCloningForm' name='dataCloningForm' onSubmit="return false;">
          <table width="100%" style="white-space:nowrap">
            <tr>
              <td>
                <label for="dataCloningUser" class="dialogLabel" style="text-align:right;"><?php echo i18n('colUser');?> : </label>
                <select dojoType="dijit.form.FilteringSelect" class="input" xlabelType="html"
                style="width: 150px;" name="dataCloningUser" id="dataCloningUser" required
                <?php echo autoOpenFilteringSelect();?>
                value="<?php echo $user->id;?>">
                  <?php $specific='imputation';
                   include '../tool/drawResourceListForSpecificAccess.php';?>  
                 </select>
  				    </td>
            </tr>
            <tr>
             <td></br></td>
           </tr>
            <tr>
              <td>
                <label for="dataCloningName" class="dialogLabel" style="text-align:right;"><?php echo i18n('colName');?> : </label>
                <input data-dojo-type="dijit.form.TextBox"
  				          id="dataCloningName" name="dataCloningName"
  				          style="width: 300px;"
  				          maxlength="4000"
  				          class="input" value=""/>
  				    </td>
            </tr>
            <tr>
             <td></br></td>
           </tr>
            <tr>
              <td>
                <label for="dataCloningPlannedDate" class="dialogLabel" style="text-align:right;"><?php echo i18n('colPlannedDate');?> : </label>
  				      <div dojoType="dijit.form.DateTextBox" disabled
               <?php if (sessionValueExists('browserLocaleDateFormatJs')) {
  							echo ' constraints="{datePattern:\''.getSessionValue('browserLocaleDateFormatJs').'\'}" ';
  						 }?>
               id="dataCloningPlannedDate" name="dataCloningPlannedDate"
               type="text" maxlength="10" hasDownArrow=false
               style="width:80px; text-align:center;" class="input rounded"
               value="<?php echo $plannedDate;?>">
               </div>
  				    </td>
            </tr>
            <tr>
             <td></br></td>
           </tr>
           <tr>
             <td></br></td>
           </tr>
           <tr>
             <td style="text-align:center;" class="dialogLabel">
               <?php echo i18n('colDataCloningCount', array($dataCloningMaxCount-$dataCloningCount, $dataCloningMaxCount));?>
             </td>
           </tr>
          </table>
        </form>
     </td>
   </tr>
   <tr>
     <td></br></td>
   </tr>
   <table width="100%">
    <tr>
      <td align="center">
        <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAddDataCloning').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="button" type="submit" onclick="saveDataCloning();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
  </table>