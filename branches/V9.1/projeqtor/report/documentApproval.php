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

include_once '../tool/projeqtor.php';

if (! isset($includedReport)) {
  include("../external/pChart2/class/pData.class.php");
  include("../external/pChart2/class/pDraw.class.php");
  include("../external/pChart2/class/pImage.class.php");
  include("../external/pChart2/class/pPie.class.php");
  
	$paramProject='';
	if (array_key_exists('idProject',$_REQUEST)) {
	  $paramProject=trim($_REQUEST['idProject']);
	  $paramProject=Security::checkValidId($paramProject); // only allow digits
	};

  
  // Header
  $headerParameters="";
  if ($paramProject!="") {
    $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project', $paramProject)) . '<br/>';
  }
  include "header.php";
}

$includedReport=true;
$obj=new Document();
$user=getSessionUser();

$query = "";
if ($paramProject!='') {
  $query = "idProject in " . getVisibleProjectsList(true, $paramProject) ;
}
$result=$obj->getSqlElementsFromCriteria(null,false,$query, 'idApprovalStatus');
$totalDocSum = count($result);

$arrayStatus = array();
foreach ($result as $doc){
  $arrayStatus[$doc->idApprovalStatus][$doc->id]=$doc;
}

if (! testGraphEnabled()) { return;}

$dataSet=new pData;
$array[1] = array(VOID,VOID,VOID,VOID);
$array[2]= array(VOID,VOID,VOID,VOID);
$array[3] = array(VOID,VOID,VOID,VOID);
$array[4] = array(VOID,VOID,VOID,VOID);
for ($i = 1; $i<=4; $i++){
	$idName = SqlList::getNameFromId('ApprovalStatus', $i);
	$dataSet->addPoints($idName,"status");
}
for ($i = 1; $i<=4; $i++){
  if(isset($arrayStatus[$i])){
    $point = $array[$i];
    $point[$i-1]=count($arrayStatus[$i]);
    $array[$i] = $point;
    $idName = SqlList::getNameFromId('ApprovalStatus', $i);
    $dataSet->addPoints($array[$i],$idName);
  }
}
$dataSet->setAbscissa("status");

$width=1000;
$legendWidth=300;
$height=400;
$legendHeight=100;
$graph = new pImage($width+$legendWidth, $height,$dataSet);
/* Draw the background */
$graph->Antialias = FALSE;

/* Add a border to the picture */
$settings = array("R"=>240, "G"=>240, "B"=>240, "Dash"=>0, "DashR"=>0, "DashG"=>0, "DashB"=>0);
$graph->drawRoundedRectangle(5,5,$width+$legendWidth-8,$height-5,5,$settings);
$graph->drawRectangle(0,0,$width+$legendWidth-1,$height-1,array("R"=>150,"G"=>150,"B"=>150));

/* Set the default font */
$graph->setFontProperties(array("FontName"=>getFontLocation("verdana"),"FontSize"=>10));

/* title */
$graph->setFontProperties(array("FontName"=>getFontLocation("verdana"),"FontSize"=>8,"R"=>100,"G"=>100,"B"=>100));
$graph->drawLegend($width+30,17,array("Mode"=>LEGEND_VERTICAL, "Family"=>LEGEND_FAMILY_BOX ,
    "R"=>255,"G"=>255,"B"=>255,"Alpha"=>100,
    "FontR"=>55,"FontG"=>55,"FontB"=>55,
    "Margin"=>5));

/* Draw the scale */
$graph->setGraphArea(60,50,$width-20,$height-$legendHeight);
$formatGrid=array("Mode"=>SCALE_MODE_ADDALL_START0, "GridTicks"=>0,
    "DrawYLines"=>array(0), "DrawXLines"=>false,"Pos"=>SCALE_POS_LEFTRIGHT,
    "LabelRotation"=>90, "GridR"=>200,"GridG"=>200,"GridB"=>200);
$graph->drawScale($formatGrid);
$graph->Antialias = TRUE;	
$graph->drawStackedBarChart();

/* Render the picture (choose the best way) */
$imgName=getGraphImgName("ApprovalStatusBar");
$graph->render($imgName);

$graph2 = new pImage(300,$height,$dataSet);

/* Draw the background */
$graph2->Antialias = FALSE;

$pieChart = new pPie($graph2,$dataSet);

/* Set the default font */
$graph2->setFontProperties(array("FontName"=>getFontLocation("verdana"),"FontSize"=>8));
$formSettings = array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>0,"Surrounding"=>0);
$graph2->setShadow(TRUE,$formSettings);
$pieChart->draw3DPie(90,($height/2)+7,array("Border"=>FALSE));
$pieChart->drawPieLegend(180,20,array("Style"=>LEGEND_BOX,"Mode"=>LEGEND_VERTICAL));
$imgName2=getGraphImgName("ApprovalStatusPie");

$graph2->Render($imgName2);

echo '<table width="95%" style="margin-top:20px;" align="center"><tr><td class="section">'.i18n('reportApprovalDocumentBar').'<td></tr><tr><td><br/></td></tr><tr><td align="center">';
echo '<img src="' . $imgName . '" />'; 
echo '</td></tr><tr><td><br/></td></tr>';
echo '<tr><td class="section">'.i18n('reportApprovalDocumentPie').'<td></tr><tr><td><br/></td></tr><tr><td align="center">';
echo '<img src="' . $imgName2 . '" />';
echo '</td></tr></table>';
?>
