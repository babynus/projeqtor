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
 * Habilitation defines right to the application for a menu and a profile.
 */ 
require_once('_securityCheck.php');
class DocumentRight extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $idDocumentDirectory;
  public $idProfile;
  public $idAccessMode;
  
  
  
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

  
 static function drawAllDocumentRight(){
   $columnList=SqlList::getList('profile');
   $nbProf=count($columnList);
   $user=getSessionUser();
   $dR=new DocumentRight();
   $lstDocRDraw=array();
   $where='1=1';
   $lstDocR=$dR->getSqlElementsFromCriteria(null,null,$where,'idDocumentDirectory');
   $documentDirectory= new DocumentDirectory();
   $classDirectory=get_class($documentDirectory);
   $lstDocDirectoty=$documentDirectory->getSqlElementsFromCriteria(null,null,$where,'name');
   $destinationWidth=((RequestHandler::getNumeric('destinationWidth')*0.90)*0.98)-5;
   $widthSelect=intval($destinationWidth/($nbProf+2));
   if(!empty($lstDocDirectoty)){
     echo '<table style="width:100%;height:100%;margin-top:45px;">';
     echo '   <tr>';
     echo '    <td>';
     echo '     <div style="width:98%;height:100%; overflow-x:auto;  overflow-y:hidden;margin-bottom:10px;margin-right:5%;margin-left:5%;">';
     echo '       <table class="crossTable" >';
     echo '         <tr><td class="tabLabel">'.i18n('colName').'</td><td class="tabLabel">'.i18n('colIdDocumentDirectory').'</td>';
                      foreach ($columnList as $col) {
     echo '             <td class="tabLabel">' . $col . '</td>';
                      }
     echo '         </tr>';
                    foreach ($lstDocDirectoty as $id=>$docD){

                      $rightUpdate=securityGetAccessRightYesNo('menu'.$classDirectory,'update',$docD);
                      $rightRead=securityGetAccessRightYesNo('menu'.$classDirectory,'read',$docD);
                      if($rightUpdate=="YES" or $rightRead=="YES"){
                        $cp=0;
                        $goto='';
                        $style='';
                        if ( securityCheckDisplayMenu(null, $classDirectory) and $rightRead=="YES") {
                          $goto=' onClick="gotoElement(\''.$classDirectory.'\',\''.htmlEncode($docD->id).'\');" ';
                        }
                        echo '         <tr>';
                        echo '            <td class="crossTableLine" title="'.$docD->name.'" style="padding-right:10px;"><label class="label classLinkName " '.$goto.' style="text-align :center;">'.$docD->name .'</label></td>';
                        echo '           <td class="crossTableLine" title="'.$docD->name.'" style="padding-right:10px;"><label class="label classLinkName " '.$goto.' style="text-align :center;">'.$docD->location.'</label></td>';
                          foreach ($lstDocR as $idR=>$docR){
                            if($docD->id==$docR->idDocumentDirectory){
                                $lstDocRDraw[]=$docR->id;
                                $cp++;
                                $name="documentRight_" . $docR->id ;
                                echo '<td class="crossTablePivot">';
                                echo '  <select dojoType="dijit.form.FilteringSelect" class="input" '.(($rightUpdate=='NO' and $rightRead=='YES')?"readonly":"");
                                echo      autoOpenFilteringSelect();
                                echo '    style="width:'.$widthSelect.'px; font-size: 80%;" id="' . $name . '" name="' . $name . '" >';
                                htmlDrawOptionForReference('idAccessProfile', $docR->idAccessMode, null, true);
                                echo '  </select>';
                                echo '</td>';
                                if($cp==$nbProf)break;
                            }
                          }
                        echo '         </tr>';
                      }
                    }
     
     echo '       </table>';
     if(!empty($lstDocRDraw))echo '         <input id="lstDocRight" name="lstDocRight" value="'.implode(',',$lstDocRDraw).'" type="hidden" />';
     if(empty($lstDocRDraw))echo '<div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;border-right: 1px solid grey;">'.i18n('noDataFound').'</div>';
     echo '     </div>';
     echo '    </td>';
     echo '   </tr>';
     echo '</table>';
   }else {
     echo '<table style="width:90%; margin-bottom:10px;margin-right:5%;margin-left:5%;margin-top:15px;">';
     echo '   <tr>';
     echo '    <td >';
     echo '    <div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;width:100%;border-right: 1px solid grey;">'.i18n('noDataFound').'</div>';
     echo '    </td>';
     echo '   </tr>';
     echo '</table>';
   }

 return ;
  }
  
  static  function drawDocumentRight($docDirect,$rightRead,$rightUpdate) {
    $columnList=SqlList::getList('profile');
    $nbProf=count($columnList);
    $lstDocRDraw=array();
    $accesR=false;
    $dR=new DocumentRight();
    $classDR=get_class($dR);
    if($docDirect->id!='' ){
      $where="idDocumentDirectory=$docDirect->id";
      $lstDocR=$dR->getSqlElementsFromCriteria(null,null,$where);
    }
    if($docDirect->id=='' or empty($lstDocR)){
      $accesR=true;
      $where="idMenu=102";
      $accessRight=new AccessRight();
      $lstDocR=$accessRight->getSqlElementsFromCriteria(null,null,$where);
    }
    $destinationWidth=((RequestHandler::getNumeric('destinationWidth')*0.98)*0.93)-5;
    $widthButton=intval($destinationWidth/4);
    $widthSelect=intval($destinationWidth/($nbProf+2));
     echo '<tr><td colspan="4"><div id="documenDirectory" dojotype="dijit.layout.ContentPane" >';
     if ( securityCheckDisplayMenu(null, $classDR) and $rightRead=="YES") {
       $menu=SqlElement::getSingleSqlElementFromCriteria('Menu', array("id"=>258));
       $goto=' onClick="loadMenuBarItem(\''.$classDR.'\',\''.htmlEncode(addslashes(i18n($menu->name)),'quotes').'\',\'bar\');showMenuBottomParam('.$classDR.',\'false\');" ';
       echo '<tr><td colspan="4">';
       echo '   <div class="roundedVisibleButton roundedButton generalColClass" style="width:'.$widthButton.'px;text-align: left;position: relative; margin-top: 30px;height: 25px;margin-left: 47px" '.$goto.'>';
       echo '     <img src="css/customIcons/new/iconMoveTo.svg" class="imageColorNewGui" style="position:relative;left:5px;top:2px;top:4px;width:16px;height:16px">';
       echo '     <div style="position:relative;top:-16px;left:25px;">'.i18n('menuDocumentRight').'</div>';
       echo '   </div>';
     }
     echo '<table style="width:100%">';
     
     echo '   <tr>';
     echo '    <td>';
     echo '     <div style="width:'.$destinationWidth.'px; overflow-x:auto;  overflow-y:hidden; text-align: -webkit-center;">';
     echo '       <table class="crossTable" >';
                      foreach ($columnList as $col) {
     echo '             <td class="tabLabel" style="width:'.$widthSelect.'px;">' . $col . '</td>';
                      }
     echo '         </tr>';
     echo '         <tr>';
                        foreach ($lstDocR as $idR=>$docR){
                            $name="documentRight_" . $docR->idProfile ;
                            echo '<td class="crossTablePivot">';
                            echo '  <select dojoType="dijit.form.FilteringSelect" class="input" '.(($rightUpdate=='NO' and $rightRead=='YES')?"readonly":"");
                            echo      autoOpenFilteringSelect();
                            echo '    style=" width:'.$widthSelect.'px;font-size: 80%;" id="' . $name . '" name="' . $name . '" >';
                            htmlDrawOptionForReference('idAccessProfile', (($docDirect->id!='' and !$accesR)?$docR->idAccessMode:$docR->idAccessProfile), null, true);
                            echo '  </select>';
                            echo '</td>';
                        }
     echo '         </tr>';
     echo '       </table>';
     echo '         <input id="lstDocRight" name="lstDocRight" value="'.implode(',',array_flip($columnList)).'" type="hidden" />';
     echo '     </div>';
     echo '    </td>';
     echo '   </tr>';
     echo '   <tr>';
     echo '   </tr>';
     echo '</table>';
     echo '</div></td></tr>';
     echo '</td></tr>';
  }
  

}
?>