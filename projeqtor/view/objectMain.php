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
  scriptLog('   ->/view/objectMain.php');
  //florent
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
      $widthListDiv='58%';
      $widthDetailDiv='42%';
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
  ///////
     
  $listHeight='40%';
  $objectClass="";
  if (isset($_REQUEST['objectClass'])) {
    $objectClass=$_REQUEST['objectClass'];
    Security::checkValidClass($objectClass);
  	if ($_REQUEST['objectClass']=='CalendarDefinition') {
  		$listHeight='25%';
  	}
  	$topDetailDivHeight=Parameter::getUserParameter('contentPaneTopDetailDivHeight'.$objectClass);
  	$screenHeight=getSessionValue('screenHeight');
  	if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
  		$topDetailDivHeight=$screenHeight-300;
  	}
  	$listHeight=($topDetailDivHeight)?$topDetailDivHeight.'px':$listHeight; 	
  	$detailDivWidth=Parameter::getUserParameter('contentPaneRightDetailDivWidth'.$objectClass);
  	if (!$detailDivWidth) $detailDivWidth=0;
  	if($detailDivWidth or $detailDivWidth==="0"){
  	  if ($detailDivWidth > 400){
  	    $detailDivWidth=400;
  	  }
  	  $rightWidth=$detailDivWidth.'px';
  	} else {
  	  $rightWidth="0%";
  	}
  }
  //florent
  if(Parameter::getUserParameter("paramRightDiv") == '3' and Parameter::getUserParameter('paramScreen')=='0' ){
    $detailRightHeight=Parameter::getUserParameter('contentPaneRightDetailDivHeight'.$objectClass);
    if (!$detailRightHeight) $detailRightHeight=0;
    if($detailRightHeight or $detailRightHeight==="0"){
      if ($detailRightHeight > 750){
        $detailRightHeight=750;
      }
      if ($detailRightHeight < 80){
        $detailRightHeight=100;
      }
      $rightHeight=$detailRightHeight.'px';
    } else {
      $rightHeight="0%";
    }
  }else{
    $rightHeight="20%";
  }
  ///////
  
?>
<input type="hidden" id="objectClass" value="<?php echo $objectClass;?>" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
  <div dojoType="dijit.layout.ContentPane" region="center" splitter="true">
    <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
	  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positionListDiv; ?>" splitter="true" style="height:<?php echo $listHeight;?>;width:<?php echo $widthListDiv; ?>;">
	     <script type="dojo/connect" event="resize" args="evt">
            if (switchedMode) return;
            saveDataToSession("contentPaneTopDetailDivHeight<?php echo $objectClass;?>", dojo.byId("listDiv").offsetHeight, true);
         </script>
	     <?php include 'objectList.php'?>
	  </div>
	  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"  style="width:<?php echo $widthDetailDiv; ?>;">
	  <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
	    <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center" >
		   <?php $noselect=true; include 'objectDetail.php'; ?>
		</div>
            <script type="dojo/connect" event="resize" args="evt">
              saveDataToSession("contentPaneDetailDivHeight<?php echo $objectClass;?>", dojo.byId("contentDetailDiv").offsetHeight, true);
            </script>
	  <?php if (property_exists($objectClass, '_Note') and Module::isModuleActive('moduleActivityStream') and Parameter::getUserParameter("paramRightDiv") !='3' ) {?>
    	<div id="hideStreamButton" region="center" style="cursor:pointer;position:absolute; right:0px; bottom:2px;z-index:999999">
    	   <a onClick="hideStreamMode(false);" id="buttonSwitchedStream" title="" ><span style="top:px;display:inline-block;margin-right:12px;"><div class='iconActivityStream32 '  >&nbsp;</div></span></a>
    	</div>
      <?php 
            }
            if (property_exists($objectClass, '_Note') and Module::isModuleActive('moduleActivityStream')) {
              $showNotes=true;
              $item=new $objectClass();
              if ($item->isAttributeSetToField('_Note','hidden')) $showNotes=false;
              else if (in_array('_Note',$item->getExtraHiddenFields(null, null, getSessionUser()->getProfile()))) $showNotes=false;
            } else {
              $showNotes=false;
            }
      if ($showNotes) {?>
	  <div id="detailRightDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positonRightDiv; ?>" splitter="true" style="width:<?php echo $rightWidth;?>;height:<?php echo $rightHeight;?>">
      	  <script type="dojo/connect" event="resize" args="evt">
              saveDataToSession("contentPaneRightDetailDivWidth<?php echo $objectClass;?>", dojo.byId("detailRightDiv").offsetWidth, true);
              saveDataToSession("contentPaneRightDetailDivHeight<?php echo $objectClass;?>", dojo.byId("detailRightDiv").offsetHeight, true);
              var newWidth=dojo.byId("detailRightDiv").offsetWidth;
              dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
              node.style.maxWidth=(newWidth-30)+"px";
              });
      	  </script>
      	  <script type="dojo/connect" event="onLoad" args="evt">
              scrollInto();
	  	  </script>
          <?php include 'objectStream.php';?>
	  </div>
      <?php }?>  
      </div>
      </div>
    </div>
  </div>
</div>