<?PHP
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

/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
require_once "../tool/projeqtor.php"; 
$result="";
$idItem=RequestHandler::getId('idItem');
$idPokerSession=RequestHandler::getId('idPokerSession');
$list = RequestHandler::getValue('itemList');
$itemList=explode(',',$list);
$nav=RequestHandler::getValue('nav');
$user = getSessionUser();

$obj = new PokerSession($idPokerSession);

$canUpdate=securityGetAccessRightYesNo('menu'.get_class($obj), 'update', $obj)=="YES";
if ($obj->idle==1) {
	$canUpdate=false;
}

$pos = array_search($idItem, $itemList);
if($pos < 0)$pos=0;
$lenght = count($itemList)-1;
if($lenght < 0)$lenght=0;
if($nav == 'next'){
  $idItem = (isset($itemList[$pos+1]))?$itemList[$pos+1]:$itemList[$lenght];
}else if($nav == 'previous'){
  $idItem = (isset($itemList[$pos-1]))?$itemList[$pos-1]:$itemList[0];
}
$pos = array_search($idItem, $itemList);
if($pos < 0)$pos=0;
$previous = ($pos>0)?true:false;
$lenght = count($itemList)-1;
if($lenght < 0)$lenght=0;
$next = ($pos<$lenght)?true:false;
$pos +=1;

