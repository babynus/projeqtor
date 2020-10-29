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
 * Presents left menu of application. 
 */
  require_once "../tool/projeqtor.php";

$displayMode=Parameter::getUserParameter('menuLeftDisplayMode');
?>

<div id="menuLeftBarContaineur" class="container"  dojoType="dijit.layout.BorderContainer" liveSplitters="false" >

  <div id="menuBArNewGuiAcces"  class="container"  dojoType="dijit.layout.BorderContainer" region="left"  style="width:32px;height:100%;">
    <div id="breadScrumb"  dojoType="dijit.layout.ContentPane"  region="center" style="height:65%;" >
    </div>
    <div id="menuPersonalAcces"  onresize="showBottomLeftMenu();"  dojoType="dijit.layout.ContentPane" region="bottom" style="height:35%;overflow: hidden;" >
      <div id="iconsBottomSize" onresize="">
        <div id="buttonParameter" class="iconParameter iconSize22 iconBreadSrumb" onclick="showBottomContent('Parameter')"  title="<?php echo i18n('menuParameter');?>"></div>
        <div id="buttonLink" class="iconLink iconSize22 iconBreadSrumb" onclick="showBottomContent('Link')" title="<?php echo i18n('ExternalShortcuts');?>"></div>
        <?php if (securityCheckDisplayMenu(null,'Document')) {?>
        <div title="<?php echo i18n('document');?>" id="buttonDocument" class="iconDocument iconSize22 iconBreadSrumb" onclick="showBottomContent('Document')"></div>
        <?php }?>
        <div id="buttonConsole" class="iconConsole iconSize22 iconBreadSrumb" onclick="showBottomContent('Console')"  title="<?php echo i18n('Console');?>"></div>
        <?php if(securityCheckDisplayMenu(null,'Notification') and isNotificationSystemActiv()){?>
        <div id="buttonNotification" class="iconNotification  iconSize22 iconBreadSrumb" onclick="showBottomContent('Notification')"  title="<?php echo i18n('accordionNotification');?>"></div>
        <?php }?>
      </div>
    </div>
  </div>
  <div id="menuBarAccesLeft"  class="container"  dojoType="dijit.layout.BorderContainer" region="center"  >
    <div id="menuBarAccesTop" class="" dojoType="dijit.layout.ContentPane"  region="center" style="height:65%;overflow-x: hidden;" oncontextmenu="event.preventDefault();showIconLeftMenu('Icon')" >
      <nav id="ml-menu" class="menu">
      <input id="displayModeLeftMenu" value="<?php echo $displayMode;?>" style="visibility:hidden"; >
            <?php // draw Menus
             echo drawLeftMenuListNewGui($displayMode);
            ?>
      </nav>
	  <script>
	  var x = 0;
	  function myFunction() {
	    var txt = x += 1;
	    document.getElementById("demo").innerHTML = txt;
	  }
	   (function() {
	     var menuEl = dojo.byId('ml-menu'),
			mlmenu = new MLMenu(menuEl, {
				initialBreadcrumb : 'Accueil', // initial breadcrumb text
				backCtrl : false, // show back button
			});
	    })();
	   new menuLeft( dojo.byId( 'mainDiv' ) );
	  </script>
    </div>
    <?php $viewSelect=Parameter::getUserParameter('bottomMenuDivItemElect');?>
    <div id="menuBarAccesBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:35%;">
      <div class="container" style="height:98%;width:100%;">
         <div id="loadDivBarBottom" style="height:100%;display:<?php echo ($viewSelect=='Console')?'none':'block';?>;">
           <?php
           $viewSelect='Notification';
           ?>
           <div id="parameterDiv" class="menuBottomDiv" dojoType="dijit.layout.ContentPane" style="display:<?php echo ($viewSelect=='Parameter')?'block':'none';?>;">
              <?php //include "../view/menuBottomParameter.php;"?>
           </div>
           <div id="projectLinkDiv" class="menuBottomDiv" dojoType="dijit.layout.ContentPane" style="display:<?php echo ($viewSelect=='Link')?'block':'none';?>;">
              <?php // include "../view/shortcut.php;"?>
           </div>
           <div id="documentsDiv"  class="menuBottomDiv" dojoType="dijit.layout.ContentPane" style="display:<?php echo ($viewSelect=='Document')?'block':'none';?>;">
              <div dojoType="dojo.data.ItemFileReadStore" id="directoryStore" jsId="directoryStore" url="../tool/jsonDirectory.php"></div>
              <div style="position: absolute; float:right; right: 5px; cursor:pointer;"
                title="<?php echo i18n("menuDocumentDirectory");?>"
                onclick="if (checkFormChangeInProgress()){return false;};loadContent('objectMain.php?objectClass=DocumentDirectory','centerDiv');"
                class="iconDocumentDirectory22">
              </div>
              <div dojoType="dijit.tree.ForestStoreModel" id="directoryModel" jsId="directoryModel" store="directoryStore"
               query="{id:'*'}" rootId="directoryRoot" rootLabel="Documents"
               childrenAttrs="children">
              </div>             
              <div dojoType="dijit.Tree" id="documentDirectoryTree" model="directoryModel" openOnClick="false" showRoot='false'>
                <script type="dojo/method" event="onClick" args="item">;
                  if (checkFormChangeInProgress()){return false;}
                  loadContent("objectMain.php?objectClass=Document&Directory="+directoryStore.getValue(item, "id"),"centerDiv");
                </script>
              </div>
           </div>
           <?php 
           if( securityCheckDisplayMenu(null,'Notification') and isNotificationSystemActiv()){
           ?>
           <div id="notificationBottom" class="menuBottomDiv" dojoType="dijit.layout.ContentPane" style="display:<?php echo ($viewSelect=='Notification')?"block":"none";?>;height:100%" >
                <div dojoType="dojo.data.ItemFileReadStore" 
                     id="notificationStore" 
                    jsId="notificationStore" url="../tool/jsonNotification.php" >
                </div>
                <div style="position: absolute; float:right; right: 5px; cursor:pointer;"
                     title="<?php echo i18n("notificationAccess");?>"
                     onclick="if (checkFormChangeInProgress()){return false;};loadContent('objectMain.php?objectClass=Notification','centerDiv');"
                     class=" iconNotification iconSize22" >
                </div>
                <div style="position: absolute; float:right; right: 45px; cursor:pointer;"
                     title="<?php echo i18n("notificationRefresh");?>"
                     onclick="if (checkFormChangeInProgress()){return false;};refreshNotificationTree(true);"
                     class="iconRefresh iconSize22">
                </div>
                <div dojoType="dijit.tree.ForestStoreModel" id="notificationModel" jsId="notificationModel" store="notificationStore"
                     query="{id:'*'}" rootId="notificationRoot" rootLabel="Notifications"
                     childrenAttrs="children" > 
                </div>             
                 <div dojoType="dijit.Tree" id="notificationTree" model="notificationModel" openOnClick="false" showRoot='false' style="height:100%">
                    <script type="dojo/method" event="onLoad" args="evt">;
                        var cronCheckNotification = <?php echo Parameter::getGlobalParameter('cronCheckNotifications'); ?>;
                        var intervalNotificationTreeDelay = cronCheckNotification*1000;
                        var intervalNotificationTree = setInterval(function() { refreshNotificationTree(true);},intervalNotificationTreeDelay);
                    </script>
                    <script type="dojo/method" event="onClick" args="item">;
                        if (notificationStore.getValue(item, "objClass")==="") {return false;}
                        if (checkFormChangeInProgress()){return false;}
                        var objectId = "";
                        var objClass = notificationStore.getValue(item, "objClass");
                        if (objClass=="NotificationManual") {
                                objClass="Notification";                            
                        }
                        if (notificationStore.getValue(item, "objId")!=="") {
                            objectId = notificationStore.getValue(item, "objId");
                            gotoElement(objClass, objectId, true);
                        } else {
                            loadContent("objectMain.php?objectClass="+objClass,"centerDiv");
                        }                            
                    </script>
                    <script type="dojo/method" event="getIconClass" args="item">
                        if (item == this.model.root) {
                          return "checkBox";
                        } else {
                            var isTotal = notificationStore.getValue(item,"isTotal");
                            if (isTotal==="YES") {
                                var totalCount = notificationStore.getValue(item,"count");

                                if (totalCount==0) {
                                    document.getElementById("notificationTree").style.visibility = "hidden";
                                    document.getElementById("menuBarNotificationCount").style.visibility = "hidden";
                                    document.getElementById("drawNotificationUnread").style.visibility = "hidden";
                                    document.getElementById("countNotifications").style.visibility="hidden";
                                } else {
                                    // Show and Update the Notification count in menuBar
                                    document.getElementById("notificationTree").style.visibility = "visible";
                                    document.getElementById("countNotifications").style.visibility="visible";
                                    document.getElementById("menuBarNotificationCount").style.visibility = "visible";
                                    document.getElementById("countNotifications").innerHTML = totalCount;
                                }
                                loadContent("../view/menuNotificationRead.php", "drawNotificationUnread");  
                            }
                            
                            return notificationStore.getValue(item, "iconClass");
                        }
                    </script>
                </div>
              </div>
           <?php 
           }           
           ?>
           </div>
           <div id="messageDivNewGui" class="messageDivNewGui" style="display:<?php echo ($viewSelect=='Console')?'block':'none';?>;height:95%;"></div>
      </div>
    </div>
  </div>
