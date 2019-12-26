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
 * Stauts defines list stauts an activity or action can get in (lifecylce).
 */ 
require_once('_securityCheck.php');
class TenderStatus extends SqlElement {

  // extends SqlElement, so has $id
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $isWaiting;
  public $isReceived;
  public $isNotSelect;
  public $isSelected;
  public $color;
  public $sortOrder=0;
  public $idle;
  //public $_sec_void;
  public $isCopyStatus;

  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="30%">${name}</th>
    <th field="isWaiting" width="10%" formatter="booleanFormatter">${isWaiting}</th>
    <th field="isReceived" width="10%" formatter="booleanFormatter">${isReceived}</th>
    <th field="isNotSelect" width="10%" formatter="booleanFormatter">${isNotSelect}</th>
    <th field="isSelected" width="10%" formatter="booleanFormatter">${isSelected}</th>
    <th field="color" width="10%" formatter="colorFormatter">${color}</th>
    <th field="sortOrder" width="5%">${sortOrderShort}</th>  
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

  private static $_fieldsAttributes=array("isCopyStatus"=>"hidden,calculated", "name"=>"required");
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
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
  
  public function deleteControl() {
    $result="";
    if ($this->isCopyStatus==1) {    
      $result="<br/>" . i18n("msgCannotDeleteStatus");
    }
    if (! $result) {  
      $result=parent::deleteControl();
    }
    return $result;
  }
}
?>