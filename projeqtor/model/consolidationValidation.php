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
require_once('_securityCheck.php');
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";

class ConsolidationValidation extends SqlElement{
	public $id;
	public $idProject;
	public $idResource;
	public $sales;
	public $validatedWork;
	public $realWork;
	public $realWorkConsumed;
	public $leftWork;
	public $plannedWork;
    public $margin;	
    public $validationDate;
    public $month;
	
	
	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct($id=NULL, $withoutDependentObjects=false) {

	}
	/** ==========================================================================
	 * Destructor
	 * @return void
	 */
	function __destruct() {}
	
	static function drawProjectConsolidationValidation($idProject,$idProjectType,$idOrganization,$year,$month){
	  debugLog($idProject);
	  if($idProject==0 and $idProjectType==0 and $idOrganization==0){
	    $visibleProject=getVisibleProjectsList();
	    $proj=new Project();
	    $where="idProject in $visibleProject";
	    $lstProject=$proj->getSqlElementsFromCriteria(null,null,$where);
	  }else if($idProject==0 and ($idProjectType!=0 or $idOrganization!=0)){
	    $proj= new Project();
	    $idProjectType=($idProjectType!=0)?$idProjectType:"";
	    $idOrganization=($idOrganization!=0)?$idOrganization:"";
	    $critArray=array("idProjectType"=>$idProjectType,"idOrganization"=>$idOrganization);
	    $lstProject=$proj->getSqlElementsFromCriteria($critArray);
	  }
      $c=0;
	  //Header
	  $result  ='<div id="imputationValidationDiv" align="center" style="margin-top:20px;margin-bottom:20px; overflow-y:auto; width:100%;">';
	  $result .='  <table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
	  $result .='   <tr class="reportHeader">';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:20%;text-align:center;vertical-align:center;">'.i18n('Project').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colSales').'</td>';
	  //$result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:8%;text-align:center;vertical-align:center;">'.i18n('expectedWork').'</td>';
	  $result .='     <td style="width:40%;border: 1px solid grey;border-right: 1px solid white;">';
	  $result .='      <table width="100%"><tr><td colspan="5" style="height:30px;text-align:center;vertical-align:center;">'.i18n('sectionWork').'</td></tr>';
	  $result .='        <tr>
	                       <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.i18n('sectionWork').'</td>';
	  $result .='          <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.i18n('colReal').'</td>';
	  $result .='          <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.i18n('colRealCons').'</td>
	                       <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.i18n('colLeft').'</td>
	                       <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.i18n('colPlanned').'</td>
	                     </tr>
	                   </table>';
	  $result .='     </td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colMargin').'</td>';
	  $result .='     <td colspan="2" style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;">';
	  $result .='      <table width="100%"><tr><td width="62%">'.i18n('menuImputationValidation').'</td>';
	  $result .='        <td width="30%">';
	  $result .='          <span id="buttonValidationAll" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('validateWorkPeriod')
	  . '                    <script type="dojo/method" event="onClick" >'
	      . '                  validateAllSelection();'
		  . '                </script>'
    . '                    </span></td>';
	  $result.='         <td width="8%" style="padding-left:5px;padding-right:5px;">
	                       <div title="'.i18n('selectionAll').'" dojoType="dijit.form.CheckBox" type="checkbox"
	                         class="whiteCheck" id="selectAll" name="selectAll" onChange="imputationValidationSelection()">
	                       </div>
                         </td>
                       </table>
                      </td>';
	  $result .='   </tr>';
	  
	  foreach ($lstProject as $proj){
	    $c++;
	    $idCheckBox=$c;
	    $uniqueId=$c;
	   $result .='   <tr>';
	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;">'.$proj->name.'</td>';
	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;"></td>';
	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;"></td>';
	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;"></td>';
	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;">';
	   $result .='      <table>';
	   $result .='        <tr>';
	   $result .='          <td style="height:30px;">'.formatIcon('Unsubmitted', 32, i18n('unvalidatedWorkPeriod')).'</td>';
	   $result .='          <td style="width:73%;padding-left:5px;height:30px;">'.i18n('unvalidatedWorkPeriod').'</td>';
	   $result .='          <td style="width:27%;padding-right:8px;height:30px;">';
	   $result .='            <span id="buttonValidation'.$uniqueId.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('validateWorkPeriod')
	          . '              <script type="dojo/method" event="onClick" >'
	          //. '                saveImputationValidation("'.$uniqueId.'", "validateWork");'
	          //. '                saveDataToSession("idCheckBox", "'.$uniqueId.'", false);'
	          . '              </script>'
	          . '            </span>';
	   $result .='          </td>';
       $result .='         <td style="padding-right:5px;"><div class="validCheckBox" type="checkbox" dojoType="dijit.form.CheckBox" id="validCheckBox'.$idCheckBox.'"></div></td>';
       $result .='       </tr>';
       $result .='     </table>';
       $result .='    </td>';
       $result .='     <input type="hidden" id="validatedLine'.$idCheckBox.'" name="'.$uniqueId.'" value=""/>';
       $result .='   </tr>';
	  }
	  $result .='<input type="hidden" id="countLine" name="countLine" value="'.$c.'"/>';
	  $result .='  </table>';
	  $result .='</div>';
	  
	  echo $result;
	}
	
	/**=========================================================================
	 * Overrides SqlElement::save() function to add specific treatments
	* @see persistence/SqlElement#save()
	* @return the return message of persistence/SqlElement#save() method
	*/
	public function save() {

	  $result = parent::save();
	  return $result;
	
	}
}