</div>

<?php 
// functions

function sortMenus(&$listMenus, &$result, $parent,$level ){
  $level++;
  foreach ($listMenus as $id=>$menu){
    if($menu->idParent == $parent){
      if ($menu->idParent=='') {
      	$menu->idParent=0;
      }
      $key=$level.'-'.numericFixLengthFormatter($menu->idParent,5).'-'.numericFixLengthFormatter($menu->sortOrder,5);
      $result[$key] = array('level'=>$level,'objectType'=>'menu','object'=>$menu);
      sortMenus($listMenus, $result, $menu->id,$level);
    }
  }
}

function storReport($listReport, &$res, $lstNewNavMenu, $idMenuReport, $level ) { //store report 
    $count=array();
    $isNewPId=array();
    $levelParent=$level-1;
    $levelSub=$level+1;
    foreach ($listReport as $id=>$report){
        $file=substr($report->file, 0,strpos($report->file, '.php'));
        $idParent=$idMenuReport->id.$levelParent.$report->idReportCategory;
        if(in_array($file, $lstNewNavMenu)){
            if(!isset($count[$file])){
              
              $keyParent=$level.'-'.numericFixLengthFormatter($report->idReportCategory,5).'-'.numericFixLengthFormatter($report->sortOrder,5);
              $isNewPId[$file]=$report->idReportCategory.$level.$report->sortOrder;
              $obj= array('id'=>$isNewPId[$file],'name'=>$file,'idParent'=>$idParent);
              $res[$keyParent]=array('level'=>$level,'objectType'=>'report','object'=>$obj);
            }
            $count[$file]=1;
            $key=$levelSub.'-'.numericFixLengthFormatter($isNewPId[$file],5).'-'.numericFixLengthFormatter($report->sortOrder,5);
            $obj= array('id'=>$report->id,'name'=>$report->name,'idParent'=>$isNewPId[$file],'idMenu'=>$report->idReportCategory);
            $res[$key]=array('level'=>$level,'objectType'=>'reportDirect','object'=>$obj);
         }else{
          $keyParent=$level.'-'.numericFixLengthFormatter($report->idReportCategory,5).'-'.numericFixLengthFormatter($report->sortOrder,5);
          $obj= array('id'=>$report->id,'name'=>$report->name,'idParent'=>$idParent,'idMenu'=>$report->idReportCategory);
          $res[$keyParent]=array('level'=>$level,'objectType'=>'reportDirect','object'=>$obj);
         }
    }
}


