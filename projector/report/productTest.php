<?php
include_once '../tool/projector.php';
include_once '../tool/formatter.php';
//echo 'versionReport.php';

$paramProject='';
if (array_key_exists('idProject',$_REQUEST)) {
  $paramProject=trim($_REQUEST['idProject']);
};
  
$paramProduct='';
if (array_key_exists('idProduct',$_REQUEST)) {
  $paramProduct=trim($_REQUEST['idProduct']);
};
$paramVersion='';
if (array_key_exists('idVersion',$_REQUEST)) {
  $paramVersion=trim($_REQUEST['idVersion']);
};
$paramDetail=false;
if (array_key_exists('showDetail',$_REQUEST)) {
  $paramDetail=trim($_REQUEST['showDetail']);
}

$user=$_SESSION['user'];
  
  // Header
$headerParameters="";
if ($paramProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $paramProject) . '<br/>';
}
if ($paramProduct!="") {
  $headerParameters.= i18n("colIdProduct") . ' : ' . SqlList::getNameFromId('Product', $paramProduct) . '<br/>';
}
if ($paramVersion!="") {
  $headerParameters.= i18n("colVersion") . ' : ' . SqlList::getNameFromId('Version', $paramVersion) . '<br/>';
}
include "header.php";

$where=getAccesResctictionClause('TestCase',false);

$order="";

if ($paramProject) {
  $lstProject=array($paramProject=>SqlList::getNameFromId('Project',$paramProject));
  $where.=" and idProject=".$paramProject;
} else {
  $lstProject=SqlList::getList('Project');
  $lstProject[0]='<i>'.i18n('undefinedValue').'</i>';
}

if ($paramProduct) {
  $lstProduct=array($paramProduct=>SqlList::getNameFromId('Product',$paramProduct));
  $where.=" and idProduct=".$paramProduct;
} else {
  $lstProduct=SqlList::getList('Product');
  $lstProduct[0]='<i>'.i18n('undefinedValue').'</i>';
}

if ($paramVersion) {
  $lstVersion=array($paramVersion=>SqlList::getNameFromId('Version',$paramVersion));
  $where.=" and idVersion=".$paramVersion;
} else {
  $lstVersion=SqlList::getList('Version');
  $lstVersion[0]='<i>'.i18n('undefinedValue').'</i>';
}

$lstType=SqlList::getList('TestCaseType');

$tc=new TestCase();
$lst=$tc->getSqlElementsFromCriteria(null, false, $where,'idProject, idProduct, idVersion, id');

if (checkNoData($lst)) exit;

echo '<table width="95%" align="center">';
echo '<tr>';
echo '<td class="reportTableHeader" style="width:8%" rowspan="2" >' . i18n('colIdProject') . '</td>';
echo '<td class="reportTableHeader" style="width:8%" rowspan="2" >' . i18n('colIdProduct') . '</td>';
echo '<td class="reportTableHeader" style="width:12%" rowspan="2" >' . i18n('colIdVersion') . '</td>';
echo '<td class="reportTableHeader" style="width:8%" rowspan="2" >' . i18n('colType') . '</td>';
echo '<td class="reportTableHeader" style="width:40%" colspan="2" rowspan="2" >' . i18n('TestCase') . '</td>';
echo '<td class="reportTableHeader" style="width:25%" colspan="5" >' .  i18n('TestSession') . " / " . i18n('sectionProgress') . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="largeReportHeader" style="width:5%;text-align:center;">' . i18n('colSum') . '</td>';
echo '<td class="largeReportHeader" style="width:5%;text-align:center;">' . i18n('colPlanned') . '</td>';
echo '<td class="largeReportHeader" style="width:5%;text-align:center;">' . i18n('colPassed') . '</td>';
echo '<td class="largeReportHeader" style="width:5%;text-align:center;">' . i18n('colBlocked') . '</td>';
echo '<td class="largeReportHeader" style="width:5%;text-align:center;">' . i18n('colFailed') . '</td>';
echo '</tr>';
$sumTotal=0;
$sumPlanned=0;
$sumPassed=0;
$sumBlocked=0;
$sumFailed=0;
$cpt=0;
$sumReal='';
  
