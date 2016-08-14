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
class TenderMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_description;
  public $id;    // redefine $id to specify its visible place
  public $reference; 
  public $name;
  public $idTenderType;
  public $idProject;
  public $idCallForTender;
  public $idTenderStatus;
  public $idUser;
  public $creationDate;
  public $idProvider;
  public $externalReference;
  public $description;
  
  public $_sec_treatment;
  public $idStatus;  
  public $idResource;
  public $idContact;
  
  public $_tab_3_1 = array('requested', 'expected', 'received','dates');
  public $requestDate;
  public $expectedTenderDate;
  public $receptionDate;
  public $offerValidityEndDate;
  public $_tab_4_2 = array('untaxedAmountShort', 'tax', '', 'fullAmountShort','initial', 'negotiated');
  public $initialAmount;
  public $taxPct;
  public $initialTaxAmount;
  public $initialFullAmount;
  public $plannedAmount;
  public $_void_1;
  public $plannedTaxAmount;
  public $plannedFullAmount;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  public $_lib_cancelled;
  public $result;
  
  public $_sec_evaluation;
  public $evaluationValue;
  public $evaluationRank;
  
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  public $_nbColMax=3;  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameTenderType" width="10%" >${type}</th>
    <th field="name" width="30%" >${name}</th>
    <th field="colorNameTenderStatus" width="10%" formatter="colorNameFormatter">${idTenderStatus}</th>
    <th field="evaluationValue" width="10%" >${evaluationValue}</th>
    <th field="plannedAmount" width="10%" formatter="amountFormatter">${plannedAmount}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "idProject"=>"required",
                                  "name"=>"required",
                                  "idTenderType"=>"required",
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr",
                                  "idleDate"=>"nobr",
                                  "cancelled"=>"nobr",
                                  "plannedTaxAmount"=>"calculated,readonly",
                                  "initialTaxAmount"=>"calculated,readonly",
      "idStatus"=>"required",
      "idTenderStatus"=>"required"
  );  
  
  private static $_colCaptionTransposition = array('idTenderType'=>'type' );
  
  private static $_databaseColumnName = array();
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
    if ($this->idCallForTender and $this->idProvider) {
      self::$_fieldsAttributes['name']='readonly';
      self::$_fieldsAttributes['idTenderStatus']='required';
    } else {
      self::$_fieldsAttributes['name']='required';
      self::$_fieldsAttributes['idTenderStatus']='';
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
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }

  
  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {
    
    if ($this->idCallForTender and $this->idProvider) {
      $this->name=SqlList::getNameFromId('CallForTender', $this->idCallForTender).' - '.SqlList::getNameFromId('Provider', $this->idProvider);
    }
    return parent::save(); 
  }
  
  public function control(){
    $result="";
    // Check dupplicate CallForTender / Provider
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
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
    if ($colName=="idProvider" or $colName=="idCallForTender") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (trim(dijit.byId("idCallForTender").get("value")) && trim(dijit.byId("idProvider").get("value"))) {';
      $colScript .= '    dojo.removeClass(dijit.byId("name").domNode, "required");';
      $colScript .= '    dijit.byId("name").set("required",false);';
      $colScript .= '    dijit.byId("name").set("readonly",true);';
      $colScript .= '    dojo.addClass(dijit.byId("idTenderStatus").domNode, "required");';
      $colScript .= '    dijit.byId("idTenderStatus").set("required",true);';
      $colScript .= '  } else {';
      $colScript .= '    dojo.addClass(dijit.byId("name").domNode, "required");';
      $colScript .= '    dijit.byId("name").set("required",true);';
      $colScript .= '    dijit.byId("name").set("readonly",false);';
      $colScript .= '    dojo.removeClass(dijit.byId("idTenderStatus").domNode, "required");';
      $colScript .= '    dijit.byId("idTenderStatus").set("required",false);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
}
?>