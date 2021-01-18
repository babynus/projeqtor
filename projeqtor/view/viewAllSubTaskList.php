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
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/imputationValidationList.php');

$cons= new SubTask();
$lockedImp= new LockedImputation();
$impLocked=$lockedImp->getMaxValueFromCriteria('month',null);
if ($impLocked ){
  $date=$impLocked;
  $currentYear=substr($date,0,-2);
  $currentMonth=substr($date,-2);
}else{
  $currentYear=strftime("%Y") ;
  $currentMonth=strftime("%m") ;
}
?>

<div dojoType="dijit.layout.BorderContainer" id="imputationConsolidationParamDiv" name="imputationConsolidationParamDiv">  
  <div dojoType="dijit.layout.ContentPane" region="top" id="subTasButtonDiv" class="listTitle" >
  <form dojoType="dijit.form.Form" name="SubTaskForm" id="SubTaskForm" action="" method="post" >
  <table width="100%" height="64px" class="listTitle">
    <tr height="32px">
    <td style="vertical-align:top; min-width:100px; width:15%;">
      <table >
		    <tr height="32px">
  		    <td width="80px" align="center">
            <?php echo formatIcon('viewAllSubTask', 32, null, true);?>
          </td>
          <td width="100px"><span class="title">&nbsp;&nbsp;&nbsp;<?php echo i18n('menuViewAllSubTask');?></span></td>
  		  </tr>
  		  <tr height="32px">
          <td>
           <?php if(!isNewGui()){?>
            <button id="refreshConcolidationValidationButton" dojoType="dijit.form.Button" showlabel="false"
              title="<?php echo i18n('buttonRefreshList');?>"
              iconClass="dijitButtonIcon dijitButtonIconRefresh" class="detailButton">
              <script type="dojo/method" event="onClick" args="evt">
	             refreshConcolidationValidationList();
              </script>
            </button> 
             <?php }else{ ?>
             <div style="width:40px;"></div>
             <?php }?>
          </td>
        </tr>
		  </table>
    </td>
      <td>   
        <table>
         <tr>
           <td nowrap="nowrap" style="text-align: right;padding-right:5px;"> <?php echo i18n("colIdProject");?> &nbsp;</td>
           <td>
                    <select dojoType="dijit.form.FilteringSelect" class="input roundedLeft" 
                      style="width: 175px;"
                      name="idProjectConsolidation" id="idProjectConsolidation"
                      <?php echo autoOpenFilteringSelect();?>
                      value="<?php if(sessionValueExists('idProjectConsolidation')){
                                     $idProject =  getSessionValue('idProjectConsolidation');
                                     echo $idProject;
                                   }else if(sessionValueExists('project') and getSessionValue('project')!="" and  getSessionValue('project')!="*" ){
                                     if(strpos(getSessionValue('project'),',')){
                                      $idProject=0;
                                      echo $idProject;
                                     }else{
                                       $idProject =  getSessionValue('project');
                                       echo $idProject;
                                     }
                                   }else{
                                    $idProject=0;
                                    echo $idProject;
                                   }?>">
                        <script type="dojo/method" event="onChange" >
                    saveDataToSession("idProjectConsolidation",dijit.byId('idProjectConsolidation').get('value'),true);
                  </script>
                        <?php htmlDrawOptionForReference('idProject', null);?>  
                    </select>
           </td>
          <td nowrap="nowrap" style="text-align: right;padding-right:5px;">&nbsp;&nbsp;&nbsp; <?php echo i18n("colIdActivity");?> &nbsp;</td>
           <td>
                    <select dojoType="dijit.form.FilteringSelect" class="input roundedLeft" 
                      style="width: 175px;"
                      name="idActivitySubTask" id="idActivitySubTask"
                      <?php echo autoOpenFilteringSelect();?>
                      value="<?php if(sessionValueExists('idActivitySubTask')){
                                    $idActivity =  getSessionValue('idActivitySubTask');
                                    echo $idActivity;
                                   }else{
                                    $idActivity=0;
                                    echo $idActivity;
                                   }?>">
                        <script type="dojo/method" event="onChange" >
                    saveDataToSession("idActivitySubTask",dijit.byId('idActivitySubTask').get('value'),true);
                  </script>
                        <?php htmlDrawOptionForReference('idActivity', null);?>  
                    </select>
           </td>
  
            <?php if(isNewGui()){?>
           <td align="top">
            <button id="refreshConcolidationValidationButton" dojoType="dijit.form.Button" showlabel="false" style="position:absolute; right:10px; top:0px;"
              title="<?php echo i18n('buttonRefreshList');?>"
              iconClass="dijitButtonIcon dijitButtonIconRefresh" class="detailButton">
              <script type="dojo/method" event="onClick" args="evt">
	             refreshConcolidationValidationList();
              </script>
            </button> 
            </td>
             <?php }?>
           </tr>

        </table>
      </td>
    </tr>
  </table>
  </form>
  </div>
</div>