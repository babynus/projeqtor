<?php
include_once '../tool/projector.php';
$paramYear='';
if (array_key_exists('yearSpinner',$_REQUEST)) {
  $paramYear=$_REQUEST['yearSpinner'];
};

$paramMonth='';
if (array_key_exists('monthSpinner',$_REQUEST)) {
  $paramMonth=$_REQUEST['monthSpinner'];
};

$paramWeek='';
if (array_key_exists('weekSpinner',$_REQUEST)) {
  $paramWeek=$_REQUEST['weekSpinner'];
};

$user=$_SESSION['user'];
$lstProj=$user->getVisibleProjects();

$periodType=$_REQUEST['periodType'];
$periodValue=$_REQUEST['periodValue'];

// Header
$headerParameters="";
if ($periodType=='year' or $periodType=='month' or $periodType=='week') {
  $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
  
}
if ($periodType=='month') {
  $headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
}
if ( $periodType=='week') {
  $headerParameters.= i18n("week") . ' : ' . $paramWeek . '<br/>';
}
include "header.php";

//$where="idProject in " . transformListIntoInClause($user->getVisibleProjects());
$where="1=1 ";
$where.=($periodType=='week')?" and week='" . $periodValue . "'":'';
$where.=($periodType=='month')?" and month='" . $periodValue . "'":'';
$where.=($periodType=='year')?" and year='" . $periodValue . "'":'';
$order="";
//echo $where;
$work=new Work();
$lstWork=$work->getSqlElementsFromCriteria(null,false, $where, $order);
$result=array();
$activities=array();
$description=array();
$parent=array();
$resources=array();
$sumActi=array();
foreach ($lstWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Resource', $work->idResource);
  }
  $refType=$work->refType;
  $refId=$work->refId;
  $key=$refType . "#" . $refId;
  if (! array_key_exists($key,$activities)) {
    $obj=new $refType($refId);
    $activities[$key]=$obj->name;
    $description[$key]=$obj->description;
    if ($refType=='Project') {
      $parent[$key]="[" . i18n('Project') . "]";
    } else {
      if (property_exists($obj,'idActivity') and $obj->idActivity) {
        $parent[$key]=SqlList::getNameFromId('Activity', $obj->idActivity);
      } else {
        $parent[$key]="";
      }
    }
  }
  if (! array_key_exists($work->idResource,$result)) {
    $result[$work->idResource]=array();
  }
  if (! array_key_exists($key,$result[$work->idResource])) {
    $result[$work->idResource][$key]=0;
  } 
  $result[$work->idResource][$key]+=$work->work;
}

if (checkNoData($result)) exit;

// title
echo '<table style="width:95%" align="center">';
echo '<tr>';
echo '<td class="reportTableHeader" rowspan="2" style="width:20%">' . i18n('Resource') . '</td>';
echo '<td class="reportTableHeader" rowspan="2" style="width:10%">' . i18n('colWork') . '</td>';
echo '<td class="reportTableHeader" colspan="3">' . i18n('Activity') . '</td>';
echo '</tr><tr>';
echo '<td class="reportTableColumnHeader" style="width:20%">' . i18n('colName') . '</td>';
echo '<td class="reportTableColumnHeader" style="width:30%">' . i18n('colDescription') . '</td>';
echo '<td class="reportTableColumnHeader" style="width:20%">' . i18n('colParentActivity') . '</td>';
echo '</tr>';

$sum=0;
foreach ($resources as $idR=>$nameR) {
  $sumRes=0;
  echo '<tr>';
  echo '<td class="reportTableLineHeader" style="width:20%" rowspan="' . (count($result[$idR]) +1) . '">' . $nameR . '</td>';
  foreach ($activities as $key=>$nameA) {
    if (array_key_exists($idR, $result)) {
      if (array_key_exists($key, $result[$idR])) {
        $val=$result[$idR][$key];
        $sumRes+=$val; 
        $sum+=$val;
        echo '<td class="reportTableData" style="width:10%">' . $val . '</td>';
        echo '<td class="reportTableData" style="width:20%; text-align:left;">' . $nameA . '</td>'; 
        echo '<td class="reportTableData" style="width:30%; text-align:left;">' . $description[$key] . '</td>'; 
        echo '<td class="reportTableData" style="width:20%; text-align:left;" >' . $parent[$key] . '</td>'; 
        echo '</tr><tr>';
      } 
    }
  }
  echo '<td class="reportTableColumnHeader">' . $sumRes . '</td>';
  echo '<td class="reportTableColumnHeader" style="text-align:left;" colspan="3">' . i18n('sum') . " " . $nameR . '</td>';
  echo '</tr>';
}
echo '<tr>';
echo '<td class="reportTableHeader">' . i18n('sum') . '</td>';
echo '<td class="reportTableHeader">' . $sum . '</td>';
echo '<td colspan="3"></td>';
echo '</tr>';
echo '</table>';