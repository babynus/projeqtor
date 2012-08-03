<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class Requirement extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $reference;
  public $idProject;
  public $idProduct;
  //public $idVersion;
  public $idRequirementType;
  public $name;
  public $externalReference;
  public $creationDateTime;
  public $idUser;
  public $idUrgency;
  public $description;
  public $_col_2_2_treatment;
  public $idRequirement;
  public $idStatus;
  public $idResource;
  public $idCriticality;
  public $idFeasibility;
  public $idRiskLevel;
  public $plannedWork;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $idTargetVersion;
  public $result;
  public $_col_1_1_Progress;
  public $_tab_7_2 = array('countLinked', 'countTotal', 'countPlanned', 'countPassed', 'countBlocked', 'countFailed', 'countIssues', 'countTests', '');
  public $countLinked;
  public $countTotal;
  public $countPlanned;
  public $countPassed;
  public $countBlocked;
  public $countFailed;
  public $countIssues;
  public $noDisplay1;
  public $noDisplay2;
  public $pctPlanned;
  public $pctPassed;
  public $pctBlocked;
  public $pctFailed;
  public $noDisplay3;
  public $_col_1_2_predecessor;
  public $_Dependency_Predecessor=array();
  public $_col_2_2_successor;
  public $_Dependency_Successor=array();
  public $_col_1_1_Link;
  public $_Link=array();
  public $_Attachement=array();
  public $_Note=array();
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameProduct" width="10%" >${idProduct}</th>
    <th field="nameRequirementType" width="10%" >${type}</th>
    <th field="name" width="20%" >${name}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameResource" width="10%" >${responsible}</th>
    <th field="nameTargetVersion" width="10%" >${idVersion}</th>
    <th field="handled" width="5%" formatter="booleanFormatter" >${handled}</th>
    <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "name"=>"required", 
                                  "idRequirementType"=>"required",
                                  "idStatus"=>"required",
                                  "creationDateTime"=>"required",
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr",
                                  "idUser"=>"hidden",
                                  "countLinked"=>"display",
                                  "countTotal"=>"display",
                                  "countPlanned"=>"display",
                                  "countPassed"=>"display",
                                  "countFailed"=>"display",
                                  "countBlocked"=>"display",
                                  "countIssues"=>"display",
                                  "noDisplay1"=>"calculated,hidden",
                                  "noDisplay2"=>"calculated,hidden",
                                  "pctPlanned"=>"calculated,display,html",
                                  "pctPassed"=>"calculated,display,html",
                                  "pctBlocked"=>"calculated,display,html",
                                  "pctFailed"=>"calculated,display,html",
                                  "noDisplay3"=>"calculated,hidden"
  );  
  
  private static $_colCaptionTransposition = array('idResource'=> 'responsible',
                                                   'idTargetVersion'=>'targetVersion',
                                                   'idRiskLevel'=>'technicalRisk',
                                                   'plannedWork'=>'estimatedEffort',
                                                   );
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
  private static $_databaseColumnName = array();
    
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
    $this->getCalculatedItem();
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
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }

  /** ========================================================================
   * Return the specific databaseColumnName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
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
    return $colScript;
  }

/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    
    if (!trim($this->idProject) and !trim($this->idProduct)) {
      $result.="<br/>" . i18n('messageMandatory',array(i18n('colIdProject') . " " . i18n('colOrProduct')));
    }
    
    if ($this->id and $this->id==$this->idRequirement) {
      $result.='<br/>' . i18n('errorHierarchicLoop');
    } else if (trim($this->idRequirement)){
      $parentList=array();
    	$parent=new Requirement($this->idRequirement);
    	while ($parent->idRequirement) {
    		$parentList[$parent->idRequirement]=$parent->idRequirement;
    		$parent=new Requirement($parent->idRequirement);
    	}
      if (array_key_exists($this->id,$parentList)) {
        $result.='<br/>' . i18n('errorHierarchicLoop');
      }
    }
    if (trim($this->idRequirement)) {
      $parentRequirement=new Requirement($this->idRequirement);
      if ( trim($this->idProduct)) {
        if (trim($parentRequirement->idProduct)!=trim($this->idProduct)) {
          $result.='<br/>' . i18n('msgParentRequirementInSameProjectProduct');
        }
      } else {
        if (trim($parentRequirement->idProject)!=trim($this->idProject)) {
          $result.='<br/>' . i18n('msgParentRequirementInSameProjectProduct');
        }
      }
    }
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function save() {

  	$result=parent::save();
    return $result;
  }
  
   /*public function drawCalculatedItem($item){
     $result="&nbsp;";
     if ($item=='pctPassed') {
       return ($this->countPlanned==0)?'&nbsp;':'<i>('.htmlDisplayPct(round($this->countPassed/$this->countPlanned*100)).')</i>';
     } else if ($item=='pctFailed') {
       return ($this->countPlanned==0)?'&nbsp;':'<i>('.htmlDisplayPct(round($this->countFailed/$this->countPlanned*100)).')</i>';
     } else if ($item=='pctBlocked') {
       return ($this->countPlanned==0)?'&nbsp;':'<i>('.htmlDisplayPct(round($this->countBlocked/$this->countPlanned*100)).')</i>';
     } else {
      return "&nbsp;"; 
     }
     return $result;
   }*/
   
  public function getCalculatedItem(){
     if ($this->countTotal!=0) {
     	$this->pctPlanned='<i>('.htmlDisplayPct(round($this->countPlanned/$this->countTotal*100)).')</i>';
     	$this->pctPassed='<i>('.htmlDisplayPct(round($this->countPassed/$this->countTotal*100)).')</i>';
      $this->pctFailed='<i>('.htmlDisplayPct(round($this->countFailed/$this->countTotal*100)).')</i>';
      $this->pctBlocked='<i>('.htmlDisplayPct(round($this->countBlocked/$this->countTotal*100)).')</i>';
     }
  }
  
  public function updateDependencies() {
  	$this->_noHistory=true;
  	$listCrit='idTestCase in (0';
  	$this->countLinked=0;
    foreach ($this->_Link as $link) {
      if ($link->ref2Type=='TestCase') {
        $listCrit.=','.$link->ref2Id;
        $this->countLinked+=1;
      }
      if ($link->ref2Type=='Ticket') {
        $this->countIssues+=1;
      }
    }
    $listCrit.=")";
    $tcr=new TestCaseRun();
    $listTcr=$tcr->getSqlElementsFromCriteria(null, false, $listCrit);
    $this->countBlocked=0;
    $this->countFailed=0;
    $this->countIssues=0;
    $this->countPassed=0;
    $this->countPlanned=0;
    $this->countTotal=0;
    foreach($listTcr as $tcr) {
    	$this->countTotal+=1;
      if ($tcr->idRunStatus==1) {
        $this->countPlanned+=1;
      }
      if ($tcr->idRunStatus==2) {
        $this->countPassed+=1;
      }
      if ($tcr->idRunStatus==3) {
        $this->countFailed+=1;
      }
      if ($tcr->idRunStatus==4) {
        $this->countBlocked+=1;
      }
    }
    $this->save();
  }
}
?>