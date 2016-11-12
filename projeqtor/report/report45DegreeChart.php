<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';
include("../external/pChart2/class/pData.class.php");
include("../external/pChart2/class/pDraw.class.php");
include("../external/pChart2/class/pImage.class.php");

$idProject="";
if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
  $idProject=trim($_REQUEST['idProject']);
  $idProject = Security::checkValidId($idProject);
}
$scale="";
if (array_key_exists('format',$_REQUEST)) {
	$scale=$_REQUEST['format'];
};
$type="";
if (array_key_exists('idMilestoneType',$_REQUEST)) {
  $type=trim($_REQUEST['idMilestoneType']);
};
$startDateReport="";
if (array_key_exists('startDate',$_REQUEST)) {
  $startDateReport=$_REQUEST['startDate'];
};
$endDateReport="";
if (array_key_exists('endDate',$_REQUEST)) {
  $endDateReport=$_REQUEST['endDate'];
};
$showToday=false;
if (array_key_exists('showBurndownToday',$_REQUEST)) {
  $showToday=true;
}
$legend='included';
if (array_key_exists('showBurndownLegendOnTop',$_REQUEST)) {
  $legend="top";
}

$headerParameters="";
if ($idProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project',$idProject)) . '<br/>';
}
if ($type!="") {
  $headerParameters.= i18n("colIdMilestoneType") . ' : ' . htmlEncode(SqlList::getNameFromId('Type',$type)) . '<br/>';
}
if ( $scale) {
  $headerParameters.= i18n("colFormat") . ' : ' . i18n($scale) . '<br/>';
}
if ($startDateReport!="") {
  $headerParameters.= i18n("colStartDate") . ' : ' . htmlFormatDate($startDateReport) . '<br/>';
}
if ($endDateReport!="") {
  $headerParameters.= i18n("colEndDate") . ' : ' . htmlFormatDate($endDateReport) . '<br/>';
}
if ($showToday) {
  $headerParameters.= i18n("colShowBurndownToday"). '<br/>';
}

include "header.php";

if (!$idProject) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('messageNoData',array(i18n('Project'))); // TODO i18n message
  echo '</div>';
  exit; 
}

// Graph
if (! testGraphEnabled()) { return;}

$user=getSessionUser();
$proj=new Project($idProject,true);
$today=date('Y-m-d');

$start="";
$end="";
// constitute query and execute for planned post $end (last real work day)
// Milestones
$m=new Milestone();
$mpe=new MilestonePlanningElement();
$mTable=$m->getDatabaseTableName();
$mpeTable=$mpe->getDatabaseTableName();
$querySelect= "select mpe.id as idpe, m.name as name, m.id as id, m.idMilestoneType as type";
$queryFrom=   " from $mTable m, $mpeTable as mpe";
$queryWhere=  " where mpe.refType='Milestone' and mpe.refId=m.id";
$queryWhere.= " and m.idProject in " . transformListIntoInClause($proj->getRecursiveSubProjectsFlatList(false, true));
$queryWhere.= " and m.idProject in ".transformListIntoInClause($user->getVisibleProjects(false));
if ($type) {
  $queryWhere.= " and m.idMilestoneType = ".Sql::fmtId($type);
}
$query=$querySelect.$queryFrom.$queryWhere;
$resultMile=Sql::query($query);
$arrayMile=array();

$listMilePE='(0';
while ($line = Sql::fetchLine($resultMile)) {
  $id=$line['id'];
  $idpe=$line['idpe'];
  $name=$line['name'];
  $tp=$line['type'];
  $listMilePE.=','.$idpe;
  $arrayMile[$idpe]=array('id'=>$id, 'idpe'=>$idpe, 'name'=>$name,'type'=>$tp,'dates'=>array(), 'periods'=>array(), 'current'=>VOID, 'lastDate'=>null);
}
$listMilePE.=')';
debugLog($arrayMile);

