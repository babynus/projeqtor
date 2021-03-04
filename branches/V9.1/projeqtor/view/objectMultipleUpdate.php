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
 * Presents the action buttons of an object.
 * 
 */ 
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/objectMultipleUpdate.php');

  $displayWidth='98%';
  $spaceWidth='33%';
  $helpWidth=25;
  $labelWidth=250;
  if (isNewGui()) {
    $labelWidth=300;
    $helpWidth=60;
  }
  $labelSelect=i18n("selectedItemsCount");
  $layout=(Parameter::getUserParameter('paramScreen')=='left')?'vertical':'horizontal';
  if (array_key_exists('destinationWidth',$_REQUEST)) {
    $width=RequestHandler::getValue("destinationWidth");
    if ($layout=='vertical') $displayWidth=intval($width)-30;
    else $displayWidth=floor($width*0.6);
    if ($displayWidth<650) $labelSelect=i18n("selectedItemsCountShort");
    //if (isNewGui()) $labelWidth=max(300,($displayWidth/2)-15);
    $fieldWidth=$displayWidth-$labelWidth-15-15;
    $spaceWidth=$displayWidth-775;
    if ($spaceWidth<0) $spaceWidth=0;
    //else $spaceWidth=$spaceWidth.'px';
    $spaceWidth=$spaceWidth.'px';
    if ($fieldWidth<150) {
      $labelWidth=$labelWidth-150+$fieldWidth;
      $fieldWidth=150;
    }
  } 
  
  $objectClass=$_REQUEST['objectClass'];
  Security::checkValidClass($objectClass);
  $obj=new $objectClass();
  
?>


