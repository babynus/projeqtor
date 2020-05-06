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
 * Client is the owner of a project.
 */  
require_once('_securityCheck.php'); 
class InputMailboxMain extends SqlElement {

  public $_sec_Description;
  public $id;
  public $name;
  public $idProject;
  public $serverImap;
  public $userImap;
  public $passwordImap;
  public $securityConstraint;
  public $_tab_2_1 = array('attachment', 'sizeAttachment' ,'attachmentSecurityConstraint');
  public $allowAttach;
  public $sizeAttachment;
  public $idle;
  public $_sec_treatment;
  public $idTicketType;
  public $idAffectable;
  public $idActivity;
  public $limitOfInputPerHour;
  public $lastInputDate;
  public $idTicket;
  public $totalInputTicket;
  public $failedRead;
  public $failedMessage;
  public $_nbColMax = 3;
  
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="8%"># ${id}</th>
    <th field="nameProject" width="15%">${idProject}</th>
    <th field="name" width="15%">${name}</th>
    <th field="idle" width="4%" formatter="booleanFormatter">${idle}</th>
    ';
  
  private static $_fieldsAttributes=array(
      'name'=>'required',
      'idProject'=>'required',
      'serverImap'=>'required',
      'userImap'=>'required',
      'passwordImap'=>'required',
      'securityConstraint'=>'required',
      'idTicketType'=>'required',
      'lastInputDate'=>'readonly',
      'idTicket'=>'readonly',
      'totalInputTicket'=>'readonly',
      'failedRead'=>'hidden',
      'failedMessage'=>'hidden',
  );
  
  private static $_colCaptionTransposition = array(
      'idAffectable' => 'responsible',
      'idActivity' => 'PlanningActivity',
      'idTicket' => 'lastInputTicket'
  );
  
  private static $_databaseColumnName = array();
  
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

  
  
  public function control(){
    $result="";
    $defaultControl=parent::control();
    $old = $this->getOld();
    //unicity project/ticket type control
    $unicity = $this->countSqlElementsFromCriteria(array('idProject'=>$this->idProject,'idTicketType'=>$this->idTicketType));
    if($unicity > 0){
      if($this->id){
        if($old->idProject != $this->idProject)$result .= '<br/>' . i18n ( 'projectIsAlreadyUsed' );
      }else{
        $result .= '<br/>' . i18n ( 'projectIsAlreadyUsed' );
      }
    }
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function setAttributes() {
    if($this->allowAttach == '1'){
      self::$_fieldsAttributes['sizeAttachment']='hidden';
    }
  }
  
  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
  * @see persistence/SqlElement#save()
  * @return the return message of persistence/SqlElement#save() method
  */
  public function save() {
    $result = parent::save();
    return $result;
  }
  public function delete() {
    $result=parent::delete();
    return $result;
  }
  
  public function copyTo($newClass, $newType, $newName, $newProject, $structure, $withNotes, $withAttachments, $withLinks, $withAssignments = false, $withAffectations = false, $toProject = NULL, $toActivity = NULL, $copyToWithResult = false,$copyToWithVersionProjects=false) {
    $result=parent::copyTo($newClass, $newType, $newName, $newProject, $structure, $withNotes, $withAttachments, $withLinks);
    return $result;
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
//     if ($colName=="attachment") {
//       $colScript .= '<script type="dojo/connect" event="onChange" >';
//       $colScript .= '  if(dojo.byId("attachment").checked){ ';
//       // afficher la taille max
//       $colScript .= '  ';
//       $colScript .= '  }';
//       $colScript .= '  formChanged();';
//       $colScript .= '</script>';
//     }
    return $colScript;
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
  
  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    global $print;
    $result = "";
    if($item == 'test'){
     
    }else if($item=='history'){
        $history = new InputMailboxHistory();
        //$history->drawInputMailboxHistory($this);
    }
    return $result;
  }
  
}
?>