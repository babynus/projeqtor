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
class PokerSessionDefinition extends PokerSessionMain {
  
   private static $_databaseTableName = 'pokersession';
   
   private static $_fieldsAttributes=array("idProject"=>"required",
   		"pokerSessionDate"=>"required, nobr",
   		"_lib_from"=>'nobr',
   		"pokerSessionStartTime"=>'nobr',
   		"_lib_to"=>'nobr',
   		"idResource"=>"required",
   		"handled"=>"readonly, nobr",
   		"done"=>"readonly, nobr",
   		"idle"=>"readonly, nobr",
   		"pokerSessionStartDateTime"=>"hidden",
   		"pokerSessionEndDateTime"=>"hidden",
        "_sec_pokerVote"=>"hidden"
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
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
  	$paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
  	return $paramDbPrefix . self::$_databaseTableName;
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
    	if ($print or !$canUpdate or ! $this->id or $this->idle or $this->done or $this->handled) {
    		return "";
    	}
    	$result .= '<tr><td valign="top" class="label"><label></label></td><td>';
    	$result .= '<button id="startMeeting" dojoType="dijit.form.Button" showlabel="true"';
    	$result .= ' title="' . i18n('pokerSessionStart') . '" class="roundedVisibleButton">';
    	$result .= '<span>' . i18n('pokerSessionStart') . '</span>';
    	$result .=  '<script type="dojo/connect" event="onClick" args="evt">';
    	$result .= '   if (checkFormChangeInProgress()) {return false;}';
    	$result .=  '  ';
    	$result .= '</script>';
    	$result .= '</button>';
    	$result .= '</td></tr>';
    	return $result;
    }
    if($item=="pokerItem"){
    	drawPokerItem($this, 'Definition');
    }
  }
}?>