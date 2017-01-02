<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';
include("../external/pChart2/class/pData.class.php");
include("../external/pChart2/class/pDraw.class.php");
include("../external/pChart2/class/pImage.class.php");

$kpiColoFull=true; // decide how kpi color is displayed correspondng on threshold : false will display rounded badge, true will fill the cell 
$displayAsPct=true;

$idProject="";
if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
  $idProject=trim($_REQUEST['idProject']);
  $idProject = Security::checkValidId($idProject);
}

$headerParameters="";
if ($idProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project',$idProject)) . '<br/>';
}

include "header.php";

if (!$idProject) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('messageNoData',array(i18n('Project'))); 
  echo '</div>';
  exit;
}

$kpi=new KpiDefinition(3);

$user=getSessionUser();
$listProjects=array();
$visibleProjects=$user->getVisibleProjects(false);
if ($idProject) {
  $listProjects[$idProject]=new Project($idProject);
}

if (checkNoData($listProjects)) exit;

$thresholds=(new KpiThreshold())->getSqlElementsFromCriteria(array('idKpiDefinition'=>$kpi->id),false,null,'thresholdValue desc');
echo '<table width="90%" align="center">';
echo '<tr>';
echo '<td class="reportTableHeader" rowspan="2" style="width:20%">' . i18n('Project') . '</td>';
echo '<td class="reportTableHeader" rowspan="2" style="width:20%">' . i18n('Client') . '</td>';
echo '<td class="reportTableHeader" colspan="4" style="width:45%">' . i18n('Term') . '</td>';
echo '<td class="reportTableHeader" rowspan="2" style="width:15%">' . htmlEncode($kpi->name) . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="reportTableHeader" style="width:15%">' . i18n('colName') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colValidated') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colReal') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colLeft') . '</td>';
echo '</tr>';
$arrayProj=array();
$cptProjectsDisplayed=0;
$sumReal=0;
$sumValidated=0;
$sumLeft=0;
foreach($listProjects as $prj) {
  $arrayProj[$prj->id]=$prj->name;
  if (! array_key_exists($prj->id, $visibleProjects)) continue; // Will avoid to display projects not visible to user
  $cptProjectsDisplayed++;
  $lstTerms=(new Term() )->getSqlElementsFromCriteria(array('idProject'=>$prj->id));
  $nbTerms=count($lstTerms);
  echo '<tr>';
  echo '<td class="reportTableDataSpanned" rowspan="'.$nbTerms.'" style="width:20%;text-align:left">' . htmlEncode($prj->name) . '</td>';
  echo '<td class="reportTableDataSpanned" rowspan="'.$nbTerms.' style="width:20%;text-align:left">' . htmlEncode(SqlList::getNameFromId('Client', $prj->idClient)) . '</td>';
  $cptTerms=0;
  foreach ($lstTerms as $term) {
    $cptTerms++;
    $validated=$term->validatedAmount;
    $real=$term->amount;
    $left=($real>0)?0:$validated;
    $sumReal+=$real;
    $sumValidated+=$validated;
    $sumLeft+=$left;
    echo '<td class="reportTableDataSpanned" style="width:15%">' . htmlEncode($term->name) . '</td>';
    echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlDisplayCurrency($validated,true) . '</td>';
    echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlDisplayCurrency($real,true) . '</td>';
    echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlDisplayCurrency($left,true) . '</td>';
    if ($cptTerms==1) {
      $critKpi=array('idKpiDefinition'=>$kpi->id,'refType'=>'Project','refId'=>$prj->id);
      $kpiValue=SqlElement::getSingleSqlElementFromCriteria('KpiValue', $critKpi);
      if (!$kpiValue) $kpiValue=new KpiValue();
      $color='#ffffff';
      foreach ($thresholds as $th) {
        if ($kpiValue->kpiValue>$th->thresholdValue) {
          $color=$th->thresholdColor;
          break;
        }
      }
      $dispValue=$kpiValue->kpiValue;
      if ($dispValue and $displayAsPct) $dispValue=htmlDisplayPct($dispValue*100);
      if ($kpiColoFull) {
        echo '<td class="reportTableData" rowspan="'.($nbTerms+1).'" style="width:15%;background-color:'.$color.';text-align:left">' . (($dispValue)?htmlDisplayColoredFull($dispValue, $color):'') . '</td>';
      } else {
        echo '<td class="reportTableDataSpanned" rowspan="'.($nbTerms+1).'" style="width:15%;text-align:left">' . (($dispValue)?htmlDisplayColored($dispValue, $color):'') . '</td>';
      }
    }
    echo '</tr>';
    echo '<tr>';
  }
  echo '<td class="reportTableHeader" colspan="3" style="width:55%">' . i18n('sum') . '</td>';
  echo '<td class="reportTableHeader" style="width:10%">' . htmlDisplayCurrency($sumValidated,true) . '</td>';
  echo '<td class="reportTableHeader" style="width:10%">' . htmlDisplayCurrency($sumReal,true) . '</td>';
  echo '<td class="reportTableHeader" style="width:10%">' . htmlDisplayCurrency($sumLeft,true) . '</td>';
  echo '</tr>';
}
echo '</table>';

