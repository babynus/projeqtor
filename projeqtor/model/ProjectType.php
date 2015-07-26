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

/* ============================================================================
 * DecisionType defines the type of a decision.
 */ 
require_once('_securityCheck.php');
class ProjectType extends SqlElement {

  // Define the layout that will be used for lists
    // extends SqlElement, so has $id
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $code;
  public $internalData;
  public $idWorkflow;
  public $sortOrder=0; 
  public $_spe_billingType;
  public $idle;
  public $description;
  public $_sec_Behavior;
  public $mandatoryDescription;
  public $_lib_mandatoryField;
  public $lockDone;
  public $_lib_statusMustChangeDone;
  public $lockIdle;
  public $_lib_statusMustChangeIdle;
  public $lockCancelled;
  public $_lib_statusMustChangeCancelled;

   private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="50%">${name}</th>
    <th field="code" width="10%">${code}</th>
    <th field="sortOrder" width="5%">${sortOrderShort}</th>
    <th field="nameWorkflow" width="20%" >${idWorkflow}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';
   
  private static $_databaseCriteria = array('scope'=>'Project');
  
   private static $_fieldsAttributes=array("name"=>"required", 
                                          "idWorkflow"=>"required",
                                          "mandatoryDescription"=>"nobr",
                                          "code"=> "readonly,nobr",
                                          "lockDone"=>"nobr",
                                          "lockIdle"=>"nobr",
                                          "lockCancelled"=>"nobr",
                                          "internalData"=>"hidden");
   
   private static $_databaseColumnName = array();
   
   private static $_databaseTableName = 'type';
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

  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria;
  }

  /** ========================================================================
   * Return the specific databaseColumnName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
    /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
  public function deleteControl() {
  	$result="";
    if ($this->code=='ADM' or $this->code=='TMP') {    
      $result="<br/>" . i18n("msgCannotDeleteProjectType");
    }
    if (! $result) {  
      $result=parent::deleteControl();
    }
    return $result;
  }
  
  public function save() {
  	if (! $this->code) {
  		$this->code='OPE';
  	}
  	return parent::save();
  }
  
    public function drawSpecificItem($item){
    $result="";
    if ($item=='billingType') {
    	$val=$this->internalData;
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('colBillingType') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td>";
      $result .='<select dojoType="dijit.form.FilteringSelect" class="input" ';
      if ($this->code=="ADM" or $this->code=="TMP") {
      	$result.=' readonly="readonlyy"';
      } 
      $result .='  style="width: 200px;" name="billingType" id="billingType" >';
      $result .='<option value="E" ' . (($val=="E" or !$val)?' SELECTED ':'') .'>' . i18n('billingTypeE') . '</option>';
      $result .='<option value="R" ' . (($val=="R" or !$val)?' SELECTED ':'') .'>' . i18n('billingTypeR') . '</option>';
      $result .='<option value="P" ' . (($val=="P" or !$val)?' SELECTED ':'') .'>' . i18n('billingTypeP') . '</option>';
      $result .='<option value="M" ' . (($val=="M" or !$val)?' SELECTED ':'') .'>' . i18n('billingTypeM') . '</option>';
      $result .='<option value="N" ' . (($val=="N" or !$val)?' SELECTED ':'') .'>' . i18n('billingTypeN') . '</option>';
      $result .= '<script type="dojo/connect" event="onChange" >';
      $result .=' dijit.byId("internalData").set("value",this.value);';
      $result .=' formChanged(); ';
      $result .= '</script>';
      $result .='</select>';
      $result .= '</td></tr></table>';
      return $result;
    }
  }
  
}
?>