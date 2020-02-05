<?php

/*
 * @author: qCazelles 
 */

require_once "../tool/projeqtor.php";
scriptLog('   ->/view/hierarchicalBudgetMain.php');
//florent
$paramScreen=RequestHandler::getValue('paramScreen');
$paramLayoutObjectDetail=RequestHandler::getValue('paramLayoutObjectDetail');
$paramRightDiv=RequestHandler::getValue('paramRightDiv');
$currentScreen='VersionsPlanning';
setSessionValue('currentScreen', $currentScreen);
$positionListDiv=changeLayoutObjectDetail($paramScreen,$paramLayoutObjectDetail);
$positonRightDiv=changeLayoutActivityStream($paramRightDiv);
$codeModeLayout=Parameter::getUserParameter('paramScreen');
if ($positionListDiv=='top'){
  $listHeight=HeightLayoutListDiv($currentScreen);
}
if($positonRightDiv=="bottom"){
  $rightHeightVersionsPlanning=getHeightLaoutActivityStream($currentScreen);
}else{
  $rightWidthVersionsPlanning=getWidthLayoutActivityStream($currentScreen);
}
$tableWidth=WidthDivContentDetail($positionListDiv,$currentScreen);
$activModeStream=Parameter::getUserParameter('modeActiveStreamGlobal');
//////

if (! isset($comboDetail)) {
	$comboDetail=false;
}
$objectClass='Budget';
Security::checkValidClass($objectClass);
$objectType='';
if (array_key_exists('objectType',$_REQUEST)) {
	$objectType=$_REQUEST['objectType'];
}

$budgetParent=RequestHandler::getValue('budgetParent');

$objectClient='';
if (array_key_exists('objectClient',$_REQUEST)) {
	$objectClient=$_REQUEST['objectClient'];
}
$objectElementable='';
if (array_key_exists('objectElementable',$_REQUEST)) {
	$objectElementable=$_REQUEST['objectElementable'];
}
$obj=new $objectClass;

if (array_key_exists('Directory', $_REQUEST)) {
	setSessionValue('Directory', $_REQUEST['Directory']);
} else {
	unsetSessionValue('Directory');
}
$multipleSelect=false;
if (array_key_exists('multipleSelect', $_REQUEST)) {
	if ($_REQUEST['multipleSelect']) {
		$multipleSelect=true;
	}
}
$showIdle=(! $comboDetail and sessionValueExists('projectSelectorShowIdle') and getSessionValue('projectSelectorShowIdle')==1)?1:0;
if ((Parameter::getUserParameter('showIdleDefault'))=='true') $showIdle=($showIdle==1)?0:1;
if (! $comboDetail and is_array( getSessionUser()->_arrayFilters)) {
	if (array_key_exists($objectClass, getSessionUser()->_arrayFilters)) {
		$arrayFilter=getSessionUser()->_arrayFilters[$objectClass];
		foreach ($arrayFilter as $filter) {
			if ($filter['sql']['attribute']=='idle' and $filter['sql']['operator']=='>=' and $filter['sql']['value']=='0') {
				$showIdle=1;
			}
		}
	}
}

$displayWidthList="1980";
if (RequestHandler::isCodeSet('destinationWidth')) {
	//$displayWidthList=RequestHandler::getNumeric('destinationWidth');
}
$rightWidthVal=0;
if (isset($rightWidth)) {
	if (substr($rightWidth,-1)=="%") {
		$rightWidthVal=(intval(str_replace('%', '', $rightWidth))/100)*$displayWidthList;
	} else {
		$rightWidthVal=intval(str_replace('px', '', $rightWidth));
	}
} else {
	$detailRightDivWidth=Parameter::getUserParameter('contentPaneRightDetailDivWidth'.$objectClass);
	if (!$detailRightDivWidth) $detailRightDivWidth=0;
	if($detailRightDivWidth or $detailRightDivWidth==="0"){
		$rightWidthVal=$detailRightDivWidth;
	} else {
		$rightWidth=0;//15/100*$displayWidthList;
	}
}
$displayWidthList-=$rightWidthVal;