// Graph
if (! testGraphEnabled()) { return;}

return;

// constitute query and execute for planned post $end (last real work day)
$h=new KpiHistory();
$hTable=$h->getDatabaseTableName();
$query = "select AVG(prj.valueP) as value, prj.periodP as period";
$query.= " from (select MAX(h.kpiValue) as valueP, h.$scale as periodP, h.refId as idP";
$query.= " from $hTable h";
$query.= " where h.idKpiDefinition=$kpi->id and h.refType='Project' and h.refId in " . transformListIntoInClause($arrayProj);
if ($done) {$query.= " and h.refDone=1";}
if ($year) {
  if ($month==1 or (!$month and $year==date('Y') and date('m')==1)) {
    $query.= " and (h.year='$year' or h.year='".($year-1)."')";
  } else {
    $query.= " and h.year='$year'";
  }
}
$query.= " group by h.$scale, h.refId) prj ";
$query.= " group by periodP";
$result=Sql::query($query);


$end='';
$start='';
$valArray=array();
foreach ($result as $line) {
  if ($end=='' or $line['period']>$end) $end=$line['period'];
  if ($start=='' or $line['period']<$start) $start=$line['period'];
  $arrValues[$line['period']]=round($line['value'],2)*(($displayAsPct)?100:1);;
}

if ($cptProjectsDisplayed==0 and (!$start or !$end)) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('reportNoData'); 
  echo '</div>';
  exit;
}
$lastValue=VOID;
$arrDates=array();
$date=$start;
while ($date<=$end) {
  if (isset($arrValues[$date])) {
    $lastValue=$arrValues[$date];
  } else {
    if ($done) {
      $arrValues[$date]=VOID;
    } else {
      $arrValues[$date]=$lastValue;
    }
  }
  $arrDates[$date]=$date;
  if ($scale=='day') {
    $d=substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2);
    $d=addDaysToDate($d, 1);
    $date=str_replace('-','',$d);
  } else if ($scale=='week') { 
    $w=substr($date,4,2);
    $y=substr($date,0,4);
    $w++;
    $lastDayOfYear=$y.'-12-31';
    if ($w>weekNumber($lastDayOfYear)) {
      $y++;
      $w='1';
    }
    if ($w<10) $w='0'.intval($w);
    $date=$y.$w; 
  } else if ($scale=='month') { 
    $m=substr($date,4,2);
    $y=substr($date,0,4);
    $m++;
    if ($m>12) {
      $y++;
      $m=1;
    }
    if ($m<10) $m='0'.intval($m);
    $date=$y.$m;
  } else if ($scale=='year') { 
    $date++;  
  }
}
ksort($arrValues);

$graphWidth=700;
$graphHeight=400;
$indexToday=0;
$maxPlotted=50; // max number of point to get plotted lines. If over lines are not plotted/

$cpt=0;
$modulo=intVal(50*count($arrDates)/$graphWidth);
if ($modulo<0.5) $modulo=0;
foreach ($arrDates as $id=>$date) {
  if ($modulo!=0 and $cpt % $modulo !=0 ) {
    $arrDates[$id]=VOID;
  } else {
    if ($scale=='day') {
      $arrDates[$id]=htmlFormatDate(substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2)); 
    } else if ($scale=='week') {
      $arrDates[$id]=htmlFormatDate(substr($date,0,4).'-'.substr($date,4,2));
    } else if ($scale=='month') {
      $arrDates[$id]=getMonthName(substr($date,4),'auto').'-'.substr($date,2,2);
    } else if ($scale=='year') {
      $arrDates[$id]=$date;
    }
  }
  $cpt++;
}

