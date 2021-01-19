<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : Julien PAPASIAN
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
 * Habilitation defines right to the application for a menu and a profile.
 */
require_once('_securityCheck.php');
class SubTask extends SqlElement {

  public $id;    
  public $refType;
  public $refId;
  public $idProject;
  public $idTargetProductVersion;
  public $sortOrder;
  public $name;
  public $idPriority;
  public $idResource;
  public $handled;
  public $done;
  public $idle;


  

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
  // DRAW SUBTASK
  // ============================================================================**********
  static function drawSubtasksForObject($obj,$refType, $refId,$refresh=false,$idResource=false,$gloablView=false){
    global $cr, $print, $user, $comboDetail;
    if ($comboDetail) {
      return;
    }
    if(!$gloablView) $view='Single';
    else $view='Global';
    $showClosedSubTask=(Parameter::getUserParameter('showClosedSubTask_'.$view)!='0')?true:false;
    $subTask=new SubTask();
    $assignment= new Assignment();
    $crit=($showClosedSubTask)? array("refType"=>$refType,"refId"=>$refId): array("refType"=>$refType,"refId"=>$refId,"idle"=>'0');
    if($idResource!=false and $idResource!=0){
      $val=array("idResource"=>$idResource);
      $crit=array_merge($crit,$val);
    }
    $res=$subTask->getSqlElementsFromCriteria($crit,false,null,'sortOrder');

    $critFld='idProject';
    $critVal=$obj->idProject;
    
    
    if (!$print and !$gloablView) {
      echo'<div style="position:absolute;right:5px;top:3px;">';
      echo'<label for="showClosedSubTask_'.$view.'"  class="dijitTitlePaneTitle" style="border:0;font-weight:normal !important;height:'.((isNewGui())?'20':'10').'px;width:'.((isNewGui())?'50':'150').'px">'.i18n('labelShowIdle'.((isNewGui())?'Short':'')).'&nbsp;</label>';
      echo'<div class="whiteCheck" id="showClosedSubTask_'.$view.'" style="'.((isNewGui())?'margin-top:14px':'').'" dojoType="dijit.form.CheckBox" type="checkbox" '.(($showClosedSubTask)?'checked':'');
      echo' title="'.i18n('labelShowIdle').'" >';
      echo'<script type="dojo/connect" event="onChange" args="evt">';
      echo' saveUserParameter("showClosedSubTask_'.$view.'",((this.checked)?"1":"0"));';
      echo' if (checkFormChangeInProgress()) {return false;}';
      echo' loadContent("objectDetail.php", "detailDiv", "listForm");';
      echo'</script>';
      echo'</div>';
    }
    
    if (!$refresh) echo '<tr><td colspan="4"><div id="'.$refType.'_'.$refId.'_drawSubTask" dojotype="dijit.layout.ContentPane">';
    echo '<table style="width:100%;margin-top: 10px;" dojotype="dojo.dnd.Source" dndType="subTask_'.$refType.'_'.$refId.'" withhandles="true" id="dndSubTask" jsId="dndSubTask">';
    if($gloablView )echo      '<input id="SubTaskIdResourceFilter" value="'.$idResource.'" hidden />';
    echo  '<tr>';
    echo    '<td class="linkHeader" style="width:2%"></td>';
    echo    '<td class="linkHeader" style="width:38%;">'.i18n('colName').'</td>';
    echo    '<td class="linkHeader" style="width:23%;">'.i18n('colPriority').'</td>';
    echo    '<td class="linkHeader" style="width:23%;">'.i18n('colResponsible').'</td>';
    echo    '<td class="linkHeader" style="width:14%;">'.i18n('colIdStatus').'</td>';
    echo  '</tr>';
    if(!empty($res)){
      foreach ($res as $id=>$subTask){
        echo  '<tr id="'.$refType.'_'.$refId.'_subTaskRow_'.$subTask->id.'" class="dojoDndItem" dndType="subTask_'.$refType.'_'.$refId.'">';
        echo    '<td  class="dojoDndHandle handleCursor linkData"  style="text-align: center;"><img style="width:7px;top: 10px;position: relative;" src="css/images/iconDrag.gif"></td>';
        echo    '<td class="linkData" style="white-space:nowrap;width:auto;margin-right:5px;text-align: center;" >';
        echo      '<div title="'.i18n('colName').'"  type="text"  id="nameNewSubTask_'.$subTask->id.'" dojoType="dijit.form.TextBox" style="width:90%;" onChange="updateSubTask('.$subTask->id.',\''.$refType.'\','.$refId.');"  value="'. htmlEncode($subTask->name).'">';
        echo    '</td>';
        echo    '<td class="linkData" style="white-space:nowrap;text-align: center;">';
        echo      '<select dojoType="dijit.form.FilteringSelect"  id="priorityNewSubTask_'.$subTask->id.'" style="width:auto;" class="input" onChange="updateSubTask('.$subTask->id.',\''.$refType.'\','.$refId.');"   >';
                    htmlDrawOptionForReference('idPriority',$subTask->idPriority);
        echo      '</select>';
        echo    '</td>';
        echo    '<td class="linkData" style="white-space:nowrap;text-align: center;">';
        echo      '<select dojoType="dijit.form.FilteringSelect" id="resourceNewSubTask_'.$subTask->id.'" style="width:auto;" class="input" onChange="updateSubTask('.$subTask->id.',\''.$refType.'\','.$refId.');"  >';
                    htmlDrawOptionForReference('idResource',$subTask->idResource,$obj,false,$critFld,$critVal);
        echo      '</select>';
        echo    '</td>';
        echo    '<td class="linkData" id="statusNewSubTask_'.$subTask->id.'" style="white-space:nowrap;text-align: center;">';
        echo      '<input id="sortOrder_'.$subTask->id.'" value="'.$subTask->sortOrder.'" hidden />';
                  $subTask->drawStatusSubTask($subTask->id,$subTask->done,$subTask->idle,$subTask->handled,$refType,$refId);
        echo    '</td>';
        echo  '</tr>';
        $lastSortRegist=$subTask->sortOrder;
      }
    }
    $lastSort=(!empty($res))? $lastSortRegist :0;
    echo  '<tr id="'.$refType.'_'.$refId.'_newSubTaskRow" >';
     echo    '<td class="linkData" id="'.$refType.'_'.$refId.'_grabDive_0">&nbsp;</td>';
    echo    '<td class="linkData" style="white-space:nowrap;text-align: center;">';
    echo      '<div title="'.i18n('colName').'"  type="text"  id="'.$refType.'_'.$refId.'_nameNewSubTask_0" dojoType="dijit.form.TextBox" style="width:90%;" onChange="updateSubTask(0,\''.$refType.'\','.$refId.');" value="">';
    echo    '</td>';
    echo    '<td class="linkData" style="white-space:nowrap;text-align: center;">';
    echo      '<select dojoType="dijit.form.FilteringSelect" id="'.$refType.'_'.$refId.'_priorityNewSubTask_0" style="width:auto;"  class="input" readonly>';
                htmlDrawOptionForReference('idPriority',null);
    echo      '</select>';
    echo    '</td>';
    echo    '<td class="linkData" style="white-space:nowrap;text-align: center;">';
    echo      '<select dojoType="dijit.form.FilteringSelect" id="'.$refType.'_'.$refId.'_resourceNewSubTask_0" style="width:auto;"  class="input"  readonly>';
                htmlDrawOptionForReference('idResource',null,$obj,false,$critFld,$critVal);
    echo      '</select>';
    echo    '</td>';
    echo    '<td class="linkData" style="white-space:nowrap;text-align: center;">';
    echo      '<input id="'.$refType.'_'.$refId.'_sortOrder_0" value="'.$lastSort.'" hidden />';
               $subTask->drawStatusSubTask('0','0','0','0',$refType,$refId);
    echo    '</td>';
    echo  '</tr>';
    echo '</table>';
    if (!$refresh) echo '</div></td></tr>';
  }
  
