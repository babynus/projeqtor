<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class ChecklistDefinition extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $idReferencable;
  public $nameReferencable;
  public $idType;
  public $lineCount;

  public $idle;
  public $_col_2_2;
  
  public $_col_1_1_checklistLines;
  public $_ChecklistDefinitionLine=array();
  public $_noCopy;
    
    private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameReferencable" formatter="translateFormatter" width="20%" >${element}</th>
    <th field="nameType" width="20%" >${type}</th>
    <th field="lineCount" formatter="numericFormatter" width="10%" >${lineCount}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"hidden",
                                  "idType"=>"nocombo",
                                  "nameReferencable"=>"hidden",
  		                            "lineCount"=>"readonly"
  );  
  
    private static $_colCaptionTransposition = array('idIndicatorable'=>'element',
                                                     'idType'=>'type',
                                                     'warningValue'=>'warning',
                                                     'alertValue'=>'alert',
                                                     'alertToUser'=>'mailToUser',
                                                     'alertToResource'=>'mailToResource',
                                                     'alertToProject'=>'mailToProject',
                                                     'alertToContact'=>'mailToContact',
                                                     'alertToLeader'=>'mailToLeader',
                                                     'alertToManager'=>'mailToManager',
                                                     'alertToAssigned'=>'mailToAssigned',
                                                     'otherMail'=>'email');
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

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
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  public function save() {
  	$referencable=new Referencable($this->idReferencable);
  	$this->nameReferencable=$referencable->name;
  	return parent::save();
  }
  
    /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
  	$colScript = parent::getValidationScript($colName);
    return $colScript;
  }
  
  public function control(){
    $result="";
    if (! trim($this->idReferencable)) {
    	$result.='<br/>' . i18n('messageMandatory',array(i18n('colElement')));
    }

    $crit=array('idReferencable'=>trim($this->idReferencable),
                'idType'=>trim($this->idType));
    $elt=SqlElement::getSingleSqlElementFromCriteria('ChecklistDefinition', $crit);
    if ($elt and $elt->id and $elt->id!=$this->id) {
      $result.='<br/>' . i18n('errorDuplicateChecklistDefinition');
    }
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
}
?>