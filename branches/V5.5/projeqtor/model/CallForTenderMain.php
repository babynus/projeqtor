<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * 
 */ 
require_once('_securityCheck.php');
class CallForTenderMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_description;
  public $id;    // redefine $id to specify its visible place
  public $reference; 
  public $name;
  public $idCallForTenderType;
  public $idProject;
  public $idUser;
  public $creationDate;
  public $maxAmount;
  public $deliveryDate;
  public $description;
  public $businessRequirements;
  public $technicalRequirements;
  public $otherRequirements;
  
  public $_sec_treatment;
  public $idStatus;
  public $idResource;
  public $sendDate;
  public $expectedTenderDate;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  public $_lib_cancelled;
  public $result;
  
  public $_sec_productComponent;
  public $idProduct;
  public $idComponent;
  public $idProductVersion;
  public $idComponentVersion;
  
  public $_sec_evaluationCriteria;
  public $_spe_evaluationCriteria;
  public $evaluationMaxValue;
  public $fixValue;
  public $_lib_colFixValue;
  
  public $_sec_submissions;

  
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  public $_nbColMax=3;  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="15%" >${idProject}</th>
    <th field="nameCallForTenderType" width="15%" >${type}</th>
    <th field="name" width="50%" >${name}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "idProject"=>"",
                                  "name"=>"required",
                                  "idCallForTenderType"=>"required",
                                  "idStatus"=>"required",
  								                "idUser"=>"",      
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr",
                                  "idleDate"=>"nobr",
                                  "cancelled"=>"nobr",
                                  "evaluationMaxValue"=>"nobr",
                                  "fixValue"=>"nobr"
  );  
  
  private static $_colCaptionTransposition = array('idUser'=>'issuer',
      'idCallForTenderType'=>'type', 
      'idResource'=>'responsible'
  );
  
  private static $_databaseColumnName = array();
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
    if ($this->fixValue) {
      self::$_fieldsAttributes['evaluationMaxValue']='nobr';
    } else {
      self::$_fieldsAttributes['evaluationMaxValue']='nobr,readonly';
    }
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
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }
  
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {
    return parent::save(); 
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
    if ($colName=='fixValue') {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    dijit.byId("evaluationMaxValue").set("readOnly",false); ';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("evaluationMaxValue").set("readOnly",true); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  public function drawSpecificItem($item, $included=false) {
    global $print, $comboDetail, $nbColMax;
    $result = "";
    if ($item == 'evaluationCriteria' and ! $comboDetail) {
      $this->drawTenderEvaluationCriteriaFromObject();
    }
    return $result;
  }
  
  function drawTenderEvaluationCriteriaFromObject() {
    global $cr, $print, $outMode, $user, $comboDetail, $displayWidth, $printWidth;
    if ($comboDetail) {
      return;
    }
    $canUpdate=securityGetAccessRightYesNo('menu' . get_class($this), 'update', $this) == "YES";
    if ($this->idle == 1) {
      $canUpdate=false;
    }
    $eval=new TenderEvaluationCriteria();
    $evalList=$eval->getSqlElementsFromCriteria(array('idCallForTender'=>$this->id));
    echo '<table width="99.9%">';
    echo '<tr>';
    if (!$print) {
      echo '<td class="noteHeader smallButtonsGroup" style="width:10%">';
      if ($this->id != null and !$print and $canUpdate) {
        echo '<img class="roundedButtonSmall" src="css/images/smallButtonAdd.png" onClick="addTenderEvaluationCriteria('.htmlEncode($this->id).');" title="' . i18n('addTenderEvaluationCriteria') . '" /> ';
      }
      echo '</td>';
    }
    echo '<td class="noteHeader" style="width:' . (($print)?'60':'50') . '%">' . i18n('colName') . '</td>';
    echo '<td class="noteHeader" style="width:20%">' . i18n('colEvaluationMaxValue') . '</td>';
    echo '<td class="noteHeader" style="width:20%">' . i18n('colCoefficient') . '</td>';
    echo '</tr>';
    foreach ( $evalList as $eval ) {     
      echo '<tr>';
      if (!$print) {
        echo '<td class="noteData smallButtonsGroup">';
        if (!$print and $canUpdate) {
          echo ' <img class="roundedButtonSmall" src="css/images/smallButtonEdit.png" onClick="editTenderEvaluationCriteria(' . htmlEncode($eval->id) . ');" title="' . i18n('editTenderEvaluationCriteria') . '" /> ';
          echo ' <img class="roundedButtonSmall" src="css/images/smallButtonRemove.png" onClick="removeTenderEvaluationCriteria(' . htmlEncode($eval->id) . ');" title="' . i18n('removeTenderEvaluationCriteria') . '" /> ';
        }
        echo '</td>';
      }
      echo '<td class="noteData">' . htmlEncode($eval->criteriaName) . '</td>';
      echo '<td class="noteData">' . htmlEncode($eval->criteriaMaxValue) . '</td>';
      echo '<td class="noteData">' . htmlEncode($eval->criteriaCoef) . '</td>';
      echo '</tr>';
    }
    echo '<tr>';
    echo '<td colspan="'.(($print)?'3':'4').'" class="noteDataClosetable">&nbsp;</td>';
    echo '</tr>';
    echo '</table>';
  }
  
}
?>