<?php 
/* ============================================================================
 * IssueType defines the type of an issue.
 */ 
class DecisionType extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $sortOrder=0;
  public $idle;
  public $_col_2_2;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="85%">${name}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

  private static $_databaseTableName = 'type';
    
  private static $_databaseCriteria = array('scope'=>'Decision');
  
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
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    global $paramDbPrefix;
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria;
  }
  
}
?>