<div dojoType="dijit.layout.BorderContainer" class="background" id="objetMultipleUpdate">
  <input hidden id="showActicityStream" name="showActicityStream" value="<?php echo getSessionValue('showActicityStream');?>">
    <div id="buttonDiv" dojoType="dijit.layout.ContentPane" region="top">
    <div dojoType="dijit.layout.BorderContainer" >
      <div id="buttonDivContainer" dojoType="dijit.layout.ContentPane" region="left">
        <table width="100%" class="listTitle" >
          <tr valign="middle" height="32px"> 
            <td width="50px" align="center" class="iconHighlight" >
            <?php if (isNewGui()) {?>
              <div style="position: absolute; top: 7px; left: 14px">
              <?php echo formatIcon($objectClass, 22,null,false);?> 
              </div>
            <?php } else {?>
              <div style="position: absolute; top: 7px; left: 14px">
              <?php echo formatIcon($objectClass, 22,null,false);?> 
              </div>    
            <?php }?>
            </td>
            <td valign="middle"><span class="title"><?php echo i18n('labelMultipleMode');?></span></td>
            <td width="50px">&nbsp;</td>
            <td style="white-space;nowrap"">
              <?php echo $labelSelect;?> :
              <input type="text" id="selectedCount"
                style="font-weight: bold;background: transparent;border: 0px;width:10%;min-width:35px;<?php if (! isNewGui()) echo 'color: white;';?>" 
                value="0" readOnly />
            </td>
            <td width="15px">&nbsp;</td>
            <td><span class="nobr">
            <button id="selectAllButton" dojoType="dijit.form.Button" showlabel="false" 
               title="<?php echo i18n('buttonSelectAll');?>"
               iconClass="iconSelectAll" class="detailButton" >
                <script type="dojo/connect" event="onClick" args="evt">
                   selectAllRows('objectGrid');
                   updateSelectedCountMultiple();
                </script>
              </button>    
              <button id="unselectAllButton" dojoType="dijit.form.Button" showlabel="false" 
               title="<?php echo i18n('buttonUnselectAll');?>"
               iconClass="iconUnselectAll" class="detailButton" >
                <script type="dojo/connect" event="onClick" args="evt">
                   unselectAllRows('objectGrid');
                   updateSelectedCountMultiple();
                </script>
              </button>    
            </span></td>
            <td style="width:<?php echo $spaceWidth;?>">&nbsp;</td>
            <td><span class="nobr">
             
              <button id="saveButtonMultiple" dojoType="dijit.form.Button" showlabel="false"
               title="<?php echo i18n('buttonSaveMultiple');?>"
               iconClass="dijitButtonIcon dijitButtonIconSave" class="detailButton" >
                <script type="dojo/connect" event="onClick" args="evt">
                  saveMultipleUpdateMode("<?php echo $objectClass;?>");  
                </script>
              </button>
              <button id="deleteButtonMultiple" dojoType="dijit.form.Button" showlabel="false"
               title="<?php echo i18n('buttonDeleteMultiple');?>"
               iconClass="dijitButtonIcon dijitButtonIconDelete" class="detailButton" >
                <script type="dojo/connect" event="onClick" args="evt">
                  deleteMultipleUpdateMode("<?php echo $objectClass;?>");  
                </script>
              </button>
              <?php 
              $paramRightDiv=Parameter::getUserParameter('paramRightDiv');
              $showActivityStream=false;
              $currentScreen=getSessionValue('currentScreen');
              if ($currentScreen=='Object') $currentScreen=$objectClass;
              if($paramRightDiv=="bottom"){
                $activityStreamSize=getHeightLaoutActivityStream($currentScreen);
                $activityStreamDefaultSize=getDefaultLayoutSize('contentPaneRightDetailDivHeight');
              }else{
                $activityStreamSize=getWidthLayoutActivityStream($currentScreen);
                $activityStreamDefaultSize=getDefaultLayoutSize('contentPaneRightDetailDivWidth');
              }
              
              ?>
              <button id="undoButtonMultiple" dojoType="dijit.form.Button" showlabel="false"
               title="<?php echo i18n('buttonQuitMultiple');?>"
               iconClass="dijitButtonIcon dijitButtonIconExit" class="detailButton" >
                <script type="dojo/connect" event="onClick" args="evt">
                  if(dojo.byId('showActicityStream').value=='show'){
                    saveDataToSession('showActicityStream','hide');
                    hideStreamMode('true','<?php echo $paramRightDiv;?>','<?php echo $activityStreamDefaultSize;?>',false);
                  }
                  dojo.byId("undoButtonMultiple").blur();
                  endMultipleUpdateMode("<?php echo $objectClass;?>");
                </script>
              </button>    
            </span></td>

          </tr>
        </table>

    </div>
   <div id="detailBarShow" class="dijitAccordionTitle" onMouseover="hideList('mouse');" onClick="hideList('click');">
     <div id="detailBarIcon" align="center">
   </div>
      </div>
      <div dojoType="dijit.layout.ContentPane" region="center" 
       style="z-index: 3; height: 35px; position: absolute !important; overflow: visible !important;">
      </div>
    </div>
  </div>
  <div dojoType="dijit.layout.ContentPane" region="center" >
    <div dojoType="dijit.layout.BorderContainer" class="background">
      <div dojoType="dijit.layout.ContentPane" region="center" style="overflow-y: auto">
        <form dojoType="dijit.form.Form" id="objectFormMultiple" jsId="objectFormMultiple" 
          name="objectFormMultiple" encType="multipart/form-data" action="" method="">
          <script type="dojo/method" event="onSubmit">
            return false;        
          </script>
          <input type="hidden" id="selection" name="selection" value=""/>
          <input type="hidden" id="dataTypeSelected"  />
          <div style="width: 92%; margin-left:8%;padding-top:30px;" >
           <table width="95%" >
             <tr style="vertical-align: top;">
              <td style="width: 220px;" >
                <div dojoType="dojo.data.ItemFileReadStore" jsId="attributeMultipleUpadteStore" url="../tool/jsonList.php?listType=object&actualView=MultipleUpadate&objectClass=<?php echo  $objectClass;?>" searchAttr="name" >
                </div>
                <select dojoType="dijit.form.FilteringSelect" 
                 <?php echo autoOpenFilteringSelect();?>
                  id="idMultipleUpdateAttribute" name="idMultipleUpdateAttribute" 
                  missingMessage="<?php echo i18n('attributeNotSelected');?>"
                  class="input" value="" style="width: <?php echo (isNewGui())?'180':'200';?>px;" store="attributeMultipleUpadteStore">
                    <script type="dojo/method" event="onChange" >
                    multipleUpadteSelectAtribute(this.value);
                  </script>              
                 </select>
              </td>
              <?php  if($displayWidth<="840") echo '</tr><tr style="'.(($displayWidth<="610")?"height:50px;":"").'">';?>
             <td id="operatorTd" style="width:190px;">
               <div id="multipleUpdateOperateur" style="width:190px;<?php echo (($displayWidth>="840")?"margin-top:10px;":"");?>" >
               </div>
             </td>
             <td id="inputTd" style="width:370 px;vertical-align:middle;position:relative;">
              <input id="newMultipleUpdateValue" name="newMultipleUpdateValue" value=""    dojoType="dijit.form.TextBox"  style="width:320 px;display:none;" />
              <input id="isLongText" name="isLongText" value=""  dojoType="dijit.form.TextBox"  style="width:320 px;display:none;" />
               <div>
               <?php if (isNewGui()) {?>
                <div  id="multipleUpdateValueCheckboxSwitch" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="off" hidden
                 leftLabel="" rightLabel="" style="width:10px;position:relative; top:0px;left:5px;z-index:99;display:none;" >
  		           <script type="dojo/method" event="onStateChanged" >
  		             dijit.byId("multipleUpdateValueCheckbox").set("checked",(this.value=="on")?true:false);
  		           </script>
  		         </div>
  		        <?php }?>
  		        <input type="checkbox" id="multipleUpdateValueCheckbox" name="multipleUpdateValueCheckbox" value=""  dojoType="dijit.form.CheckBox" style="padding-top:7px;margin-left:5px;display:none;";/> 
	           </div>
               <input id="multipleUpdateValueDate" name="multipleUpdateValueDate" value=""  dojoType="dijit.form.DateTextBox" constraints="{datePattern:browserLocaleDateFormatJs}"  style="width:100px;display:none;float:left;" />
               <input id="multipleUpdateValueTime" name="multipleUpdateValueTime" value=""  dojoType="dijit.form.TimeTextBox"   style="width:75px;display:none;float:left;margin-left:15px;" />
               <?php  if($displayWidth<="610"){
                        echo "</td></tr><tr><td style='width:100%;vertical-align:middle;position:relative;'>"; 
                        }
                ?>
               <div id="divListElement" >
                <textarea dojoType="dijit.form.Textarea" id="multipleUpdateTextArea" name="multipleUpdateTextArea" style="float:left;width:90%;min-width:300px;min-height:150px;font-size: 90%; background:none;display:none;" 
                class="input" maxlength="4000" ></textarea>
                <select id="multipleUpdateValueList" name="multipleUpdateValueList[]" value=""  dojoType="dijit.form.MultiSelect" 
                 style="<?php  echo ($displayWidth<="840")?"width:370px;":"width:350px;";?>font-size:10pt;color:#555555;height:150px;display:none;float:left;" size="10" class="selectList">
                </select>
                <button style="display:none;width:20px;float:left;margin-left:15px;" id="showDetailInMultipleUpdate" dojoType="dijit.form.Button" showlabel="false"
                      title="<?php echo i18n('showDetail')?>" class="resetMargin notButton notButtonRounded"
                      iconClass="iconSearch22 iconSearch iconSize22 imageColorNewGui">
                      <script type="dojo/connect" event="onClick" args="evt">
                        var objectName = dijit.byId('showDetailInMultipleUpdate').get('value');
                        if( objectName ){
                          var objectClass=objectName[0].substr(2);
                          if (objectName[0].indexOf('__id')>=0) {
                            objectClass=objectName[0].substr(objectName[0].indexOf('__id')+4);
                          }  
                          if (objectClass=='TargetProductVersion' || objectClass=='OriginalProductVersion') objectClass='ProductVersion';
                          dijit.byId('multipleUpdateValueList').reset();
                          showDetail('multipleUpdateValueList',0,objectClass,false);
                        }
                      </script>
                  </button>
                </div>
             </td>
            </tr>
           <?php  //gautier #533
            if(property_exists(get_class($obj), 'password') and securityGetAccessRightYesNo('menu'.get_class($obj), 'update', $obj)=='YES'){?>
            <tr><td><div>&nbsp;</div></td></tr>
            <tr class="detail">
              <td>
                <button id="resetPassword" dojoType="dijit.form.Button" showlabel="true"'
                        class="generalColClass" title="<?php echo i18n('resetPassword');?>" >
                  <span><?php echo i18n('resetPassword');?></span>
                  <script type="dojo/connect" event="onClick" args="evt">
                    multipleUpdateResetPwd("<?php echo $objectClass;?>");
                  </script>
                </button>
              </td>
            </tr>
          <?php  } ?>  
          </table>
          </div>
        </form>
      </div>
      <div dojoType="dijit.layout.ContentPane" id="resultDivMultiple" 
      region="<?php echo ($layout=='vertical')?'bottom':'right';?>" class="listTitle multipleResultDiv" 
      style="<?php echo ($layout=='vertical')?'height:60%;border-top:1px solid var(--color-detail-header-border);':'width:38%;border-left:1px solid var(--color-detail-header-border);';?>">
         <span class="labelMessageEmptyArea" style=""><?php echo i18n('resultArea');?></span>
      </div>
    </div>
  </div> 
