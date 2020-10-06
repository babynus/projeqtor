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
      this.menuTopDiv=dojo.byId('menuTop');
      this.menuRight=dojo.byId('menuBarVisibleDiv');
      this.trigger = dojo.byId( 'hideStreamNewGui' );
      this.menuLeft=this.el.querySelector( '.menu-left' );
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
      console.log('ui');
      this.isMenuOpen = true; //replace to datatsession;
      classie.remove( this.menuLeft, 'close' );
      classie.remove( this.menuTopDiv, 'close-menu' );
      dojo.removeAttr('hideStreamNewGuiTopBar','style');
      this._showHideButton();
    },
    
    _closeMenu : function() {
      if( !this.isMenuOpen ) return;
      this.isMenuOpen = false;//replace to datatsession;
      //if(this.el.querySelector( '.gn-open-all' ))classie.remove( this.menuLeft, 'gn-open-all' );
      classie.add( this.menuLeft, 'close' );
      classie.add( this.menuTopDiv, 'close-menu' );
      this._showHideButton();
    },
    
    _showHideButton : function(){
      dojo.removeAttr('hideStreamNewGui','style');
      dojo.removeAttr('contentMenuBar','style');
      dojo.removeAttr('hideStreamNewGuiTopBar','style');
      var duration=10;
      var globalWidth=dojo.byId('mainDiv').offsetWidth;
      var pos='left';
      if(this.isMenuOpen){
        this.trigger.setAttribute('style','display:block;float:right;');
        this.triggerBar.setAttribute('style','display:none;');
        globalWidth=globalWidth-250;
      }else{
        this.trigger.setAttribute('style','display:none;');
        this.triggerBar.setAttribute('style','float:left;width:32px;display:block;');
        pos='right';
      }
      console.log(globalWidth);
      dojox.fx.combine([ dojox.fx.animateProperty({
        node : "menuTop",
        properties : {
          width : globalWidth
        },
        duration : duration
      }), dojox.fx.animateProperty({
        node : "globalTopCenterDiv",
        properties : {
          width : globalWidth
        },
        duration : duration
      }), dojox.fx.animateProperty({
        node : "centerDiv",
        properties : {
          width : globalWidth
        },
        duration : duration
      }), dojox.fx.animateProperty({
        node : "statusBarDiv",
        properties : {
          width : globalWidth
        },
        duration : duration
      }), dojox.fx.animateProperty({
        node : "leftMenu",
        properties : {
          width : (this.isMenuOpen)? 250 : 0
        },
        duration : duration
      }), dojox.fx.animateProperty({
        node : "contentMenuBar",
        properties : {
          width : (this.isMenuOpen)? width+38 : width-38,
          float: pos
        },
        duration : duration
      })]).play();
      dojo.setAttr('contentMenuBar','style', 'top:1px; overflow:hidden; z-index:0');
      setTimeout('dijit.byId("globalTopCenterDiv").resize();', duration+5);
      
      
    },
    
  };

  window.menuLeft = menuLeft;

} )(window);

//=============================================================================


function menuNewGuiFilter(filter) {
  var allCollection = dojo.query(".menuBarItem");
  allCollection.style("display", "none");
  var newCollection = dojo.query("." + filter);
  if(newCollection.length > 10){
	  newCollection.splice(0, newCollection.length-10);
  }
  newCollection.style("display", "block");
  saveUserParameter('defaultMenu', filter);
  defaultMenu=filter;
}

