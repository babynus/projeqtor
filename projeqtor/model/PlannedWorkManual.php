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

/* ============================================================================
 * RiskType defines the type of a risk.
 */ 
require_once('_securityCheck.php');
class PlannedWorkManual extends GeneralWork {

	 public $period;
	 public $idInterventionMode;
   public $inputUser;
   public $inputDateTime;
   public $idWork;
   public $idPlannedWork;
   private static $_size='22';
   
   public static $_cacheColor=array();
   
	 private static $_colCaptionTransposition = array(
	     'workDate'=>'date'
	 );
	 private static $_fieldsAttributes=array(
	     "day"=>"hidden,noExport,noImport",
	     "week"=>"hidden,noExport,noImport",
	     "month"=>"hidden,noExport,noImport",
	     "year"=>"hidden,noExport,noImport",
	     "dailyCost"=>"hidden,noExport,noImport"
	 );
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  // ================================================================================================
  //
  // ================================================================================================
  
  public function control(){
    $result="";
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function deleteControl() {
    $result='';
   
    if ($result=='') {
      $result .= parent::deleteControl();
    }
    return $result;
  }
  
  public function delete() {
    debugLog("DELETE");
    $old=$this->getOld();
    $result=parent::delete();
    if ($old->refType) {
      // Save planned work depending on work type
      $old->saveWork();
    }
    return $result;
  }
  
  public function save() {
    debugLog("SAVE");
    $old=$this->getOld();
    if ($this->refType) {
      $refType=$this->refType;
      $item=new $refType($this->refId);
      $this->idProject=$item->idProject;
    }
    $result=parent::save();
    if ($this->refType) {
      // Save planned work depending on work type
      $this->saveWork();
    }
    if ($old->refType and ($old->refType!=$this->refType or $old->refId!=$this->refId)) {
      $old->work=0;
      $old->saveWork();
    }
    return $result;
  }
  public function simpleSave() {
    return parent::save();
  }
  
  function saveWork() {
    debugLog("saveWork");
    $type=self::getWorkType();
    $wClass=($type=='real')?'Work':'PlannedWork';
    $wField='id'.$wClass;
    debugLog("PlannedWorkManuel::save() - will save $wClass");
    $w=new $wClass();
    $critAss=array('idResource'=>$this->idResource, 'refType'=>$this->refType, 'refId'=>$this->refId);
    $crit=array('workDate'=>$this->workDate, 'idResource'=>$this->idResource, 'refType'=>$this->refType, 'refId'=>$this->refId);
    $sum=$this->sumSqlElementsFromCriteria('work', $crit);
    $workList=$w->getSqlElementsFromCriteria($crit,true);
    if (count($workList)>1) {
      traceLog("ERROR - PlannedWorkManuel::save() : found more than one $wClass");
      traceLog($crit);
    }
    $work=reset($workList);
    if ($sum==0) {
      if ($work->id) {
        $workResult=$work->delete();
        debugLog("PlannedWorkManuel::save() - delete $wClass : $workResult");
        $this->$wField=null;
      }
    } else {
      $ass=new Assignment();
      $assList=$ass->getSqlElementsFromCriteria($critAss,true);
      if (count($assList)>1) {
        traceLog("ERROR - PlannedWorkManuel::save() : found more than one Assignment");
        traceLog($critAss);
      }
      $ass=reset($assList);
      if (!$ass->id) {
        $ass->idProject=$this->idProject;
        $assResult=$ass->save();
        debugLog("PlannedWorkManuel::save() - save Assignment : $assResult");
      }
      $work->work=$sum;
      $work->idProject=$this->idProject;
      $work->setDates($this->workDate);
      $work->idAssignment=$ass->id;
      $workResult=$work->save();
      debugLog("PlannedWorkManuel::save() - save $wClass : $workResult");
      if (!$this->idAssignment or $this->idAssignment!=$ass->id or !$this->$wField or $this->$wField!=$work->id) {
        if (!$this->idAssignment or $this->idAssignment!=$ass->id) {
          $this->idAssignment=$ass->id;
        } 
        if (!$this->$wField or $this->$wField!=$work->id) {
          $this->$wField=$work->id;
        }
        $this->simpleSave();
      }
    }
    if ($this->idAssignment) {
      $this->updateAssignment();
    }
  }
  public function updateAssignment() {
    if (!$this->idAssignment) return;
    $ass=new Assignment($this->idAssignment);
    $crit=array('refType'=>$this->refType, 'refId'=>$this->refId, 'idResource'=>$this->idResource);
    $pw=new PlannedWork();
    $w=new Work();
    $realwork=$w->sumSqlElementsFromCriteria('work', $crit);
    $plannedwork=$pw->sumSqlElementsFromCriteria('work', $crit);
    $realStart=$w->getMinValueFromCriteria('workDate', $crit,null,true);
    $realEnd=$w->getMaxValueFromCriteria('workDate', $crit);
    $plannedStart=$pw->getMinValueFromCriteria('workDate', $crit,null,true);
    $plannedEnd=$pw->getMaxValueFromCriteria('workDate', $crit);
    $ass->assignedWork=$plannedwork+$realwork;
    $ass->leftWork=$plannedwork;
    $ass->realWork=$realwork;
    $ass->plannedStartDate=$plannedStart;
    $ass->plannedEndDate=$plannedEnd;
    $ass->realStartDate=$realStart;
    $ass->realEndDate=$realEnd;
    $resAss=$ass->save();
    debugLog("Save Assignment : $resAss");
  }
  
  
  public function getMenuClass() {
    return "menuActivity";
  }
  
  public static function getWorkType() {
    $param=Parameter::getGlobalParameter('plannedWorkManualType');
    if ($param=='real') return 'real';
    else return 'planned';
  }
  
  public static function drawLine($scope, $idResource, $year, $month, $readonly=false) {
    // draw line for given resource and month
    // if $idAssignment is not null, we are on update of existing assignment
    // if $idActivity is not null, we are on creation of new assignment (so no existing data to retreive)
    $month=intval($month);
    $monthWithZero=(($month<10)?'0':'').$month;
    $lastDay=lastDayOfMonth($month,$year);
    $lastDayWithZero=(($lastDay<10)?'0':'').$lastDay;
    $max=($scope=='intervention')?$lastDay:31;
    $size=self::$_size;
    $midSize=($size-1)/2;
    $letterSize=($size/2)-2;
    $crit="idResource=$idResource and workDate>='$year-$monthWithZero-01 and workDate<=$year-$monthWithZero-$lastDayWithZero'";
    $pwm=new PlannedWorkManual();
    $lstPwm=$pwm->getSqlElementsFromCriteria(null,null,$crit);
    $exist=array();
    $resObj=new ResourceAll($idResource);
    foreach ($lstPwm as $pwm) {
        if (!isset($exist[$pwm->workDate])) $exist[$pwm->workDate]=array();
        $exist[$pwm->workDate][$pwm->period]=array('refType'=>$pwm->refType,'refId'=>$pwm->refId,'mode'=>$pwm->idInterventionMode);
    }
    for ($i=1;$i<=$max;$i++) {
      if ($i>$lastDay) {
        echo '<td style="border:0;background-color:transparent"></td>'; 
        continue;
      }
      $colorAM='#ffffff';
      $colorPM='#ffffff';
      $letterAM='';
      $letterPM='';
      $date=$year.'-'.(($month<10)?'0':'').$month.'-'.(($i<10)?'0':'').$i;
      if (isOffDay($date,$resObj->idCalendarDefinition)) {
        $colorAM="#d0d0d0";
        $colorPM="#d0d0d0";
      }
      //if ($i%4==0) $colorAM='#f0a0a0';
      //if ($i%5==0) $colorAM='#a0a0f0';
      //if ($i%3==0) $colorPM='#a0f0e0';
      if (isset($exist[$date])) {
        foreach (array('AM','PM') as $period) {
          if (isset($exist[$date][$period])) {
            $type=$exist[$date][$period]['refType'];
            $id=$exist[$date][$period]['refId'];
            $mode=$exist[$date][$period]['mode'];
            $colorName='color'.$period;
            if ($type and $id) $$colorName=self::getColor($type,$id);
            $letterName='letter'.$period;
            if ($mode) $$letterName=SqlList::getFieldFromId('InterventionMode', $mode, 'letter',false);
          }
        }
      }
      echo '<td style="border:1px solid #a0a0a0;">';
      echo '<table style="width:100%;height:100%">';
      $color=getForeColor($colorAM);
      $cursor="pointer";
      echo '<tr style="height:'.$midSize.'px;"><td onClick="selectInterventionDate(\''.$date.'\',\''.$idResource.'\',\'AM\',event)" style="cursor:'.$cursor.';width:100%;background:'.$colorAM.';border-bottom:1px solid #e0e0e0;position:relative;text-align:center;"><div style="max-height:'.$midSize.'px;width:100%;overflow-hidden;font-size:'.$letterSize.'px;position:absolute;top:-1px;color:'.$color.';">'.$letterAM.'</div></td></tr>';
      $color=getForeColor($colorPM);
      echo '<tr style="height:'.$midSize.'px;"><td onClick="selectInterventionDate(\''.$date.'\',\''.$idResource.'\',\'PM\',event)" style="cursor:'.$cursor.';width:100%;background:'.$colorPM.';border:0;position:relative;text-align:center;"><div style="max-height:'.$midSize.'px;width:100%;overflow-hidden;font-size:'.$letterSize.'px;position:absolute;top:-1px;color:'.$color.';">'.$letterPM.'</div></td></tr>';
      echo '</table>';  
      echo '</td>';
    }
  }
  /**
   * 
   * @param unknown $scope 'intervention' or 'assignment'
   * @param unknown $resourceList
   * @param unknown $monthsList
   */
  public static function drawTable($scope, $resourceList, $monthList, $readonly=false) {
    if ($scope=='assignment') {
      if (is_array($resourceList) and count($resourceList)>1) { 
        echo "ERROR - Only one resource for assignment mode";
        exit;
      }
      if (! is_array($monthList) and count($monthList)>1) {
        echo "ERROR - monthList must be a list for assignment mode";
        exit;
      }     
    } else if ($scope=='intervention') {
      if (is_array($monthList) and count($monthList)>1) {
        echo "ERROR - Only one month for intervention mode";
        exit;
      }
      if (! is_array($resourceList) and count($resourceList)>1) {
        echo "ERROR - Resource must be a list for intervention mode";
        exit;
      }
    } else {
      echo "ERROR - invalid parameters";
    }
    $size=self::$_size;
    
    if ($scope=='intervention') {
      $nameWidth=150;
      $monthYear=(is_array($monthList))?$monthList[0]:$monthList;
      $monthYear=str_replace('-','',$monthYear);
      $year=substr($monthYear,0,4);
      $month=substr($monthYear,4);
      $nbDays=lastDayOfMonth(intval($month),$year);
      echo '<table>';
      echo '<tr>';
      echo '<td class="reportTableHeader" rowSpan="2" style="width:'.$nameWidth.'px">'.i18n('menuResource').'</td>';
      echo '<td class="reportTableHeader" colspan="'.$nbDays.'">'.getMonthName($month).' '.$year.'</td>';
      echo '</tr>';
      echo '<tr >';
      for ($i=1;$i<=$nbDays;$i++) {
        $date=$year.'-'.$month.'-'.(($i<10)?'0':'').$i;
        if (isOffDay($date)) $classDay="reportTableHeader";
        else $classDay="noteHeader";
        echo '<td class="'.$classDay.'" style="padding:0;font-weight:normal;width:'.$size.'px">'.$i.'</td>';
      }
      echo '</tr>';
      foreach ($resourceList as $idRes) {
        $nameRes=SqlList::getNameFromId('Affectable', $idRes);
        echo '<tr style="height:'.$size.'px">';
        echo '<td class="noteHeader" style="width:'.$nameWidth.'px;"><div style="white-space:nowrap;max-width:'.$nameWidth.'px;max-height:'.$size.'px;overflow:hidden;">'.$nameRes.'</div></td>';
        self::drawLine($scope, $idRes, $year, $month, $readonly);
        echo '<tr>';
      }
      echo '</table>';
    } else {
      $nameWidth=150;
      $nbDays=31;
      $idRes=(is_array($resourceList))?$resourceList[0]:$resourceList;
      echo '<table>';
      echo '<tr>';
      echo '<td class="reportTableHeader" rowSpan="2" style="width:'.$nameWidth.'px">'.i18n('months').'</td>';
      echo '<td class="reportTableHeader" colspan="'.$nbDays.'">'.i18n('sectionRepartitionMonthly').'</td>';
      echo '</tr>';
      echo '<tr >';
      for ($i=1;$i<=$nbDays;$i++) {
        echo '<td class="noteHeader" style="width:'.$size.'px">'.$i.'</td>';
      }
      echo '</tr>';
      foreach ($monthList as $monthYear) {
        $monthYear=str_replace('-','',$monthYear);
        $year=substr($monthYear,0,4);
        $month=substr($monthYear,4);
        echo '<tr style="height:'.$size.'px">';
        echo '<td class="noteHeader" style="width:'.$nameWidth.'px"><div style="white-space:nowrap;max-width:'.$nameWidth.'px;max-height:'.$size.'px;overflow:hidden;">'.getMonthName($month).' '.$year.'</div></td>';
        self::drawLine($scope, $idRes, $year, $month, $readonly);
        echo '<tr>';
      }
      echo '</table>';            
    }
    $listR=(is_array($resourceList))?implode(',',$resourceList):$resourceList;
    $listM=(is_array($monthList))?implode(',',$monthList):$monthList;
    echo '<input type="hidden" id="plannedWorkManualInterventionSize" value="'.self::$_size.'" style="background:#ffe0e0"/>';
    echo '<input type="hidden" id="plannedWorkManualInterventionResourceList" value="'.$listR.'" style="background:#ffe0e0"/>';
    echo '<input type="hidden" style="width:500px;background:#ffe0e0" id="plannedWorkManualInterventionMonthList" value="'.$listM.'" />';
    
  }
  
  public static function drawActivityTable($idProject=null,$monthYear=null) {
    if($idProject){
      $crit=array('idPlanningMode'=>23,'idle'=>'0','idProject'=>$idProject);
    }else{
      $crit=array('idPlanningMode'=>23,'idle'=>'0');
    }
    $pe=new PlanningElement();
    $list=$pe->getSqlElementsFromCriteria($crit);
    $nameWidth=250;
    $idWidth=20;
    $nbDays=31;
    $year=null;
    $size=self::$_size;
    $midSize=($size-1)/2;
    $projList=array();
    if ($monthYear) {
      $monthYear=str_replace('-','',$monthYear);
      $year=substr($monthYear,0,4);
      $month=substr($monthYear,4);
      $nbDays=lastDayOfMonth(intval($month),$year);
    }
    echo '<table>';
    echo '<tr>';
    echo '<td class="reportTableHeader" style="width:'.$nameWidth.'px">'.i18n('Project').'</td>';
    echo '<td class="reportTableHeader" style="width:'.($nameWidth+($idWidth*2)).'px" colspan="3">'.i18n('Activity').'</td>';
    echo '<td class="reportTableHeader" style="width:'.$idWidth.'px">'.i18n('unitCapacity').'</td>';
    if ($monthYear) {
      for ($i=1;$i<=$nbDays;$i++) {
        $date=$year.'-'.$month.'-'.(($i<10)?'0':'').$i;
        if (isOffDay($date)) $classDay="reportTableHeader";
        else $classDay="noteHeader";
        echo '<td class="'.$classDay.'" style="padding:0;font-weight:normal;width:'.$size.'px">'.$i.'</td>';
      }
    }
    
    echo '</tr>';
    foreach ($list as $pe) {
      if (!isset($projList[$pe->idProject])) {
        $proj=new Project($pe->idProject,true);
        $projList[$pe->idProject]=$proj->name;
      }
      $badgeSize=self::$_size-4;
      $colorBadge='<div style="border-radius:'.($badgeSize/2+2).'px;border:1px solid #e0e0e0;width:'.$badgeSize.'px;height:'.$badgeSize.'px;float:left;background-color:'.self::getColor($pe->refType,$pe->refId).'" ></div>';
      echo '<tr style="cursor:pointer" class="dojoxGridRow" onClick="selectInterventionActivity(\''.$pe->refType.'\','.$pe->refId.','.$pe->id.');">';
      echo '<td class="dojoxGridCell interventionActivitySelector interventionActivitySelector'.$pe->id.'" style="width:'.$nameWidth.'px">'.$projList[$pe->idProject].'</td>';
      echo '<td class="dojoxGridCell noteDataCenter interventionActivitySelector interventionActivitySelector'.$pe->id.'" style="width:'.($idWidth).'px" >#'.$pe->refId.'</td>';
      echo '<td class="dojoxGridCell interventionActivitySelector interventionActivitySelector'.$pe->id.'" style="border-right:0;width:'.($idWidth).'px" >'.$colorBadge.'</td>';
      echo '<td class="dojoxGridCell interventionActivitySelector interventionActivitySelector'.$pe->id.'" style="border-left:0;width:'.($nameWidth).'px" >'.$pe->refName.'</td>';
      echo '<td class="dojoxGridCell noteDataCenter interventionActivitySelector interventionActivitySelector'.$pe->id.'" style="text-align:center;margin:0;padding;0;width:'.$idWidth.'px">'
          .'<input type="text" xdata-dojo-type="dijit.form.TextBox" value="1" style="font-family: Verdana, Arial, Tahoma, sans-serif;font-size: 8pt;text-align:center;width:'.($idWidth-2).'px;"/>' 
          .'</td>';
      if ($monthYear) {
        for ($i=1;$i<=$nbDays;$i++) {
          $date=$year.'-'.$month.'-'.(($i<10)?'0':'').$i;
          //$date=$year.'-'.(($month<10)?'0':'').$month.'-'.(($i<10)?'0':'').$i;
          $colorAM='#ffffff';
          $colorPM='#ffffff';
          if (isOffDay($date)) {
            $colorAM="#d0d0d0";
            $colorPM="#d0d0d0";
          }
          echo '<td style="border:1px solid #a0a0a0;">';
          echo '<table style="width:100%;height:100%">';
          $color=getForeColor($colorAM);
          $cursor="pointer";
          echo '<tr style="height:'.$midSize.'px;"><td style="width:100%;background:'.$colorAM.';border-bottom:1px solid #e0e0e0;position:relative;text-align:center;"></td></tr>';
          $color=getForeColor($colorPM);
          echo '<tr style="height:'.$midSize.'px;"><td style="width:100%;background:'.$colorPM.';border:0;position:relative;text-align:center;"></td></tr>';
          echo '</table>';  
          echo '</td>';
        }
      }
      echo '</tr>';
    }
    echo '</table>';
    echo '<input type="hidden" id="interventionActivityType" value="" style="width:80px;background:#ffe0e0" />';
    echo '<input type="hidden" id="interventionActivityId" value="" style="width:30px;background:#ffe0e0" />';
  }
  public static function setSize($size) {
    if ($size<20) {
      debugLog("PlannedWorkManual::setSize($size) cannot set less than 20");
      $size=20;
    }
    self::$_size=$size;
  }
  
  
  public static function getColor($type,$id) {
    if (! $type or !$id ) return '';
    $key=$type.'#'.$id;
    if (isset(self::$_cacheColor[$key])) {
      return self::$_cacheColor[$key];
    }
    if (property_exists($type, 'color')) {
      $obj=new $type($id,true);
      if ($obj->color) {
        self::$_cacheColor[$key]=$obj->color;
        return self::$_cacheColor[$key];
      }
    }
    self::$_cacheColor[$key]=Absence::$_colorTab[$id%10];
    return self::$_cacheColor[$key];
  }
}
require_once '../tool/formatter.php';
?>