$h=new History();
$hTable=$h->getDatabaseTableName();
$querySelect= "select h.refId as idpe, h.oldValue as old, h.newValue as new, h.operationDate as date";
$queryFrom=   " from $hTable h";
$queryWhere=  " where h.refType='MilestonePlanningElement'" ;
$queryWhere.= " and h.refId in $listMilePE" ;
$queryWhere.= " and colName='plannedEndDate' ";
$queryOrder= "  order by h.operationDate";
$query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
$resultPlanned=Sql::query($query);
$tablePlanned=array();
$existingDates=array();
while ($line = Sql::fetchLine($resultPlanned)) {
  $day=substr($line['date'],0,10);
  $existingDates[$day]=$day;
  $arrDates[$day]=$day;
  $idpe=$line['idpe'];
  $old=$line['old'];
  $new=$line['new'];
  $arrayMile[$idpe]['dates'][$day]=strtotime($new);
  $arrayMile[$idpe]['lastDate']=$day;
  if ($start=="" or $start>$day) {$start=$day;}
  if ($end=="" or $end<$day) { $end=$day;}
}

if (checkNoData($arrayMile)) exit;

$date=$start;
if (!$start or !$end) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('reportNoData'); 
  echo '</div>';
  exit;
}
$start=substr($start,0,8).'01';
$end=substr($end,0,8).date('t',strtotime($end));
$arrDates=array();
while ($date<=$end) {
  if ($scale=='week') { 
    $arrDates[$date]=weekFormat($date); 
  } else if ($scale=='month') { 
    $arrDates[$date]=date('Y-m',strtotime($date));  
  } else if ($scale=='quarter') { 
    $year=date('Y',strtotime($date));
    $month=date('m',strtotime($date));
    $quarter=1+intval(($month-1)/3);
    $arrDates[$date]=$year.'-Q'.$quarter;  }
  else { 
    if (isset($existingDates[$date])) {
      $arrDates[$date]=$date;
    }
  }
  $date=addDaysToDate($date, 1);
}

$resBase=array();

foreach ($arrDates as $date => $period) {
  $resBase[$period]=strtotime($date);
  foreach($arrayMile as $idx=>$arr) {
    if (isset($arrayMile[$idx]['dates'][$date])) {
      $arrayMile[$idx]['current']=$arrayMile[$idx]['dates'][$date];
    }
    if ($arrayMile[$idx]['current']!=VOID or ! isset($arrayMile[$idx]['periods'][$period])) {
      $arrayMile[$idx]['periods'][$period]=$arrayMile[$idx]['current'];
    }
    if ($arrayMile[$idx]['lastDate']==$date) {
      $arrayMile[$idx]['current']=VOID;
    }
  }
}
$startDatePeriod=null;
$endDatePeriod=null;
if ($startDateReport and isset($arrDates[$startDateReport])) $startDatePeriod=$arrDates[$startDateReport];
if ($endDateReport and isset($arrDates[$endDateReport])) $endDatePeriod=$arrDates[$endDateReport];

/*if ($startDatePeriod or $endDatePeriod) {
  foreach ($arrDates as $date => $period) {
    if ( ($startDatePeriod and $period<$startDatePeriod) or ($endDatePeriod and $period>$endDatePeriod) ) {
      unset($arrDates[$date]);
      unset($resReal[$period]);
      unset($resPlanned[$period]);
      unset($resBaseline[$period]);
    }
  }
}*/

$graphWidth=1200;
$graphHeight=720;
$indexToday=0;

$arrDates=array_flip($arrDates);
$arrLabel=array();
$cpt=0;
$modulo=intVal(50*count($arrDates)/$graphWidth);
if ($modulo<0.5) $modulo=0;
foreach ($arrDates as $date => $period) {
  if ($period<$today) $indexToday++;
  if (0 and $cpt % $modulo !=0 ) {
    $arrDates[$date]=VOID;
  } else {
    if ($scale=='day') {
      $arrDates[$date]=htmlFormatDate($date); 
    } else if ($scale=='month') {
      $arrDates[$date]=getMonthName(substr($date,5)).' '.substr($date,0,4);
    } else {
      $arrDates[$date]=$date;
    }
  }
  $cpt++;
}

$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}

$maxPlotted=30; // max number of point to get plotted lines. If over lines are not plotted/

