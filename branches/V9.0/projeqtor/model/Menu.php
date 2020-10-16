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
 * Menu defines list of items to present to users.
 */ 
require_once('_securityCheck.php');
class Menu extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $idMenu;
  public $type;
  public $sortOrder=0;
  public $menuClass;
  public $idle;
  
  public $_isNameTranslatable = true;
  public $_noHistory=true; // Will never save history for this object
  
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
    
  // Will hide menu for disabled plugins
  public static function canDisplayMenu($menu) {
    $plgName=lcfirst(substr($menu,4));
    $listPlugin=Plugin::getLastVersionPluginList();
    if (!isset($listPlugin[$plgName])) return true;
    $plg=$listPlugin[$plgName];
    if ($plg->idle) return false;
    return true;
  }
  public function canDisplay() {
    return self::canDisplayMenu($this->name);
  }
  public static function getMenuNameFromPage($page) {
    if (substr($page,0,27)=='objectMain.php?objectClass=') {
      $class=substr($page,27);
      if (strpos($class,'&')>0) $class=substr($class,0,strpos($class,'&'));
      return $class;
    } else {
      $class=str_replace('ViewMain.php','',$page);
      $class=str_replace('Main.php','',$class);
      $class=str_replace('.php','',$class);
      $class=str_replace('../view/','',$class);
      $class=ucfirst($class);     
      return $class;
    }
  }
  
  public static function drawNewGuiMenu($menu, $defaultMenu, $customMenuArray) {
  	$drawMode=Parameter::getUserParameter('menuBarTopMode');
  	if(!$drawMode)$drawMode='TXT';
  	$menuName=$menu->name;
  	$menuClass=' menuBarItem '.$menu->menuClass;
  	if (in_array($menu->name,$customMenuArray)) $menuClass.=' menuBarCustom';
  	$idMenu=$menu->id;
  	$class=substr($menuName,4);
  	$style='width:auto;height:auto;max-height:48px !important;padding:5px 10px 5px 10px !important;color: var(--color-dark);filter:unset !important;white-space:nowrap;';
  	if ($menu->type=='menu') {
  		if ($menu->idMenu==0) {
  		}
  	} else if ($menu->type=='item') {
  		echo '<td id="dndItem'.$class.'" name="dndItem'.$class.'" title="' .i18n($menu->name) . '" class="dojoDndItem" dndType="menuBar" style="border:unset !important;">';
  		echo '<div dndType="menuBar" class="'.$menuClass.'" style="'.$style.'" id="iconMenuBar'.$class.'" ';
  		echo 'onClick="hideReportFavoriteTooltip(0);loadMenuBarItem(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\',\'bar\');" ';
  		echo 'oncontextmenu="event.preventDefault();customNewGuiMenuManagement(\''.$class.'\');" ';
  		if ($menuName=='menuReports' and isHtml5() ) {
  			echo ' onMouseEnter="showReportFavoriteTooltip();"';
  			echo ' onMouseLeave="hideReportFavoriteTooltip(2000);"';
  		}
  		echo '>';
  		if($drawMode=='ICON'){
  			echo '<div class="icon'.$class.'22 icon'.$class.' iconSize22 imageColorNewGui" style="width:22px;height:22px"></div>';
  		}else if($drawMode=='TXT'){
  			echo i18n($menu->name);
  		}else if($drawMode=='ICONTXT'){
  		  echo '<table><tr>';
  		  echo '<td><div class="icon'.$class.'16 icon'.$class.' iconSize16 imageColorNewGui" style="width:16px;height:16px"></div></td>';
  	      echo '<td style="padding-left:5px;">'.i18n($menu->name).'</td>';
  		  echo '</tr></table>';
  		}
        if ($menuName=='menuReports' and isHtml5() ) {
          echo '<button class="comboButtonInvisible" dojoType="dijit.form.DropDownButton" 
           id="listFavoriteReports" name="listFavoriteReports" style="position:relative;top:-10px;left:-10px;height: 0px; overflow: hidden; ">
            <div dojoType="dijit.TooltipDialog" id="favoriteReports" style="position:absolute;"
              href="../tool/refreshFavoriteReportList.php"
              onMouseEnter="clearTimeout(closeFavoriteReportsTimeout);"
              onMouseLeave="hideReportFavoriteTooltip(200)"
              onDownloadEnd="checkEmptyReportFavoriteTooltip()">';
              Favorite::drawReportList();
            echo '</div></button>';
        }
        echo '</div>';
        echo '</td>'; 
        } else if ($menu->type=='plugin') {
          echo '<td id="dndItem'.$class.'" name="dndItem'.$class.'" title="' .i18n($menu->name) . '" class="dojoDndItem" dndType="menuBar" style="border:unset !important;">';
          echo '<div class="'.$menuClass.'" style="'.$style.'" id="iconMenuBar'.$class.'"';
          echo 'oncontextmenu="event.preventDefault();customNewGuiMenuManagement(\''.$class.'\');" ';
          echo 'onClick="loadMenuBarPlugin(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\',\'bar\');">';
          if($drawMode=='ICON'){
            echo '<img src="../view/css/images/icon'.$class.'22.png" />';
          }else if($drawMode=='TXT'){
            echo i18n($menu->name);
          }else if($drawMode=='ICONTXT'){
            echo '<table><tr>';
            echo '<td><img src="../view/css/images/icon'.$class.'22.png" /></td>';
            echo '<td style="padding-left:5px;">'.i18n($menu->name).'</td>';
            echo '</tr></table>';
          }
          echo '</div>';
          echo '</td>';
        } else if ($menu->type=='object') { 
          if (securityCheckDisplayMenu($idMenu, $class)) {
          	echo '<td id="dndItem'.$class.'" name="dndItem'.$class.'" title="' .i18n('menu'.$class) . '" class="dojoDndItem" dndType="menuBar" style="border:unset !important;">';
          	echo '<div class="'.$menuClass.'" style="'.$style.'" id="iconMenuBar'.$class.'" ';
          	echo 'oncontextmenu="event.preventDefault();customNewGuiMenuManagement(\''.$class.'\');" ';
          	echo 'onClick="loadMenuBarObject(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\',\'bar\');">';
          	if($drawMode=='ICON'){
          		echo '<div class="icon'.$class.'22 icon'.$class.' iconSize22 imageColorNewGui" style="width:22px;height:22px"></div>';
          	}else if($drawMode=='TXT'){
          		echo i18n($menu->name);
          	}else if($drawMode=='ICONTXT'){
          		echo '<table><tr>';
        		 echo '<td><div class="icon'.$class.'16 icon'.$class.' iconSize16 imageColorNewGui" style="width:16px;height:16px"></div></td>';
        	    echo '<td style="padding-left:5px;">'.i18n($menu->name).'</td>';
        		echo '</tr></table>';
          	}
          	echo '</div>';
          	echo '</td>';
          }
        }
      }  
      
      public static function drawAllNewGuiMenus($defaultMenu, $historyTable, $nbSkipMenu, $idFavoriteRow) {
        $isNotificationSystemActiv = isNotificationSystemActiv();
        $isLanguageActive=(Parameter::getGlobalParameter('displayLanguage')=='YES')?true:false;
        $customMenu = new MenuCustom();
        $customMenuArray=$customMenu->getSqlElementsFromCriteria(array('idUser'=>getSessionUser()->id, 'idRow'=>$idFavoriteRow), false, null, 'sortOrder');
        $obj=new Menu();
        $where=null;
        if(!$nbSkipMenu)$nbSkipMenu = 0;
        if($defaultMenu == 'menuBarCustom'){
          // $where = "idUser=".getSessionUser()->id." and idRow != ".$idFavoriteRow;
          // $otherCustomArray = $customMenu->getSqlElementsFromCriteria(null, false, $where);
          $customArray= array();
          foreach ($customMenuArray as $custom){
            array_push($customArray, $custom->name);
          }
          $where = "name in ('".implode("','", $customArray)."')";
          $menuList=$obj->getSqlElementsFromCriteria(null, false, $where);
          $menuListOrder = array();
          foreach ($customArray as $name){
            foreach ($menuList as $menu){
              if($menu->name == $name){
                array_push($menuListOrder, $menu);
              }
            }
          }
          $menuList=$menuListOrder;
          $customMenuArray=$customArray;
        }else if ($defaultMenu == 'menuBarRecent'){
          $historyTable = explode(',', $historyTable);
          $reverseArray = array_reverse($historyTable);
          $where = ($reverseArray)?"name in ('".implode("','", $reverseArray)."')":"";
          $menuList=($where)?$obj->getSqlElementsFromCriteria(null, false, $where):array();
          $sortHistoryTable = array();
          foreach ($reverseArray as $name){
          	foreach ($menuList as $menu){
              if($menu->name == $name){
                $sortHistoryTable[$menu->name] = $menu;
                break;
              }
            }
          }
          $menuList=$sortHistoryTable;
          if($nbSkipMenu > 0){
            $menuList=array_reverse($sortHistoryTable);
            $menuList = array_slice($menuList, $nbSkipMenu);
            $menuList=array_reverse($menuList);
          }
        }else{
          $menuList = array();
        }
        
        $pluginObjectClass='Menu';
        $tableObject=$menuList;
        $lstPluginEvt=Plugin::getEventScripts('list',$pluginObjectClass);
        foreach ($lstPluginEvt as $script) {
        	require $script; // execute code
        }
        $menuList=$tableObject;
        $lastType='';
        foreach ($menuList as $menu) { 
          if (! $isLanguageActive and $menu->name=="menuLanguage") { continue; }
          if (! $isNotificationSystemActiv and strpos($menu->name, "Notification")!==false) { continue; }
          if (! $menu->canDisplay() ) { continue;}
          if()
          if (securityCheckDisplayMenu($menu->id,substr($menu->name,4)) ) {
        		Menu::drawNewGuiMenu($menu, $defaultMenu, $customMenuArray);
        		$lastType=$menu->type;
        	}
        }
      }
}
?>