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
 * List of items subscribed by a user.
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/dynamicSubscriptionForOhter.php');
  
$objectClass=RequestHandler::getClass('objectClass',true); 
$objectId=RequestHandler::getId('objectId',true);

$res=new Affectable();
$scope=Affectable::getVisibilityScope();
$crit="idle=0";
if ($scope=='orga') {
	$crit.=" and idOrganization in (". Organization::getUserOrganisationList().")";
} else if ($scope=='team') {
	$aff=new Affectable(getSessionUser()->id,true);
	$crit.=" and idTeam=".Sql::fmtId($aff->idTeam);
}
$lstRes=$res->getSqlElementsFromCriteria(null,false,$crit,'fullName asc, name asc',true);
$sub=new Subscription();
$crit=array("refType"=>$objectClass,"refId"=>$objectId);
$lstSub=$sub->getSqlElementsFromCriteria($crit,false,null,null,true);
foreach ($lstSub as $sub) {
  if (isset($lstRes['#'.$sub->idAffectable])) unset($lstRes['#'.$sub->idAffectable]);
}
if (sessionValueExists('screenHeight') and getSessionValue('screenHeight')) {
	$showHeight = round(getSessionValue('screenHeight') * 0.4)."px";
} else {
	$showHeight="100%";
}



$crit=array('scope' => 'subscription','idProfile' => getSessionUser()->idProfile);
$habilitation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther', $crit);
$scope=new AccessScope($habilitation->rightAccess, true);
if (! $scope->accessCode or $scope->accessCode == 'NO') {
	$canValidate=false;
} else if ($scope->accessCode == 'ALL') {
	$canValidate=true;
} else if (($scope->accessCode == 'OWN' or $scope->accessCode == 'RES') and $user->isResource and $resourceId == $user->id) {
	$canValidate=true;
} else if ($scope->accessCode == 'PRO') {
	$crit='idProject in ' . transformListIntoInClause($user->getVisibleProjects());
	$aff=new Affectation();
	$lstAff=$aff->getSqlElementsFromCriteria(null, false, $crit, null, true, true);
	$fullTable=SqlList::getList('Resource');
	foreach ( $lstAff as $id => $aff ) {
		if ($aff->idResource == $resourceId) {
			$canValidate=true;
			continue;
		}
	}
}






echo '<input type="hidden" id="subscriptionObjectClass" value="'.$objectClass.'" />';
echo '<input type="hidden" id="subscriptionObjectClass" value="'.$objectId.'" />';
echo '<table style="width:100%;height:100%;min-height:300px">';
echo '<tr style="height:20px">';
echo '<td class="section" style="width:200px">'.i18n('titleAvailable').'</td>';
echo '<td class="" style="width:50px">&nbsp;</td>';
echo '<td class="section" style="width:200px">'.i18n('titleSelected').'</td>';
echo '</tr>';
echo '<tr style="height:10px"><td colspan="3">&nbsp;</td></tr>';
echo '<tr style="height:20px">';
echo '<td style="position:relative">';
echo '<input dojoType="dijit.form.TextBox" id="subscriptionAvailableSearch" class="input" style="width:210px" value="" onKeyUp="filterDnDList(\'subscriptionAvailableSearch\',\'subscriptionAvailable\',\'div\');" />';
echo '<div style="position:absolute;right:4px;top:3px;" class="iconView"></div>';
echo '</td>';
echo '<td >&nbsp;</td>';
echo '<td style="position:relative;">';
echo '<input dojoType="dijit.form.TextBox" id="subscriptionSubscribedSearch" class="input" style="width:210px" value="" onKeyUp="filterDnDList(\'subscriptionSubscribedSearch\',\'subscriptionSubscribed\',\'div\');" />';
echo '<div style="position:absolute;right:4px;top:3px;" class="iconView"></div>';
echo '</td></tr>';
echo '<tr>';
echo '<td style="max-width:200px;vertical-align:top" class="dijitAccordionTitle" >';
echo '<div style="height:'.$showHeight.';overflow:auto;" id="subscriptionAvailable" dojotype="dojo.dnd.Source" dndType="subsription" withhandles="false" data-dojo-props="accept: [ \'subscription\' ]">';
foreach($lstRes as $res) {
  drawResourceTile($res,"subscriptionAvailable");
}
echo '</div>';
echo '</td>';
echo '<td class="" ></td>';
echo '<td style="position:relative;max-width:200px;max-height:'.$showHeight.';vertical-align:top" class="dijitAccordionTitle" >';
echo '<div style="position:absolute;bottom:5px;left:5px;width:24px;height:24px;opacity:0.7;" class="dijitButtonIcon dijitButtonIconSubscribe" ></div>';
echo '<div style="height:'.$showHeight.';overflow:auto;" id="subscriptionSubscribed" dojotype="dojo.dnd.Source" dndType="subsription" withhandles="false" data-dojo-props="accept: [ \'subscription\' ]">';
foreach($lstSub as $sub) {
  $res=new Affectable($sub->idAffectable);
  drawResourceTile($res,"subscriptionSubscribed");
}
echo '</td>';
echo '</tr>';
echo '</table>';
echo'<br/><table style="width: 100%;" ><tr><td style="width: 100%;" align="center">'
    .'<button dojoType="dijit.form.Button" type="button" onclick="dijit.byId(\'dialogSubscriptionForOthers\').hide();">'.i18n("close").'</button>'
    .'</td></tr></table>';

function drawResourceTile($res,$dndSource){
  global $objectClass, $objectId;
  $name=($res->name)?$res->name:$res->userName;
  echo '<div class="dojoDndItem subscription" id="subscription'.$res->id.'" value="'.str_replace('"','',$name).'" objectclass="'.$objectClass.'" objectid="'.$objectId.'" userid="'.$res->id.'" currentuserid="'.getSessionUser()->id.'" dndType="subscription" style="position:relative;padding: 2px 5px 3px 5px;margin:0px 3px 5px 0px;color:#707070;min-height:22px;background-color:#ffffff; border:1px solid #707070" >'
    .formatUserThumb($res->id, "", "")
    .$name
    .'</div>';
}
?>