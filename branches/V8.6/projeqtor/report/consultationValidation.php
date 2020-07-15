<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * Most of properties are extracted from Dojo Framework.
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

$paramProject = trim(RequestHandler::getId('idProject'));
$paramProjectType = trim(RequestHandler::getId('idProjectType'));
$idOrganization = trim(RequestHandler::getId('idOrganization'));
$paramYear = RequestHandler::getYear('yearSpinner');
$paramMonth = RequestHandler::getMonth('monthSpinner');
$user=getSessionUser();

// Header
$headerParameters="";
if ($paramProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project', $paramProject)) . '<br/>';
}
if ($paramProjectType!="") {
  $headerParameters.= i18n("colIdProjectType") . ' : ' . htmlEncode(SqlList::getNameFromId('ProjectType', $paramProjectType)) . '<br/>';
}
if ($idOrganization!="") {
  $headerParameters.= i18n("colIdOrganization") . ' : ' . htmlEncode(SqlList::getNameFromId('Organization',$idOrganization)) . '<br/>';
}
if ($paramMonth!="") {
  $headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
}
if ($paramYear!="") {
  $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
}
if (isset($outMode) and $outMode=='excel') {
  $headerParameters.=str_replace('- ','<br/>',Work::displayWorkUnit()).'<br/>';
}

include "header.php";
/*__________________________________________________*/

$compStyle='font-size:10px;';
$lstVisibleProj=($paramProject=='')?ConsolidationValidation::getVisibleProjectToConsolidated($paramProject, $paramProjectType, $idOrganization):$paramProject;
$lstProj=$lstVisibleProj[0];
$month=(strlen($paramMonth)==1)?'0'.$paramMonth:$paramMonth;
$concMonth=$paramYear.$month;

$reelTotal=0;
$leftWorkTotal=0;
$plannedWorkTotal=0;
$validatedWorkTotal=0;
$revenueTotal=0;
$marginTotal=0;
$reelConsTotal=0;


// top board
echo '<table  style="width:90%;margin-left:5%;margin-right:5%;" '.excelName().'>';
echo ' <tr>';
echo '   <td style="width:20%,border-bottom:2px solid black;" class="reportTableHeader" '.excelFormatCell('header').' rowspan="2" colspan="2">&nbsp;</td>';
echo '   <td style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).' rowspan="2">'.i18n('validatedConsolidation').'</td>';
echo '   <td style="width:70%" class="reportTableHeader" '.excelFormatCell('header',20).' colspan="7">'.i18n('sectionWork').'</td>';
echo ' </tr>';
echo ' <tr>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colCA').'</td>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colValidated').'</td>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colReal').'</td>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colRealCons').'</td>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colLeft').'</td>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colPlanned').'</td>';
echo '  <td  style="width:10%" class="reportTableHeader" '.excelFormatCell('header',20).'>'.i18n('colMargin').'</td>';
echo ' <tr>';


  foreach ($lstProj as $proj){    // draw line for each project 
    
    $consValPproj=SqlElement::getSingleSqlElementFromCriteria("ConsolidationValidation",array("idProject"=>$proj->id,"month"=>$concMonth));
    $consolidation=i18n('displayNo');
    if($consValPproj->id!=''){
      $consolidation=i18n('displayYes');
      $reel=$consValPproj->realWork;
      $leftWork=$consValPproj->leftWork;
      $plannedWork=$consValPproj->plannedWork;
      $validatedWork=$consValPproj->validatedWork;
      $revenue=$consValPproj->revenue;
      $margin=$consValPproj->margin;
      $reelCons=$consValPproj->realWorkConsumed;
    }else{
      $lstPeProject=$proj->ProjectPlanningElement;
      $reel=$lstPeProject->realWork;
      $leftWork=$lstPeProject->leftWork;
      $plannedWork=$lstPeProject->plannedWork;
      $validatedWork=$lstPeProject->validatedWork;
      $revenue=($lstPeProject->revenue!='')?$lstPeProject->revenue:0;
      $margin=$validatedWork-$plannedWork;
      $reelCons=ConsolidationValidation::getReelWorkConsumed($proj,$concMonth);
    }
    $projectCode=($proj->projectCode!='')?$proj->projectCode:'-';

    $revenueTotal+=$revenue;
    $validatedWorkTotal+=$validatedWork;
    $reelTotal+=$reel;
    $reelConsTotal+=$reelCons;
    $leftWorkTotal+=$leftWork;
    $plannedWorkTotal+=$plannedWork;
    $marginTotal+=$margin;
    echo '  <tr>';
      echo '   <td class="reportTableData" style="border-right:1px solid grey;'.$compStyle.'" '.excelFormatCell('data',20).' >'.$proj->name.'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',20).' >'.$projectCode.'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.$consolidation.'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.costFormatter($revenue).'</td>';    
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($validatedWork).'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($reel).'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($reelCons).'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($leftWork).'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($plannedWork).'</td>';
      echo '   <td class="reportTableData" style="'.$compStyle.''.(($margin<0)?"background-color:#E8ABAB":"").'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($margin).'</td>';
    echo '  </tr>';
  }
  
// Total line 
echo '  <tr>';
echo '   <td class="reportTableHeader" colspan="3" '.excelFormatCell('header').' >'.i18n('sum').'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.costFormatter($revenueTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($validatedWorkTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($reelTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($reelConsTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($leftWorkTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($plannedWorkTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('data',null,null,null,null,null,null,null,'work').'>'.Work::displayWorkWithUnit($marginTotal).'</td>';
echo '  </tr>';
echo '</table>';