function getReportMenu(){
  // ===============list of all reportCategories by user profil;
  $level=2;
  $hr=new HabilitationReport();
  $user=getSessionUser();
  $allowedReport=array();
  $allowedCategory=array();
  $lst=$hr->getSqlElementsFromCriteria(array('idProfile'=>$user->idProfile, 'allowAccess'=>'1'), false);
  $res=array();
  $listCateg=SqlList::getList('ReportCategory');
  $idMenuReport=SqlElement::getSingleSqlElementFromCriteria('Navigation', array('name'=>'navReports','idParent'=>null,'idMenu'=>null));
  foreach ($lst as $h) {
    $report=$h->idReport;
    $nameReport=SqlList::getNameFromId('Report', $report, false);
    if (! Module::isReportActive($nameReport)) continue;
    $allowedReport[$report]=$report;
    $category=SqlList::getFieldFromId('Report', $report, 'idReportCategory',false);
    $allowedCategory[$category]=$category;
  }
  $c=1;
  foreach ($listCateg as $id=>$name) {
    if (isset($allowedCategory[$id])) {
      $c++;
      $lstIdCate[]=$id;
      $idReport=$idMenuReport->id.$level.$id;
      $key=$level.'-'.numericFixLengthFormatter($idMenuReport->id,5).'-'.numericFixLengthFormatter($c,5);
      $obj= array('id'=>$idReport,'name'=>$name,'idParent'=>$idMenuReport->id);
      $res[$key]=array('level'=>$level,'objectType'=>'report','object'=>$obj);
    }
  }
  //===================
  //=================== lis of all report dependant of this categoryies

   $level++;
   $reportDirect= new Report();
   $where=" idReportCategory in (".implode(",", $lstIdCate).")";
   $reportList= $reportDirect->getSqlElementsFromCriteria(null,false,$where,"file");
   $nameFile=SqlList::getList('report','file');
   $lstReportName=array();
   $lstNewNavMenu=array();
   foreach ($nameFile as $idN=>$nameFile){
    $lstReportName[]=substr($nameFile, 0,strpos($nameFile, '.php'));
   }
   $countNameFil=array_count_values($lstReportName);
   foreach ($countNameFil as $name=>$val){
    if($val==1)unset($countNameFil[$name]);
    else $lstNewNavMenu[]=$name;
   }
   storReport($reportList,$res, $lstNewNavMenu,$idMenuReport, $level);
  return $res;
 
}


