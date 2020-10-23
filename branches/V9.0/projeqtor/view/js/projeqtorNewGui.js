/*******************************************************************************
 * COPYRIGHT NOTICE *
 * 
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 * 
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org
 * 
 * DO NOT REMOVE THIS NOTICE **
 ******************************************************************************/

// ============================================================================
// All specific ProjeQtOr functions and variables
// This file is included in the main.php page, to be reachable in every context
// ============================================================================
// =============================================================================
// = Variables (global)
// =============================================================================
var i18nMessages = null; // array containing i18n messages
var i18nMessagesCustom = null; // array containing i18n messages
var currentLocale = null; // the locale, from browser or user set
var browserLocale = null; // the locale, from browser
var cancelRecursiveChange_OnGoingChange = false; // boolean to avoid
// recursive change trigger
var formChangeInProgress = false; // boolean to avoid exit from form when
// changes are not saved
var currentRow = null; // the row num of the current selected
// element in the main grid
var currentFieldId = ''; // Id of the ciurrent form field (got
// via onFocus)
var currentFieldValue = ''; // Value of the current form field (got
// via onFocus)
var g; // Gant chart for JsGantt : must be
// named "g"
var quitConfirmed = false;
var noDisconnect = false;
var forceRefreshMenu = false;
var directAccessIndex = null;

var debugPerf = new Array();

var pluginMenuPage = new Array();

var previousSelectedProject=null;
var previousSelectedProjectName=null;

var mustApplyFilter=false;

var arraySelectedProject = new Array();

var displayFilterVersionPlanning='0';
var displayFilterComponentVersionPlanning='0';

var contentPaneResizingInProgress={};

var defaultMenu=null;

//=============================================================================
//function for left Menu 
//
// ticket 4965 Florent
//=============================================================================

;( function(window) {
  function menuLeft(menu) {  
    this.el = menu;
    this._init();
  }

  menuLeft.prototype = {
    _init : function() {
      this.menuRight=dojo.byId('menuBarVisibleDiv');
      this.trigger = dojo.byId( 'hideStreamNewGui' );
      this.isMenuOpen = true; //replace to datatsession;

      //divButton
      this.hidStreamButtonTopBar= document.createElement('div');
      this.hidStreamButtonTopBar.className = 'hideStreamNewGuiTopBar';
      this.hidStreamButtonTopBar.setAttribute('id', 'hideStreamNewGuiTopBar');
      this.hidStreamButtonTopBar.setAttribute('style', 'display:none;');
      //incon
      this.hidStreamButtonTopBarIcon = document.createElement('div');
      this.hidStreamButtonTopBarIcon.className = 'iconHideMenuRight iconSize32';
      //insert in menuBar
      this.menuRight.insertAdjacentElement('afterbegin', this.hidStreamButtonTopBar);
      this.hidStreamButtonTopBar.insertAdjacentElement('afterbegin',  this.hidStreamButtonTopBarIcon);
      
      this.triggerBar = dojo.byId( 'hideStreamNewGuiTopBar' );
      this.eventtype ='click';
      this._initEvents();

    },
    
    _initEvents : function() {
      var self = this;
      this.trigger.addEventListener( this.eventtype, function( ev ) {
        ev.stopPropagation();
        ev.preventDefault();
        if( self.isMenuOpen ) {
          self._closeMenu();
          document.removeEventListener( self.eventtype, self.bodyClickFn );
        }
      } );
      this.triggerBar.addEventListener( this.eventtype, function( ev ) {
        ev.stopPropagation();
        ev.preventDefault();
        if(! self.isMenuOpen ) {
          self._openMenu();
          document.addEventListener( self.eventtype, self.bodyClickFn );
        }
      } );
    },
    
    _openMenu : function() {
      if( this.isMenuOpen ) return;
      this.isMenuOpen = true; //replace to datatsession;
      this._setSize();
      this._showHideButton();
    },
    
    _closeMenu : function() {
      if( !this.isMenuOpen ) return;
      this.isMenuOpen = false;//replace to datatsession;
      this._setSize();
      this._showHideButton(),30;
    },
    
    _showHideButton : function(){
      dojo.removeAttr('hideStreamNewGui','style');
      dojo.removeAttr('contentMenuBar','style');
      dojo.removeAttr('hideStreamNewGuiTopBar','style');
      if(this.isMenuOpen){
        this.trigger.setAttribute('style','display:block;float:right;');
        this.triggerBar.setAttribute('style','display:none;');
      }else{
        this.trigger.setAttribute('style','display:none;');
        this.triggerBar.setAttribute('style','float:left;width:32px;display:block;');
      }
      dojo.setAttr('contentMenuBar','style','top:1px; overflow:hidden; z-index:0');
    },
    
    _setSize :function(){
      var globalWidth=(this.isMenuOpen) ? dojo.byId('globalContainer').offsetWidth-250 : dojo.byId('globalContainer').offsetWidth;
      this._resizeDiv (globalWidth);
     },
    
    _resizeDiv : function(globalWidth){
      var duration=300;
        dojox.fx.combine([ dojox.fx.animateProperty({
          node : "menuTop",
          properties : {
            width : globalWidth,
          },
          duration : duration
        }), dojox.fx.animateProperty({
          node : "leftMenu",
          properties : {
            width : { start:(this.isMenuOpen)? 0 : 250 ,end:(this.isMenuOpen)? 250 : 0}
          },
          duration : duration
        }), dojox.fx.animateProperty({
          node : "leftDiv",
          properties : {
            width : { start:(this.isMenuOpen)? 0 : 250 ,end:(this.isMenuOpen)? 250 : 0}
          },
          duration : duration
        }), dojox.fx.animateProperty({
          node : "globalTopCenterDiv",
          properties : {
            width : globalWidth,
            left: { start:(this.isMenuOpen)? 0 : 250 ,end:(this.isMenuOpen)? 250 : 0}
          },
          duration : duration
        }), dojox.fx.animateProperty({
          node : "centerDiv",
          properties : {
            width : globalWidth,
            left: { start:(this.isMenuOpen)? 0 : 250 ,end:(this.isMenuOpen)? 250 : 0}
          },
          duration : duration
        }),dojox.fx.animateProperty({
          node : "menuLeftBarContaineur",
          properties : {
            width :{ start:(this.isMenuOpen)?  0 : 250,end:(this.isMenuOpen)? 250 :0 }
          },
          duration : duration
        }), dojox.fx.animateProperty({
          node : "statusBarDiv",
          properties : {
            width : globalWidth,
          },
          duration : duration
        }),  dojox.fx.animateProperty({
          node : "statusBarDivBottom",
          properties : {
            width : globalWidth,
            left: { start:(this.isMenuOpen)? 0 : 250 ,end:(this.isMenuOpen)? 250 : 0}
          },
          duration : duration
      })]).play();
      setTimeout('dijit.byId("globalContainer").resize();', duration+5);
    }
  };
  
  window.menuLeft = menuLeft;

} )(window);

