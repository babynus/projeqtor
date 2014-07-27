<?php
/* ============================================================================
 * Planning element is an object included in all objects that can be planned.
 */ 
require_once('_securityCheck.php');
class ProjectPlanningElement extends PlanningElement {

  public $id;
  public $idProject;
  public $refType;
  public $refId;
  public $refName;
  public $_tab_10_6 = array('requested', 'validated', 'assigned', 'planned', 'real', 'left', '', '', '', '', 'startDate', 'endDate', 'duration', 'work', 'cost', 'expense');
  public $initialStartDate;
  public $validatedStartDate;
  public $_void_13;
  public $plannedStartDate;
  public $realStartDate;
  public $_void_16;
  public $_label_priority;
  public $priority;
  public $_void_19;
  public $_void_10;
  public $initialEndDate;
  public $validatedEndDate;
  public $_void_23;
  public $plannedEndDate;
  public $realEndDate;
  public $_void_26;
  public $_void_27;
  public $_void_28;
  public $_void_29;
  public $_void_20;
  public $initialDuration;
  public $validatedDuration;
  public $_void_33;
  public $plannedDuration;
  public $realDuration;
  public $_void_36;
  public $_label_wbs;
  public $wbs;
  public $_void_39;
  public $_void_30;
  public $_void_41;
  public $validatedWork;
  public $assignedWork;
  public $plannedWork;
  public $realWork;
  public $leftWork;
  public $_label_progress;
  public $progress;
  public $_label_expected;
  public $expectedProgress;
  public $_void_51;
  public $validatedCost;
  public $assignedCost;
  public $plannedCost;
  public $realCost;
  public $leftCost;
  public $_void_57;
  public $_void_58;
  public $_void_59;
  public $_void_50;
  public $_void_61;
  public $_void_62;
  public $assignedExpense;
  public $plannedExpense;
  public $realExpense;
  public $leftExpense;
  public $_void_67;
  public $_void_68;
  public $_void_69;
  public $_void_60;
  
  public $wbsSortable;
  public $topId;
  public $topRefType;
  public $topRefId;
  public $idle;
  private static $_fieldsAttributes=array(
    "plannedStartDate"=>"readonly,noImport",
    "realStartDate"=>"readonly,noImport",
    "plannedEndDate"=>"readonly,noImport",
    "realEndDate"=>"readonly,noImport",
    "plannedDuration"=>"readonly,noImport",
    "realDuration"=>"readonly,noImport",
    "initialWork"=>"hidden,noImport",
    "plannedWork"=>"readonly,noImport",
    "realWork"=>"readonly,noImport",
    "leftWork"=>"readonly,noImport",
    "assignedWork"=>"readonly,noImport",
    "idPlanningMode"=>"hidden,noImport",
  	"assignedExpense"=>"readonly,noImport",
  	"plannedExpense"=>"readonly,noImport",
  	"realExpense"=>"readonly,noImport",
  	"leftExpense"=>"readonly,noImport"
  );   
  
  private static $_databaseTableName = 'planningelement';
  
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

    /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    return $paramDbPrefix . self::$_databaseTableName;
  }
    
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return array_merge(parent::getStaticFieldsAttributes(),self::$_fieldsAttributes);
  }
  
}
?>