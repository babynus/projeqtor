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

function menuNewGuiFilter(filter) {
  var allCollection = dojo.query(".menuBarItem");
  //allCollection.forEach(function(node, index, arr){ node.style.display="none";});
  var newCollection = dojo.query("." + filter);
  //newCollection.forEach(function(node, index, arr){ node.style.display="block";});
  allCollection
      .fadeOut(
          {
            duration : 200,
            onEnd : function() {
              allCollection.style("display", "none");
              newCollection.style("display", "block");
              newCollection.style("width", "auto");
              newCollection.style("height", "auto");
              newCollection.style("max-height", "48px !important");
              newCollection.style("white-space", "nowrap");
              newCollection.style("filter", "unset");
              newCollection.style("padding", "5px 10px 5px 10px !important");
              newCollection.style("color", "var(--color-dark)");
              if (newCollection.length < 20) {
                newCollection.fadeIn({
                  duration : 200
                }).play();
              } else {
                newCollection.style("opacity", "1");
              }
            }
          }).play();
  saveUserParameter('defaultMenu', filter);
}
