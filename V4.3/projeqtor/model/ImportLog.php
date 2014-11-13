<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
require_once('_securityCheck.php');
class ImportLog extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $mode;
  public $importDateTime;
  public $importFile;
  public $importClass;
  public $importStatus;
  public $importTodo;
  public $importDone;
  public $importDoneCreated;
  public $importDoneModified;
  public $importDoneUnchanged;
  public $importRejected;
  public $importRejectedInvalid;
  public $importRejectedError;
  public $idle;
  
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
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
}
?>