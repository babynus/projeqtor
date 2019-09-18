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
  scriptLog('   ->/view/portfolioPlanningMain.php');  
  
  $topDetailDivHeight=Parameter::getUserParameter('contentPaneTopPortfolioPlanningDivHeight');
  $screenHeight=getSessionValue('screenHeight');
  if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
  	$topDetailDivHeight=$screenHeight-300;
  }
  //florent
  $paramScreen=RequestHandler::getValue('paramScreen');
  $paramLayoutObjectDetail=RequestHandler::getValue('paramLayoutObjectDetail');
  $paramRightDiv=RequestHandler::getValue('paramRightDiv');
  $currentScreen='PortfolioPlanning';
  $positionListDiv=changeLayoutObjectDetail($paramScreen,$paramLayoutObjectDetail);
  $positonRightDiv=changeLayoutActivityStream($paramRightDiv);
 $tableWidth=WidthDivContentDetail($positionListDiv,$currentScreen);
 if ($positionListDiv=='top'){
   $listHeight=HeightLayoutListDiv($currentScreen);
 }
 if($positonRightDiv=="bottom"){
   $rightHeightPortfolioPlanning=heightLaoutActivityStream($currentScreen);
 }else{
   $rightWidthPortfolioPlanning=WidthLayoutActivityStream($currentScreen);
 }
 $tableWidth=WidthDivContentDetail($positionListDiv,$currentScreen);
 //////
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="PortfolioPlanning" />
<input type="hidden" name="portfolioPlanning" id="portfolioPlanning" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listBarShow" class="dijitAccordionTitle"  onMouseover="showList('mouse')" onClick="showList('click');">
    <div id="listBarIcon" align="center"></div>
  </div>
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positionListDiv?>" splitter="true" 
   style="<?php if($positionListDiv=='top'){echo "height:".$listHeight;}else{ echo "width:".$tableWidth[0];}?>">
    <script type="dojo/connect" event="resize" args="evt">
      if (switchedMode) return;
      var paramDiv=<?php echo json_encode($positionListDiv); ?>;
      var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
      if(paramDiv=="top" && paramMode!='5'){
        saveDataToSession("contentPaneTopDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetHeight, true);
      }else if(paramMode!='5'){
        saveDataToSession("contentPaneTopDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetWidth, true);
      }
    </script>
   <?php include 'portfolioPlanningList.php'?>
  </div>
  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"   style="width:<?php echo $tableWidth[1]; ?>;">
      <script type="dojo/connect" event="resize" args="evt">
           var paramDiv=<?php echo json_encode($positionListDiv); ?>;
           var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
            checkValidatedSize(paramDiv);
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
     style="<?php if($positonRightDiv=="bottom"){echo "height:".$rightHeightPortfolioPlanning;}else{ echo "width:".$rightWidthPortfolioPlanning;}?>">
              <script type="dojo/connect" event="resize" args="evt">
                  var paramDiv=<?php echo json_encode($positonRightDiv); ?>;
                  var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
                  hideSplitterStream (paramDiv);
                  if(paramDiv=='trailing' && paramMode!='5'){
                    saveDataToSession("contentPaneRightDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("detailRightDiv").offsetWidth, true);
                    var newWidth=dojo.byId("detailRightDiv").offsetWidth;
                    dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
                    node.style.maxWidth=(newWidth-30)+"px";
                    });
                  }else if(paramMode!='5'){
                    saveDataToSession("contentPaneRightDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("detailRightDiv").offsetHeight, true);
                
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