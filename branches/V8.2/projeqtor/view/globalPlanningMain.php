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
  scriptLog('   ->/view/globalPlanningMain.php');
    
  $listHeight='60%';
  $topDetailDivHeight=Parameter::getUserParameter('contentPaneTopGlobalPlanningDivHeight');
  $screenHeight=getSessionValue('screenHeight');
  if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
    $topDetailDivHeight=$screenHeight-300;
  }
  $listHeight=($topDetailDivHeight)?$topDetailDivHeight.'px':$listHeight;
  $detailDivWidthPlanning=Parameter::getUserParameter('contentPaneRightDetailDivWidthGlobalPlanning');
  if($detailDivWidthPlanning or $detailDivWidthPlanning==="0"){
    $rightWidthGlobalPlanning=$detailDivWidthPlanning.'px';
  } else {
    $rightWidthGlobalPlanning="15%";
  }
  
  if(empty(RequestHandler::getValue('paramScreen'))and Parameter::getUserParameter("paramScreen") =='0'){
    $valScreen='0';
    $widthListDiv='100%';
    $widthDetailDiv='100%';
    $positionListDiv='top';
    Parameter::storeUserParameter("paramScreen", $valScreen);
  }else{
    if(RequestHandler::getValue('paramScreen')=='1'){
      $valScreen='0';
      $widthListDiv='100%';
      $widthDetailDiv='100%';
      $positionListDiv='top';
      Parameter::storeUserParameter("paramScreen", $valScreen);
    }else {
      $valScreen='1';
      $widthListDiv='65%';
      $widthDetailDiv='25%';
      $positionListDiv='left';
      Parameter::storeUserParameter("paramScreen", $valScreen);
    }
  }
  if(empty(Parameter::getUserParameter("paramRightDiv"))){
    if(empty(RequestHandler::getValue('paramRightDiv'))){
      $positonRightDiv='trailing';
    }else{
      $valScreen='3';
      $positonRightDiv='bottom';
      Parameter::storeUserParameter("paramRightDiv", $valScreen);
    }
  }else{
    if(RequestHandler::getValue('paramRightDiv')=='3' and Parameter::getUserParameter("paramRightDiv") == '3'){
      $valScreen='0';
      $positonRightDiv='trailing';
      Parameter::storeUserParameter("paramRightDiv", $valScreen);
    }else{
      $valScreen='3';
      $positonRightDiv='bottom';
      Parameter::storeUserParameter("paramRightDiv", $valScreen);
    }
  }
  if((empty(Parameter::getUserParameter("paramLayoutObjectDetail")) or Parameter::getUserParameter("paramLayoutObjectDetail")=='4')and RequestHandler::getValue('paramLayoutObjectDetail')=='4') {
    $valScreen='4';
    Parameter::storeUserParameter("paramLayoutObjectDetail", $valScreen);
  }else if(Parameter::getUserParameter("paramLayoutObjectDetail")=='4' and RequestHandler::getValue('paramLayoutObjectDetail')=='0'){
    $valScreen='0';
    Parameter::storeUserParameter("paramLayoutObjectDetail", $valScreen);
  }
  //florent
  if(Parameter::getUserParameter("paramRightDiv") == '3' and Parameter::getUserParameter('paramScreen')=='0' ){
    $detailRightHeightPlanning=Parameter::getUserParameter('contentPaneRightDetailDivHeightGlobalPlanning');
    if (!$detailRightHeightPlanning) $detailRightHeightPlanning=0;
    if($detailRightHeightPlanning or $detailRightHeightPlanning==="0"){
      if ($detailRightHeightPlanning > 750){
        $detailRightHeightPlanning=750;
      }
      if ($detailRightHeightPlanning < 80){
        $detailRightHeightPlanning=100;
      }
      $rightHeightGlobalPlanning=$detailRightHeightPlanning.'px';
    } else {
      $rightHeightGlobalPlanning="0%";
    }
  }else{
    $rightHeightGlobalPlanning="20%";
  }
  ///////
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="GlobalPlanning" />
<input type="hidden" name="globalPlanning" id="globalPlanning" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer" onclick="hideDependencyRightClick();">
 <div dojoType="dijit.layout.ContentPane" region="center" splitter="true">
    <div class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
      <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positionListDiv; ?>" splitter="true" style="height:<?php echo $listHeight;?>;">
        <script type="dojo/connect" event="resize" args="evt">
          if (switchedMode) return;
          storePaneSize("contentPaneTopGlobalPlanningDivHeight",dojo.byId("listDiv").offsetHeight);
        </script>
        <?php include 'globalPlanningList.php'?>
      </div>
      <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"   style="width:<?php echo $widthDetailDiv; ?>;">
	  <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
          <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center"> 
            <div id="detailBarShow" class="dijitAccordionTitle" onMouseover="hideList('mouse');" onClick="hideList('click');">
              <div id="detailBarIcon" align="center"></div> 
            </div> 
            <?php $noselect=true; //include 'objectDetail.php'; ?>
          </div>
          <?php if (property_exists($objectClass, '_Note') and Module::isModuleActive('moduleActivityStream') and Parameter::getUserParameter("paramRightDiv") !='3' ) {?>
      	  <div id="hideStreamButton" region="center" style="cursor:pointer;position:absolute; right:0px; bottom:2px;z-index:999999">
      	     <a onClick="hideStreamMode(false);" id="buttonSwitchedStream" title="" ><span style="top:px;display:inline-block;margin-right:12px;"><div class='iconActivityStream32 '  >&nbsp;</div></span></a>
      	  </div>
          <?php }?>
          <div id="detailRightDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positonRightDiv; ?>" splitter="true" style="width:<?php echo $rightWidthGlobalPlanning;?>;height:<?php echo $rightHeightGlobalPlanning;?>">
              <script type="dojo/connect" event="resize" args="evt">
                  saveDataToSession("contentPaneRightDetailDivWidthGlobalPlanning", dojo.byId("detailRightDiv").offsetWidth, true);
                  saveDataToSession("contentPaneRightDetailDivHeightGlobalPlanning", dojo.byId("detailRightDiv").offsetHeight, true);
                  var newWidth=dojo.byId("detailRightDiv").offsetWidth;
                  dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
                  node.style.maxWidth=(newWidth-30)+"px";
                  });
              </script>
              <script type="dojo/connect" event="onLoad" args="evt">
                scrollInto();
	         </script>
              <?php include 'objectStream.php'?>
          </div>
      </div>
      </div>
 </div>
</div>  