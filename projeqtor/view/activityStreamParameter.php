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

/*
 * ============================================================================ Presents an object.
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
$user = getSessionUser ();

?>
<div id="resultDiv" style="padding: 5px; padding-bottom: 20px; max-height: 100px; padding-left: 300px; z-index: 999"></div>
<table width="100%">
	<tr height="32px">
		<td width="50px" align="center"><?php echo formatIcon('ActivityStream', 32, null, true);?></td>
		<td><span class="title"><?php echo i18n('menuActivityStream');?>&nbsp;</span></td>
	</tr>
</table>

<div style="width: 100%; margin: 0 auto; height: 90px; padding-bottom: 15px; border-bottom: 1px solid #CCC;background-color:#FFFFFF">
  <form id="activityStreamForm" name="activityStreamForm">
		<table width="100%" class="dashboardTicketMain" style="">
			<tr>
				<td valign="top" width="10%">
					<table>
					  <input type="hidden" id="activityStreamAllItems" name="activityStreamAllItems" value="<?php echo Parameter::getUserParameter("activityStreamAllItems");?>" />
						<tr>
							<td align="left" >
							  <a onclick="console.log('test');dojo.byId('activityStreamAllItems').value=0;refreshActivityStreamList();" href="#">
							    <?php echo i18n("activityStreamAllItems").addSelected("activityStreamAllItems",0);?>
							  </a>
							</td>
						</tr>
						<tr>
							<td align="left">
							  <a onClick="dojo.byId('activityStreamAllItems').value=1;refreshActivityStreamList();" href="#">
							    <?php echo i18n("activityStreamNotDone").addSelected("activityStreamAllItems",1);?>
							  </a>
							</td>
						</tr>
						<tr>
							<td align="left"><a
								onClick="dojo.byId('activityStreamAllItems').value=2;refreshActivityStreamList();"
								href="#"><?php echo i18n("activityStreamNotClosed").addSelected("activityStreamAllItems",2);?></a></td>
						</tr>
					</table>
				</td>
				<td valign="top" width="10%">
					<table>
						<tr>
							<td align="left">xxx<?php echo i18n('filterOnAuthor');?></td>
						</tr>
						<tr>
							<td align="left">
							  <select title="<?php echo i18n('filterOnAuthor')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
                <?php echo autoOpenFilteringSelect();?> 
                id="activityStreamAuthorFilter" name="activityStreamAuthorFilter" style="width:200px">
                  <?php 
                    $selectedAuthor=Parameter::getUserParameter('activityStreamParameter');
                    htmlDrawOptionForReference('idUser', $selectedAuthor, null, false); ?>
                  <script type="dojo/method" event="onChange" >
                    refreshActivityStreamList();
                  </script>
                </select>
							</td>
						</tr>
					</table>
        </td>
        <td width="80%">&nbsp;
        </td>
			</tr>
		</table>
	</form>
</div>
<?php 
function addSelected($param,$value){
  if(Parameter::getUserParameter($param)!=null){
    if(Parameter::getUserParameter($param)==$value){
      return "&nbsp;&nbsp;<img src=\"css/images/iconSelect.png\"/>";
    }
  }
}
?>