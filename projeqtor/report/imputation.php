<?php
//echo "imputation.php";
include_once '../tool/projeqtor.php';

$userId=$_REQUEST['userId'];
$rangeType=$_REQUEST['rangeType'];
$rangeValue=$_REQUEST['rangeValue'];
$idle=false;
if (array_key_exists('idle',$_REQUEST)) {
  $idle=true;
}
$showPlannedWork=false; 
if (array_key_exists('showPlannedWork',$_REQUEST)) {
  $showPlannedWork=true;
}
$hideDone=Parameter::getUserParameter('imputationHideDone');
$displayOnlyHandled=Parameter::getUserParameter('imputationDisplayOnlyHandled');
$displayOnlyCurrentWeekMeetings=Parameter::getUserParameter('imputationDisplayOnlyCurrentWeekMeetings');
if (Parameter::getGlobalParameter('displayOnlyHandled')=="YES") {
	$displayOnlyHandled=true;
} 
//echo '<div style="height:10px">';
ImputationLine::drawLines($userId, $rangeType, $rangeValue, $idle, $showPlannedWork, true, $hideDone, $displayOnlyHandled, $displayOnlyCurrentWeekMeetings);

//echo '</div>';
?>