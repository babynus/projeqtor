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
 * RiskType defines the type of a risk.
 */  
require_once('_securityCheck.php');
class ActivityType extends Type {

  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place
  public $name;
  public $code;
  public $idWorkflow;
  public $idActivityPlanningMode;
  public $priority;
  public $sortOrder=0;
  public $idle;
  public $description;
  public $_sec_Behavior;
  public $mandatoryDescription;
  public $_lib_mandatoryField;
  public $mandatoryResourceOnHandled;
  public $_lib_mandatoryOnHandledStatus;
  public $mandatoryResultOnDone;
  public $_lib_mandatoryOnDoneStatus;
  public $lockHandled;
  public $_lib_statusMustChangeHandled;
  public $lockDone;
  public $_lib_statusMustChangeDone;
  public $lockIdle;
  public $_lib_statusMustChangeIdle;
  public $lockCancelled;
  public $_lib_statusMustChangeCancelled;
  public $showInFlash;
  public $internalData;
  public $canHaveSubActivity;
  public $_lib_helpCanHaveSubActivity;
  // Define the layout that will be used for lists
    
  private static $_fieldsAttributes=array("name"=>"required", 
                                          "idWorkflow"=>"required",
                                          "mandatoryDescription"=>"nobr",
                                          "mandatoryResourceOnHandled"=>"nobr",
                                          "mandatoryResultOnDone"=>"nobr",
                                          "mandatoryResolutionOnDone"=>"hidden",
                                          "_lib_mandatoryResolutionOnDoneStatus"=>"hidden", 
                                          "lockHandled"=>"nobr",
                                          "lockDone"=>"nobr",
                                          "lockIdle"=>"nobr",
                                          "lockCancelled"=>"nobr",
  										                    "internalData"=>"hidden",
                                          "showInFlash"=>"hidden",
                                          "idPlanningMode"=>"hidden",
                                          "scope"=>"hidden",
                                          "idActivityPlanningMode"=>"required",
                                          "lockNoLeftOnDone"=>"nobr",
                                          "lockCancelled"=>"nobr",
                                          "canHaveSubActivity"=>"nobr",
                                          "activityOnRealTime"=>"nobr",
  );
  private static $_colCaptionTransposition = array('idActivityPlanningMode'=>'defaultPlanningMode');
  private static $_databaseColumnName = array('idActivityPlanningMode'=>'idPlanningMode');
  private static $_databaseCriteria = array('scope'=>'Activity');
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
    if (!$this->id) $this->canHaveSubActivity=1;
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
    return array_merge(parent::getStaticFieldsAttributes(),self::$_fieldsAttributes);
    //return self::$_fieldsAttributes;
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
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
  
  public function setAttributes() {
    if(Parameter::getGlobalParameter('activityOnRealTime')!='YES'){
      self::$_fieldsAttributes["activityOnRealTime"]='hidden';
    }
  }
  
  public function save() {
    $old = $this->getOld (false);
    if($old->activityOnRealTime!=$this->activityOnRealTime){
      $wokOnRealTime=($this->activityOnRealTime==1)?0:1;
      $clause="idActivityType=$this->id and workOnRealTime=$wokOnRealTime";
      $act= new Activity();
      $lstAct=$act->getSqlElementsFromCriteria(null,null,$clause);
      foreach ($lstAct as $id=>$activity){
        $activity->workOnRealTime=$this->activityOnRealTime;
        $activity->save();
      }
    }
      
    return parent::save();
  }
}
?>