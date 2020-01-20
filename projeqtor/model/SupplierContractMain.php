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
class SupplierContractMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_Description;
  public $id;    
  public $name;
  public $number;
  public $idTypeContract;
  public $idProject;
  public $idUser;
  public $idProvider;
  public $idContact;
  public $tenderReference;
  public $phoneNumber;
  public $origin;
  public $description;
  
  public $_sec_Progress;
  public $startDate;
  public $initialContractTerm;
  public $idUnitDurationContract;
  public $endDate;
  public $noticePeriod;
  public $idUnitDurationNotice;
  public $noticeDate;
  public $deadlineDate;
  public $periodicityContract;
  public $periodicityBill;
  public $interventionStartTime;
  public $interventionEndTime;
  public $periode;

  
  public $_sec_Treatment_right;
  public $idRenewal;
  public $idStatus;
  public $idResource;
  public $sla;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();
  public $_nbColMax=3;
  // Define the layout that will be used for lists
  
  private static $_layout='
          <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
          <th field="name" width="15%" >${name}</th>
          <th field="colorNameStatus" width="8%" formatter="colorNameFormatter">${idStatus}</th>
          <th field="handled" width="5%" formatter="booleanFormatter" >${handled}</th>
          <th field="approved" width="5%" formatter="booleanFormatter" >${approved}</th>
          <th field="handled" width="5%" formatter="booleanFormatter" >${handled}</th>
          <th field="approved" width="5%" formatter="booleanFormatter" >${approved}</th>
          <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
          <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required",      
                                  "done"=>"nobr",
                                  "handled"=>"nobr",
                                  "idle"=>"nobr",
                                  "idleDate"=>"nobr",
                                  "cancelled"=>"nobr",
                                  "idStatus"=>"required",
  );   
 
  private static $_colCaptionTransposition = array('idResource'=>'manager',
   'doneDate'=>'dateApproved',
   'idUser'=>'issuer',
   'idResource'=>'responsible',
  );
  
  private static $_databaseColumnName = array();
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
    if ($colName=='done') {
//       $colScript .= '<script type="dojo/connect" event="onChange" >';
//       $colScript .="    if (this.checked) dijit.byId('isUnderConstruction').set('checked',false);";
//       $colScript .= '</script>';
    }
    return $colScript;
  }
  
  
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
  
  public function save() {
     
    $result=parent::save();
    return $result;
  }
  
  }
?>