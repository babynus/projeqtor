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
    <div id="menuPersonalAcces"   dojoType="dijit.layout.ContentPane" region="bottom" style="height:35%;overflow: initial;" >
      <div id="buttonParameter" class="iconParameter iconSize22 iconBreadSrumb" onclick=""></div>
      <div id="buttonActivityStream" class="iconActivityStream iconSize22 iconBreadSrumb" onclick=""></div>
      <div id="buttonFlux" class="iconHome iconSize22 iconBreadSrumb" onclick=""></div>
      <div id="buttonDocument" class="iconDocument iconSize22 iconBreadSrumb" onclick=""></div>
      <div id="buttonConsole" class="iconHome iconSize22 iconBreadSrumb" onclick=""></div>
      <div id="buttonNotification" class="iconNotification  iconSize22 iconBreadSrumb" onclick=""></div>
    </div>
  </div>
  <div id="menuBarAccesLeft"  class="container"  dojoType="dijit.layout.BorderContainer" region="center"  >
    <div id="menuBarAccesTop" class="" dojoType="dijit.layout.ContentPane"  region="center" style="height:65%;overflow: hidden;" oncontextmenu="event.preventDefault();showIconLeftMenu('Icon')" >
      <nav id="ml-menu" class="menu">
      <input id="displayModeLeftMenu" value="<?php echo $displayMode;?>" style="visibility:hidden"; >
            <?php // draw Menus
             echo drawLeftMenuListNewGui($displayMode);
            ?>
      </nav>
	  <script>
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
    <div id="menuBarAccesBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:35%;">
    </div>
  </div>
</div>

<?php 
// functions

function sortMenus(&$listMenus, &$result, $parent,$level ){
  $level++;
  foreach ($listMenus as $id=>$menu){
    if($menu->idParent == $parent){
      $key=$level.'-'.$menu->idParent.'-'.$menu->sortOrder;
      $result[$key] = array('level'=>$level,'object'=>$menu);
      sortMenus($listMenus, $result, $menu->id,$level);
    }
  }
}

function getNavigationMenuLeft (){
  $level=0;
  $result=array();
  $nav=new Navigation();
  $isLanguageActive=(Parameter::getGlobalParameter('displayLanguage')=='YES')?true:false;
  $contexctMenuMain=$nav->getSqlElementsFromCriteria(null, false,null,'id asc');
  sortMenus($contexctMenuMain,$result,0,$level);
  ksort($result);


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
    $obj=$menu['object'];
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
        $styleDiv="display:block;";
      }
      $funcuntionFav="addRemoveFavMenuLeft('div".$obj->id."', '".$obj->name."','".$mode."');";
      
      $result.='<li class="menu__item" role="menuitem" onmouseenter="checkClassForDisplay(\'div'.$obj->id.'\',\'enter\');" onmouseleave="checkClassForDisplay(\'div'.$obj->id.'\',\'leave\');">';
      $result.='<a class="menu__linkDirect" onclick="'.$funcOnClick.'" href="#" id="'.$obj->name.'" ><div class="icon'.$classEl.' iconSize16" style="'.$displayIcon.'position:relative;float:left;margin-right:10px;"></div>'.i18n($obj->name).'</a>';
      $result.='<div id="div'.$obj->id.'" style="'.$styleDiv.'" class="'.$class.'" onclick="'.$funcuntionFav.'" ></div><div id="currentDiv'.$obj->name.'" class="div__link"></div></li>';
}else{
      $sub='submenu-'.$obj->id;
      $result.='<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="'.$sub.'" aria-owns="'.$sub.'" href="#" id="'.$obj->name.'"><div class="icon'.substr($obj->name,3).' iconSize16" style="'.$displayIcon.'position:relative;float:left;margin-right:10px;"></div>'.i18n(substr($obj->name,3)).'</a><div id="currentDiv'.$obj->name.'" class="div__link" ></div></li>';
    }
    $old=$menu['level'];
    $idP=$menu['object']->idParent;
  }
  $result.='</div">';
  return $result;
}
  

?>