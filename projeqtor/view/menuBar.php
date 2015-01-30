<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
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
  scriptLog('   ->/view/menuBar.php');
  //$iconSize=Parameter::getUserParameter('paramTopIconSize');
  $iconSize=32;
  $showMenuBar=Parameter::getUserParameter('paramShowMenuBar');
  $showMenuBar='YES';
  //$showMenuBar='NO';
  if (! $iconSize or $showMenuBar=='NO') $iconSize=16;
  
  function drawMenu($menu) {
  	global $iconSize;
  	$menuName=$menu->name;
    $idMenu=$menu->id;
    if ($menu->type=='menu') {
    	if ($menu->idMenu==0) {
    		//echo '<td class="menuBarSeparator" style="width:5px;"></td>';
    	}
    } else if ($menu->type=='item') {
    	  $class=substr($menuName,4); 
        echo '<td  title="' .i18n($menu->name) . '">';
        echo '<div class="menuBarItem '.$menu->menuClass.'" onClick="loadMenuBarItem(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\',\'bar\');">';
        echo '<img src="../view/css/images/icon' . $class . $iconSize.'.png" />';       
        echo '<div class="menuBarItemCaption">'.i18n($menu->name).'</div>';
        echo '</div>';
        echo '</td>';    	
    } else if ($menu->type=='object') { 
      $class=substr($menuName,4);
      if (securityCheckDisplayMenu($idMenu, $class)) {
      	echo '<td title="' .i18n('menu'.$class) . '">';
      	echo '<div class="menuBarItem '.$menu->menuClass.'" onClick="loadMenuBarObject(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\',\'bar\');" >';
      	echo '<img src="../view/css/images/icon' . $class . $iconSize. '.png" />';
      	echo '<div class="menuBarItemCaption">'.i18n('menu'.$class).'</div>';
      	echo '</div>';
      	echo '</td>';
      }
    }
  }  
  
  function drawAllMenus() {
  	//echo '<td class="menuBarSeparator"></td>';
    $obj=new Menu();
    $suspend=false;
    echo '<td>&nbsp;</td>';
    $menuList=$obj->getSqlElementsFromCriteria(null, false);
    $lastType='';
    foreach ($menuList as $menu) { 
    	//if ($menu->id==36) {$suspend=true;}
    	if (! $suspend and securityCheckDisplayMenu($menu->id,$menu) ) {
    		drawMenu($menu);
    		$lastType=$menu->type;
    	}
    }
  }
?>
  <table width="100%"><tr height="<?php echo $iconSize+18; ?>px">  
    <td width="287px">
      <div class="titleProject" style="position: absolute; left:0px; top: -1px;width:75px; text-align:right;">
        &nbsp;<?php echo (i18n("menu"));?>&nbsp;:&nbsp;</div>
      <div style="position: absolute; left:75px; top: 1px;width:205px; background: transparent; color: #FFFFFF; border:1px solid #FFF" 
        onChange="menuFilter(this.value);"
        dojoType="dijit.form.Select" class="input filterField rounded menuSelect" 
        >
        <option value="menuBarItem" selected=selected><?php echo i18n("all");?></option>
        <option value="work"><?php echo i18n("work");?></option>
        <option value="risks"><?php echo i18n("risks");?></option>
        <option value="security"><?php echo i18n("security");?></option>
        </div>
      <div class="titleProject" style="position: absolute; left:0px; top: 22px;width:75px; text-align:right;">
        &nbsp;<?php echo (i18n("projectSelector"));?>&nbsp;:&nbsp;</div>
      <div style="height:100%" dojoType="dijit.layout.ContentPane" region="center" id="projectSelectorDiv" >
        <?php include "menuProjectSelector.php"?>
      </div>
      <span style="position: absolute; left:250px; top:22px; height: 20px">
        <button id="projectSelectorParametersButton" dojoType="dijit.form.Button" showlabel="false"
         title="<?php echo i18n('menuParameter');?>" style="height:20px;"
         iconClass="dijitButtonIcon dijitButtonIconTool" xclass="detailButton" >
          <script type="dojo/connect" event="onClick" args="evt">
           loadDialog('dialogProjectSelectorParameters', null, true);
          </script>
        </button>
      </span>
    </td>
