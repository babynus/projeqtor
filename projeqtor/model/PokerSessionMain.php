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
class PokerSessionMain extends SqlElement {

  public $_sec_description;
  public $id;
  public $name;
  public $idPokerSessionType;
  public $idStatus;
  public $idProject;
  public $pokerSessionDate;
  public $_lib_from;
  public $pokerSessionStartTime;
  public $_lib_to;
  public $pokerSessionEndTime;
  public $_spe_startPokerSession;
  public $idResource;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $_sec_Attendees;
  public $_Assignment=array();
  public $_sec_pokerItem;
  public $_spe_pokerItem;
  public $_sec_progress_left;
  public $PokerSessionPlanningElement;
  public $_sec_pokerVote;
  public $_spe_pokerVote;
  public $_sec_predecessor;
  public $_Dependency_Predecessor=array();
  public $_sec_successor;
  public $_Dependency_Successor=array();
  public $pokerSessionStartDateTime;
  public $pokerSessionEndDateTime;
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();
  public $_nbColMax=3;
  
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="name" width="15%">${name}</th>
    <th field="nameProject" width="15%">${idProject}</th>
    <th field="pokerSessionDate" width="10%" formatter="dateFormatter">${date}</th>
    <th field="nameResource" formatter="thumbName22" width="15%">${responsible}</th>
    ';
  
  private static $_fieldsAttributes=array(
                                  "pokerSessionDate"=>"nobr",
                                  "_lib_from"=>'nobr',
                                  "pokerSessionStartTime"=>', nobr',
                                  "_lib_to"=>'nobr',
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr",
                                  "pokerSessionStartDateTime"=>"hidden",
                                  "pokerSessionEndDateTime"=>"hidden",
  );
  
  private static $_colCaptionTransposition = array('idResource'=> 'responsible',
                                                  'attendees'=>'otherAttendees',
                                                  'pokerSessionStartDateTime'=>'pokerSessionStartTime',
                                                  'pokerSessionEndDateTime'=>'pokerSessionEndTime'
  );
  
  public function setAttributes() {
    if(!$this->id){
    	self::$_fieldsAttributes ['_button_startEndPokerSession'] = 'hidden';
    }
  }
  
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
  
  public function save() {
      $result = parent::save();         
      return $result;
  }
  
  public function drawSpecificItem($item) {
    global $print;
    $canUpdate=securityGetAccessRightYesNo('menuPokerSession', 'update', $this) == "YES";
    $result = "";
    if($item=="startPokerSession"){
    	if ($print or !$canUpdate or !$this->id or $this->idle or $this->done) {
    		return "";
    	}
    	$result .= '<tr><td valign="top" class="label"><label></label></td><td>';
    	$result .= '<button id="startPokerSession" dojoType="dijit.form.Button" showlabel="true"';
    	$result .= ' title="' . i18n('pokerSessionStop') . '" class="roundedVisibleButton">';
    	$result .= '<span>' . i18n('pokerSessionStop') . '</span>';
    	$result .=  '<script type="dojo/connect" event="onClick" args="evt">';
    	$result .= '   if (checkFormChangeInProgress()) {return false;}';
    	$result .=  '  stopPokerSession('.$this->id.');';
    	$result .= '</script>';
    	$result .= '</button>';
    	$result .= '</td></tr>';
    	return $result;
    }
  	if($item=="pokerItem"){
	  drawPokerItem($this, 'Session');
  	}
  	if($item=="pokerVote"){
      drawPokerVote($this);
  	}
  }
}?>