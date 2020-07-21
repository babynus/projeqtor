<?php
/*
 *	@author: qCazelles 
 */

require_once('_securityCheck.php');
class WorkUnit extends SqlElement {
	
	public $id;   
	public $reference;
	public $description;
	public $entering;
	public $deliverable;
	public $validityDate;
  public $idCatalog;
  public $idProject;
  	
	private static $_databaseCriteria = array();
	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	 */

	
	/** ========================================================================
	 * Return the specific database criteria
	 * @return the databaseTableName
	 */
	protected function getStaticDatabaseCriteria() {
	  return self::$_databaseCriteria;
	}
	
	/** ==========================================================================
	 * Construct
	 * @return void
	 */
	function __construct($id = NULL, $withoutDependentObjects=false) {
		parent::__construct($id,$withoutDependentObjects);
	}
	
	public function deleteControl()
	{
	  $result="";
	  $actPl = new ActivityPlanningElement();
	  $isUsed = $actPl->countSqlElementsFromCriteria(array('idWorkUnit'=>$this->id));
	  if ($isUsed){
	    $result .= '<br/>' . i18n ( 'workUnitIsUseByActivity' );
	  }
	  if (! $result) {
	    $result=parent::deleteControl();
	  }
	  return $result;
	}
	/** ==========================================================================
	 * Destructor
	 * @return void
	 */
	function __destruct() {
		parent::__destruct();
	}
	
	
	
}