<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
require_once('_securityCheck.php');
class ProjectExpenseMain extends Expense {

  // List of fields that will be exposed in general user interface
  public $_sec_description;
  public $id;    // redefine $id to specify its visible place
  public $reference; 
  public $name;
  public $idProjectExpenseType;
  public $idProject;
  public $idUser;
  public $idProvider;
  public $externalReference;
  public $Origin;
  public $idResource;
  public $idResponsible;
  public $paymentCondition;
  public $description;
  public $_sec_treatment;
  public $idStatus;  
  public $sendDate;
  public $idDeliveryMode;
  public $deliveryDelay;
  public $deliveryDate;
  public $receptionDate;
  public $idle;
  public $cancelled;
  public $_lib_cancelled;
  public $_tab_5_2_smallLabel = array('untaxedAmountShort', 'tax', '', 'fullAmountShort','paymentDateShort', 'planned', 'real');
  public $plannedAmount;
  public $taxPct;
  public $plannedTaxAmount;
  public $plannedFullAmount;
  public $expensePlannedDate;
  public $realAmount;
  public $_void_1;
  public $realTaxAmount;
  public $realFullAmount;
  public $expenseRealDate;
  public $paymentDone;
  public $result;
  public $_sec_ExpenseDetail;
  public $_ExpenseDetail=array();
  public $_expenseDetail_colSpan="2";
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  public $_nbColMax=3;  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="15%" >${idProject}</th>
    <th field="nameProjectExpenseType" width="15%" >${type}</th>
    <th field="name" width="50%" >${name}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "idProject"=>"required",
                                  "name"=>"required",
                                  "idProjectExpenseType"=>"required",
                                  "expensePlannedDate"=>"",
                                  "plannedAmount"=>"",
                                  "idStatus"=>"required",
  								                "idUser"=>"hidden",              
                                  "day"=>"hidden",
                                  "week"=>"hidden",
                                  "month"=>"hidden",
                                  "year"=>"hidden",
                                  "idle"=>"nobr",
                                  "cancelled"=>"nobr",
                                  "plannedTaxAmount"=>"calculated,readonly",
                                  "realTaxAmount"=>"calculated,readonly"
  );  
  
  private static $_colCaptionTransposition = array('idProjectExpenseType'=>'type',
  'expensePlannedDate'=>'plannedDate',
  'expenseRealDate'=>'realDate',
  'idResource'=>'businessResponsible',
  'idResponsible'=>'financialResponsible',
  'sendDate'=>'orderDate'
  );
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
  private static $_databaseColumnName = array("idProjectExpenseType"=>"idExpenseType",
  );

  private static $_databaseCriteria = array('scope'=>'ProjectExpense');

  private static $_databaseTableName = 'expense';
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
    if (count($this->getExpenseDetail())>0) {
      self::$_fieldsAttributes['realAmount']="readonly";
      self::$_fieldsAttributes['realFullAmount']="readonly";
    }
    if ($this->realFullAmount>0) {
      $this->realTaxAmount=$this->realFullAmount-$this->realAmount;
    }
    if ($this->plannedFullAmount>0) {
      $this->plannedTaxAmount=$this->plannedFullAmount-$this->plannedAmount;
    }
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
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
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }

  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria; 
  }
  
  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {
    $this->realFullAmount=$this->realAmount*(1+$this->taxPct/100);
    $this->plannedFullAmount=$this->plannedAmount*(1+$this->taxPct/100);
    return parent::save(); 
  }

  // ============================================================================**********
  // GET VALIDATION SCRIPT
  // ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    if ($colName=="expenseRealDate") {
      //$colScript .= '<script type="dojo/connect" event="onChange" >';
      //$colScript .= '  if (this.value) {';
      //$colScript .= '    dijit.byId("paymentDone").set("checked",true);';
      //$colScript .= '  }';
      //$colScript .= '  formChanged();';
      //$colScript .= '</script>';
    } else if ($colName=="paymentDone") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked && !dijit.byId("expenseRealDate").get("value")) {';
      $colScript .= '    var curDate = new Date();';
      $colScript .= '    dijit.byId("expenseRealDate").set("value",curDate);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
}
?>