$dataSet = new pData();
// Definition of series
$dataSet->addPoints($arrValues,"kpi");
$dataSet->addPoints($arrDates,"dates");
$dataSet->setSerieOnAxis("kpi",0);
$dataSet->setAbscissa("dates");

/* Create the pChart object */
$graph = new pImage($graphWidth,$graphHeight,$dataSet);

/* Draw the background */
$graph->Antialias = FALSE;
$Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>0, "DashR"=>0, "DashG"=>0, "DashB"=>0);
$graph->drawFilledRectangle(0,0,$graphWidth,$graphHeight,$Settings);

/* Add a border to the picture */
$graph->drawRectangle(0,0,$graphWidth-1,$graphHeight-1,array("R"=>150,"G"=>150,"B"=>150));

/* Set the default font */
$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>9,"R"=>50,"G"=>50,"B"=>50));

/* Draw the scale */
$dataSet->setAxisUnit(0,($displayAsPct)?"%  ":"  ");
$graph->setGraphArea(55,70,$graphWidth-20,$graphHeight-60);
$graph->drawFilledRectangle(55,70,$graphWidth-20,$graphHeight-60,array("R"=>230,"G"=>230,"B"=>230));




$graph->Antialias = TRUE;
if ($showThreshold) {
  $graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>9,"R"=>50,"G"=>50,"B"=>50));
  $cpt=0;
  foreach ($thresholds as $th) {
    if ($th->thresholdValue==0) continue;
    $cpt++;
    $arrTh=array();
    foreach ($arrDates as $dt) {$arrTh[]=$th->thresholdValue*(($displayAsPct)?100:1);}
    $dataSet->addPoints($arrTh,"th"+$cpt);
    $format=array_merge(hex2rgb($th->thresholdColor),array("Alpha"=>255));
    $dataSet->setPalette("th"+$cpt,$format);
    $dataSet->setSerieDrawable("th"+$cpt,true);
    $dataSet->setSerieWeight("th"+$cpt,1);
    //$dataSet->setSerieOnAxis("th"+$cpt,0);
  }
}
$formatGrid=array("LabelSkip"=>$modulo, "SkippedAxisAlpha"=>(($modulo>9)?0:20), "SkippedGridTicks"=>0,
    "Mode"=>SCALE_MODE_FLOATING , "GridTicks"=>0,
    "DrawYLines"=>array(0), "DrawXLines"=>false,"Pos"=>SCALE_POS_LEFTRIGHT,
    "LabelRotation"=>90, "GridR"=>150,"GridG"=>150,"GridB"=>150);
$graph->drawScale($formatGrid);
$dataSet->setSerieDrawable("kpi",false);
$graph->drawLineChart();

$dataSet->setSerieWeight("kpi",1);
$dataSet->setPalette("kpi",array("R"=>120,"G"=>140,"B"=>250,"Alpha"=>255));
$dataSet->setSerieDrawable("kpi",true);
$graph->drawLineChart();
$cpt=0;
foreach ($thresholds as $th) {
  $cpt++;
  $dataSet->setSerieDrawable("th"+$cpt,false);
}
$graph->drawLineChart();
if (count($arrDates)<$maxPlotted) {
  $graph->drawPlotChart();
}
//if ($showToday) $graph->drawXThreshold(array($indexToday),array("Alpha"=>70,"Ticks"=>0));
$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>12,"R"=>50,"G"=>50,"B"=>50));
$name=i18n('kpiProgress').' '.$kpi->name;
if ($idProject) {
  $prj=new Project($idProject,true);
  $name.=' - '.$prj->name;
} 
if ($idOrganization) {
  $org=new Organization($idOrganization,true);
  $name.=' - '.$org->name;
}
if ($idProjectType) {
  $typ=new ProjectType($idProjectType,true);
  $name.=' - '.$typ->name;
}
$name=wordwrap($name,50); 
$graph->drawText($graphWidth/2,35,$name,array("FontSize"=>18,"Align"=>TEXT_ALIGN_MIDDLEMIDDLE));

/* Render the picture (choose the best way) */
$imgName=getGraphImgName("scurvechart");
$graph->Render($imgName);
echo '<br/><br/><br/>';
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img style="width:700px;height:400px" src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';

?>