function getNavigationMenuLeft (){
  $level=0;
  $result=array();
  $nav=new Navigation();
  $isLanguageActive=(Parameter::getGlobalParameter('displayLanguage')=='YES')?true:false;
  $contexctMenuMain=$nav->getSqlElementsFromCriteria(null, false,null,'id asc');
  sortMenus($contexctMenuMain,$result,0,$level);
  foreach ($result as $id=>$context){
      $context=$context['object'];
      if($context->idParent!=0 and $context->idMenu!=0){
        $unset=false;
        $menu=new Menu($context->idMenu);
        if (!isNotificationSystemActiv() and strpos($menu->name, "Notification")!==false) $unset=true; 
        if (! $menu->canDisplay() )  $unset=true;
        if (!$isLanguageActive and $menu->name=="menuLanguage")  $unset=true;
        if (!Module::isMenuActive($menu->name))  $unset=true;
        if (!securityCheckDisplayMenu($menu->id,substr($menu->name,4))) $unset=true;
        if($unset==true)unset($result[$id]);
      }
  }
  $result=array_merge ($result,getReportMenu());
  ksort($result);
  
  return $result;
}


function drawLeftMenuListNewGui($displayMode){
  $result='';
  $old="";
  $idP="";
  $maineDraw=false;
  $allMenu=getNavigationMenuLeft();
  $result.='<div class="menu__wrap">';
  $displayIcon=($displayMode=='TXT')?"display:none;":"display:block;";
  
   foreach ($allMenu as $id=>$menu){
    
    if($menu['objectType']=='report' or $menu['objectType']=='reportDirect'){
      $obj=new Navigation();
      $obj->id=$menu['object']['id'];
      $obj->idParent=$menu['object']['idParent'];
      $obj->name=$menu['object']['name'];
      $obj->idMenu=($menu['objectType']=='reportDirect')?$menu['object']['idMenu']:0;
      if($menu['objectType']=='reportDirect'){
        $file=(isset($menu['object']['file']))?$menu['object']['file']:'';
      }
    }else{
      $obj=$menu['object'];
    }
    if($old!=$menu['level'] and $menu['level']==1 and $maineDraw!=true){
      $maineDraw=true;
      $result.='<ul data-menu="main" class="menu__level" tabindex="-1" role="menu" >';
    }
    if ( ($old!=$menu['level'] or ($old==$menu['level'] and $idP!=$obj->idParent)) and $menu['level']!=1 ){
      $result.='</ul>';
      $nameLink='submenu-'.$obj->idParent;
      $result.='<ul data-menu="'.$nameLink.'" id="'.$nameLink.'" class="menu__level" tabindex="-1" role="menu" >';
    }
    if($obj->idParent!=0 and $obj->idMenu!=0){
      if( $menu['objectType']!='reportDirect'){
        $realMenu=new Menu($obj->idMenu);
        $menuName=$realMenu->name;
        $menuNameI18n = i18n($menuName);
        $menuName2 = addslashes(i18n($menuName));
        $classEl=substr($menuName,4);
        $isFav=SqlElement::getSingleSqlElementFromCriteria('MenuCustom', array("name"=>$obj->name));
        if($realMenu->type=='item'){
          $funcOnClick="loadMenuBarItem('".$classEl."','".htmlEncode($menuName2,'quotes')."','bar');";
        }else{
           $funcOnClick="loadMenuBarObject('".$classEl."','".htmlEncode($menuName2,'bar')."','bar');";
        }
        if($isFav->id==''){
          $mode='add';
          $class="menu__add__Fav";
          $styleDiv="display:none;";
        }else{
          $mode='remove';
          $class="menu__as__Fav";
        }
        $styleDiv="display:none;";
        $funcuntionFav="addRemoveFavMenuLeft('div".$obj->id."', '".$obj->name."','".$mode."','".$menu['objectType']."');";
        
        $result.='<li class="menu__item" role="menuitem" onmouseenter="checkClassForDisplay(\'div'.$obj->id.'\',\'enter\');" onmouseleave="checkClassForDisplay(\'div'.$obj->id.'\',\'leave\');">';
        $result.='<a class="menu__linkDirect" onclick="'.$funcOnClick.'" href="#" id="'.$obj->name.'" ><div class="icon'.$classEl.' iconSize16" style="'.$displayIcon.'position:relative;float:left;margin-right:10px;"></div>'.ucfirst(i18n($obj->name)).'</a>';
        $result.='<div id="div'.$obj->id.'" style="'.$styleDiv.'" class="'.$class.'" onclick="'.$funcuntionFav.'" ></div></li>';
    }else{
      $classEl="Reports";
      $funcOnClick="loadMenuReportDirect(".$obj->idMenu.",".$obj->id.")";
      
      if($isFav->id==''){
        $mode='add';
        $class="menu__add__Fav";
        $styleDiv="display:none;";
      }else{
        $mode='remove';
        $class="menu__as__Fav";
      }
      $funcuntionFav="addRemoveFavMenuLeft('div".$obj->id."', '".$obj->name."','".$mode."','".$menu['objectType']."');";
      $styleDiv="display:none;";
      $class="menu__add__Fav";
      $result.='<li class="menu__item" role="menuitem" onmouseenter="checkClassForDisplay(\'div'.$obj->id.'report\',\'enter\');" onmouseleave="checkClassForDisplay(\'div'.$obj->id.'report\',\'leave\');">';
      $result.='<input type="hidden" id="reportFileMenu" value="'.$file.'"/>';
      $result.='<a class="menu__linkDirect" onclick="'.$funcOnClick.'" href="#" id="'.$obj->name.'" ><div class="icon'.$classEl.' iconSize16" style="'.$displayIcon.'position:relative;float:left;margin-right:10px;"></div>'.ucfirst(i18n($obj->name)).'</a>';
      $result.='<div id="div'.$obj->id.'report" style="'.$styleDiv.'" class="'.$class.'" onclick="'.$funcuntionFav.'" ></div></li>';
    }
  }else{
      $sub='submenu-'.$obj->id;
      $result.='<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="'.$sub.'" aria-owns="'.$sub.'" href="#" id="'.$obj->name.'">
                                <div class="icon'.(($menu['objectType']=='menu')?substr($obj->name,3):$obj->name).' iconSize16" style="'.$displayIcon.'position:relative;float:left;margin-right:10px;"></div>'.ucfirst((($menu['objectType']=='menu')?i18n(substr($obj->name,3)):$obj->name)).'</a>
                            <div id="currentDiv'.$obj->name.'" class="div__link" ></div></li>';
    }
    $old=$menu['level'];
    $idP=$obj->idParent;
   }
  $result.='</div">';
  return $result;
}
  

?>