//=============================================================================


function menuNewGuiFilter(filter, item) {
	var historyBar = new Array();
	var historyBarSort = new Array();
	historyTable.forEach(function(element){
		historyBar.push('menu'+element[0]);
		if(!historyBarSort.includes('menu'+element[0]))historyBarSort.push('menu'+element[0]);
	});
	var countList = historyBarSort.length*140;
	var containerDivWidth = dojo.byId('menubarContainer').offsetWidth;
	var listDivWidth = dojo.byId('menuBarListDiv').offsetWidth;
	if(countList > listDivWidth)listDivWidth=countList;
	var buttonDivWidth = dojo.byId('menuBarButtonDiv').offsetWidth;
	var maxDivWidth = containerDivWidth-buttonDivWidth-140;
	var nbSkipMenu = 0;
	
	if(filter == 'menuBarRecent'){
		while(listDivWidth > maxDivWidth){
			historyBarSort.splice(0, 1);
			listDivWidth -= 140;
			nbSkipMenu++;
		}
	}else{
	}
	var callback = function(){
		if(item)selectIconMenuBar(item);
		if(filter != 'menuBarCustom'){
			dojo.byId('favoriteSwitch').style.display = 'none';
			dojo.addClass('recentButton','imageColorNewGuiSelected');
			dojo.removeClass('favoriteButton','imageColorNewGuiSelected');
		}else{
			dojo.byId('favoriteSwitch').style.display = 'block';
			dojo.addClass('favoriteButton','imageColorNewGuiSelected');
			dojo.removeClass('recentButton','imageColorNewGuiSelected');
		}
        dojo.query('.anotherBarDiv').forEach(function(el){
        	var source = new dojo.dnd.Source(el.id, { accept:["menuBar" ],horizontal:true});
        	
        });
	};
	loadContent('../view/refreshMenuBarList.php?menuFilter='+filter+'&historyTable='+historyBar+'&nbSkipMenu='+nbSkipMenu, 'menuBarListDiv', null, null, null, null, null, callback);
	loadContent('../view/refreshMenuAnotherBarList.php?menuFilter='+filter, 'anotherBarContainer');
	saveUserParameter('defaultMenu', filter);
	defaultMenu=filter;
}

