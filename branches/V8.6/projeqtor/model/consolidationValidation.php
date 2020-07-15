<?php
use PhpOffice\PhpSpreadsheet\Calculation\Database;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
	public $revenue;
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
	
	
	/** ==========================================================================
	 * Draw project table 
	 */
	static function drawProjectConsolidationValidation($idProject,$idProjectType,$idOrganization,$year,$month){
	  $month=(strlen($month)==1)?'0'.$month:$month;
	  $cons= new ConsolidationValidation();
	  $idProject=($idProject=='')?0:$idProject;
	  $idProjectType=($idProjectType=='')?0:$idProjectType;
	  $idOrganization=($idOrganization=='')?0:$idOrganization;
	  $lockedProects=array();
	  $levels=array();
	  $lstProject=$cons->getVisibleProjectToConsolidated($idProject,$idProjectType,$idOrganization);
	  $projectsList=$lstProject[0];
	  $srtingProjectList=$lstProject[1];
	  $length=count($projectsList);
	  $concMonth=$year.$month;
	  $countLocked=0;
	  $c=0;
      $where="idProject in ($srtingProjectList) and month ='".$concMonth."'";
      $lockImputation=new LockedImputation();
      $lstLockedImp=$lockImputation->getSqlElementsFromCriteria(null,null,$where);
      $curUser=getSessionUser();
      $prof=$curUser->idProfile;
      
      foreach ($projectsList as $proj) {
        foreach ($lstLockedImp as $lockProjImp){
          if($lockProjImp->idProject==$proj->id){
            $countLocked++;
            $lockedProects[$proj->id]=$lockProjImp->month;
          }
          else continue;
        }
      }
      $habLockedImputation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther',array('idProfile'=>$prof,'scope'=>'lockedImputation'));
      $habValidationImputation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther',array('idProfile'=>$prof,'scope'=>'validationImputation'));
      
      if($habLockedImputation->rightAccess=='1'){
        $lockedFunction='onclick="lockedImputation(\''.$srtingProjectList.'\','.$length.',\''.$concMonth.'\');"';
      }
      
      $AllLocked=($countLocked==$length)?true:false;
	  //Header
	  $result  ='<div id="imputationValidationDiv" align="center" style="margin-top:20px;margin-bottom:20px; overflow-y:auto; width:100%;">';
	  $result .='  <table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
	  $result .='   <tr class="reportHeader">';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:16%;text-align:center;vertical-align:center;">'.i18n('Project').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:8%;text-align:center;vertical-align:center;">'.i18n('colRevenue').'</td>';
	  $result .='     <td style="width:38%;border: 1px solid grey;border-right: 1px solid white;">';
	  $result .='      <table width="100%"><tr><td colspan="5" style="height:30px;text-align:center;vertical-align:center;">'.ucfirst (i18n('technicalWork')).'</td></tr>';
	  $result .='        <tr>
	                       <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.ucfirst (i18n('colWorkApproved')).'</td>';
	  $result .='          <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.ucfirst (i18n('totalReal')).'</td>';
	  $result .='          <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.ucfirst (i18n('colRealCons')).'</td>
	                       <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.i18n('colRemainToDo').'</td>
	                       <td style="border-top: 1px solid white;border-right: 1px solid white;width:20%;height:30px;text-align:center;vertical-align:center;">'.ucfirst (i18n('colWorkReassessed')).'</td>
	                     </tr>
	                   </table>';
	  $result .='     </td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:8%;text-align:center;vertical-align:center;">'.i18n('colMargin').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">';
	  $result .='      <table><tr>';
	  $result .='          <td style="height:30px;padding-left:5px;width:10%;cursor:pointer;">';
	  if(!$AllLocked){
	    $result .='            <div id="UnlockedImputation" '.$lockedFunction.' class="iconUnLocked32 iconUnLocked iconSize32" ></div>';
	  }else{
	    $result .='            <div id="lockedImputation" '.$lockedFunction.' class="iconLocked32 iconLocked iconSize32" ></div>';
	  }
	  $result .='           </td>';
	  $result .='          <td> '.i18n('colBlocking').'</td>';
	  $result .='      </tr></table>';
	  $result .='     </td>';
	  $result .='     <td colspan="2" style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;">';
	  $result .='      <table width="100%"><tr><td width="62%">'.i18n('menuConsultationValidation').'</td>';
	  $result .='        <td width="30%">';
	  if($habValidationImputation->rightAccess=='1'){
	  $result .='          <span id="buttonValidationAll" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('validateWorkPeriod')
	  . '                    <script type="dojo/method" event="onClick" >'
	      . '                  validateAllSelection();'
		  . '                </script>'
    . '                    </span></td>';

	  $result.='         <td width="8%" style="padding-left:5px;padding-right:5px;">
	                       <div title="'.i18n('selectionAll').'" dojoType="dijit.form.CheckBox" type="checkbox"
	                         class="whiteCheck" id="selectAll" name="selectAll" onChange="imputationValidationSelection()">
	                       </div>';
	 }
     $result .='        </td>
                       </table>
                      </td>
	                 </tr>';
	  if(!empty($projectsList)){
        for($i=0;$i<$length;$i++) {
          $idCheckBox=$projectsList[$i]->id;
          $uniqueId=$concMonth.$projectsList[$i]->id;
          $lock=(isset($lockedProects[$idCheckBox])?$lockedProects[$idCheckBox]:'');
          $consValPproj=SqlElement::getSingleSqlElementFromCriteria("ConsolidationValidation",array("idProject"=>$projectsList[$i]->id,"month"=>$concMonth));
          $asSub=($projectsList[$i]->getSubProjectsList())?true:false;
          if($consValPproj->id!=''){
            $reel=$consValPproj->realWork;
            $leftWork=$consValPproj->leftWork;
            $plannedWork=$consValPproj->plannedWork;
            $validatedWork=$consValPproj->validatedWork;
            $revenue=$consValPproj->revenue;
            $margin=$consValPproj->margin;
            $reelCons=$consValPproj->realWorkConsumed;
          }else{
            $lstPeProject=$projectsList[$i]->ProjectPlanningElement;
            $reel=$lstPeProject->realWork;
            $leftWork=$lstPeProject->leftWork;
            $plannedWork=$lstPeProject->plannedWork;
            $validatedWork=$lstPeProject->validatedWork;
            $revenue=($lstPeProject->revenue!='')?$lstPeProject->revenue:0;
            $margin=$validatedWork-$plannedWork;
            $reelCons=ConsolidationValidation::getReelWorkConsumed($projectsList[$i],$concMonth);
          }
          $wbs=$projectsList[$i]->ProjectPlanningElement->wbsSortable;
          $split=explode('.', $wbs);
          $level=0;
          $testWbs='';
          foreach($split as $sp) {
            $testWbs.=(($testWbs)?'.':'').$sp;
            if (isset($levels[$testWbs])) $level=$levels[$testWbs]+1;
          }
          $levels[$wbs]=$level;
          $tab="";
          for ($j=1; $j<=$level; $j++) {
            $tab.='&nbsp;&nbsp;&nbsp;';
            // $tab.='...';
          }
          $classSub='Project';
          $goto='';
          $style='style="padding-left:15px;';
          if ( securityCheckDisplayMenu(null, $classSub) and securityGetAccessRightYesNo('menu'.$classSub, 'read', '')=="YES") {
            $goto=' onClick="gotoElement(\''.$classSub.'\',\''.htmlEncode($projectsList[$i]->id).'\');" ';
            $style.='cursor: pointer;';
          }
          $clauseArray=array('idProject'=>$projectsList[$i]->id,'idResource'=>$curUser->id);
          $ass=SqlElement::getSingleSqlElementFromCriteria('Affectation', $clauseArray);
          $profAss=$ass->idProfile;
          
          $style.='"';
    	   $result .='   <tr>';
    	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:left;vertical-center;"><div  '.$style.' '.$goto.'>'.$tab.'-&nbsp;'.$projectsList[$i]->name.'</div></td>';
    	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;">
    	                     <input type="hidden" id="revenue_'.$uniqueId.'" name="revenue_'.$uniqueId.'" value="'.$revenue.'"/>
    	                     '.costFormatter($revenue).'
    	                  </td>';
    	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;" >';
    	   $result .='     <table style="width:100%;height:100%" >';
    	   $result .='       <tr>';
    	   $result .='         <td style="border-right: 1px solid black;width:20%;text-align:center;vertical-align:center;">
    	                         <input type="hidden" id="validatedWork_'.$uniqueId.'" name="validatedWork_'.$uniqueId.'" value="'.$validatedWork.'"/>
    	                         '.workFormatter($validatedWork).'
    	                       </td>';
    	   $result .='         <td style="border-right: 1px solid black;width:20%;text-align:center;vertical-align:center;">
    	                         <input type="hidden" id="realWork_'.$uniqueId.'" name="realWork_'.$uniqueId.'" value="'.$reel.'"/>
  	                             '.workFormatter($reel).'
    	                       </td>';
    	   $result .='         <td style="border-right: 1px solid black;width:20%;text-align:center;vertical-align:center;">
    	                         <input type="hidden" id="realWorkConsumed_'.$uniqueId.'" name="realWorkConsumed_'.$uniqueId.'" value="'.(($reelCons!='')?$reelCons:0).'"/>
    	                         '.workFormatter($reelCons).'
    	                       </td>';
    	   $result .='         <td style="border-right: 1px solid black;width:20%;text-align:center;vertical-align:center;">
    	                         <input type="hidden" id="leftWork_'.$uniqueId.'" name="leftWork_'.$uniqueId.'" value="'.$leftWork.'"/>
                  	             '.workFormatter($leftWork).'
                        	   </td>';
    	   $result .='         <td style="width:20%;text-align:center;vertical-align:center;">
    	                         <input type="hidden" id="plannedWork_'.$uniqueId.'" name="plannedWork_'.$uniqueId.'" value="'.$plannedWork.'"/>
    	                         '.workFormatter($plannedWork).'
                               </td>';
    	   $result .='       </tr>';
    	   $result .='     </table>';
    	   $result .='    </td>';
    	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;background-color:'.(($margin<0)?"#E8ABAB":"").'">
    	                    <input type="hidden" id="margin_'.$uniqueId.'" name="margin_'.$uniqueId.'" value="'.$margin.'"/>
    	                    '.workFormatter($margin).'
    	                        </div>
    	                  </td>';
    	   $result .='     <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;">';
    	   $result .='       <div style="margin:2px 0px 2px 2px;" id="lockedDiv_'.$uniqueId.'" name="lockedDiv_'.$uniqueId.'" dojoType="dijit.layout.ContentPane" region="center">';
    	   $result .=          ConsolidationValidation::drawLockedDiv($uniqueId,$concMonth,$lock,$asSub,(($profAss!='' and $profAss!=$prof)?$profAss:$prof),$consValPproj);
    	   $result .='       </div>';
    	   $result .='    </td>';
    	   $result .='    <td style="border-top: 1px solid black;border-right: 1px solid black;height:30px;text-align:center;vertical-align:center;">';
    	   $result .='       <div style="margin:2px 0px 2px 2px;" id="validatedDiv_'.$uniqueId.'" name="validatedDiv_'.$uniqueId.'" dojoType="dijit.layout.ContentPane" region="center">';
           $result .=          ConsolidationValidation::drawValidationDiv($consValPproj,$uniqueId,$concMonth,$asSub,(($profAss!='' and $profAss!=$prof)?$profAss:$prof));
           $result .='       </div>';
           $result .='    </td>';
           $result .='     <input type="hidden" id="validatedLine'.$idCheckBox.'" name="'.$uniqueId.'" value="0"/>';
           $result .='     <input type="hidden" id="countLine" name="countLine" value="'.$i.'"/>';
           $result .='   </tr>';
    	  }
	  }else{
	    $result .='   <tr>';
	    $result .='    <td colspan="6">';
	    $result .='    <div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;width:100%;border-right: 1px solid grey;">'.i18n('noDataFound').'</div>';
	    $result .='    </td>';
	    $result .='   </tr>';
	  }
	  $result .='<input type="hidden" id="monthConsolidationValidation" name="monthConsolidationValidation" value="'.$concMonth.'"/>';
	  $result .='  </table>';
	  $result .='</div>';
	  
	  echo $result;
	}
	
	/** ==========================================================================
	 * Draw div
	 * @return list of project
	 */
	static function drawLockedDiv($proj,$month,$lock,$asSub,$prof,$consValPproj){
	  $habLockedImputation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther',array('idProfile'=>$prof,'scope'=>'lockedImputation'));
	  $functionLocked=($habLockedImputation->rightAccess=='1' and $consValPproj->id=='')?'onclick="lockedImputation(\''.$proj.'\',\'false\',\''.$month.'\',\''.$asSub.'\');"':'';
	  $result ='  <table>';
	  $result .='    <tr>';
	  $result .='      <td style="width: 70px; ">';
	  if($lock==''){
	    $result .='      <div '.(($habLockedImputation->rightAccess=='1' and $consValPproj->id=='')?'style="cursor:pointer;"':'style="cursor: not-allowed;"').'  id="UnlockedImputation_'.$proj.'"  '.$functionLocked.' class="iconUnLocked32 iconUnLocked iconSize32" ></div>';
	  }else{
	    $result .='      <div '.(($habLockedImputation->rightAccess=='1' and $consValPproj->id=='')?'style="margin-left:5px;cursor:pointer;"':'style="cursor: not-allowed;margin-left:5px;"').'  id="lockedImputation_'.$proj.'" '.$functionLocked.' class="iconLocked32 iconLocked iconSize32" ></div>';
	  }
	  $result .='     <input type="hidden" id="projHabilitationLocked_'.substr($proj, 6).'" name="projHabilitationLocked_'.substr($proj, 6).'" value="'.$habLockedImputation->rightAccess.'"/>';
      $result .='     </td>';
      $result .='     <td >'.(($lock=='')?i18n('colUnlock'):i18n('colLocked')).'</td>';
      $result .='   </tr>';
	  $result .='  </table>';
	  
	  return $result;
	}
	
	static function drawValidationDiv($consValPproj,$uniqueId,$concMonth,$asSub,$prof){
	  $habValidationImputation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther',array('idProfile'=>$prof,'scope'=>'validationImputation'));
	  $right=$habValidationImputation->rightAccess;
	  $result="";
	  if($consValPproj->id!=''){
	    $resource=new User ($consValPproj->idResource);
	    $resourceName=$resource->name;
	    $validatedDate=$consValPproj->validationDate;
	    $result .='      <table>';
	    $result .='        <tr>';
	    $result .='          <td style="height:30px;">'.formatIcon('Submitted', 32, i18n('validatedWork', array($resourceName, htmlFormatDate($validatedDate)))).'</td>';
	    $result .='          <td style="width:'.(($right=='1')?"73%":"100%").';padding-left:5px;height:30px;">'.i18n('validatedWork', array($resourceName, htmlFormatDate($validatedDate))).'</td>';
	    $result .='          <input type="hidden" id="projHabilitationValidation_'.substr($uniqueId, 6).'" name="projHabilitationValidation_'.substr($uniqueId, 6).'" value="'.$right.'"/>';
	    if($right=='1'){
    	    $result .='          <td style="width:27%;padding-right:8px;height:30px;">';
    	    $result .='            <span id="buttonCancel_'.$uniqueId.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
    	            . '              <script type="dojo/method" event="onClick" >'
    	            . '                saveOrCancelConsolidationValidation("'.$uniqueId.'","'.$concMonth.'","'.$asSub.'");'
    	            . '              </script>'
    	            . '            </span>';
    	    $result .='          </td>';
	    }
	    $result .='         <td style="padding-right:22px;"></td>';
	  }else{
	    $result .='      <table>';
	    $result .='        <tr>';
	    $result .='          <td style="height:30px;">'.formatIcon('Unsubmitted', 32, i18n('unvalidatedWorkPeriod')).'</td>';
	    $result .='          <td style="width:'.(($right=='1')?"73%":"100%").';padding-left:5px;height:30px;">'.i18n('unvalidatedWorkPeriod').'</td>';
	    if($right=='1'){
    	    $result .='          <td style="width:27%;padding-right:8px;height:30px;">';
    	    $result .='            <span id="buttonValidation_'.$uniqueId.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('validateWorkPeriod')
    	            . '              <script type="dojo/method" event="onClick" >'
    	            . '                saveOrCancelConsolidationValidation("'.$uniqueId.'","'.$concMonth.'","'.$asSub.'");'
    	            . '              </script>'
    	            . '            </span>';
    	    $result .='          </td>';
    	    $result .='         <td style="padding-right:5px;"><div class="validCheckBox" type="checkbox" dojoType="dijit.form.CheckBox" name="validCheckBox'.substr($uniqueId, 6).'" id="validCheckBox'.substr($uniqueId, 6).'"></div></td>';
	    }
	    
	  }
	  $result .='            </tr>';
	  $result .='         </table>';
	  return $result;
	}
	/** ==========================================================================
	 * Get Visible Project
	 * @return list of project 
	 */
	static  function getVisibleProjectToConsolidated ($idProject,$idProjectType,$idOrganization) {
	  $currentUser=new User(getCurrentUserId());
	  $visibleProject=implode(',', array_flip($currentUser->getVisibleProjects()));
	  $where="id in ($visibleProject) ";
	  $proj= new Project();
	  if($idProject==0 and $idProjectType==0 and $idOrganization==0){
	    $where.="order by sortOrder";
	    $lstProject=$proj->getSqlElementsFromCriteria(null,null,$where);
	  }else if($idProjectType!=0 or $idOrganization!=0){
	    $critArray=array();
	    if($idProject!=0){
	      $where=ConsolidationValidation::clauseWhithSubProj($idProject);
	    }
	    ($idProjectType!=0 )?$where.=" and idProjectType=$idProjectType ":"";
 	    ($idOrganization!=0)?$where.=" and idOrganization=$idOrganization ":"";
 	    $where.="order by sortOrder";
	    $lstProject=$proj->getSqlElementsFromCriteria(null,null,$where);
	  }else{
        $where=ConsolidationValidation::clauseWhithSubProj($idProject);
        $where.="order by sortOrder";
        $lstProject=$proj->getSqlElementsFromCriteria(null,null,$where);
	  }
	  $result[]=$lstProject;
	  $stringProjectList="";
	  foreach ($lstProject as $proj){
	    if($stringProjectList==""){
	      $stringProjectList.=$proj->id;
	    }else{
	      $stringProjectList.=','.$proj->id;
	    }
	  }
	  $result[]=$stringProjectList;
	  return $result;
	}
	
	static function clauseWhithSubProj($idProject){
	  $lstProj=$idProject;
	  $proj=new Project($idProject);
	  $sub=$proj->getRecursiveSubProjectsFlatList();
	  foreach ($sub as $id=>$subproj){
	    $lstProj.=",".$id;
	  }
	 return "id in ($lstProj)";
	}
	
	/** ==========================================================================
	 * Get Visible Project
	 * @return list of project
	 */
	static function getReelWorkConsumed ($project,$month) {
	  $work=new Work();
	  if($project->getSubProjectsList()){
	    $sub=$project->getSubProjectsList();
	    $subList=$project->id.','.implode(',', array_keys($sub));
	    $where="idProject in ($subList) and month = $month ";
	  }else{
	    $where="idProject = $project->id and month = $month ";
	  }
	  $reelCons=$work->sumSqlElementsFromCriteria('work',null,$where);
	  return $reelCons;
	}

	
}