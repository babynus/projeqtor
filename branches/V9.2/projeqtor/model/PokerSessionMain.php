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
  public $date;
  public $_button_startEndPokerSession;
  public $idResource;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $_sec_pokerMember;
  public $_spe_pokerMember;
  public $_sec_pokerItem;
  public $_spe_pokerItem;
  public $_sec_pokerVote;
  public $_spe_pokerVote;
  
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="date" width="10%" formatter="dateFormatter">${date}</th>
    <th field="nameResource" formatter="thumbName22" width="15%">${responsible}</th>
    ';
  
  private static $_fieldsAttributes=array("name"=>"readonly",
                                  "date"=>"readonly, nobr",
                                  "idResource"=>"readonly",
                                  "handled"=>"readonly, nobr",
                                  "done"=>"readonly, nobr",
                                  "idle"=>"readonly, nobr",
                                  "handledDate"=>"readonly",
                                  "doneDate"=>"readonly",
                                  "idleDate"=>"readonly",
  );
  
  private static $_colCaptionTransposition = array('idResource'=> 'responsible');
  
  public function setAttributes() {
    if(!$this->id){
    	self::$_fieldsAttributes ['_button_startPokerSession'] = 'hidden';
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
  	if ($item=='startEndPokerSession') {
  	    $name=(!$this->handled)?i18n('startPokerSession'):i18n('endPokerSession');
  		echo '<div id="'.$item.'" title="' . $name . '" style="float:right;padding:3px 0px 0px 5px;left: 285px;position: absolute;top: 119px;" >';
  		echo '<button id="' . $item . 'Button" dojoType="dijit.form.Button" style="width:150px;vertical-align: middle;" class="roundedVisibleButton">';
  		echo '<span>' . $name . '</span>';
  		echo '<script type="dojo/connect" event="onClick" args="evt">';
  		echo (!$this->handled)?'startPokerSession('.$this->id.');':'endPokerSession('.$this->id.');';
  		echo '</script>';
  		echo '</button>';
  		echo '</div>';
  	}
  	if($item=="pokerMember"){
  	  drawPokerMember($this, 'Session');
  	}
  	if($item=="pokerItem"){
	  drawPokerItem($this, 'Session');
  	}
  }
}?>