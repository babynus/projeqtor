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
class ClientContractMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_Description;
  public $id;    
  public $name;
  public $number;
  public $idClientContractType;
  public $idProject;
  public $idUser;
  public $idClient;
  public $tenderReference;
  public $origin;
  public $description;
  public $_sec_Progress;
  public $_tab_2_1=array('startDate', 'endDate' , 'contractDate');
  public $startDate;
  public $endDate;
  public $initialContractTerm;
  public $idUnitContract;
  public $noticePeriod;
  public $idUnitNotice;
  public $noticeDate;
  public $deadlineDate;
  public $periodicityContract;
  public $_lib_helpPeriodicityContract;
  public $periodicityBill;
  public $_lib_helpPeriodicityBill;
  public $_sec_Treatment_right;
  public $idResource;
  public $idStatus;
  public $idRenewal;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  public $_lib_cancelled;
  public $_sec_contacts;
  public $idContactContract;
  public $phoneNumber;
  public $sla;
  public $_lib_help_sla;
  public $_tab_2_3=array('StartTime', 'EndTime' , 'weekPeriod','saturdayPeriod','sundayAndOffDayPeriod');
  public $weekPeriod;
  public $weekPeriodEnd;
  public $saturdayPeriod;
  public $saturdayPeriodEnd;
  public $sundayAndOffDayPeriod;
  public $sundayAndOffDayPeriodEnd;
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();
  public $_nbColMax=3;
  // Define the layout that will be used for lists
  
  private static $_layout='
          <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
          <th field="name" width="15%" >${name}</th>
          <th field="number" width="15%" >${number}</th>
          <th field="nameProject" width="8%" >${idProject}</th>
          <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
          <th field="handled" width="5%" formatter="booleanFormatter" >${handled}</th>
          <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
          <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required",  
                                  "idProject"=>"required",
                                  "idClientContractType"=>"required",
                                  "idClient"=>"required",
                                  "done"=>"nobr",
                                  "handled"=>"nobr",
                                  "idle"=>"nobr",
                                  "idleDate"=>"nobr",
                                  "cancelled"=>"nobr",
                                  "idStatus"=>"required",
                                  "startDate"=>"nobr",
                                  "periodicityContract"=>"nobr",
                                  "periodicityBill"=>"nobr",
                                  "sla"=>"nobr",
                                  "weekPeriod"=>"nobr",
                                  "sundayAndOffDayPeriod"=>"nobr",
                                  "startDate"=>"nobr",          
                                  "initialContractTerm"=>"nobr",
                                  "idUnitContract"=>"size1/3",
                                  "noticePeriod"=>"nobr",
                                  "idUnitNotice"=>"size1/3"
  );   
 
  private static $_colCaptionTransposition = array(
   'idPeriod'=>'period',
   'idUser'=>'issuer',
   'idContactContract'=>'idContact',
   'idResource'=>'responsible',
   'idUnitContract'=>'idUnitDurationContract',
   'idUnitNotice'=>'idUnitDurationNotice',
  );
  
  private static $_databaseColumnName = array( 
      'idUnitContract'=>'idUnitDurationContract', 
      'idUnitNotice' => 'idUnitDurationNotice');
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
  	parent::__construct($id,$withoutDependentObjects);
  	if ($withoutDependentObjects) return;
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

  public function setAttributes() {
    if (!$this->id) {
      self::$_fieldsAttributes['approved']='readonly,nobr';
    }
  }
// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }  

  
  /** ========================================================================
   * Return the specific databaseColumnName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    if ($colName=='startDate') {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var initialContractTermVal=dijit.byId('initialContractTerm').getValue();";
      $colScript .=" var unitDuration=dijit.byId('idUnitContract').getValue();";
      $colScript .=" var end=dijit.byId('endDate');";
      $colScript .=" end.set('dropDownDefaultValue',this.value);";
      $colScript .=" end.constraints.min=this.value;"; 
      $colScript .="  if( initialContractTermVal && initialContractTermVal != 0 ){ ";
      $colScript .="    switch (unitDuration) { ";
      $colScript .="      case '1':";
      $colScript .="                var newDate=addDaysToDate(this.value,initialContractTermVal);";
      $colScript .="                dijit.byId('endDate').set('value',newDate);";
      $colScript .="                break;";
      $colScript .="      case '2':";
      $colScript .="                var newDate= new Date(this.value);";
      $colScript .="                newDate.setMonth(this.value.getMonth()+initialContractTermVal);";
      $colScript .="                dijit.byId('endDate').set('value',addDaysToDate(newDate,-1));";
      $colScript .="                break;";
      $colScript .="      case '3':";
      $colScript .="                var newDate= new Date(this.value);";
      $colScript .="                newDate.setUTCFullYear(this.value.getUTCFullYear()+initialContractTermVal);";
      $colScript .="                dijit.byId('endDate').set('value',addDaysToDate(newDate,-1));";
      $colScript .="                break;";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='idUnitContract'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var initialContractTermVal=dijit.byId('initialContractTerm').getValue();";
      $colScript .=" var startDate=dijit.byId('startDate').getValue();";
      $colScript .="  if( (initialContractTermVal  && initialContractTermVal!= 0) && (startDate != undefined)  ){ ";
      $colScript .="    switch (this.value) { ";
      $colScript .="      case '1':";
      $colScript .="                var newDate=addDaysToDate(startDate,initialContractTermVal);";
      $colScript .="                dijit.byId('endDate').set('value',newDate);";
      $colScript .="                break;";
      $colScript .="      case '2':";
      $colScript .="                var newDate= new Date(startDate);";
      $colScript .="                newDate.setMonth(startDate.getMonth()+initialContractTermVal);";
      $colScript .="                dijit.byId('endDate').set('value',addDaysToDate(newDate,-1));";
      $colScript .="                break;";
      $colScript .="      case '3':";
      $colScript .="                var newDate= new Date(startDate);";
      $colScript .="                newDate.setUTCFullYear(startDate.getUTCFullYear()+initialContractTermVal);";
      $colScript .="                dijit.byId('endDate').set('value',addDaysToDate(newDate,-1));";
      $colScript .="                break;";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='initialContractTerm'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var reg =/^\d*[1-9]+\d*$/;";
      $colScript .=" if(isNaN(this.value))dijit.byId('initialContractTerm').set('value',0);";
      $colScript .=" var startDate=dijit.byId('startDate').getValue();";
      $colScript .=" var unitDuration=dijit.byId('idUnitContract').getValue();";
      $colScript .="  if( startDate != undefined ){ ";
      $colScript .="    switch (unitDuration) { ";
      $colScript .="      case '1':";
      $colScript .="                var newDate=addDaysToDate(startDate,this.value);";
      $colScript .="                dijit.byId('endDate').set('value',newDate);";
      $colScript .="                break;";
      $colScript .="      case '2':";
      $colScript .="                var newDate= new Date(startDate);";
      $colScript .="                newDate.setMonth(startDate.getMonth()+this.value);";
      $colScript .="                dijit.byId('endDate').set('value',addDaysToDate(newDate,-1));";
      $colScript .="                break;";
      $colScript .="      case '3':";
      $colScript .="                var newDate= new Date(startDate);";
      $colScript .="                newDate.setUTCFullYear(startDate.getUTCFullYear()+this.value);";
      $colScript .="                dijit.byId('endDate').set('value',addDaysToDate(newDate,-1));";
      $colScript .="                break;";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='endDate'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var startDate=dijit.byId('startDate').getValue();";
      $colScript .=" var noticePeriod=dijit.byId('noticePeriod').getValue();";
      $colScript .=" var idUnitNotice=dijit.byId('idUnitNotice').getValue();";
      $colScript .=" var endDate=dijit.byId('endDate').getValue();";
      $colScript .=" var reelEndDate=addDaysToDate(dijit.byId('endDate').getValue(),1);";
      $colScript .=" var dayStartDate=startDate.getDate();";
      $colScript .=" var MonthStart=startDate.getMonth();";
      $colScript .=" var dayEndDate=reelEndDate.getDate();";
      $colScript .=" var MonthEnd=reelEndDate.getMonth();";
      $colScript .=" var start=dijit.byId('startDate');";
      $colScript .=" start.set('dropDownDefaultValue',this.value);";
      $colScript .=" start.constraints.max=this.value;";
      $colScript .="  if( startDate != undefined){";
      $colScript .="    if( dayStartDate == dayEndDate && MonthStart==MonthEnd && startDate.getYear()!= endDate.getYear()){";
      $colScript .="               var nbY=startDate.getYear()-reelEndDate.getYear();";
      $colScript.="                setTimeout(dijit.byId('idUnitContract').set('value',3),500);";
      $colScript .="               setTimeout(dijit.byId('initialContractTerm').set('value',Math.abs(nbY)),500);";
      $colScript .="    }else if( dayStartDate == dayEndDate && MonthStart!=MonthEnd) {";
      $colScript .="                var nbM=MonthStart-MonthEnd;";
      $colScript.="                 setTimeout(dijit.byId('idUnitContract').set('value',2),500);";
      $colScript.="                 setTimeout(dijit.byId('initialContractTerm').set('value',Math.abs(nbM)),500);";
      $colScript.="    }else { ";
      $colScript.="                var nbJ=dayDiffDates(startDate,endDate);";
      $colScript.="                setTimeout(dijit.byId('idUnitContract').set('value',1),500);";
      $colScript.="                setTimeout(dijit.byId('initialContractTerm').set('value',nbJ),500);";
      $colScript.="    } ";
      $colScript .="  } ";
      $colScript .="  if( noticePeriod != 0 && idUnitNotice!= undefined){";
      $colScript .="    switch (idUnitNotice) { ";
      $colScript .="      case '1':";
      $colScript .="                var newDate=addDaysToDate(this.value,-noticePeriod);";
      $colScript .="                dijit.byId('noticeDate').set('value',newDate);";
      $colScript .="                break;";
      $colScript .="      case '2':";
      $colScript .="                var newDate= new Date(this.value);";
      $colScript .="                newDate.setMonth(endDate.getMonth()-noticePeriod);";
      $colScript .="                dijit.byId('noticeDate').set('value',addDaysToDate(newDate,1));";
      $colScript .="                break;";
      $colScript .="      case '3':";
      $colScript .="                var newDate= new Date(this.value);";
      $colScript .="                newDate.setUTCFullYear(newDate.getUTCFullYear()-noticePeriod);";
      $colScript .="                dijit.byId('noticeDate').set('value',addDaysToDate(newDate,1));";
      $colScript .="                break;";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='noticeDate') {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var endDate=dijit.byId('endDate').getValue();";
      $colScript .=" var reelEndDate=addDaysToDate(dijit.byId('endDate').getValue(),+1);";
      $colScript .=" var noticeDate=dijit.byId('noticeDate').getValue();";
      $colScript .=" var dayNoticeDate=noticeDate.getDate();";
      $colScript .=" var dayEndDate=reelEndDate.getDate();";
      $colScript .=" var MonthNotice=noticeDate.getMonth();";
      $colScript .=" var MonthEnd=reelEndDate.getMonth();";
      $colScript .="  if( endDate != undefined ){ ";
      $colScript .="    if( dayNoticeDate == dayEndDate &&  MonthNotice==MonthEnd && this.value.getYear()!=endDate.getYear()){ ";
      $colScript .="      var nbY=noticeDate.getYear()-reelEndDate.getYear();";
      $colScript .="      dijit.byId('idUnitNotice').set('value',3);";
      $colScript .="      dijit.byId('noticePeriod').set('value',Math.abs(nbY));";
      $colScript .="    }else if( dayNoticeDate == dayEndDate &&  MonthNotice!=MonthEnd ){ ";
      $colScript .="      var nbM=MonthNotice-MonthEnd;";
      $colScript .="      if(dijit.byId('idUnitNotice').getValue()!='2')dijit.byId('idUnitNotice').set('value',2);";
      $colScript .="      dijit.byId('noticePeriod').set('value',Math.abs(nbM));";
      $colScript .="    }else{ ";
      $colScript .="      var nbJ=dayDiffDates(noticeDate,endDate);";
      $colScript .="      dijit.byId('idUnitNotice').set('value',1);";
      $colScript .="      dijit.byId('noticePeriod').set('value',nbJ);";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='idUnitNotice'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var noticePeriod=dijit.byId('noticePeriod').getValue();";
      $colScript .=" var endDate=dijit.byId('endDate').getValue();";
      $colScript .="  if( (noticePeriod  && noticePeriod!= 0) && (endDate != undefined)  ){ ";
      $colScript .="    switch (this.value) { ";
      $colScript .="      case '1':";
      $colScript .="                var newDate=addDaysToDate(endDate,-noticePeriod);";
      $colScript .="                dijit.byId('noticeDate').set('value',newDate);";
      $colScript .="                break;";
      $colScript .="      case '2':";
      $colScript .="                var newDate= new Date(endDate);";
      $colScript .="                newDate.setMonth(endDate.getMonth()-noticePeriod);";
      $colScript .="                dijit.byId('noticeDate').set('value',addDaysToDate(newDate,1));";
      $colScript .="                break;";
      $colScript .="      case '3':";
      $colScript .="                var newDate= new Date(endDate);";
      $colScript .="                newDate.setUTCFullYear(endDate.getUTCFullYear()-noticePeriod);";
      $colScript .="                dijit.byId('noticeDate').set('value',addDaysToDate(newDate,1));";
      $colScript .="                break;";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='noticePeriod'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" var reg = new RegExp([0-9]);";
      $colScript .=" if(isNaN(this.value))dijit.byId('noticePeriod').set('value',0);";
      $colScript .=" if(this.value==reg)dijit.byId('noticePeriod').set('value',0);";
      $colScript .=" var endDate=dijit.byId('endDate').getValue();";
      $colScript .=" var unitNotice=dijit.byId('idUnitNotice').getValue();";
      $colScript .="  if( endDate != undefined ){ ";
      $colScript .="    switch (unitNotice) { ";
      $colScript .="      case '1':";
      $colScript .="                var newDate=addDaysToDate(endDate,-this.value);";
      $colScript .="                dijit.byId('noticeDate').set('value',newDate);";
      $colScript .="                break;";
      $colScript .="      case '2':";
      $colScript .="                var newDate= new Date(endDate);";
      $colScript .="                newDate.setMonth(endDate.getMonth()-this.value);";
      $colScript .="                dijit.byId('noticeDate').set('value',addDaysToDate(newDate,1));";
      $colScript .="                break;";
      $colScript .="      case '3':";
      $colScript .="                var newDate= new Date(endDate);";
      $colScript .="                newDate.setUTCFullYear(endDate.getUTCFullYear()-this.value);";
      $colScript .="                dijit.byId('noticeDate').set('value',addDaysToDate(newDate,1));";
      $colScript .="                break;";
      $colScript .="    } ";
      $colScript .="  } ";
      $colScript .= '</script>';
    }else if($colName=='periodicityContract'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" if(isNaN(this.value))dijit.byId('periodicityContract').set('value',0);";
      $colScript .= '</script>';
    }else if($colName=='periodicityBill'){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .=" if(isNaN(this.value))dijit.byId('periodicityBill').set('value',0);";
      $colScript .= '</script>';
    } else if ($colName=="idClient") {
			$colScript .= '<script type="dojo/connect" event="onChange" >';
			$colScript .= '  refreshList("idContactContract", "idClient", this.value, null, null, false);';
			$colScript .= '  formChanged();';
			$colScript .= '</script>';
	}
    return $colScript;
  }
  
  
  public function control(){
    $result="";
    if(!$this->initialContractTerm){
      $this->initialContractTerm=0;
    }
    if(!$this->noticePeriod){
      $this->noticePeriod=0;
    }
    if(!$this->periodicityBill){
      $this->periodicityBill=0;
    }
    if(!$this->periodicityContract){
      $this->periodicityContract=0;
    }
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function save() {
    
    $result=parent::save();
    return $result;
  }
  
  }
?>