<?php if ($showMenuBar!='NO') {?>    
    <td width="3px"></td>
    <td class="menuBarSeparator" ></td>
    <td width="8px">
      <button id="menuBarMoveLeft" dojoType="dijit.form.Button" showlabel="false"
       title="<?php echo i18n('menuBarMoveLeft');?>"
       iconClass="leftBarIcon" style="position:relative; left: -6px; width: 14px;margin:0;vertical-align:middle">
         <script type="dojo/method" event="onMouseDown">         
           menuBarMove=true;
           moveMenuBar('left');
         </script>
         <script type="dojo/method" event="onMouseUp">
           moveMenuBarStop();
         </script>
         <script type="dojo/method" event="onClick">
           moveMenuBarStop();
         </script>
      </button>    
    </td>
    <td >
    <div id="menuBarVisibleDiv" style="height:<?php echo $iconSize+9;?>px;width:<?php 
      if (0 and array_key_exists('screenWidth',$_SESSION)) {
         $width = $_SESSION['screenWidth'] - 395;
         echo $width . 'px';
      } else {
      	echo '100%';
      }
    ?>; position: absolute; top: 0px; left: 315px; z-index:0">
      <div style="width: 100%; height:50px; position: absolute; left: 0px; top:0px; overflow:hidden; z-index:0">
	    <div name="menubarContainer" id="menubarContainer" style="width: 3000px; position: absolute; left:0px; overflow:hidden;z-index:0">
	      <table><tr>
	    <?php drawAllMenus();?>
	    </tr></table>
	    </div>
      </div>
    </div>
    </td> 
<?php } else {?>
    <td style="width:80%"><div id="menuBarVisibleDiv"></div></td>
<?php }?>
    <td width="80px" align="center" class="statusBar" style="position:relative;z-index:30;">
<?php if ($showMenuBar!='NO') {?>       
      <button id="menuBarMoveRight" dojoType="dijit.form.Button" showlabel="false" 
       title="<?php echo i18n('menuBarMoveRight');?>"
       iconClass="rightBarIcon" onMouseDown="" onMouseUp=""
       style="position:absolute; right: 63px; width: 14px;margin:0; margin-top: 2px;z-index:35; vertical-align:middle">
         <script type="dojo/method" event="onMouseDown">         
           menuBarMove=true;
           moveMenuBar('right');
         </script>
         <script type="dojo/method" event="onMouseUp">
           moveMenuBarStop();
         </script>
         <script type="dojo/method" event="onClick">
           moveMenuBarStop();
         </script>
      </button>   
<?php }?>
      <div style="vertical-align: middle; height:<?php echo $iconSize+9;?>px; position: absolute; top : -2px; right: 48px;margin:0; padding 0;z-index:35;" class="menuBarSeparator" ></div>
      <button id="menuBarUndoButton" dojoType="dijit.form.Button" showlabel="false"
       title="<?php echo i18n('buttonUndoItem');?>"
       disabled="disabled"
       style="position:relative;left: 12px; z-index:30;"
       iconClass="dijitEditorIcon dijitEditorIconBackBtn" >
        <script type="dojo/connect" event="onClick" args="evt">
          undoItemButton();
        </script>
      </button>    
      <button id="menuBarRedoButton" dojoType="dijit.form.Button" showlabel="false"
       title="<?php echo i18n('buttonRedoItem');?>"
       disabled="disabled"
       style="position:relative;left: 6px; z-index:30"
       iconClass="dijitEditorIcon dijitEditorIconNextBtn" >
        <script type="dojo/connect" event="onClick" args="evt">
          redoItemButton();
        </script>
      </button>    
    </td>
  </tr></table>