$hideTypeSearch=false;
$hideClientSearch=false;
$hideParentBudgetSearch=false;
$hideNameSearch=false;
$hideIdSearch=false;
$hideShowIdleSearch=false;
$hideEisSearch=false;
$referenceWidth=50;
if ($comboDetail) {
	$screenWidth=getSessionValue('screenWidth',$displayWidthList);
	$displayWidthList=round($screenWidth*0.55,0)+150;
}
if ($displayWidthList<1560 and $objectClass == 'Budget' ) {
	$hideClientSearch=true;
}
if ($displayWidthList<1400) {
	$referenceWidth=40;
	if ($displayWidthList<1250) {
		$hideParentBudgetSearch=true;
		$referenceWidth=30;
		if ($displayWidthList<1165) {
			$hideClientSearch=true;
			$hideEisSearch=true;
			if ($displayWidthList<1025) {
				$hideTypeSearch=true;
				if ($displayWidthList<700) {
					$hideIdSearch=true;
					if ($displayWidthList<650) {
						$hideShowIdleSearch=true;
						if ($displayWidthList<550) {
							$hideNameSearch=true;
						}
					}
				}
			}
		}
	}
}
$extrahiddenFields=$obj->getExtraHiddenFields('*','*');
if ($obj->isAttributeSetToField('idClient','hidden') or in_array('idClient',$extrahiddenFields)) $hideClientSearch=true;
if ($obj->isAttributeSetToField('idBudget','hidden') or in_array('idBudget',$extrahiddenFields)) $hideParentBudgetSearch=true;
if ($obj->isAttributeSetToField('id'.$objectClass.'Type','hidden') or in_array('id'.$objectClass.'Type',$extrahiddenFields)) $hideTypeSearch=true;

if ($comboDetail) $referenceWidth-=5;

$iconClassName=((SqlElement::is_subclass_of($objectClass, 'PlgCustomList'))?'ListOfValues':$objectClass);

$allProjectsChecked=false;
if (RequestHandler::getValue('objectClass')=='Project' and RequestHandler::getValue('mode')=='search') {
	$allProjectsChecked=true;
}

//Gautier saveParam
if(sessionValueExists('listTypeFilter'.$objectClass)){
	$listTypeFilter = getSessionValue('listTypeFilter'.$objectClass);
}else{
	$listTypeFilter = '';
}
if(sessionValueExists('listClientFilter'.$objectClass)){
	$listClientFilter = getSessionValue('listClientFilter'.$objectClass);
}else{
	$listClientFilter = '';
}
if(sessionValueExists('listElementableFilter'.$objectClass)){
	$listElementableFilter = getSessionValue('listElementableFilter'.$objectClass);
}else{
	$listElementableFilter = '';
}
if(sessionValueExists('listBudgetParentFilter') and $objectClass=='Budget'){
	$listBudgetParent = getSessionValue('listBudgetParentFilter');
}else{
	$listBudgetParent = '';
}
if(sessionValueExists('listShowIdle'.$objectClass)){
	$listShowIdle = getSessionValue('listShowIdle'.$objectClass);
	if($listShowIdle == "on"){
		$listShowIdle = true;
	}else{
		$listShowIdle = '';
	}
}else{
	$listShowIdle = '';
}