function switchFavoriteRow(idRow, direction, maxRow){
	var nextRow=idRow;
	if(direction=='up'){
		nextRow -= 1;
		if(nextRow < 1)nextRow=maxRow;
	}else if(direction=='down'){
		nextRow += 1;
		if(nextRow > maxRow)nextRow=1;
	}
	var callback = function(){
		saveUserParameter('idFavoriteRow', nextRow);
		menuNewGuiFilter('menuBarCustom', null);
	};
	loadDiv('../view/refreshMenuBarFavoriteCount.php?idFavoriteRow='+nextRow, 'favoriteSwitch', null, callback);
}

function wheelFavoriteRow(idRow, evt, maxRow){
	if(defaultMenu == 'menuBarRecent')return;
	var nextRow=idRow;
	if(evt.deltaY < 0){
		nextRow -= 1;
		if(nextRow < 1)nextRow=maxRow;
	}else if(evt.deltaY > 0){
		nextRow += 1;
		if(nextRow > maxRow)nextRow=1;
	}
	var callback = function(){
		saveUserParameter('idFavoriteRow', nextRow);
		menuNewGuiFilter('menuBarCustom', null);
	};
	loadDiv('../view/refreshMenuBarFavoriteCount.php?idFavoriteRow='+nextRow, 'favoriteSwitch', null, callback);
}

function addRemoveFavMenuLeft (id,name,mode,type){
  dojo.removeClass(id);
  dojo.removeAttr(id,'onclick');
  if(mode=='add'){
    if(type=="reportDirect"){
      var fileName = dojo.byId('reportFileMenu').value;
      var form="reportForm";
      if(fileName=="showIntervention" && dojo.byId("consultationPlannedWorkManualParamDiv")){
        form="listFormConsPlannedWorkManual";
      }
        loadContent("../tool/saveReportInToday.php", "resultDivMain", form, true,
        'report');
    }else{
      var func= "addRemoveFavMenuLeft('"+id+"','"+name+"','remove')";
      var param="?operation=add&class="+name.substr(4);
      dojo.xhrGet({
        url : "../tool/saveCustomMenu.php"+param,
        handleAs : "text",
        load : function(data, args) {
        },
      });
      dojo.setAttr(id,"onclick",func);
      dojo.byId(id).className='menu__as__Fav';
    }
  }else{
    var func= "addRemoveFavMenuLeft('"+id+"','"+name+"','add')";
    var param="?operation=remove&class="+name.substr(4);
    dojo.xhrGet({
      url : "../tool/saveCustomMenu.php"+param,
      handleAs : "text",
      load : function(data, args) {
      },
    });
    dojo.setAttr(id,"onclick",func);
    dojo.byId(id).className='menu__add__Fav';
  }

  menuNewGuiFilter('menuBarCustom', null);
}

function checkClassForDisplay(id,mode){
  if(mode=='leave'){
        dojo.setAttr(id,'style','display:none;');
  }else{
      dojo.setAttr(id,'style','display:display;');
  }
}

function moveMenuBarItem(source, target){
	dojo.byId('anotherBarContainer').style.display = 'none';
	var idRow = null;
	if(target != 'menuBarDndSource'){
		idRow = target.substr(-1);
	}else{
		idRow = dojo.byId('idFavoriteRow').value;
	}
	var customArray = new Array();
	var pos = 1;
	dojo.byId(target).querySelectorAll('.dojoDndItem').forEach(function(node){
		customArray[pos] = 'menu'+node.id.substr(7);
		pos++;
	});
	var param="?idSourceFrom="+source+"&idSourceTo="+target+"&idRow="+idRow+"&customArray="+customArray;
    dojo.xhrGet({
      url : "../tool/saveCustomMenuOrder.php"+param,
      handleAs : "text",
      load : function(data, args) {
      },
    });
}

function showFavoriteTooltip(menuClass) {
	  clearTimeout(closeFavoriteTimeout);
	  clearTimeout(openFavoriteTimeout);
	  openFavoriteTimeout=setTimeout("dijit.byId('addFavorite"+menuClass+"').openDropDown();",100);
	  customMenuAddRemoveClass=menuClass;
}

function hideFavoriteTooltip(delay, menuClass) {
  if (!dijit.byId("addFavorite"+menuClass)) return;
  clearTimeout(closeFavoriteTimeout);
  clearTimeout(openFavoriteTimeout);
  closeFavoriteTimeout=setTimeout("dijit.byId('addFavorite"+menuClass+"').closeDropDown();",delay);
  customMenuAddRemoveClass=menuClass;
}