$dataSet = new pData();
// Definition of series
foreach($arrayMile as $idx=>$arr) {
  $dataSet->addPoints($arrayMile[$idx]['periods'],"mile$idx");
  $dataSet->setSerieOnAxis("mile$idx",0);
  $dataSet->setSerieWeight("mile$idx",1);
  $dataSet->setSerieDescription("mile$idx",$arrayMile[$idx]['name']."  ");
}
$dataSet->addPoints($resBase,"base");
$dataSet->setSerieOnAxis("base",0);
$dataSet->setSerieWeight("base",1);
$dataSet->setPalette("base",array("R"=>250,"G"=>180,"B"=>210,"Alpha"=>255));
$dataSet->setSerieDescription("base",i18n("legendBaseline")."  ");

if ($scale=='day') {
  foreach ($arrLabel as $idx=>$val) {
    $arrLabel[$idx]=strtotime($val);
  }
}
$dataSet->addPoints($arrLabel,"dates");
$dataSet->setAxisDisplay(0,AXIS_FORMAT_DATE);
$dataSet->setAbscissa("dates");
if ($scale=='day') {
  $dataSet->setXAxisDisplay(AXIS_FORMAT_DATE);
}

/* Create the pChart object */
$graph = new pImage($graphWidth,$graphHeight,$dataSet);

/* Draw the background */
$graph->Antialias = FALSE;
$Settings = array("R"=>240, "G"=>240, "B"=>240, "Dash"=>0, "DashR"=>0, "DashG"=>0, "DashB"=>0);
$graph->drawFilledRectangle(0,0,$graphWidth,$graphHeight,$Settings);
/* Add a border to the picture */
$graph->drawRectangle(0,0,$graphWidth-1,$graphHeight-1,array("R"=>150,"G"=>150,"B"=>150));
/* Set the default font */
$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>9,"R"=>100,"G"=>100,"B"=>100));

/* Draw the scale */
$graph->setGraphArea(90,30,$graphWidth-20,$graphHeight-(($scale=='month')?100:75));
$graph->drawFilledRectangle(90,30,$graphWidth-20,$graphHeight-(($scale=='month')?100:75),array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>230));
$formatGrid=array("LabelSkip"=>$modulo, "SkippedAxisAlpha"=>(($modulo>9)?0:20), "SkippedGridTicks"=>0,
    "Mode"=>SCALE_MODE_FLOATING, "GridTicks"=>0, 
    "DrawYLines"=>array(0), "DrawXLines"=>true,"Pos"=>SCALE_POS_LEFTRIGHT, 
    "LabelRotation"=>60, "GridR"=>200,"GridG"=>200,"GridB"=>200,
    "ScaleModeAuto"=>TRUE);
$graph->drawScale($formatGrid);

$graph->Antialias = TRUE;

$dataSet->setSerieDrawable("base",true);

//$drawFormat=array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"ScaleModeAuto"=>TRUE);
if ($scale=='day') {
  $drawFormat=array("ScaleModeAuto"=>TRUE);
} else {
  $drawFormat=array();
}
$graph->drawLineChart($drawFormat);
$dataSet->setSerieDrawable("base",false);
if (count($arrLabel)<$maxPlotted) {
  $graph->drawPlotChart($drawFormat);
}
if ($showToday) $graph->drawXThreshold(array($indexToday),array("Alpha"=>70,"Ticks"=>0));

if ($legend=="top") {
  $graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>10.8,"R"=>100,"G"=>100,"B"=>100));
  $graph->drawLegend(10,10,array("Mode"=>LEGEND_HORIZONTAL, "Family"=>LEGEND_FAMILY_BOX ,
      "R"=>255,"G"=>255,"B"=>255,"Alpha"=>0,
      "FontR"=>55,"FontG"=>55,"FontB"=>55,
      "Margin"=>0));
  $graph->drawText($graphWidth/2,50,i18n("reportSCurveChart"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
} else {
  $graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>11,"R"=>100,"G"=>100,"B"=>100));
  $graph->drawLegend(100,50,array("Mode"=>LEGEND_VERTICAL, "Family"=>LEGEND_FAMILY_BOX ,
      "R"=>255,"G"=>255,"B"=>255,"Alpha"=>100,
      "FontR"=>55,"FontG"=>55,"FontB"=>55,
      "Margin"=>5));
  $graph->drawText($graphWidth/2,20,i18n("report45DegreeChart"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
}

/* Render the picture (choose the best way) */
$imgName=getGraphImgName("scurvechart");
$graph->Render($imgName);

echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img style="width:1000px;height:600px" src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';

?>