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
require_once('_securityCheck.php');
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";

class DataCloning extends SqlElement{
	public $id;
	public $name;
	public $idResource;
	public $versionCode;
	public $idOrigine;
	public $requestedDate;
	public $plannedDate;
	public $deletedDate;
	public $requestedDeletedDate;
	public $isRequestedDelete;
	public $isActive;
	public $idle;
	
	private static $_databaseTableName = 'dataCloning';
	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	*/
	function __construct($id=NULL, $withoutDependentObjects=false) {
	  parent::__construct($id,$withoutDependentObjects);
	}
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }
	
	function save(){
		return parent::save();
	}
	
	function getVersionCodeList(){
	  $List = SqlList::getList('DataCloning', 'versionCode');
	  if($List){
	    foreach ($List as $version){
	    	$versionList[$version]=$version;
	    }
	    return $versionList;
	  }else{
	    return false;
	  }
	}

	public static function drawDataCloningList($idUser, $versionCode){
		$noData = true;
		$dataCloning = new DataCloning();
		$user = getSessionUser();
		$showClosed = Parameter::getUserParameter('dataCloningShowClosed');
		if($showClosed == ''){
		  $showClosed = 0;
		}
		$critWhere = "";
		if($versionCode != ''){
			$critWhere .=" and versionCode='".$versionCode."'";
		}
		if($showClosed == 0){
			$critWhere .=" and idle=".$showClosed;
		}
		$listUser=array();
		if(trim($idUser)){
			$aff=new Affectable($idUser);
			$listUser[$idUser]=($aff->name)?$aff->name:$aff->userName;
		} else {
			$listUser = getListForSpecificRights('imputation');
		}
		$dataCloningCount = $dataCloning->countSqlElementsFromCriteria(array("idResource"=>$user->id, "idle"=>"0"));
		$result = "";
		$result .='<div id="dataCloningDiv" align="center" style="margin-top:20px;margin-bottom:20px; overflow-y:auto; width:100%;">';
		$result .='  <table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
		$result .='   <tr class="reportHeader">';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colIdUser').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colName').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colVersion').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colRequestDate').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colPlannedDate').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colRequestedDeletedDate').'</td>';
		$result .='     <td style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;">';
		$result .='     <a onClick="addDataCloning();" title="'.i18n('addDataCloning').'" >'.formatBigButton('Add').'</a></td>';
		$result .='   </tr>';
		foreach ($listUser as $id=>$name){
		  $where ="idResource=".$id.$critWhere.";";
			$listDataCloning = $dataCloning->getSqlElementsFromCriteria(null, null, $where);
			$countLine = 0;
			foreach ($listDataCloning as $data){
			  $noData = false;
			  $resource = new Resource($data->idResource, true);
			  $result .='<tr>';
			  if($countLine == 0){
			  	$result .='<td style="border-top: 1px solid grey;border-left: 1px solid grey;border-right: 1px solid grey;height:40px;width:10%;text-align:left;vertical-align:center;">';
			  	$result .='<table align="center"><tr>'
			  			.'<td style="text-align:right">'.formatUserThumb($resource->id, $resource->name, null, 22, 'right').'</td>'
			  					.'<td style="white-space:nowrap;text-align:left">&nbsp'.$resource->name.'</td></tr>';
			  	$result .=' </table></td>';
			  }else{
			  	$result .='     <td style="border-left: 1px solid grey;border-right: 1px solid grey;height:40px;width:10%;"></td>';
			  }
			  $idleColor='';
			  if($data->idle){
			    $idleColor = 'background-color:#eeeeee;';
			  }
			  $result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:center;vertical-align:center;'.$idleColor.'">'.$data->name.'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;'.$idleColor.'">'.$data->versionCode.'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:center;vertical-align:center;font-style:italic;'.$idleColor.'">'.htmlFormatDateTime($data->requestedDate).'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:center;vertical-align:center;font-style:italic;'.$idleColor.'">'.htmlFormatDateTime($data->plannedDate).'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:center;vertical-align:center;font-style:italic;'.$idleColor.'">'.htmlFormatDateTime($data->requestedDeletedDate).'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:20%;text-align:center;vertical-align:center;">';
			  $background = '#a3d179';
			  $result .='<table width="100%"><tr>';
			  if($data->idle){
			  	$background = '#ff7777';
			  	$result .='<td width="100%" style="background-color:'.$background.';border-right:1px solid grey;height:40px;">'.i18n('deleteCloningStatus', array(htmlFormatDateTime($data->deletedDate))).'</td>';
			  }else if($data->isRequestedDelete){
			    $background = '#ffb366';
			    $result .='<td width="80%" style="background-color:'.$background.';border-right:1px solid grey;height:40px;">'.i18n('cancelCloningStatus').'</td>';
			    $result .='<td width="20%"><a onClick="cancelDataCloningStatus('.$data->id.');" title="'.i18n('cancelDataCloningStatus').'" > '.formatMediumButton('Cancel', true).'</a></td>';
			  }else{
			    if($data->isActive){
			      $activeText = i18n('activeCloningStatus');
			    }else{
			      $activeText = i18n('requestedCloningStatus');
			    }
			    $result .='<td width=80%" style="background-color:'.$background.';border-right:1px solid grey;height:40px;">';
			    $result .='<table width="100%"><tr>';
			    $result .='<td width=10%" style="padding-left:10px"><a onClick="gotoDataCloningStatus('.$data->id.');" title="'.i18n('gotoDataCloningStatus').'" > '.formatMediumButton('Goto', true).'</a></td>';
			    $result .='<td width=90%">'.$activeText.'</td></tr></table>';
			    $result .='<td width="20%"><a onClick="removeDataCloningStatus('.$data->id.');" title="'.i18n('removeDataCloningStatus').'" > '.formatMediumButton('Remove').'</a></td>';
			  }
			  $result .='</tr></table></td>';
			  $countLine++;
			}
		}
		if($noData==true){
			$result .='<tr><td colspan="8">';
			$result .='<div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;width:100%;">'.i18n('noDataFound').'</div>';
			$result .='</td></tr>';
		}
		$result .='  </table>';
		$result .='</div>';
		echo $result;
	}
	
	public static function drawDataCloningParameter(){
	  $result = '';
	  $columnList=SqlList::getList('profile');
	  $result .= '<br/><div style="width:98%; overflow-x:auto;  overflow-y:hidden;">';
  	$result .= '<table class="crossTable" >';
  	// Draw Header
  	$result .= '<tr><td>&nbsp;</td>';
  	foreach ($columnList as $col) {
  		$result .= '<td class="tabLabel">' . $col . '</td>';
  	}
  	$result .= '</tr>';
  	$result .= '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningCreationRequest').'</label></td>';
  	foreach ($columnList as $colId => $colName) {
  		$result .= '<td class="crossTablePivot">';
  		$result .= '<select dojoType="dijit.form.FilteringSelect" class="input" ';
  		$result .= autoOpenFilteringSelect();
  		$result .= ' style="width: 100px; font-size: 80%;"';
  		$result .= ' >';
  		//htmlDrawOptionForReference('id' . $formatList, $val, null, true);
  		$result .= '</select>';
  		$result .= '</td>';
  	}
  	$result .= '</tr>';
  	$result .= '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningAccess').'</label></td>';
  	foreach ($columnList as $colId => $colName) {
  		$result .= '<td class="crossTablePivot">';
  		$result .= '<select dojoType="dijit.form.FilteringSelect" class="input" ';
  		$result .= autoOpenFilteringSelect();
  		$result .= ' style="width: 100px; font-size: 80%;"';
  		$result .= ' >';
  		//htmlDrawOptionForReference('id' . $formatList, $val, null, true);
  		$result .= '</select>';
  		$result .= '</td>';
  	}
  	$result .= '</tr>';
  	$result .= '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningTotal').'</label></td>';
  	foreach ($columnList as $colId => $colName) {
  		$result .= '<td class="crossTablePivot">';
  		$result .= '<select dojoType="dijit.form.FilteringSelect" class="input" ';
  		$result .= autoOpenFilteringSelect();
  		$result .= ' style="width: 100px; font-size: 80%;"';
  		$result .= ' >';
  		//htmlDrawOptionForReference('id' . $formatList, $val, null, true);
  		$result .= '</select>';
  		$result .= '</td>';
  	}
  	$result .= '</tr>';
  	$result .= '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningDay').'</label></td>';
  	foreach ($columnList as $colId => $colName) {
  		$result .= '<td class="crossTablePivot">';
  		$result .= '<select dojoType="dijit.form.FilteringSelect" class="input" ';
  		$result .= autoOpenFilteringSelect();
  		$result .= ' style="width: 100px; font-size: 80%;"';
  		$result .= ' >';
  		//htmlDrawOptionForReference('id' . $formatList, $val, null, true);
  		$result .= '</select>';
  		$result .= '</td>';
  	}
  	$result .= '</tr>';
  	$result .= '</table></div>';
	  echo $result;
	}
}
?>