function addNewGuiItem(item){
	if (checkFormChangeInProgress()) {
	    return false;
	}
    var currentScreen=null;
    if(dojo.byId('objectClass'))currentScreen=dojo.byId('objectClass').value;
    var param = dojo.byId('newItemAccessMode').value;
	if(param == 'direct'){
		var callbackPlanning = function(){
			loadDiv("menuUserScreenOrganization.php?currentScreen=Planning&objectExist="+objectExist,"mainDivMenu");
			stockHistory('Planning',null,'Planning');
			if(defaultMenu == 'menuBarRecent'){
			  menuNewGuiFilter(defaultMenu, 'Planning');
			}
			selectIconMenuBar('Planning');
			addNewItem(item);
		};
		var callbackItem = function(){
			loadDiv("menuUserScreenOrganization.php?currentScreen="+item+"&objectExist="+objectExist,"mainDivMenu");
			stockHistory(item,null,'Object');
			if(defaultMenu == 'menuBarRecent'){
			  menuNewGuiFilter(defaultMenu, item);
			}
			selectIconMenuBar(item);
			addNewItem(item);
		};
		if(item != 'Resource' && item != 'Ticket'){
			var currentMenu=null;
		    if(dojo.byId('objectClassManual'))currentMenu=dojo.byId('objectClassManual').value;
		    if(currentMenu != 'Planning'){
		    	vGanttCurrentLine=-1;
			    cleanContent("centerDiv");
				loadContent("planningMain.php", "centerDiv",null,null,null,null,null,callbackPlanning);
		    }else{
		    	addNewItem(item);
		    }
		}else{
			if(currentScreen != item){
				cleanContent("detailDiv");
				loadContent("objectMain.php?objectClass=" + item, "centerDiv",null,null,null,null,null,callbackItem);
			}else{
				addNewItem(item);
			}
		}
	}else{
		actionSelectAdd(item, null, null);
	}
}

function showIconLeftMenu(){
  var leftMenu=dojo.byId('ml-menu');
  var mode=dojo.byId('displayModeLeftMenu').value;
  display=(mode=='ICONTXT')?'none':'block';
  leftMenu.menus = [].slice.call(leftMenu.querySelectorAll('.menu__level'));
  leftMenu.menus.forEach(function(menuEl, pos) {
    var items = menuEl.querySelectorAll('.menu__item');
    items.forEach(function(itemEl, iPos) {
      var iconDiv = itemEl.querySelector('.iconSize16');
      iconDiv.style.display=display;
    });
  });
  dojo.setAttr('displayModeLeftMenu','value',(display=='block')?'ICONTXT':'TXT');
  saveUserParameter('menuLeftDisplayMode',mode);
}

function showBottomContent (menu){
  saveDataToSession('bottomMenuDivItemElect',menu,true);
  
  if(menu!='Console'){
    dojo.byId('messageDiv').style.display='none';
    dojo.byId('loadDivBarBottom').style.display='block';
  }
  
  var items=dojo.byId('loadDivBarBottom');
  var alldiv=items.querySelectorAll('.menuBottomDiv');
  alldiv.forEach(function(el){
    el.style.display='none';
  });
  switch(menu){
    case 'Link':
      dojo.byId('projectLinkDiv').style.display='block';
      break;
    case 'Document':
      dojo.byId('documentsDiv').style.display='block';
      dijit.byId('documentsDiv').resize();
      break;
    case 'Notification':
      dojo.byId('notificationBottom').style.display='block';
      dijit.byId('notificationBottom').resize();
      break;
    case 'Console':
      items.style.display='none';
      dojo.byId('messageDiv').style.display='block';
      break;
  }
}

function loadMenuReportDirect(cate,idReport){
  if (checkFormChangeInProgress()) {
    return false;
  }
  item="Reports";
  cleanContent("detailDiv");
  hideResultDivs();
  formChangeInProgress=false;
  var currentScreen=item;
  var objectExist='false';
  loadContent("reportsMain.php?idCategory="+cate, "centerDiv");
  loadDiv("menuUserScreenOrganization.php?currentScreen="+currentScreen+'&objectExist='+objectExist,"mainDivMenu");
  stockHistory(item,null,currentScreen);
  if(defaultMenu == 'menuBarRecent'){
    menuNewGuiFilter(defaultMenu, item);
  }
  selectIconMenuBar(item);
  setTimeout('reportSelectReport('+idReport+')',500);
  return true;
}