  function drawStatusSubTask($id, $done, $idle, $handled,$refType,$refId){
    echo '<div id="'.$refType.'_'.$refId.'_slidContainer_'.$id.'" class="slideshow-container">';

    
    echo '<div class="mySlides fade" style="'.(($done==0 && $idle==0 && $handled==0)?'display:block;':'display:none;').'">';
    echo '  <div class="slideStatus"></div>';
    echo '</div>';
    
    echo '<div class="mySlides fade" style="'.(($done==1)?'display:block;':'display:none;').'">';
    echo '  <div class="slideStatus"><span>'.i18n('colHandled').'</span></div>';
    echo '</div>';
    
    echo '<div class="mySlides fade" style="'.(($handled==1)?'display:block;':'display:none;').'">';
    echo '  <div class="slideStatus"><span>'.i18n('done').'</span></div>';
    echo '</div>';
    
     echo '<div class="mySlides fade" style="'.(($idle==1)?'display:block;':'display:none;').'">';
     echo   '<div class="slideStatus" ><span>'.i18n('colIdle').'</span></div>';
     echo '</div>';
    
     $pos=1;
     if($done==1){
       $pos=2;
     }else if($handled==1){
       $pos=3;
     }else if($idle==1){
       $pos=4;
     }
     
     echo '<input id="'.(($id==0)?$refType.'_'.$refId.'_pos_'.$id:'pos_'.$id).'" value="'.$pos.'" hidden />';
     echo '<div id="'.(($id==0)?$refType.'_'.$refId.'_prev_'.$id:'prev_'.$id).'" class="prev" style="'.(($id==0)?'display:none':'').'" onclick="'.(($id!=0)?"nextSlides('prev',".$id.",'".$refType."',".$refId.");":"").'">&#10094;</div>';
     echo '<div  id="'.(($id==0)?$refType.'_'.$refId.'_next_'.$id:'next_'.$id).'" class="next" style="'.(($id==0)?'display:none':'').'"  onclick="'.(($id!=0)?"nextSlides('next',".$id.",'".$refType."',".$refId.");":"").'">&#10095;</div>';
    
     echo '</div>';
  }
  
  
  static function drawAllSubTask($idProject,$idResource,$elementType,$idVersion){
    $tab= array();
    $subTask= new SubTask();
    $tableName=$subTask->getDatabaseTableName();
    $query="SELECT DISTINCT  $tableName.refId as refId,$tableName.refType as refType FROM $tableName ";
    $query.="WHERE 1=1";
    if($idProject!=0)$query.=" and  $tableName.idProject = ".$idProject;
    if($idResource!=0)$query.=" and  $tableName.idResource = ".$idResource;
    if(trim($elementType)!='')$query.=" and  $tableName.refType = '".$elementType."'";
    if($idResource!=0)$query.=" and  $tableName.idResource = ".$idResource;
    if ($idVersion!=0)$query.=" and  $tableName.idTargetProductVersion = ".$idVersion;;
    $result=Sql::query($query);
    while ($line = Sql::fetchLine($result)) {
      $tab[]=$line;
    }
    if(!empty($tab)){
      foreach ($tab as $id=>$obj){
        $element= new $obj['refType']( $obj['refId']);
        $goto="";
        $style="";
        if ( securityCheckDisplayMenu(null, $obj['refType']) and securityGetAccessRightYesNo('menu'.$obj['refType'], 'read', '')=="YES") {
          $goto=' onClick="gotoElement(\''.$obj['refType'].'\',\''.htmlEncode($element->id).'\');" ';
          $style='cursor: pointer;';
        }
          echo '<table style="width:95%; margin-bottom:10px;">';
            echo '<tr style="height:42px;"><td colspan="4" ><div dojotype="dijit.layout.ContentPane" class="dijitContentPane">';
              echo'<table style="width:100%;"><tr>';
                    echo '<td style="width:63%;">';
                      echo '<div class="reportHeader" style="width:100%;height:42px;border-radius:unset!important;"><span style="margin-left:25px;float:left;padding-top:12px;'.$style.'" '.$goto.'>'.ucfirst($obj['refType']).'&nbsp#'.$element->id.'&nbsp_'.$element->name.'</span></div>';
                    echo '</td>';
                    echo '<td style="width:23%;">';
                       echo '<div class="reportHeader" style="width:100%;height:42px;border-radius:unset!important;vertical-align:middle;">';
                        echo      '<select dojoType="dijit.form.FilteringSelect" id="idStatusElement_'.$obj['refType'].'_'.$element->id.'" style="width:auto;margin-top:7px;" class="input" onChange="saveActivityValueFilter(\'Status\',\''.$obj['refType'].'\','.$element->id.'); "  >';
                          htmlDrawOptionForReference('idStatus',$element->idStatus,$element);
                        echo      '</select>';
                       echo '</div>';
                       echo      '<input id="idOldStatusElement_'.$obj['refType'].'_'.$element->id.'" value="'.$element->idStatus.'" hidden />';
                    echo '</td>';
                    echo '<td style="width:14%;">';
                       echo '<div class="reportHeader" style="width:100%;height:42px;border-radius:unset!important;vertical-align:middle;">';
                        echo      '<select dojoType="dijit.form.FilteringSelect" id="idResourceElement_'.$obj['refType'].'_'.$element->id.'" style="width:auto;margin-top:7px;" class="input" onChange="saveActivityValueFilter(\'Resposible\',\''.$obj['refType'].'\','.$element->id.');"  >';
                          htmlDrawOptionForReference('idResource',$element->idResource,$element);
                        echo      '</select>';
                       echo '</div>';
                       echo      '<input id="idOldResourceElement_'.$obj['refType'].'_'.$element->id.'" value="'.$element->idResource.'" hidden />';
                     echo '</td >';
              echo'</tr></table>';
            echo '</div></td></tr>';
            SubTask::drawSubtasksForObject($element, $obj['refType'],  $obj['refId'],null,$idResource,true);
          echo '</table>';
      }
    }else{
      echo '<table style="width:95%; margin-bottom:10px;">';
  	  echo '   <tr>';
      echo '    <td colspan="10">';
      echo '    <div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;width:100%;border-right: 1px solid grey;">'.i18n('noDataFound').'</div>';
      echo '    </td>';
      echo '   </tr>';
      echo '</table>';
    }
  }
  
  // ============================================================================**********
  // CONTROL
  // ============================================================================**********
  public function control(){
    $result="";
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }

  // ============================================================================**********
  // SAVE
  // ============================================================================**********
  public function save() {
    $result=parent::save();
    return $result;
  }
  
  
}
?>