$pokerComplexity = new PokerComplexity();
$pokerComplexityList = $pokerComplexity->getSqlElementsFromCriteria(array('idle'=>'0'), null, null, "sortOrder ASC");
$pokerItem = new PokerItem($idItem);
$pokerMember = new PokerResource();
$pokerMember = $pokerMember->getSingleSqlElementFromCriteria('PokerResource', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id));
$pokerMemberList = $pokerMember->getSqlElementsFromCriteria(array('idPokerSession'=>$idPokerSession));
$pokerVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id, 'idPokerItem'=>$pokerItem->id));
$pokerVoteList = SqlList::getListWithCrit('pokerVote', array('idPokerSession'=>$idPokerSession, 'idPokerItem'=>$pokerItem->id), 'value');
sort($pokerVoteList);
$lowVote = '';
$highVote = '';
if(count($pokerVoteList) > 0){
  sort($pokerVoteList);
  $lowVote = $pokerVoteList[0];
  $highVote = $pokerVoteList[count($pokerVoteList)-1];
}
$refObj = new $pokerItem->refType($pokerItem->refId);
echo '<table style="width: 100%;"><tr><td>';
echo '<div id="pokerVoteDescription" dojoType="dijit.layout.ContentPane" region="center" align="center" style="width: 100%;overflow:hidden"><table style="width: 100%;"><tr><td>';
echo '<div style="width: 100%;">';
echo '  <table style="width: 100%;"><tr>';
echo '    <td class="assignHeader" style="width:30%">'.i18n('colReference').'</td>';
echo '    <td class="assignHeader" style="width:30%">'.i18n('colName').'</td>';
echo '    <td class="assignHeader" style="width:40%">'.i18n('colDescription').'</td>';
echo '  </tr><tr>';
echo '<td class="noteData" style="width:30%; text-align: left;height:22px;">';
echo '  <table><tr><td style="padding-right:10px">'.formatIcon(get_class($refObj), 22).'</td><td>'.htmlEncode($refObj->name).' #'.htmlEncode($refObj->id).'</td></tr></table></td>';
echo '<td class="noteData" style="width:30%; text-align: left;height:22px;">'.htmlEncode($pokerItem->name).' #'.htmlEncode($pokerItem->id).'</td>';
echo '<td class="noteData" style="width:40%; text-align: left;height:22px;">'.htmlEncode($pokerItem->comment).'</td>';
echo '  </tr></table>';
echo '</div>';
echo '<div id="pokerVoteList" dojoType="dijit.layout.ContentPane" region="center" style="width: 100%;padding-top: 10px;padding-left: 10px;">';
echo '<div style="width: 100%;padding-bottom: 20px;">';
echo '  <button id="refreshPokerDiv" dojoType="dijit.form.Button" showlabel="false"';
echo '  title="'.i18n('refreshPokerVote').'" iconClass="dijitButtonIcon dijitButtonIconRefresh" class="detailButton">';
echo   '  <script type="dojo/connect" event="onClick" args="evt">';
echo   '    refreshPokerItemResult('.$obj->id.','.$pokerItem->id.',\''.$list.'\');';
echo   '  </script>';
echo '  </button>';
$disabled='';
if(!$previous){
  $disabled = 'disabled';
}
echo ' <button id="previousItem" dojoType="dijit.form.Button" class="roundedVisibleButton" style="vertical-align: middle;width: 120px;" '.$disabled.'>';
echo '   <div class="dijitButtonIcon dijitButtonIconPrevious" style="float:left"></div><span style="padding-left: 10px;">' . i18n('previous') . '</span>';
echo '   <script type="dojo/connect" event="onClick" args="evt">';
echo '     pokerItemNav('.$obj->id.','.$pokerItem->id.',\''.$list.'\', \'previous\');';
echo '   </script>';
echo ' </button>';
$disabled='';
if(!$next){
  $disabled = 'disabled';
}
echo '<span style="padding-left:5px">('.$pos.'/'.count($itemList).')</span>';
echo ' <button id="nextItem" dojoType="dijit.form.Button" style="vertical-align: middle;width: 120px;" class="roundedVisibleButton" '.$disabled.'>';
echo '   <span style="padding-right: 10px;">' . i18n('next') . '</span><div class="dijitButtonIcon dijitButtonIconNext" style="float:right"></div>';
echo '   <script type="dojo/connect" event="onClick" args="evt">';
echo '     pokerItemNav('.$obj->id.','.$pokerItem->id.',\''.$list.'\', \'next\');';
echo '   </script>';
echo ' </button>';
if($canUpdate){
	$name = i18n('flipPokerVote');
	if($pokerItem->flipped){
		$name = i18n('resetPokerVote');
	}
	echo ' <button id="flipPokerVote" dojoType="dijit.form.Button" style="vertical-align: middle;padding: 0px 5px 0px 5px;" class="roundedVisibleButton">';
	$icon = '&curarr;&nbsp;';
  	if($pokerItem->flipped)$icon='&orarr;&nbsp;';
  	echo '   <span>'.$icon . $name . '</span>';
	echo '   <script type="dojo/connect" event="onClick" args="evt">';
	if(!$pokerItem->flipped){
		echo '     flipPokerVote('.$obj->id.','.$pokerItem->id.',\''.$list.'\');';
	}else{
		echo '     resetPokerVote('.$obj->id.','.$pokerItem->id.',\''.$list.'\');';
	}
	echo '   </script>';
	echo ' </button>';
	echo ' <button id="closePokerVote" dojoType="dijit.form.Button" style="vertical-align: middle;padding: 0px 5px 0px 5px;" class="roundedVisibleButton">';
	echo '   <span>' . i18n('closePokerVote') . '</span>';
	echo '   <script type="dojo/connect" event="onClick" args="evt">';
	echo '     closePokerItemVote('.$pokerItem->id.','.$obj->id.');';
	echo '   </script>';
	echo ' </button>';
}
echo '</div>';
foreach ($pokerMemberList as $member){
  echo '<div style="float:left;padding: 0px 5px 10px 5px;"><table><tr>';
  echo '<td>';
  $pVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerItem'=>$pokerItem->id, 'idPokerSession'=>$obj->id, 'idResource'=>$member->idResource));
  $pComplex = PokerComplexity::getSingleSqlElementFromCriteria('PokerComplexity', array('value'=>$pVote->value));
  $style='';
  $color='white';
  if($lowVote == $pComplex->value){
  	$color='#65b577';
  }else if($highVote == $pComplex->value){
  	$color='#d46d6d';
  }
  if($pVote->id and $pComplex->id and $pokerItem->flipped){
    $style='background-color:'.$pComplex->color.';color:'.$color;
  }else if($pVote->id and !$pokerItem->flipped){
    $style='background-color:var(--color-medium);';
  }
  echo '<div class="card-on-table">';
    echo '<div class="card-wrapper-mini">';
      echo '<div class="card-container-mini">';
        echo '<div class="card-mini card-face" style="'.$style.'" align="center">';
          if($pVote->id and $pokerItem->flipped){
            echo '<div class="text-center player-vote-mini"><span>'.$pComplex->name.'</span></div>';
          }else if($pVote->id and !$pokerItem->flipped){
            echo '<div style="position: absolute;top: 20px;left: 8px;"><img style="height:32px;width:32px;" src="img/logoSmallWhite.png"></div>';
          }
        echo '</div>';
      echo '</div>';
    echo '</div>';
  echo '</div>';
  echo '</td>';
  echo '<td><div style="padding-left: 10px;width: 55px;">'.SqlList::getNameFromId('Affectable', $member->idResource).'</div></td>';
  echo '</tr></table></div>';
}
echo '</div>';
echo '</div></td></tr>';
echo '<tr><td><br></td></tr>';
echo '<tr><td>';
echo '<div id="pokerVoteResult" dojoType="dijit.layout.ContentPane" region="center" align="center" style="width: 100%;height: 100%;padding: 10px 0px 10px 0px;overflow: hidden;">';
$pokerMember = new PokerResource();
$pokerMember = $pokerMember->getSingleSqlElementFromCriteria('PokerResource', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id));
$pokerMemberList = $pokerMember->getSqlElementsFromCriteria(array('idPokerSession'=>$idPokerSession));
$pokerVote = new PokerVote();
$pokerVote = $pokerVote->getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id, 'idPokerItem'=>$pokerItem->id));
$pokerVoteList = SqlList::getListWithCrit('pokerVote', array('idPokerSession'=>$idPokerSession, 'idPokerItem'=>$pokerItem->id), 'value');
sort($pokerVoteList);
$lowVote = (isset($pokerVoteList[0]))?$pokerVoteList[0]:1;
$highVote = (isset($pokerVoteList[count($pokerVoteList)-1]))?$pokerVoteList[count($pokerVoteList)-1]:1;
if($pokerMember->id and !$obj->done){
  foreach ($pokerComplexityList as $pokerComplexity){
      $selected = ($pokerVote->id and $pokerVote->value == $pokerComplexity->value)?'selected':'';
      $onclick=(!$pokerItem->flipped)?'voteToPokerItem('.$obj->id.','.$pokerItem->id.',\''.$list.'\', '.$pokerComplexity->value.');':'';
      if($selected)$onclick='';
      $style='background-color:'.$pokerComplexity->color.';';
      if($selected)$style='background-color:white;color:'.$pokerComplexity->color.';';
      echo '<div class="card-rig card-in-hand '.$selected.'" onclick="'.$onclick.'">';
        echo '<div class="card-wrapper perspective-wrapper">';
          echo '<div class="card-container">
                  <div class="card card-face" style="'.$style.'">
                      <div class="small-card-id"><span>'.$pokerComplexity->value.'</span></div>
                      <div class="text-center player-vote"><span>'.$pokerComplexity->name.'</span></div>
                  </div>
                </div>';
        echo '</div>';
      echo '</div>';
  }
}
echo '</table>';
echo '</div>';
echo '</table>';
?>