//objectStatus
$objectStatus = array();
$object = new $objectClass();
$cptStatus=0;
$filteringByStatus = false;
if (property_exists($objectClass,'idStatus')) {
	$listStatus = $object->getExistingStatus();
	foreach ($listStatus as $status) {
		$cptStatus += 1;
		if(sessionValueExists('showStatus'.$status->id.$objectClass)){
			if(getSessionValue('showStatus'.$status->id.$objectClass)=='true'){
				$filteringByStatus = true;
				$objectStatus[$cptStatus] = $status->id;
			}
		}
	}
}
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="HierarchicalBudget" />
<input type="hidden" name="HierarchicalBudget" id="HierarchicalBudget" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer" onclick="hideDependencyRightClick();">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="<?php  echo $positionListDiv;?>" splitter="true" 
   style="<?php if($positionListDiv=='top'){echo "height:".$listHeight;}else{ echo "width:".$tableWidth[0];}?>">
    <script type="dojo/connect" event="resize" args="evt">
         if (switchedMode) return;
         var paramDiv=<?php  echo json_encode($positionListDiv); ?>;
         var paramMode=<?php  echo json_encode($codeModeLayout); ?>;
         if(paramDiv=="top" && paramMode!='switch'){
             saveDataToSession("contentPaneTopDetailDivHeight<?php echo $currentScreen;?>", dojo.byId("listDiv").offsetHeight, true);
          }else{
            saveDataToSession("contentPaneTopDetailDivWidth<?php  echo $currentScreen;?>", dojo.byId("listDiv").offsetWidth, true);
          }
    </script>
   <?php include 'hierarchicalBudgetView.php'?>
  </div>
  <div id="contentDetailDiv" dojoType="dijit.layout.ContentPane" region="center"   style="width:<?php  echo $tableWidth[1]; ?>;">
      <script type="dojo/connect" event="resize" args="evt">
           var paramDiv=<?php  echo json_encode($positionListDiv); ?>;
           var paramRightDiv=<?php echo json_encode($positonRightDiv);?>;
           var paramMode=<?php  echo json_encode($codeModeLayout); ?>;
           if (checkValidatedSize(paramDiv,paramRightDiv, paramMode, paramMode)){
            return;
           }
           if(paramDiv=="top" && paramMode!='switch'){
             saveDataToSession("contentPaneDetailDivHeight<?php  echo $currentScreen;?>", dojo.byId("contentDetailDiv").offsetHeight, true);
           }else if(paramMode!='switch'){
              saveDataToSession("contentPaneDetailDivWidth<?php  echo $currentScreen;?>", dojo.byId("contentDetailDiv").offsetWidth, true);
              var param=dojo.byId('objectClass').value;
              var paramId=dojo.byId('objectId').value;
              if(paramId !='' && multiSelection==false){
                loadContent("objectDetail.php?objectClass"+param+"&objectId="+paramId, "detailDiv", 'listForm');  
              }else if(multiSelection==true){
               loadContent('objectMultipleUpdate.php?objectClass=' + param,
                  'detailDiv');
              }
            }
      </script>
     <div class="container" dojoType="dijit.layout.BorderContainer"  liveSplitters="false">
        <div id="detailBarShow" class="dijitAccordionTitle" onMouseover="hideList('mouse');" onClick="hideList('click');"
          <?php  if (RequestHandler::isCodeSet('switchedMode') and RequestHandler::getValue('switchedMode')=='on') echo ' style="display:block;"'?>>
          <div id="detailBarIcon" align="center"></div>
        </div>
        <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center" >
          <?php  $noselect=true; //include 'objectDetail.php'; ?>
        </div>
    <?php if (Module::isModuleActive('moduleActivityStream')) {?>
        <div id="detailRightDiv" dojoType="dijit.layout.ContentPane" region="<?php echo $positonRightDiv; ?>" splitter="true" 
             style="<?php  if($positonRightDiv=="bottom"){echo "height:".$rightHeightVersionsPlanning;}else{ echo "width:".$rightWidthVersionsPlanning;}?>">
              <script type="dojo/connect" event="resize" args="evt">
                var paramDiv=<?php echo json_encode($positionListDiv); ?>;
                var paramMode=<?php echo json_encode($codeModeLayout); ?>;
                var paramRightDiv=<?php echo json_encode($positonRightDiv); ?>;
                var activModeStream=<?php echo json_encode($activModeStream);?>;
                hideSplitterStream (paramRightDiv);
                if (checkValidatedSizeRightDiv(paramDiv,paramRightDiv, paramMode)){
                    return;
                }
                if(paramRightDiv=='trailing'){
                   saveDataToSession("contentPaneRightDetailDivWidth<?php  echo $currentScreen;?>", dojo.byId("detailRightDiv").offsetWidth, true);
                   var newWidth=dojo.byId("detailRightDiv").offsetWidth;
                   dojo.query(".activityStreamNoteContainer").forEach(function(node, index, nodelist) {
                      node.style.maxWidth=(newWidth-30)+"px";
                   });
                }else{
                  saveDataToSession("contentPaneRightDetailDivHeight<?php  echo $currentScreen;?>", dojo.byId("detailRightDiv").offsetHeight, true);
                  var newHeight=dojo.byId("detailRightDiv").offsetHeight;
                  if (dojo.byId("noteNoteStream")) dojo.byId("noteNoteStream").style.height=(newHeight-40)+'px';
               }
                 
              </script>
              <script type="dojo/connect" event="onLoad" args="evt">
                scrollInto();
	         </script>
            <?php include 'objectStream.php'?>
      </div> 
      <?php }?>  
    </div>
  </div>
</div>