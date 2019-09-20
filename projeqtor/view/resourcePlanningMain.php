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
  scriptLog('   ->/view/planningMain.php');  
  $topDetailDivHeight=Parameter::getUserParameter('contentPaneTopResourcePlanningDivHeight');
  $screenHeight=getSessionValue('screenHeight');
  if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
    $topDetailDivHeight=$screenHeight-300;
  }
  //florent
  $paramScreen=RequestHandler::getValue('paramScreen');
  $paramLayoutObjectDetail=RequestHandler::getValue('paramLayoutObjectDetail');
  $paramRightDiv=RequestHandler::getValue('paramRightDiv');
  $currentScreen='ResourcePlanning';
  $positionListDiv=changeLayoutObjectDetail($paramScreen,$paramLayoutObjectDetail);
  $positonRightDiv=changeLayoutActivityStream($paramRightDiv);
  $codeModeLayout=Parameter::getUserParameter('paramScreen');
 if ($positionListDiv=='top'){
   $listHeight=HeightLayoutListDiv($currentScreen);
 }
 if($positonRightDiv=="bottom"){
   $rightHeightResourcePlanning=heightLaoutActivityStream($currentScreen);
 }else{
  $rightWidthResourcePlanning=WidthLayoutActivityStream($currentScreen);
 }
 $tableWidth=WidthDivContentDetail($positionListDiv,$currentScreen);
 $activModeStream=Parameter::getUserParameter('modeActiveStreamGlobal');
 //////
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="ResourcePlanning" />
<input type="hidden" name="resourcePlanning" id="resourcePlanning" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listBarShow" class="dijitAccordionTitle" onMouseover="showList('mouse')" onClick="showList('click');">
	<div id="listBarIcon" align="center"></div>
  </div>
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positionListDiv?>" splitter="true" 
   style="<?php if($positionListDiv=='top'){echo "height:".$listHeight;}else{ echo "width:".$tableWidth[0];}?>">
    <script type="dojo/connect" event="resize" args="evt">
         if (switchedMode) return;
         var paramDiv=<?php echo json_encode($positionListDiv); ?>;
         var paramMode=<?php echo json_encode($codeModeLayout); ?>;
         if(paramDiv=="top" && paramMode!='5'){
             saveDataToSession("contentPaneTopDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetHeight, true);
          }else if(paramMode!='5'){
              saveDataToSession("contentPaneTopDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetWidth, true);
          }
    </script>
   <?php include 'resourcePlanningList.php'?>
  </div>
  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"   style="width:<?php echo $tableWidth[1]; ?>;">
      <script type="dojo/connect" event="resize" args="evt">
           var paramDiv=<?php echo json_encode($positionListDiv); ?>;
           var paramRightDiv=<?php echo json_encode($positonRightDiv);?>;
           var paramMode=<?php echo json_encode($codeModeLayout); ?>;
           if (checkValidatedSize(paramDiv,paramRightDiv, paramMode)){
            return;
           }
           if(paramDiv=="top" && paramMode!='5'){
            saveDataToSession("contentPaneDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("contentDetailDiv").offsetHeight, true);
           }else if(paramMode!='5'){
              saveDataToSession("contentPaneDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("contentDetailDiv").offsetWidth, true);
              var param=dojo.byId('objectClass').value;
              var paramId=dojo.byId('objectId').value;
              if(paramId !='' && multiSelection==false){
                loadContent("objectDetail.php?objectClass="+param+"&objectId="+paramId, "detailDiv", 'listForm');  
              }else if(multiSelection==true){
               loadContent('objectMultipleUpdate.php?objectClass=' + param,
                  'detailDiv')
              }
            }
      </script>
  <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
        <div id="detailBarShow" class="dijitAccordionTitle" onMouseover="hideList('mouse');" onClick="hideList('click');"
          <?php if (RequestHandler::isCodeSet('switchedMode') and RequestHandler::getValue('switchedMode')=='on') echo ' style="display:block;"'?>>
          <div id="detailBarIcon" align="center"></div>
        </div>
      <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center" >
        <?php $noselect=true; //include 'objectDetail.php'; ?>

      </div>
      <div id="detailRightDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positonRightDiv; ?>" splitter="true" 
      style="<?php if($positonRightDiv=="bottom"){echo "height:".$rightHeightResourcePlanning;}else{ echo "width:".$rightWidthResourcePlanning;}?>">
              <script type="dojo/connect" event="resize" args="evt">
               var paramDiv=<?php echo json_encode($positionListDiv); ?>;
               var paramMode=<?php echo json_encode($codeModeLayout); ?>;
               var paramRightDiv=<?php echo json_encode($positonRightDiv); ?>;
               var activModeStream=<?php echo json_encode($activModeStream);?>;
               hideSplitterStream (paramRightDiv);
               if (checkValidatedSizeRightDiv(paramDiv,paramRightDiv, paramMode)){
                    return;
                  }
                  if(paramRightDiv=='trailing' && paramMode!='5'){
                    if(activModeStream=='true') {
                      saveDataToSession("contentPaneRightDetailDivWidth", dojo.byId("detailRightDiv").offsetWidth, true);
                    } 
                    saveDataToSession("contentPaneRightDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("detailRightDiv").offsetWidth, true);
                    var newWidth=dojo.byId("detailRightDiv").offsetWidth;
                    dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
                    node.style.maxWidth=(newWidth-30)+"px";
                    });
                  }else if(paramMode!='5'){
                   if(activModeStream=='true') {
                      saveDataToSession("contentPaneRightDetailDivHeight", dojo.byId("detailRightDiv").offsetHeight, true);
                    }
                    saveDataToSession("contentPaneRightDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("detailRightDiv").offsetHeight, true);
                    var newHeight=dojo.byId("detailRightDiv").offsetHeight;
                    if (dojo.byId("noteNoteStream")) dojo.byId("noteNoteStream").style.height=(newHeight-40)+'px';
                 }
                 
              </script>
              <script type="dojo/connect" event="onLoad" args="evt">
                scrollInto();
	         </script>
              <?php include 'objectStream.php'?>
          </div>
  </div>
  </div>
</div>  