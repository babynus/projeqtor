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

?>

<div id="menuLeftBarContaineur" class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false" >

  <div id="menuBArNewGuiAcces"  class="container"  dojoType="dijit.layout.BorderContainer" region="left"  style="width:32px;height:100%;">
    <div id="breadScrumb"  dojoType="dijit.layout.ContentPane" region="center" style="height:70%;" >
      <div id="buttonHome" style="height:60px;">
      </div>
      <?php // draw History navigation and Home
      ?>
    </div>
    <div id="menuPersonalAcces"  dojoType="dijit.layout.ContentPane" region="bottom" style="height:30%;" >
    </div>
  </div>
  <div id="menuBarAccesLeft"  class="container"  dojoType="dijit.layout.BorderContainer" region="center"  >
    <div id="menuBarAccesTop" dojoType="dijit.layout.ContentPane"  region="center" style="height:70%;overflow: hidden;" >
      <nav id="ml-menu" class="menu">
            <?php // draw Menus
             echo drawLeftMenuListNewGui();
            ?>
      </nav>
	<script>
	(function() {
		var menuEl = document.getElementById('ml-menu'),
			mlmenu = new MLMenu(menuEl, {
				initialBreadcrumb : 'Accueil', // initial breadcrumb text
				backCtrl : false, // show back button
			});
	})();
	</script>
    </div>
    <div id="menuBarAccesBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:30%;">
    </div>
  </div>
</div>

<?php 
// functions

function sortMenus(&$listMenus, &$result, $parent,$level ){
  $level++;
  $c=0;
  foreach ($listMenus as $id=>$menu){
    if($menu->idParent == $parent){
      $c++;
      $key=$level.'-'.$menu->idParent.'-'.$c;
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
//   $liArray=$result;
//   foreach ($liArray as $menu){
//     debugLog($menu['level'].'    /   '.$menu['object']->idParent.'    '.$menu['object']->name);
//   }


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



function drawLeftMenuListNewGui(){
  $result='';
  $old="";
  $idP="";
  $maineDraw=false;
  $allMenu=getNavigationMenuLeft();
  $result.='<div class="menu__wrap">';
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
      $result.='<li class="menu__item" role="menuitem"><a class="menu__link" href="#">'.i18n($obj->name).'</a></li>';
    }else{
      $sub='submenu-'.$obj->id;
      $result.='<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="'.$sub.'" aria-owns="'.$sub.'" href="#">'.i18n($obj->name).'</a></li>';
    }
    $old=$menu['level'];
    $idP=$menu['object']->idParent;
  }
  $result.='</div">';
  return $result;
}
  

?>