</div>

<?php 
function isDisplayable($obj, $field, $fromPlanningElement=false) {
  global $extraHiddenFields, $extraReadonlyFields, $peExtraHiddenFields, $peExtraReadonlyFields;
  if (!$extraHiddenFields) $extraHiddenFields = $obj->getExtraHiddenFields ( null, null, getSessionUser ()->getProfile () );
  if (!$extraReadonlyFields) $extraReadonlyFields = $obj->getExtraReadonlyFields ( null, null, getSessionUser ()->getProfile () );
  if ( property_exists($obj,$field) 
  and ! $obj->isAttributeSetToField($field,'readonly') 
  and ! $obj->isAttributeSetToField($field,'hidden') 
  and ! in_array($field,$extraHiddenFields) and ! in_array($field,$extraReadonlyFields)) {
    return true;
  } else {
    $pe=get_class($obj).'PlanningElement';
    if ($fromPlanningElement and property_exists($obj,$pe) and is_object($obj->$pe) and property_exists($obj->$pe,$field)) {
      $peObj=$obj->$pe;
      $peObj->setVisibility();
      $workVisibility=$peObj->_workVisibility;
      $costVisibility=$peObj->_costVisibility;
      if ( (substr($field,-4,4)=='Cost' and $costVisibility!='ALL') or (substr($field,-4, 4)=='Work' and $workVisibility!='ALL') ) {
        return false;
      }
      if (!$peExtraHiddenFields) $peExtraHiddenFields = $peObj->getExtraHiddenFields ( null, null, getSessionUser ()->getProfile () );
      if (!$peExtraReadonlyFields) $peExtraReadonlyFields = $peObj->getExtraReadonlyFields ( null, null, getSessionUser ()->getProfile () );
      if (! $peObj->isAttributeSetToField($field,'readonly')
      and ! $peObj->isAttributeSetToField($field,'hidden')
      and ! in_array($field,$peExtraHiddenFields) and ! in_array($field,$peExtraReadonlyFields)     ) {
        return true;
      } else {
        return false;
      }      
    } else {
      return false;
    }
  }         
}
?>