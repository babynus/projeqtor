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
	
	public function calculNextTime(){
		$UTC=new DateTimeZone(Parameter::getGlobalParameter ( 'paramDefaultTimezone' ));
		$date=new DateTime('now');
		$date->modify('+1 minute');
		$cron = Parameter::getGlobalParameter('dataCloningCreationRequest');
		if(!$cron){
			$splitCron=explode(" ",$this->cron);
		}else{
			$splitCron=explode(" ",$cron);
		}
		$count=0;
		if(count($splitCron)==5){
			$find=false;
			while(!$find){ //cron minute/hour/dayOfMonth/month/dayOfWeek
				if(($splitCron[0]=='*' || $date->format("i")==$splitCron[0])
				&& ($splitCron[1]=='*' || $date->format("H")==$splitCron[1])
				&& ($splitCron[2]=='*' || $date->format("d")==$splitCron[2])
				&& ($splitCron[3]=='*' || $date->format("m")==$splitCron[3])
				&& ($splitCron[4]=='*' || $date->format("N")==$splitCron[4])){
					$find=true;
					$date->setTime($date->format("H"), $date->format("i"), 0);
					$this->plannedDate=$date->format("U");
					$this->save(false);
				}else{
					$date->modify('+1 minute');
				}
				$count++;
				if($count>=2150000){
					$this->idle=1;
					$this->save(false);
					$find=true;
					errorLog("Can't find next time for cronAutoSendReport because too many execution #".$this->id);
				}
			}
		}else{
			errorLog("Can't find next time for cronAutoSendReport because too many execution #".$this->id);
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
		$wherePerDay = 'idResource = '.$idUser.' and `requestedDate` > "'.date('Y-m-d').'" and `requestedDate` < "'.addDaysToDate(date('Y-m-d'), 1).'" and `idle` = 0';
		$dataCloningCountPerDay = $dataCloning->countSqlElementsFromCriteria(null, $wherePerDay);
		$dataCloningCountTotal = $dataCloning->countSqlElementsFromCriteria(array("idle"=>"0"));
		$dataCloningPerDay = Parameter::getGlobalParameter('dataCloningPerDay');
		$dataCloningTotal = Parameter::getGlobalParameter('dataCloningTotal');
		if(($dataCloningPerDay-$dataCloningCountPerDay > 0) and ($dataCloningTotal-$dataCloningCountTotal > 0)){
		  $hide = 'block';
		}else{
		  $hide = 'none';
		}
		if($idUser != ''){
		  $dataCloningCount = i18n('colDataCloningCount', array($dataCloningPerDay-$dataCloningCountPerDay, $dataCloningPerDay));
		}else{
		  $dataCloningCount = i18n('colDataCloningCount', array($dataCloningTotal-$dataCloningCountTotal, $dataCloningTotal));
		}
		$result = "";
		$result .='<div id="dataCloningDiv" align="center" style="margin-top:20px;margin-bottom:20px; overflow-y:auto; width:100%;">';
		$result .='  <table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
		$result .='   <tr class="reportHeader">';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colIdUser').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colName').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colVersion').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colOrigin').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colRequestDate').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colPlannedDate').'</td>';
		$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colRequestedDeletedDate').'</td>';
		$result .='     <td style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;">';
		$result .='       <table width="100%"><tr>';
		$result .='         <td width="80%">'.$dataCloningCount.'</td>';
		$result .='         <td width="20%"><a onClick="addDataCloning();" title="'.i18n('addDataCloning').'" style="display:'.$hide.'">'.formatBigButton('Add').'</a></td>';
		$result .='       </tr></table>';
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
			  $result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:left;vertical-align:center;'.$idleColor.'">';
			  $result .='<table width="100%"><tr>';
			  if(!$data->idle){
			    $result .='<td width=10%" style="padding-left:10px"><a onClick="copyDataCloning('.$data->id.');" title="'.i18n('copyDataCloning').'" > '.formatMediumButton('Copy').'</a></td>';
			    $result .='<td width=90%" style="padding-left:10px">'.$data->name.'</td></tr></table></td>';
			  }else{
			    $result .='<td width=100%" style="padding-left:44px">'.$data->name.'</td></tr></table></td>';
			  }
			  $result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;'.$idleColor.'">'.$data->versionCode.'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:left;vertical-align:center;'.$idleColor.'">';
			  $result .='<table width="100%"><tr>';
			  if($data->idOrigine and !$data->idle){
			    $result .='<td width=10%" style="padding-left:10px"><a onClick="gotoDataCloningStatus('.$data->id.');" title="'.i18n('gotoDataCloningStatus').'" > '.formatMediumButton('Goto', true).'</a></td>';
			    $origin = new DataCloning($data->idOrigine);
			    $result .='<td width=90%" style="padding-left:10px">'.$origin->name.'</td></tr></table></td>';
			  }else{
			    $result .='</tr></table></td>';
			  }
			  $result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;font-style:italic;'.$idleColor.'">'.htmlFormatDateTime($data->requestedDate).'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;font-style:italic;'.$idleColor.'">'.htmlFormatDateTime(date('Y-m-d H:i:s', $data->plannedDate)).'</td>';
			  $result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;font-style:italic;'.$idleColor.'">'.htmlFormatDateTime($data->requestedDeletedDate).'</td>';
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
	  $columnList=SqlList::getList('profile');
	  echo '<div style="width:100%;">';
	  echo '<div id="CrossTable_DataCloning_Right" dojoType="dijit.TitlePane"';
	  echo ' title="' .i18n('dataCloningProfileRight') . '"';
	  echo ' style="width:100%; overflow-x:auto;  overflow-y:hidden;"';
	  echo '><br/>';
  	echo '<table class="crossTable" >';
  	// Draw Header
  	echo '<tr><td>&nbsp;</td>';
  	foreach ($columnList as $col) {
  		echo '<td class="tabLabel">' . $col . '</td>';
  	}
  	echo '</tr>';
  	echo '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningAccess').' : </label></td>';
  	foreach ($columnList as $colId => $colName) {
  		echo '<td class="crossTablePivot">';
  		$crit = array("idProfile"=>$colId, "idMenu"=>"222");
  		$checked = SqlElement::getSingleSqlElementFromCriteria('Habilitation', $crit);
  		$checked = ($checked->allowAccess)?'checked':'';
  		echo '<input dojoType="dijit.form.CheckBox" type="checkbox" '.$checked.' id="dataCloningAccess'.$colId.'" name="dataCloningAccess'.$colId.'"/>';
  		echo '</td>';
  	}
  	echo '</tr>';
  	echo '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningRight').' : </label></td>';
  	foreach ($columnList as $colId => $colName) {
  		echo '<td class="crossTablePivot">';
  		echo '<select dojoType="dijit.form.FilteringSelect" class="input" ';
  		echo autoOpenFilteringSelect();
  		echo ' style="width: 100px; font-size: 80%;"';
  		echo ' id="dataCloningRight'.$colId.'" name="dataCloningRight'.$colId.'" ';
  		echo ' >';
  		$crit = array("scope"=>"dataCloningRight", "idProfile"=>$colId);
  		$right=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther', $crit);
  		echo htmlDrawOptionForReference('idaccessScopeSpecific',$right->rightAccess,null,true);
  		echo '</select>';
  		echo '</td>';
  	}
  	echo '</tr>';
  	echo '</table></div><br/>';
  	echo '<div id="CrossTable_DataCloning_GlobalParmeter" dojoType="dijit.TitlePane"';
  	echo ' title="' .i18n('menuGlobalParameter') . '"';
  	echo ' style="width:100%; overflow-x:auto;  overflow-y:hidden;"';
  	echo '>';
  	echo '<table class="crossTable" >';
  	echo '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningCreationRequest').' : </label></td>';
  	echo '<td class="crossTablePivot">';
  	echo '<select dojoType="dijit.form.FilteringSelect" class="input" ';
  	echo autoOpenFilteringSelect();
  	echo ' style="width: 100px; font-size: 80%;"';
  	echo ' id="dataCloningCreationRequest" name="dataCloningCreationRequest"';
  	echo ' onChange="showSpecificHours();">';
  	$request=SqlElement::getSingleSqlElementFromCriteria('Parameter', array("parameterCode"=>"dataCloningCreationRequest"));
  	$request=$request->parameterValue;
  	$selectImmediate = ($request=='* * * * *')?'selected':'';
  	$selectSpecificHours = ($request !='* * * * *')?'selected':'';
  	echo '<option value="immediate" '.$selectImmediate.'>'.i18n('dataCloningImmediate').'</option>';
  	echo '<option value="specificHours" '.$selectSpecificHours.'>'.i18n('dataCloningSpecificHours').'</option>';
  	echo '</select></td>';
  	echo '<td>';
  	$display = ($request !='* * * * *')?'block':'none';
  	echo '<div dojoType="dijit.form.TimeTextBox" name="dataCloningSpecificHours" id="dataCloningSpecificHours"
                    invalidMessage="'.i18n('messageInvalidTime').'" 
                    type="text" maxlength="5" style="margin-left:20px;width:40px; text-align: center;display:'.$display.';" class="input rounded"
                    value="T'.date('H:i').'" hasDownArrow="false">';
    echo '</div>';
  	echo '</td></tr>';
  	echo '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningTotal').' : </label></td>';
  		echo '<td class="crossTablePivot">';
  		$paramCreaTotal=SqlElement::getSingleSqlElementFromCriteria('Parameter', array("parameterCode"=>"dataCloningTotal"));
  		$creaTotal=$paramCreaTotal->parameterValue;
  		echo '<input dojoType="dijit.form.TextBox" id="dataCloningTotal" name="dataCloningTotal" type="number" class="input" style="width: 100px;" value="'.$creaTotal.'" />';
  		echo '</td>';
  	echo '</tr>';
  	echo '<tr><td class="crossTableLine"><label class="label largeLabel">'.i18n('dataCloningPerDay').' : </label></td>';
  		echo '<td class="crossTablePivot">';
  		$paramPerDay=SqlElement::getSingleSqlElementFromCriteria('Parameter', array("parameterCode"=>"dataCloningPerDay"));
  		$creaPerDay=$paramPerDay->parameterValue;
  		echo '<input dojoType="dijit.form.TextBox" id="dataCloningPerDay" name="dataCloningPerDay" type="number" class="input" style="width: 100px;" value="'.$creaPerDay.'" />';
  		echo '</td>';
  	echo '</tr></table>';
  	echo '</div></div>';
	}
}
?>