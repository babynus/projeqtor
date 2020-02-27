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
 * Line defines right to the application for a menu and a profile.
 */  
require_once('_securityCheck.php'); 
class SituationMain extends SqlElement {
  
  public $id;
  public $refType;
  public $refId;
  public $idProject;
  public $idUser;
  public $date;
  public $situation;
  public $situationType;
  public $idResource;
  public $comment;

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
  
  function drawSituationHistory($obj){
    global $cr, $print, $outMode, $user, $comboDetail, $displayWidth, $printWidth;
    if ($comboDetail) {
      return;
    }
    $canUpdate=securityGetAccessRightYesNo('menu'.get_class($obj), 'update', $obj) == "YES";
    $where = 'refType = "'.get_class($obj).'" and refId = '.$obj->id.' and idProject = '.$obj->idProject.' order by date desc';
    $situationList = $this->getSqlElementsFromCriteria(null,null,$where);
    echo '</br>';
    echo '<table width="99.9%">';
    echo '<tr>';
    if (!$print) {
    	echo '<td class="noteHeader smallButtonsGroup" style="width:10%">';
    	if (!$print and $canUpdate) {
    		echo '<a '; echo 'onClick="addSituation('.htmlEncode($obj->id). ',\''.htmlEncode(get_class($obj)).'\','.htmlEncode($obj->idProject). ');"title="' . i18n('addSituation') .'"'; echo '>';
    		echo formatSmallButton('Add');
    		echo '</a>';
    	}
    	echo '</td>';
    }
    echo '<td class="noteHeader" style="width:10%">' . i18n('colId') . '</td>';
    echo '<td class="noteHeader" style="width:20%">' . i18n('colDate') . '</td>';
    echo '<td class="noteHeader" style="width:40%">' . i18n('colSituation') . '</td>';
    echo '<td class="noteHeader" style="width:30%">' . i18n('colResponsible') . '</td>';
    echo '</tr>';
    foreach ($situationList as $id=>$val){
      echo '<tr>';
      if (!$print) {
      	echo '<td class="noteData smallButtonsGroup">';
      	if (!$print and $canUpdate) {
      		echo '  <a onClick="editSituation(' . htmlEncode($val->id) . ');" title="' . i18n('editSitutation'). '" >'
      				.formatSmallButton('Edit')
      				.'</a> ';
      	}
      	echo '</td>';
      }
      echo '<td class="noteData" style="text-align:center">' . htmlEncode($val->id) . '</td>';
      echo '<td class="noteData" style="text-align:center">' . htmlFormatDateTime($val->date) . '</td>';
      echo '<td class="noteData" style="text-align:center">' . htmlEncode($val->situation) . '</td>';
      $responsible = new ResourceAll($val->idResource);
      echo '<td class="noteData" style="text-align:center">' . htmlEncode($responsible->name) . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
  
  }
?>
