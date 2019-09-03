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
  $listHeight='60%';
  $topDetailDivHeight=Parameter::getUserParameter('contentPaneTopResourcePlanningDivHeight');
  $screenHeight=getSessionValue('screenHeight');
  if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
    $topDetailDivHeight=$screenHeight-300;
  }
  $listHeight=($topDetailDivHeight)?$topDetailDivHeight.'px':$listHeight;
  $detailDivWidthPlanning=Parameter::getUserParameter('contentPaneRightDetailDivWidthResourcePlanning');
  if($detailDivWidthPlanning or $detailDivWidthPlanning==="0"){
    if ($detailDivWidthPlanning > 400){
      $detailDivWidthPlanning=400;
    }
    $rightWidthResourcePlanning=$detailDivWidthPlanning.'px';
  } else {
    $rightWidthResourcePlanning="15%";
  }
  //florent
  $paramScreen=RequestHandler::getValue('paramScreen');
  $paramLayoutObjectDetail=RequestHandler::getValue('paramLayoutObjectDetail');
  $paramRightDiv=RequestHandler::getValue('paramRightDiv');
  $currentScreen='ResourcePlanning';
  $positionListDiv=changeLayoutObjectDetail($paramScreen,$paramLayoutObjectDetail);
  $positonRightDiv=changeLayoutActivityStream($paramRightDiv);
  if($positonRightDiv=="bottom"){
    $rightHeightResourcePlanning=heightLaoutActivityStream($currentScreen);
  }
  if($positionListDiv=='left'){
    $widthListDiv='65%';
    $widthDetailDiv='25%';
  }else{
    $widthListDiv='100%';
    $widthDetailDiv='100%';
  }
  ///////
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="ResourcePlanning" />
<input type="hidden" name="resourcePlanning" id="resourcePlanning" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listBarShow" class="dijitAccordionTitle" onMouseover="showList('mouse')" onClick="showList('click');">
	<div id="listBarIcon" align="center"></div>
  </div>
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positionListDiv?>" splitter="true" 
   style="<?php if($positionListDiv=='top'){echo "height:".$listHeight;}else{ echo "width:".$widthListDiv;}?>">
    <script type="dojo/connect" event="resize" args="evt">
         if (switchedMode) return;
         var paramDiv=<?php echo json_encode($positionListDiv); ?>;
           if(paramDiv=="top"){
             saveDataToSession("contentPaneTopResourcePlanningDivHeight", dojo.byId("listDiv").offsetHeight, true);
          }
    </script>
   <?php include 'resourcePlanningList.php'?>
  </div>
  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"   style="width:<?php echo $widthDetailDiv; ?>;">
      <script type="dojo/connect" event="resize" args="evt">
           var paramDiv=<?php echo json_encode($positionListDiv); ?>;
           if(paramDiv=="top"){
            saveDataToSession("contentPaneDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("detailDiv").offsetHeight, true);
           }
      </script>
  <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
  <div id="detailBarShow" class="dijitAccordionTitle" onMouseover="hideList('mouse');" onClick="hideList('click');">
          <div id="detailBarIcon" align="center"></div>
        </div>
      <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center"  style="width:<?php echo $widthDetailDiv?>">
        <?php $noselect=true; //include 'objectDetail.php'; ?>

      </div>
      <div id="detailRightDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positonRightDiv; ?>" splitter="true" 
      style="<?php if($positonRightDiv=="bottom"){echo "height:".$rightHeightResourcePlanning;}else{ echo "width:".$rightWidthResourcePlanning;}?>">
              <script type="dojo/connect" event="resize" args="evt">
               var paramDiv=<?php echo json_encode($positonRightDiv); ?>;
                  if(paramDiv=='trailing'){
                    saveDataToSession("contentPaneRightDetailDivWidthResourcePlanning", dojo.byId("detailRightDiv").offsetWidth, true);
                    var newWidth=dojo.byId("detailRightDiv").offsetWidth;
                    dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
                    node.style.maxWidth=(newWidth-30)+"px";
                    });
                  }else{
                    saveDataToSession("contentPaneRightDetailDivHeightResourcePlanning", dojo.byId("detailRightDiv").offsetHeight, true);
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