if ($paramDetail) {
  echo '<tr><td colspan="10" style="font-size:3px;">&nbsp;</td></tr>';
}
foreach ($lst as $tc) {
	$countTotal=0;
	$countPlanned=0;
	$countPassed=0;
	$countBlocked=0;
	$countFailed=0;
	$tcr=new TestCaseRun();
  $crit=array('idTestCase'=>$tc->id);
  $lstTcr=$tcr->getSqlElementsFromCriteria($crit,true, false, 'idTestSession');
  $inClause='(0';
  foreach($lstTcr as $tcr) {
  	$countTotal+=1;
  	if ($tcr->idRunStatus==1) $countPlanned+=1;
  	if ($tcr->idRunStatus==2) $countPassed+=1;
  	if ($tcr->idRunStatus==3) $countFailed+=1;
  	if ($tcr->idRunStatus==4) $countBlocked+=1;
  }
  echo '<tr>';
  echo '<td class="reportTableData">' . (($tc->idProject)?$lstProject[$tc->idProject]:'') . '</td>';
  echo '<td class="reportTableData">' . (($tc->idProduct)?$lstProduct[$tc->idProduct]:'') . '</td>';
  echo '<td class="reportTableData">' . (($tc->idVersion)?$lstVersion[$tc->idVersion]:'') . '</td>';
  echo '<td class="reportTableData">' . (($tc->idTestCaseType)?$lstType[$tc->idTestCaseType]:'') . '</td>';
  echo '<td class="reportTableData">#' . $tc->id . '</td>';
  echo '<td class="reportTableData" style="text-align:left;">' . $tc->name . '</td>';
  echo '<td class="reportTableData">' . $countTotal . '</td>';
  echo '<td class="reportTableData" >' . $countPlanned . '</td>';
  echo '<td class="reportTableData" style="' . (($countPassed and $countPassed==$countTotal)?'color:green;':'') . '">' . $countPassed . '</td>';
  echo '<td class="reportTableData" style="' . (($countBlocked)?'color:orange;':'') . '">' . $countBlocked . '</td>';
  echo '<td class="reportTableData" style="' . (($countFailed)?'color:red;':'') . '">' . $countFailed . '</td>';
  echo '</tr>';
  $sumTotal+=$countTotal;
  $sumPlanned+=$countPlanned;
  $sumPassed+=$countPassed;
  $sumBlocked+=$countBlocked;
  $sumFailed+=$countFailed;
  $cpt+=1;
  if ($paramDetail) {
  	if (count($lstTcr)>0) {
	  	echo '<tr><td></td><td colspan="10">';
	  	echo '<table width="100%">';
	  	echo '<tr>';
	  	echo '<td  colspan="2"></td>';
	  	echo '<td class="largeReportHeader" colspan="2">' . i18n('TestSession') . '</td>';
	  	echo '<td class="largeReportHeader" colspan="2" width="10%">' . i18n('colResult') . '</td>';
	  	echo '</tr>';
        
      foreach ($lstTcr as $tcr) {
        echo '<tr>';
        echo '<td width="5%" style="text-align: center;"></td>';
        echo '<td width="40%""></td>';
        echo '<td class="largeReportData" width="5%" style="text-align: center;">' . (($tcr->idTestSession)?'#':'') . $tcr->idTestSession . '</td>';
        echo '<td class="largeReportData" width="45%" >' . (($tcr->idTestSession)?SqlList::getNameFromId('TestSession', $tcr->idTestSession):'') . '</td>';
          $st=new RunStatus($tcr->idRunStatus);
        echo '<td class="largeReportData" style="text-align: center;" width="4%" >' . (($tcr->id)?colorNameFormatter(i18n($st->name) . '#split#' . $st->color):'') . '</td>';
        echo '<td class="largeReportData" style="text-align: center;font-size:75%;" width="6%" >' . htmlFormatDate($tcr->statusDateTime, true) . '</td>';
        echo '</tr>';
      }
    }
    echo '<tr><td colspan="6" style="font-size:3px;">&nbsp;</td></tr>';
    echo '</table>';
    echo '</td></tr>';
  }
}
echo '<tr>';
echo '<td colspan="6"></td>';
echo '<td class="largeReportHeader" >' . $sumTotal . '</td>';
echo '<td class="largeReportHeader" >' . $sumPlanned . '</td>';
echo '<td class="largeReportHeader" >' . $sumPassed . '</td>';
echo '<td class="largeReportHeader" >' . $sumBlocked . '</td>';
echo '<td class="largeReportHeader" >' . $sumFailed . '</td>';
echo '</tr>';
echo '</table>';
echo '<br/>';
