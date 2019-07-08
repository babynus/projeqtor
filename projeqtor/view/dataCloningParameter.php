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
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/dataCloningList.php');

$user=getSessionUser();
$userName=$user->id;
?>

<div dojoType="dijit.layout.BorderContainer" id="dataCloningParameterTopDiv" name="dataCloningParameterTopDiv">
  <div style="top:30px !important; left: 200px !important; width: 500px; margin: 0px 8px 4px 8px; padding: 5px;display:none;" 
       id="resultDiv" dojoType="dijit.layout.ContentPane" region="none" >
  </div>   
  <div dojoType="dijit.layout.ContentPane" region="top" id="dataCloningParameterButtonDiv" class="listTitle" >
  <form dojoType="dijit.form.Form" name="dataCloningParameterForm" id="dataCloningParameterForm" action="" method="post" >
  <table width="100%" height="64px" class="listTitle">
    <tr height="32px">
    <td style="vertical-align:top;min-width:100px;width:20%;">
      <table >
		    <tr height="32px">
  		    <td width="50px" align="center">
            <?php echo formatIcon('DataCloningParameter', 32, null, true);?>
          </td>
          <td width="200px"><span class="title"><?php echo i18n('menuDataCloningParameter');?></span></td>
  		  </tr>
  		  <tr height="32px">
          <td>
            <button id="refreshDataCloningParameterButton" dojoType="dijit.form.Button" showlabel="false"
              title="<?php echo i18n('buttonRefreshList');?>"
              iconClass="dijitButtonIcon dijitButtonIconRefresh" class="detailButton">
              <script type="dojo/method" event="onClick" args="evt">
	             refreshDataCloningParameter();
              </script>
            </button> 
          </td>
        </tr>
		  </table>
    </td>
    </tr>
  </table>
  </form>
  </div>
  <div id="dataCloningParameterDiv" name="dataCloningParameterDiv" dojoType="dijit.layout.ContentPane" region="center" >
    <div id="dataCloningParameterCenterDiv" name="dataCloningParameterCenterDiv">
      <?php ?>
    </div>
  </div>  
</div>