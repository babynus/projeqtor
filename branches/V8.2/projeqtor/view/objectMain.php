<?php 
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
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
  $paramScreen=RequestHandler::getValue('paramScreen');
  $paramLayoutObjectDetail=RequestHandler::getValue('paramLayoutObjectDetail');
  $paramRightDiv=RequestHandler::getValue('paramRightDiv');
  $positionListDiv=changeLayoutObjectDetail($paramScreen,$paramLayoutObjectDetail);
  $positonRightDiv=changeLayoutActivityStream($paramRightDiv);
  ///////
  $objectClass="";
  if (isset($_REQUEST['objectClass'])) {
    $objectClass=$_REQUEST['objectClass'];
    Security::checkValidClass($objectClass);
  	if ($_REQUEST['objectClass']=='CalendarDefinition') {
  		$listHeight='25%';
  	}else if ($positionListDiv=='top'){
  	  $listHeight=HeightLayoutListDiv($objectClass);
  	}
  	if($positonRightDiv=="bottom"){
      $rightHeight=heightLaoutActivityStream($objectClass);
    }else{
  	 $rightWidth=WidthLayoutActivityStream($objectClass);
  	}
  }
  $tableWidth=WidthDivContentDetail($positionListDiv,$objectClass);

?>
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
  <div dojoType="dijit.layout.ContentPane" region="center" splitter="true">
    <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
      <div id="listBarShow" class="dijitAccordionTitle" onMouseover="showList('mouse')" onClick="showList('click');">
        <div id="listBarIcon" align="center"></div>
      </div>
	  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positionListDiv; ?>" splitter="true" 
	  style="<?php if($positionListDiv=='top'){echo "height:".$listHeight;}else{ echo "width:".$tableWidth[0];}?>">
	     <script type="dojo/connect" event="resize" args="evt">
            if (switchedMode) return;
            var paramDiv=<?php echo json_encode($positionListDiv); ?>;
            var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
            if(paramDiv=="top" && paramMode!='5'){
              saveDataToSession("contentPaneTopDetailDivHeight<?php echo $objectClass;?>", dojo.byId("listDiv").offsetHeight, true);
            }else if(paramMode!='5'){
              saveDataToSession("contentPaneTopDetailDivWidth<?php echo $objectClass;?>", dojo.byId("listDiv").offsetWidth, true);
            }
         </script>
	     <?php include 'objectList.php'?>
	  </div>
	  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"  style="width:<?php echo $tableWidth[1];?>;">
	    <script type="dojo/connect" event="resize" args="evt">
          var paramDiv=<?php echo json_encode($positionListDiv); ?>;
          var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
          if(paramDiv=="top" && paramMode!='5'){
            saveDataToSession("contentPaneDetailDivHeight<?php echo $objectClass;?>", dojo.byId("contentDetailDiv").offsetHeight, true);
          } else if(paramMode!='5'){
            saveDataToSession("contentPaneDetailDivWidth<?php echo $objectClass;?>", dojo.byId("contentDetailDiv").offsetWidth, true);
            var param=dojo.byId('objectClass').value;
            var paramId=dojo.byId('objectId').value;
            if(paramId !='' && multiSelection==false){
              loadContent("objectDetail.php?objectClass"+param+"&objectId="+paramId, "detailDiv", 'listForm');  
            }else if(multiSelection==true){
              loadContent('objectMultipleUpdate.php?objectClass=' + param,'detailDiv');
            }
          }
          //resizeListDiv();
          var width = parseInt(dojo.style('listDiv', "width"));
          dojo.query(".allSearchTD").forEach(function(node, index, nodelist) { node.style.display="table-cell";});
          var refWidth=50;
          if (width<1650) {
            dojo.query(".parentBudgetSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
          if (width<1300) {
            dojo.query(".clientSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
          if (width<1100) {
            refWidth=25;
          }
          dojo.query("#widget_listNameFilter").forEach(function(node, index, nodelist) { node.style.width=(refWidth*2)+"px";});
          dojo.query("#widget_listIdFilter").forEach(function(node, index, nodelist) { node.style.width=(refWidth*1)+"px";});
          dojo.query("#widget_listTypeFilter").forEach(function(node, index, nodelist) { node.style.width=(refWidth*4)+"px";});

          if (width<900) {
            dojo.query(".typeSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
          if (width<800) {
            dojo.query(".idSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
            dojo.query(".resetSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
          if (width<700) {
            dojo.query(".idSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
          if (width<630) {
            dojo.query(".idleSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
          if (width<600) {
            dojo.query(".nameSearchTD").forEach(function(node, index, nodelist) { node.style.display="none";});
          }
         </script>
	    <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
	       <div id="detailBarShow" class="dijitAccordionTitle"
              onMouseover="hideList('mouse');" onClick="hideList('click');"
              <?php if (RequestHandler::isCodeSet('switchedMode') and RequestHandler::getValue('switchedMode')=='on') echo ' style="display:block;"'?>>
              <div id="detailBarIcon" align="center"></div>
          </div>
	    <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center" >
		   <?php $noselect=true; include 'objectDetail.php'; ?>
		</div>

	  <?php 
            if (property_exists($objectClass, '_Note') and Module::isModuleActive('moduleActivityStream')) {
              $showNotes=true;
              $item=new $objectClass();
              if ($item->isAttributeSetToField('_Note','hidden')) $showNotes=false;
              else if (in_array('_Note',$item->getExtraHiddenFields(null, null, getSessionUser()->getProfile()))) $showNotes=false;
            } else {
              $showNotes=false;
            }
      if ($showNotes) {?>
	  <div id="detailRightDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positonRightDiv; ?>" splitter="true" 
	  style="<?php if($positonRightDiv=="bottom"){echo "height:".$rightHeight;}else{ echo "width:".$rightWidth;}?>">
      	  <script type="dojo/connect" event="resize" args="evt">
              var paramDiv=<?php echo json_encode($positonRightDiv); ?>;
              var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
              if(paramDiv=='trailing' && paramMode!='5'){
                saveDataToSession("contentPaneRightDetailDivWidth<?php echo $objectClass;?>", dojo.byId("detailRightDiv").offsetWidth, true);
                var newWidth=dojo.byId("detailRightDiv").offsetWidth;
                dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
                  node.style.maxWidth=(newWidth-30)+"px";
                });
              }else if (paramMode!='5'){
                saveDataToSession("contentPaneRightDetailDivHeight<?php echo $objectClass;?>", dojo.byId("detailRightDiv").offsetHeight, true);
                if (dijit.byId('detailRightDiv')) loadContent("objectStream.php", "detailRightDiv", 'listForm');
              }
                
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