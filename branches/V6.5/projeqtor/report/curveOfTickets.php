<?php
/*
 * @author: atrancoso ticket #84
 */
include_once '../tool/projeqtor.php';

if (! isset ( $includedReport )) {
  include("../external/pChart2/class/pData.class.php");
  include("../external/pChart2/class/pDraw.class.php");
  include("../external/pChart2/class/pImage.class.php");
  
  $paramProject = '';
  if (array_key_exists ( 'idProject', $_REQUEST )) {
    $paramProject = trim ( $_REQUEST ['idProject'] );
    Security::checkValidId ( $paramProject );
  }
  
  $paramProduct = '';
  if (array_key_exists ( 'idProduct', $_REQUEST )) {
    $paramProduct = trim ( $_REQUEST ['idProduct'] );
    $paramProduct = Security::checkValidId ( $paramProduct ); // only allow digits
  }
  ;
  
  $paramVersion = '';
  if (array_key_exists ( 'idVersion', $_REQUEST )) {
    $paramVersion = trim ( $_REQUEST ['idVersion'] );
    $paramVersion = Security::checkValidId ( $paramVersion ); // only allow digits
  }
  ;
  
  $paramPriority = '';
  if (array_key_exists ( 'idPriority', $_REQUEST )) {
    $paramPriority = trim ( $_REQUEST ['idPriority'] );
    $paramPriority = Security::checkValidId ( $paramPriority ); // only allow digits
  }
  ;
  
  // Header
  $headerParameters = "";
  
  if ($paramVersion != "") {
    $headerParameters .= i18n ( "colVersion" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Version', $paramVersion ) ) . '<br/>';
  }
  
  if ($paramProject != "") {
    $headerParameters .= i18n ( "colIdProject" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Project', $paramProject ) ) . '<br/>';
  }
  
  if ($paramProduct != "") {
    $headerParameters .= i18n ( "colIdProduct" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Product', $paramProduct ) ) . '<br/>';
  }
  
  if ($paramPriority != "") {
    $headerParameters .= i18n ( "colPriority" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Priority', $paramPriority ) ) . '<br/>';
  }
  
  include "header.php";
}

$where = getAccesRestrictionClause ( 'Requirement', false );

if ($paramProject != "") {
  $where .= " and idProject in " . getVisibleProjectsList ( false, $paramProject );
}
if ($paramProduct != "") {
  $where .= " and idProduct=" . Sql::fmtId ( $paramProduct );
}
if ($paramVersion != "") {
  $where .= " and idVersion=" . Sql::fmtId ( $paramVersion ) ;
}
if ($paramPriority != "") {
  $where .= " and idPriority=" . Sql::fmtId ( $paramPriority );
}

$startDate = '';
$endDate = '';
if ($paramVersion != '') {
  $pe = new Version ();
  $pe = SqlElement::getSingleSqlElementFromCriteria ( 'Version', array('id' => $paramVersion) );
  if ((($pe->initialStartDate != '') or ($pe->plannedStartDate != '')) and (($pe->initialEndDate != '') or ($pe->plannedEndDate != ''))) {
    if ($pe->initialStartDate != '') {
      $startDate = $pe->initialStartDate;
    } else {
      $startDate = $pe->plannedStartDate;
    }
    if ($pe->initialEndDate != '') {
      $endDate = $pe->initialEndDate;
    } else {
      $endDate = $pe->plannedEndDate;
    }
  } else {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n ( 'wrongDate' );
    echo '</div>';
    exit ();
  }
} else if ($paramProject != '') {
  $pe = new PlanningElement ();
  $pe = SqlElement::getSingleSqlElementFromCriteria ( 'PlanningElement', array('refType' => 'Project', 'refId' => $paramProject) );
  if ((($pe->validatedStartDate != '') or ($pe->plannedStartDate != '')) and (($pe->validatedEndDate != '') or ($pe->plannedEndDate != ''))) {
    if ($pe->validatedStartDate != '') {
      $startDate = $pe->validatedStartDate;
    } else {
      $startDate = $pe->plannedStartDate;
    }
    if ($pe->validatedEndDate != '') {
      $endDate = $pe->validatedEndDate;
    } else {
      $endDate = $pe->plannedEndDate;
    }
  } else {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n ( 'wrongDate' );
    echo '</div>';
    exit ();
  }
} else {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n ( 'messageNoData', array(i18n ( 'Project' )) );
  echo i18n ( 'messageNoData', array(i18n ( 'Version' )) );
  echo '</div>';
  exit ();
}
$order = "";
// echo $where;
$ticket = new Ticket ();
$lstTicNew = $ticket->getSqlElementsFromCriteria ( null, false, $where, $order );
$nbTicket = 0;
foreach ( $lstTicNew as $t ) {
  if ($t->creationDateTime != '') {
    $nbTicket = $nbTicket + 1;
  }
}
$start = date_create ( $startDate );
$end = date_create ( $endDate );
$nbDay = $start->diff ( $end )->days + 1;

$perfect = array();
for($i = 1; $i <= $nbDay; $i ++) {
  $perfect [$i] = ((- $nbTicket) / ($nbDay)) * $i + $nbTicket;
}
$created = array();
if ($nbDay != 0) {
  for($i = 1; $i <= $nbDay; $i ++) {
    foreach ( $lstTicNew as $t ) {
      if ($t->doneDateTime != '') {
        $startTicket = strtotime ( $t->doneDateTime );
        if ($startTicket < (strtotime ( $startDate ) + ($i * 24 * 60 * 60)) and $t->doneDateTime != '') {
          $nbTicket = $nbTicket - 1;
          $t->doneDateTime = '';
        }
      }
    }
    $created [$i] = $nbTicket;
  }
} else {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n ( 'invalidNbOfDay' );
  echo '</div>';
  exit ();
}
$month = getNbMonth ( 4, true );
$arrDays = array();
if (($month [date ( 'n', strtotime ( $startDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ))) == $month [date ( 'n', strtotime ( $endDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $endDate ) ))
{
  for($i = 1; $i <= $nbDay; $i ++) {
    $arrDays [$i] = '';
    if ($i == 1) {
      $arrDays [1] =date ( 'd', strtotime($startDate)). '/' . $month [date ( 'n', strtotime ( $startDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) );
    } else {
      $arrDays [$i] = date ( 'd', strtotime($startDate)+ (($i-1) * 24 * 60 * 60)) . '/' . $month [date ( 'n', strtotime ( $startDate ) + (($i-1)* 24 * 60 * 60) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) + (($i)* 24 * 60 * 60) );
    }if ($i == $nbDay){
      $arrDays [$i] = date ( 'd', strtotime($endDate) ). '/' . $month [date ( 'n', strtotime ( $endDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $endDate ) );
    }
  }
}else {
  for($i = 1; $i <= $nbDay; $i ++) {
    $arrDays [$i] = '';
    if ($i == 1) {
      $arrDays [1] = date ( 'd', strtotime($startDate)). '/' .$month [date ( 'n', strtotime ( $startDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) );
    } else if (date ( 'm', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) == '01' and (date ( 'd', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) == '01')) {
      $arrDays [$i] = date ( 'd', strtotime($startDate)+ (($i) * 24 * 60 * 60)) . '/' . $month [date ( 'n', strtotime ( $startDate ) + (($i)* 24 * 60 * 60) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) + (($i)* 24 * 60 * 60) );
    }
    else if (date ( 'd', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) == '01') {
      $arrDays [$i] = date ( 'd', strtotime($startDate)+ (($i) * 24 * 60 * 60)) . '/' . $month [date ( 'n', strtotime ( $startDate ) + (($i)* 24 * 60 * 60) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) + (($i)* 24 * 60 * 60) );
    }
    if ($i == $nbDay){
      $arrDays [$i] = date ( 'd', strtotime($endDate) ). '/' . $month [date ( 'n', strtotime ( $endDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $endDate ) );
    }
  }
}

// Render graph
// pGrapg standard inclusions
if (! testGraphEnabled ()) {
  return;
}

$dataSet = new pData ();
$dataSet->addPoints ( $created, "created" );
$dataSet->setSerieDescription ( "created",i18n ( "ticketLeft" ) );
$dataSet->setSerieOnAxis("created",0);
$dataSet->addPoints ( $perfect, "perfect" );
$dataSet->setSerieDescription("perfect",i18n("idealNbofTicket"));
$dataSet->setSerieOnAxis("perfect",0);

$dataSet->addPoints ( $arrDays, "days" );
$dataSet->setAbscissa ( "days" );

$serieSettings = array("R"=>200,"G"=>100,"B"=>100,"Alpha"=>80);
$dataSet->setPalette("created",$serieSettings);
$serieSettings = array("R"=>100,"G"=>200,"B"=>100,"Alpha"=>80);
$dataSet->setPalette("perfect",$serieSettings);
$dataSet->setSerieDrawable("created",true);
$dataSet->setSerieDrawable("perfect",true);

// Initialise the graph
$width = 1000;
$height=400;

$graph = new pImage ( $width, $height ,$dataSet);
$graph->Antialias = FALSE;

$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>8,"R"=>100,"G"=>100,"B"=>100));
//$graph->setColorPalette ( 0, 200, 100, 100 );
//$graph->setColorPalette ( 1, 100, 200, 100 );
//$graph->setColorPalette ( 2, 100, 100, 200 );
//$graph->setColorPalette ( 3, 200, 100, 100 );
//$graph->setColorPalette ( 4, 100, 200, 100 );
//$graph->setColorPalette ( 5, 100, 100, 200 );
$graph->setGraphArea ( 40, 30, $width - 140, $height-80 );
//$graph->drawGraphArea ( 252, 252, 252 );
$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>8,"R"=>100,"G"=>100,"B"=>100));

$formatGrid=array("Mode"=>SCALE_MODE_START0, "GridTicks"=>0,
    "DrawYLines"=>array(0), "DrawXLines"=>false,
    "LabelRotation"=>60, "GridR"=>200,"GridG"=>200,"GridB"=>200);

$graph->drawScale ( $formatGrid );
//$graph->drawGrid ( 0, TRUE, 230, 230, 230, 255 );

// Draw the line graph
$graph->drawLineChart ( );
if ($nbDay < 30){
  $graph->drawPlotGraph ();
}
$dataSet->setSerieDrawable("perfect",true);
// Draw the area between points
$graph->drawAreaChart ();

// Finish the graph

/* title */
$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>8,"R"=>100,"G"=>100,"B"=>100));
$graph->drawLegend($width-120,17,array("Mode"=>LEGEND_VERTICAL, "Family"=>LEGEND_FAMILY_BOX ,
    "R"=>255,"G"=>255,"B"=>255,"Alpha"=>100,
    "FontR"=>55,"FontG"=>55,"FontB"=>55,
    "Margin"=>5));

$imgName = getGraphImgName ( "Curve Of Tickets" );
$graph->Render ( $imgName );
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />';
echo '</td></tr></table>';
