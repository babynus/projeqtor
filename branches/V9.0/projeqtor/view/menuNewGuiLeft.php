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
      <div id="historyNavBar" style="height:60px;">
      
      </div>
      <?php // draw Menus
        echo drawLeftMenuListNewGui();
      ?>
    </div>
    <div id="menuBarAccesBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:30%;border-top:1px solid black ">
    </div>
  </div>
</div>

<?php 
// functions
function getNavigationMenuLeft (){
  $result="";
  $result=array();
  $nav=new Navigation();
  $isLanguageActive=(Parameter::getGlobalParameter('displayLanguage')=='YES')?true:false;
  $contexctMenuMain=$nav->getSqlElementsFromCriteria(null, false,null,'id asc',true);
  //debugLog($contexctMenuMain);
  foreach ($contexctMenuMain as $idContext=>$context){
    if($context->idParent==0 and $context->idMenu==0){
      $result[$idContext]=array('type'=>'main','id'=>'','object'=>$context);
    }else if ($context->idMenu==0){
      $result[$idContext]=array('type'=>'subNavMenu','id'=>$context->idParent,'object'=>$context);
    }else{
      $menu=new Menu($context->idMenu);
      if (!isNotificationSystemActiv() and strpos($menu->name, "Notification")!==false) continue; 
      if (! $menu->canDisplay() ) continue;
      if (!$isLanguageActive and $menu->name=="menuLanguage") continue; 
      if (!Module::isMenuActive($menu->name)) continue;
      if (!securityCheckDisplayMenu($menu->id,substr($menu->name,4))) continue;
      $result[$idContext]=array('type'=>'menuDirect','id'=>$context->idParent,'object'=>$context);
    }
  }
  return $result;
}

function drawLeftMenuListNewGui(){
      $allMenu=getNavigationMenuLeft();
      foreach ($allMenu as $idMenu=>$menu){
          //debugLog($menu['type']);
      }
//       $result.='<ul data-menu="submenu-1" id="submenu-'.$context->id.'" tabindex="-1" role="menu" >';
    //$result.='<ul data-menu="main" class="menu__level" tabindex="-1" role="menu" >';
    
//     foreach ($menuList as $id=>$menu) {
//     if (!isNotificationSystemActiv() and strpos($menu->name, "Notification")!==false) { continue; }
//     if (! $menu->canDisplay() ) { continue;}
//     if (!$isLanguageActive and $menu->name=="menuLanguage") { continue; }
//     if (!Module::isMenuActive($menu->name)) {continue;}
//     if ($level>0 and securityCheckDisplayMenu($menu->id,substr($menu->name,4))) {continue;}
//       $subMenuId="";// menu id to link the sub
//       $result.='<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-'.$subMenuId.'" aria-owns="submenu-1" href="#">'.$menu->name.'</a></li>';
//     }
//     if($context->idMenu==''){
//       $result.='</ul>';
//     }
 
//  return $result;
}
  

?>