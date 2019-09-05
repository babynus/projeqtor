<?php

/*
 * @author: qCazelles 
 */

require_once "../tool/projeqtor.php";
scriptLog('   ->/view/versionsPlanningMain.php');

$topDetailDivHeight=Parameter::getUserParameter('contentPaneTopPlanningDivHeight');
$screenHeight=getSessionValue('screenHeight');
if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
	$topDetailDivHeight=$screenHeight-300;
}

//florent
$paramScreen=RequestHandler::getValue('paramScreen');
$paramLayoutObjectDetail=RequestHandler::getValue('paramLayoutObjectDetail');
$paramRightDiv=RequestHandler::getValue('paramRightDiv');
$currentScreen='VersionsPlannig';
$positionListDiv=changeLayoutObjectDetail($paramScreen,$paramLayoutObjectDetail);
$positonRightDiv=changeLayoutActivityStream($paramRightDiv);
if ($positionListDiv=='top'){
  $listHeight=HeightLayoutListDiv($currentScreen);
}
if($positonRightDiv=="bottom"){
  $rightHeightVersionsPlannig=heightLaoutActivityStream($currentScreen);
}else{
  $rightWidthVersionsPlannig=WidthLayoutActivityStream($currentScreen);
}
$tableWidth=WidthDivContentDetail($positionListDiv,$currentScreen);
//////
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="VersionsPlanning" />
<input type="hidden" name="versionsPlanning" id="versionsPlanning" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer" onclick="hideDependencyRightClick();">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top" splitter="true" 
   style="<?php if($positionListDiv=='top'){echo "height:".$listHeight;}else{ echo "width:".$tableWidth[0];}?>">
    <script type="dojo/connect" event="resize" args="evt">
         if (switchedMode) return;
         var paramDiv=<?php echo json_encode($positionListDiv); ?>;
         var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
         if(paramDiv=="top" && paramMode!='5'){
             saveDataToSession("contentPaneTopDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetHeight, true);
          }else{
              saveDataToSession("contentPaneTopDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetWidth, true);
          }
    </script>
   <?php include 'versionsPlanningList.php'?>
  </div>
  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"   style="width:<?php echo $tableWidth[1]; ?>;">
      <script type="dojo/connect" event="resize" args="evt">
           var paramDiv=<?php echo json_encode($positionListDiv); ?>;
           var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
           if(paramDiv=="top" && paramMode!='5'){
            saveDataToSession("contentPaneDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("contentDetailDiv").offsetHeight, true);
           }else{
              saveDataToSession("contentPaneDetailDivWidth<?php echo $currentScreen;?>", dojo.byId("contentDetailDiv").offsetWidth, true);
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
      style="<?php if($positonRightDiv=="bottom"){echo "height:".$rightHeightVersionsPlannig;}else{ echo "width:".$rightWidthVersionsPlannig;}?>">
              <script type="dojo/connect" event="resize" args="evt">
               var paramDiv=<?php echo json_encode($positonRightDiv); ?>;
               var paramMode=<?php echo json_encode(Parameter::getUserParameter('paramScreen')); ?>;
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