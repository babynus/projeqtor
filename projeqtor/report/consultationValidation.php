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
$concMonth=$paramYear.$paramMonth;

$reelTotal=0;
$leftWorkTotal=0;
$plannedWorkTotal=0;
$validatedWorkTotal=0;
$revenueTotal=0;
$marginTotal=0;
$reelConsTotal=0;


// top board
echo '<table  style="width:90%;margin-left:5%;margin-right:5%;" '.excelName('consolidationValidation').'>';
echo ' <tr>';
echo '   <td colspan="2" style="width:20%,border-bottom:2px solid black;" class="reportTableColumnHeader" '.excelFormatCell('header').'>&nbsp;</td>';
echo '   <td style="width:10%" class="reportTableColumnHeader" '.excelFormatCell('header').'>'.i18n('consolidation validé').'</td>';
  if(isset($outMode) and $outMode=='excel'){
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
    echo '        <td  style="width:16%;" class="reportTableColumnHeader" '.excelFormatCell('subheader').'>'.i18n('').'</td>';
  }else{
    echo '   <td colspan="7" style="width:70%;padding-left:0px;padding-right:0px;" class="reportTableLineHeader" '.excelFormatCell('rowheader').' >';
    echo '    <table style="width:100%"  >';
    echo '      <tr >';
    echo '        <td style="width:100%" class="reportTableColumnHeader"  colspan="7"  >'.i18n('sectionWork').'</td>';
    echo '      </tr>';
    echo '      <tr>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '        <td  style="width:14%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '        <td  style="width:16%;" class="reportTableColumnHeader" >'.i18n('').'</td>';
    echo '      <tr>';
    echo '    </table>';
    echo '   </td>';
  }
echo '  </tr>';


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
      $margin=abs($validatedWork-$plannedWork);
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
    if(isset($outMode) and $outMode=='excel'){
      echo '        <td  style="width:50%;border-right:1px solid grey;'.$compStyle.'" '.excelFormatCell('data',20).' >'.$proj->name.'</td>';
      echo '        <td style="'.$compStyle.'" '.excelFormatCell('data',20).' >'.$projectCode.'</td>';
    }else{
      echo '   <td class="reportTableData" style="width:20%;"colspan="2" >';
      echo '     <table style="width:100%">';
      echo '      <tr>';
      echo '        <td  style="width:50%;border-right:1px solid grey;'.$compStyle.'" >'.$proj->name.'</td>';
      echo '        <td style="'.$compStyle.'" >'.$projectCode.'</td>';
      echo '      </tr>';
      echo '     </table>';
      echo '   </td>';
    }
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($consolidation).'</td>';
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($revenue).'</td>';    
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($validatedWork).'</td>';
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($reel).'</td>';
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($reelCons).'</td>';
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($leftWork).'</td>';
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($plannedWork).'</td>';
    echo '   <td class="reportTableData" style="width:10%;'.$compStyle.'" '.excelFormatCell('data').'>'.Work::displayWorkWithUnit($margin).'</td>';
  }
  
// Total line 
echo '  <tr>';
echo '   <td class="assignHeader" colspan="2" '.excelFormatCell('subheader').' >'.i18n('sum').'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>&nbsp;</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($revenueTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($validatedWorkTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($reelTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($reelConsTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($leftWorkTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($plannedWorkTotal).'</td>';
echo '   <td class="assignHeader" style="'.$compStyle.'" '.excelFormatCell('subheader').'>'.Work::displayWorkWithUnit($marginTotal).'</td>';
echo '  </tr>';
echo '</table>';