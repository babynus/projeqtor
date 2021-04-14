<?php
use Doctrine\Common\Cache\Version;
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
  static function drawSubtasksForObject($obj,$refType, $refId,$rightUpdate,$rightRead,$refresh=false,$idResource=false,$gloablView=false,$dialogView=false){
    global $cr, $print, $user, $comboDetail;
    if ($comboDetail or (!$rightUpdate and !$rightRead) or ($rightUpdate=='NO' and $rightRead=='NO')) {
      return;
    }
    if(!$gloablView ) $view='Single';
    else $view='Global';
    $showClosedSubTask=(Parameter::getUserParameter('showClosedSubTask_'.$view)!='' and Parameter::getUserParameter('showClosedSubTask_'.$view)!='0')?true:false;
    $showDoneSubTask=((Parameter::getUserParameter('showDoneSubTask_'.$view)!='0') or $showClosedSubTask==true)?true:false;
    $subTask=new SubTask();
    $assignment= new Assignment();
    $crit=array("refType"=>$refType,"refId"=>$refId,"done"=>"0","idle"=>"0");
    if($showDoneSubTask){
      $crit=array("refType"=>$refType,"refId"=>$refId,"idle"=>"0");
    }
    if($showClosedSubTask){
      $crit=array("refType"=>$refType,"refId"=>$refId);
    }
    
    if($idResource!=false and $idResource!=0){
      $val=array("idResource"=>$idResource);
      $crit=array_merge($crit,$val);
    }
    $res=$subTask->getSqlElementsFromCriteria($crit,false,null,'sortOrder');
    $critFld='idProject';
    $critVal=$obj->idProject;
    $widthDisplay=(RequestHandler::isCodeSet("destinationWidth")?RequestHandler::getValue("destinationWidth"):"");
    if(!$gloablView){
      $priority=new Priority();
      $allPrio=$priority->getSqlElementsFromCriteria(null,null,"1=1");
      foreach ($allPrio as $id=>$priority){
        echo '<input id="colorPrio_'.$priority->id.'" value="'.$priority->color.'" type="hidden" />';
      }
    }
    if($dialogView) echo '<table>';
    if (!$print and !$gloablView and !$dialogView) {
      echo'<div style="position:absolute;right:5px;top:3px;">';
      echo' <label for="showClosedSubTask_'.$view.'"  class="dijitTitlePaneTitle" style="border:0;font-weight:normal !important;height:'.((isNewGui())?'20':'10').'px;width:'.((isNewGui())?'50':'150').'px">'.i18n('labelShowIdle'.((isNewGui())?'Short':'')).'&nbsp;</label>';
      echo' <div class="'.((isNewGui())?"whiteCheck":"").'" id="showClosedSubTask_'.$view.'" style="'.((isNewGui())?'margin-top:14px':'').'" dojoType="dijit.form.CheckBox" type="checkbox" '.(($showClosedSubTask)?'checked':'');
      echo'   title="'.i18n('labelShowIdle').'" >';
      echo'   <script type="dojo/connect" event="onChange" args="evt">';
      echo'     saveUserParameter("showClosedSubTask_'.$view.'",((this.checked)?"1":"0"));';
      echo'     if (checkFormChangeInProgress()) {return false;}';
      echo'     loadContent("objectDetail.php", "detailDiv", "listForm");';
      echo'   </script>';
      echo' </div>';
      echo'</div>';
      echo'<div style="position:absolute;right:'.((isNewGui())?"110px":"200px").';top:3px;">';
      echo' <label for="showDoneSubTask_'.$view.'"  class="dijitTitlePaneTitle" style="border:0;font-weight:normal !important;height:'.((isNewGui())?'20':'10').'px;width:'.((isNewGui())?'50':'150').'px">'.i18n('labelShowDone'.((isNewGui())?'Short':'')).'&nbsp;</label>';
      echo' <div class="'.((isNewGui())?"whiteCheck":"").'" id="showDoneSubTask_'.$view.'" style="'.((isNewGui())?'margin-top:14px':'').'" dojoType="dijit.form.CheckBox" type="checkbox"  '.(($showDoneSubTask)?'checked':'').' '.(($showClosedSubTask)?'readonly':'');
      echo' title="'.i18n('labelShowDone').'" >';
      echo'   <script type="dojo/connect" event="onChange" args="evt">';
      echo'     saveUserParameter("showDoneSubTask_'.$view.'",((this.checked)?"1":"0"));';
      echo'     if (checkFormChangeInProgress()) {return false;}';
      echo'     loadContent("objectDetail.php", "detailDiv", "listForm");';
      echo'   </script>';
      echo' </div>';
      echo'</div>';
    }
    
    if (!$refresh) echo '<tr><td colspan="4"><div id="'.$refType.'_'.$refId.'_drawSubTask" dojotype="dijit.layout.ContentPane">';
    echo '<table style="width:100%;margin-top: 10px;" dojotype="dojo.dnd.Source" dndType="subTask_'.$refType.'_'.$refId.'" withhandles="true" id="dndSubTask_'.$refType.'_'.$refId.'" jsId="dndSubTask_'.$refType.'_'.$refId.'" data-dojo-id="test">';
    if($gloablView and $idResource!=''){
      echo      '<input id="SubTaskIdResourceFilter_'.$refType.'_'.$refId.'" value="'.$idResource.'" type="hidden" />';
    }
    else {
      echo      '<input id="SubTaskIdResourceFilter_'.$refType.'_'.$refId.'" value="'.$obj->idResource.'" type="hidden" />';
    }
    echo      '<input id="subTaskView" value="'.$view.'" type="hidden" />';
    echo  '<tr style="width:100%">';
    echo    '<td class="linkHeader" style="width:2%"></td>';
    echo    '<td class="linkHeader" style="'.(($gloablView and $widthDisplay>='1530')?'width:64%;':'width:52%;').'">'.i18n('colName').'</td>';
    echo    '<td class="linkHeader" style="'.(($gloablView and $widthDisplay>='1530')?'width:12%;':'width:18%;').'">'.i18n('colPriority').'</td>';
    echo    '<td class="linkHeader" style="'.(($gloablView and $widthDisplay>='1530')?'width:12%;':'width:18%;').'">'.i18n('colResponsible').'</td>';
    echo    '<td class="linkHeader" style="'.(($gloablView and $widthDisplay>='1530')?'width:8%;':'width:10%;').';min-width:95px;">'.i18n('colIdStatus').'</td>';
    echo  '</tr>';
    if(!empty($res)){
      foreach ($res as $id=>$subTask){
        $prioSubTask=new Priority($subTask->idPriority);
        $colorPrio=$prioSubTask->color;
        echo  '<tr  id="'.$refType.'_'.$refId.'_subTaskRow_'.$subTask->id.'" '.(($rightUpdate=='NO' and $rightRead=='YES')?'':'class="dojoDndItem" dndType="subTask_'.$refType.'_'.$refId.'"').'  >';
        echo      '<input id="sortOrder_'.$refType.'_'.$refId.'_'.$subTask->id.'" value="'.$subTask->sortOrder.'" type="hidden" />';
        if($rightUpdate=='NO' and $rightRead=='YES'){
          echo   '<td class="todoListTab" id="'.$refType.'_'.$refId.'_grabDive_0" >&nbsp;</td>';
        }else{
          echo    '<td  class="dojoDndHandle handleCursor todoListTab"  style="text-align: center;"><img style="width:7px;top:4px;position: relative;" src="css/images/iconDrag.gif"></td>';
        }
        
        echo    '<td class="todoListTab" style="white-space:nowrap;width:auto;margin-right:5px;text-align: center;" >';
        echo      '<textarea title="'.i18n('colName').'" id="'.$refType.'_'.$refId.'_nameNewSubTask_'.$subTask->id.'" name="'.$refType.'_'.$refId.'_nameNewSubTask_'.$subTask->id.'" 
                    dojoType="dijit.form.Textarea" style="'.(($gloablView)?"width:98%;":"width:90%;" ).'max-height:150px !important;" 
                    value="'. htmlEncode($subTask->name).'" ';
        if ($rightUpdate=='NO' and $rightRead=='YES'){
          echo ' readonly="true">';
        }else {
          echo 'onChange="updateSubTask('.$subTask->id.',\''.$refType.'\','.$refId.');"  ></textarea>';
        }
        echo    '</td>';
        echo    '<td class="todoListTab" style="white-space:nowrap;text-align: center;background-color:'.$colorPrio.';">';
        echo      '<select dojoType="dijit.form.FilteringSelect"  id="'.$refType.'_'.$refId.'_priorityNewSubTask_'.$subTask->id.'" name="'.$refType.'_'.$refId.'_priorityNewSubTask_'.$subTask->id.'" style="width:auto;" class="input" '.autoOpenFilteringSelect().''; 
        if ($rightUpdate=='NO' and $rightRead=='YES'){
          echo ' readonly="true">';
        }else {
          echo 'onChange="updateSubTask('.$subTask->id.',\''.$refType.'\','.$refId.',\'true\',\'false\');"  >';
        }
                    htmlDrawOptionForReference('idPriority',$subTask->idPriority);
        echo      '</select>';
        echo    '</td>';
        echo    '<td class="todoListTab" style="white-space:nowrap;text-align: center;">';
        echo      '<select dojoType="dijit.form.FilteringSelect" id="'.$refType.'_'.$refId.'_resourceNewSubTask_'.$subTask->id.'" name="'.$refType.'_'.$refId.'_resourceNewSubTask_'.$subTask->id.'" style="width:auto;" class="input"Â² '.autoOpenFilteringSelect().'';
        if ($rightUpdate=='NO' and $rightRead=='YES'){
          echo ' readonly="true" >';
        }else {
          echo 'onChange="updateSubTask('.$subTask->id.',\''.$refType.'\','.$refId.',\'false\',\'true\');">';
        }
                    htmlDrawOptionForReference('idResource',$subTask->idResource,$obj,false,$critFld,$critVal);
        echo      '</select>';
        echo    '</td>';
        echo    '<td   style="white-space:nowrap;text-align: center;border: 1px solid #AAAAAA;">';
                  $subTask->drawStatusSubTask($subTask->id,$subTask->done,$subTask->idle,$subTask->handled,$refType,$refId,$gloablView,$rightUpdate,$rightRead);
        echo    '</td>';
        echo  '</tr>';
        $lastSortRegist=$subTask->sortOrder;
      }
    }
    if($rightUpdate=='YES'){
      $lastSort=(!empty($res))? $lastSortRegist :0;
      echo  '<tr id="'.$refType.'_'.$refId.'_newSubTaskRow" >';
      echo      '<input id="sortOrder_'.$refType.'_'.$refId.'_0" value="'.$lastSort.'" type="hidden" />';
       echo   '<td class="todoListTab" id="'.$refType.'_'.$refId.'_grabDive_0" >&nbsp;</td>';
      echo    '<td class="todoListTab" style="white-space:nowrap;text-align: center;">';
      echo      '<textarea title="'.i18n('colName').'" id="'.$refType.'_'.$refId.'_nameNewSubTask_0" name="'.$refType.'_'.$refId.'_nameNewSubTask_0" 
                  dojoType="dijit.form.Textarea" style="'.(($gloablView)?"width:98%;":"width:90%;" ).'max-height:150px !important;" 
                  maxlength="4000"  onChange="updateSubTask(0,\''.$refType.'\','.$refId.');" value="">';
      echo      '</textarea>';
      echo    '</td>';
      echo    '<td class="todoListTab" style="white-space:nowrap;text-align: center;">';
      echo      '<select dojoType="dijit.form.FilteringSelect" id="'.$refType.'_'.$refId.'_priorityNewSubTask_0" style="width:auto;"  class="input" readonly="true" >';
                  htmlDrawOptionForReference('idPriority',null);
      echo      '</select>';
      echo    '</td>';
      echo    '<td class="todoListTab" style="white-space:nowrap;text-align: center;" >';
      echo      '<select dojoType="dijit.form.FilteringSelect" id="'.$refType.'_'.$refId.'_resourceNewSubTask_0" style="width:auto;"  class="input"  readonly="true">';
                  htmlDrawOptionForReference('idResource',null,$obj,false,$critFld,$critVal);
      echo      '</select>';
      echo    '</td>';
      echo    '<td  style="white-space:nowrap;text-align: center;border: 1px solid #AAAAAA;" >';
                 $subTask->drawStatusSubTask('0','0','0','0',$refType,$refId,$gloablView,$rightUpdate,$rightRead);
      echo    '</td>';
      echo  '</tr>';
    }
    echo '</table>';
    if (!$refresh) echo '</div></td></tr>';
    if($dialogView) echo '</table>';
  }
  
  function drawStatusSubTask($id, $done, $idle, $handled,$refType,$refId,$gloablView,$rightUpdate,$rightRead){

    $pos=1;
    $backgroundColor="";
    if($handled==1){
      $pos=2;
      $backgroundColor="background-color:#FACA77;";
    }else if($done==1){
      $pos=3;
      $backgroundColor="background-color:#57CE44;";
    }else if($idle==1){
      $pos=4;
      $backgroundColor="background-color:#B7B3A9;";
    }
    
    
    echo '<div id="'.$refType.'_'.$refId.'_slidContainer_'.$id.'" >';
    echo '<table style="width:100%;height:100%;">';
      echo '<tr>';
        echo ' <td style="width:12%;height:100%;">';
        echo '<div id="'.$refType.'_'.$refId.'_prev_'.$id.'" class="prev" style="'.(($id==0 or ($done==0 && $idle==0 && $handled==0) or ($rightUpdate=='NO' and $rightRead=='YES'))?'display:none':'').'" 
                  onclick="'.(($id!=0 and  $rightUpdate=='YES' )?"nextSlides('prev',".$id.",'".$refType."',".$refId.");":"").'">&#10094;</div>';
        echo ' </td>';
        echo ' <td style="width:76%;height:100%;'.$backgroundColor.'">';
          echo '<div  class="slideshow-container" style="width:100%;height:30px">';
          echo '<input id="'.$refType.'_'.$refId.'_pos_'.$id.'" value="'.$pos.'" type="hidden" />';
          
          echo '<div class="mySlides fade" style="'.(($done==0 && $idle==0 && $handled==0)?'display:block;':'display:none;').'margin-top:9px;padding-top:1px;">';
          echo '  <div class="slideStatus">&nbsp;</div>';
          echo '</div>';
          
          echo '<div class="mySlides fade" style="'.(($handled==1)?'display:block;':'display:none;').'margin-top:9px;padding-top:1px;">';
          echo '  <div class="slideStatus"><span  style="font-weight: bolder;">'.i18n('colHandled').'</span></div>';
          echo '</div>';
          
          echo '<div class="mySlides fade" style="'.(($done==1)?'display:block;':'display:none;').'margin-top:9px;padding-top:1px;">';
          echo '  <div class="slideStatus"><span  style="font-weight: bolder;">'.i18n('done').'</span></div>';
          echo '</div>';
          
           echo '<div class="mySlides fade" style="'.(($idle==1)?'display:block;':'display:none;').'margin-top:9px;padding-top:1px;">';
           echo   '<div class="slideStatus" ><span style="font-weight: bolder;">'.i18n('colIdle').'</span></div>';
           echo '</div>';

           echo '</div>';
         echo ' </td>';
         echo ' <td style="width:12%;height:100%;" >';
         echo '<div  id="'.$refType.'_'.$refId.'_next_'.$id.'" class="next" style="'.(($id==0 or ($idle==1) or ($rightUpdate=="NO" and $rightRead=='YES'))?'display:none':'').'"  onclick="'.(($id!=0 and  $rightUpdate=='YES')?"nextSlides('next',".$id.",'".$refType."',".$refId.");":"").'">&#10095;</div>';
         echo ' </td>';
       echo '</tr>';
     echo '</table>';
     echo '</div>';
  }
  
  
  static function drawAllSubTask($idProject,$idResource,$elementType,$idVersion){
    $tab= array();
    $subTask= new SubTask();
    $ticket=new Ticket();
    $action=new Action();
    $activity=new Activity();
    $user=getSessionUser();
   
    
    $tableName=$subTask->getDatabaseTableName();
    $showClosedSubTask=(Parameter::getUserParameter('showClosedSubTask_Global')!='' and Parameter::getUserParameter('showClosedSubTask_Global')!='0')?true:false;
    $showDoneSubTask=((Parameter::getUserParameter('showDoneSubTask_Global')!='0') or $showClosedSubTask==true)?true:false;
    $query="SELECT DISTINCT  $tableName.refId as refid, $tableName.refType as reftype FROM $tableName ";
    $query.="WHERE 1=1";
    if($idProject!=0){
      $lstProj=$idProject;
      $idProjects=explode(',', $idProject);
      $idProjectsFlip=array_flip($idProjects);
      foreach ($idProjects as $id=>$idP){
        $proj=new Project($idP);
        $sub=$proj->getRecursiveSubProjectsFlatList();
        if(!empty($sub)){
          foreach ($sub as $id=>$subproj){
            if(array_key_exists($id, $idProjectsFlip))continue;
            $lstProj.=",".$id;
          }
        }
      }
      $query.=" and  $tableName.idProject in (".$lstProj.")";
    }else {
      $visibleProject= transformListIntoInClause($user->getVisibleProjects());
      $query.=" and  $tableName.idProject in ".$visibleProject;
    }
    if($idResource!=0)$query.=" and  $tableName.idResource = ".$idResource;
    if(trim($elementType)!=''){
      $query.=" and  $tableName.refType = '".$elementType."'";
    }

    if($idResource!=0){
      $query.=" and  $tableName.idResource = ".$idResource;
      if($showClosedSubTask!=1)$query.=" and  $tableName.idle = 0";
    }
    if ($idVersion!=0)$query.=" and  $tableName.idTargetProductVersion = ".$idVersion;
    $result=Sql::query($query);
    while ($line = Sql::fetchLine($result)) {
      $tab[]=$line;
    }
    $priority=new Priority();
    $allPrio=$priority->getSqlElementsFromCriteria(null,null,"1=1");
    foreach ($allPrio as $id=>$priority){
      echo '<input id="colorPrio_'.$priority->id.'" value="'.$priority->color.'" type="hidden" />';
    }
    if(!empty($tab)){
      foreach ($tab as $id=>$obj){
        $element= new $obj['reftype']( $obj['refid']);
        //$menName= new Menu($element->idMenu);
        $rightUpdate=securityGetAccessRightYesNo('menu'.get_class($element),'update',$element);
        $rightRead=securityGetAccessRightYesNo('menu'.get_class($element),'read',$element);
        if (($element->idle==1) or ($rightUpdate=='NO' and $rightRead=='NO') or (!$rightUpdate and !$rightRead))continue;
        if(!$showClosedSubTask and !$showDoneSubTask and $element->done==1){
          $cpST=$subTask->countSqlElementsFromCriteria(array("refType"=>$obj['reftype'],"refId"=>$element->id,"idle"=>'0'));
          if ($cpST==0)continue;
        }
        $goto="";
        $style="";
        $draw='';
        $version=(property_exists(get_class($element), 'idTargetProductVersion') and $element->idTargetProductVersion!='')?new ProductVersion($element->idTargetProductVersion):'&nbsp;-';
        if ( securityCheckDisplayMenu(null, get_class($element)) and $rightRead=="YES") {
          $goto=' onClick="gotoElement(\''.$obj['reftype'].'\',\''.htmlEncode($element->id).'\');" ';
          $style='cursor: pointer;';
        }
        
          echo '<table style="width:95%; margin-bottom:10px;">';
            echo '<tr style="height:42px;"><td colspan="4" ><div dojotype="dijit.layout.ContentPane" class="dijitContentPane">';
              echo'<table style="width:100%;"><tr>';
                    echo '<td style="width:63%;">';
                      echo '<div class="reportHeader" style="width:100%;height:42px;border-radius:unset!important;"><span style="margin-left:25px;float:left;padding-top:12px;'.$style.'" class="classLinkName" '.$goto.'>'
                          .ucfirst($obj['reftype']).'&nbsp#'.$element->id.'&nbsp-&nbsp'.$element->name.'&nbsp;'.((property_exists(get_class($element), 'idTargetProductVersion'))? '|&nbsp;'.ucfirst(i18n('colVersion')).':&nbsp;'.(($element->idTargetProductVersion!='')?$version->name:$version):"").'</span></div>';
                    echo '</td>';
                    echo '<td style="width:23%;">';
                       echo '<div class="reportHeader" style="width:100%;height:42px;border-radius:unset!important;vertical-align:middle;">';
                        echo      '<select dojoType="dijit.form.FilteringSelect" id="idStatusElement_'.$obj['reftype'].'_'.$element->id.'" name="idStatusElement_'.$obj['reftype'].'_'.$element->id.'" '.(( $rightUpdate=='NO' and $rightRead=="YES")?'readonly="true"':'').'
                                  style="width:auto;margin-top:7px;" class="input" onChange="saveActivityValueFilter(\'Status\',\''.$obj['reftype'].'\','.$element->id.'); "  '.autoOpenFilteringSelect().'>';
                          htmlDrawOptionForReference('idStatus',$element->idStatus,$element);
                        echo      '</select>';
                       echo '</div>';
                       echo      '<input id="idOldStatusElement_'.$obj['reftype'].'_'.$element->id.'" value="'.$element->idStatus.'" type="hidden" />';
                    echo '</td>';
                    echo '<td style="width:14%;">';
                       echo '<div class="reportHeader" style="width:100%;height:42px;border-radius:unset!important;vertical-align:middle;">';
                        echo      '<select dojoType="dijit.form.FilteringSelect" id="idResourceElement_'.$obj['reftype'].'_'.$element->id.'" name="idResourceElement_'.$obj['reftype'].'_'.$element->id.'" '.(( $rightUpdate=='NO' and $rightRead=="YES")?'readonly="true"':'').'
                            style="width:auto;margin-top:7px;" class="input" onChange="saveActivityValueFilter(\'Resposible\',\''.$obj['reftype'].'\','.$element->id.');" '.autoOpenFilteringSelect().' >';
                          htmlDrawOptionForReference('idResource',$element->idResource,$element);
                        echo      '</select>';
                       echo '</div>';
                       echo      '<input id="idOldResourceElement_'.$obj['reftype'].'_'.$element->id.'" value="'.$element->idResource.'" type="hidden" />';
                     echo '</td >';
              echo'</tr></table>';
            echo '</div></td></tr>';
            SubTask::drawSubtasksForObject($element, $obj['reftype'],  $obj['refid'],$rightUpdate,$rightRead,null,$idResource,true);
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
