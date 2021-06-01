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
$id=RequestHandler::getId('idItem');
$idPokerSession=RequestHandler::getId('idPokerSession');
$list = RequestHandler::getValue('itemList');
$itemList=explode(',',$list);
$nav=RequestHandler::getValue('nav');
$user = getSessionUser();

$pos = array_search($id, $itemList);
if($pos < 0)$pos=0;
$lenght = count($itemList)-1;
if($lenght < 0)$lenght=0;
if($nav == 'next'){
  $idItem = (isset($itemList[$pos+1]))?$itemList[$pos+1]:$itemList[0];
}else{
  $idItem = (isset($itemList[$pos-1]))?$itemList[$pos-1]:$itemList[$lenght];
}
$pokerItem = new PokerItem($idItem);
$pokerMember = new PokerResource();
$pokerMemberList = $pokerMember->getSqlElementsFromCriteria(array('idPokerSession'=>$idPokerSession));
$pokerVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id, 'idPokerItem'=>$pokerItem->id));
$pokerVoteList = SqlList::getListWithCrit('pokerVote', array('idPokerSession'=>$idPokerSession, 'idPokerItem'=>$pokerItem->id), 'value');
sort($pokerVoteList);
$lowVote = $pokerVoteList[0];
$highVote = $pokerVoteList[count($pokerVoteList)-1];
echo '<table style="width: 100%;"><tr><td>';
echo '<div><table style="width: 50%;"><tr>';
echo '<td class="" style="width:50%;text-align: right;padding-right: 10px;padding-top: 5px;">'.i18n('colType').'</td>';
echo '<td class="noteData" style="position:absolute;min-width:232px;height:15px;">'.$pokerItem->refType.' #'.$pokerItem->refId.'</td>';
echo '</tr><tr><td><br></td></tr><tr>';
echo '<td class="" style="width:50%;text-align: right;padding-right: 10px;padding-top: 5px;" coslpan="2">'.i18n('colName').'</td>';
echo '<td class="noteData" style="position:absolute;min-width:232px;height:15px;">'.$pokerItem->name.'</td>';
echo '</tr>';
echo '</tr><tr><td><br></td></tr><tr>';
echo '<td class="" style="width:50%;text-align: right;padding-right: 10px;padding-top: 5px;">'.i18n('colDescription').'</td>';
echo '<td class="noteData" style="position:absolute;min-width:232px;height:15px;">'.htmlEncode($pokerItem->comment).'</td>';
echo '</tr>';
echo '</table></div></td></tr>';
echo '<tr><td><br><br></td></tr><tr>';
echo '<tr><td>';
echo '<div id="pokerVoteResult" dojoType="dijit.layout.ContentPane" align="center" style="width: 100%;">';
if(!$pokerVote->id and !$pokerItem->value){
	echo '<table style="width: 100%;">';
	echo '<tr>';
	echo '<td align="center" class="imageColorNewGui" style="cursor:pointer" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'previous\');"><div class="dijitButtonIcon dijitButtonIconPrevious"></div></td>';
	echo '<td><table style="width: 100%;" class="pokerComplexityTable"><tr><td>';
	echo '<tr><td style="width:50%;text-align:center;border-bottom: unset;" class="noteHeader">'.i18n('colMyVote').'</td></tr>';
	$pokerComplexityList = array(1,2,3,4,5,6,7,8,9,'?');
	foreach ($pokerComplexityList as $pokerComplexity){
		echo '<tr>';
		echo '<td class="pokerComplexity" style="width:50%;height:15px;text-align:center;cursor:pointer;" onclick="voteToPokerItem('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', '.$pokerComplexity.');">'.$pokerComplexity.'</td>';
		echo '</tr>';
	}
	echo '</td></tr></table></td>';
	echo '<td align="center" class="imageColorNewGui" style="cursor:pointer" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'next\');"><div class="dijitButtonIcon dijitButtonIconNext"></div></td>';
	echo '</tr>';
}else{
	echo '<table style="width: 50%;">';
	echo '<tr>';
	echo '<td align="center" class="imageColorNewGui" style="cursor:pointer;padding-right: 10px;" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'previous\');"><div class="dijitButtonIcon dijitButtonIconPrevious"></div></td>';
	echo '<td><table><tr>';
	$count = 0;
	foreach ($pokerMemberList as $member){
        $pokerVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$member->idResource, 'idPokerItem'=>$pokerItem->id));
		$count++;
		echo '<td><table style="width:200px;margin-right: 10px;">';
		echo '<tr><td style="width:50%;text-align:center;border-bottom: unset;" class="noteHeader">'.htmlEncode(SqlList::getNameFromId("Resource", $member->idResource)).'</td></tr>';
		$pokerComplexityList = array(1,2,3,4,5,6,7,8,9,'?');
		foreach ($pokerComplexityList as $pokerComplexity){
            $class = 'pokerComplexityResult';
            if($pokerVote->id and $pokerVote->value == $pokerComplexity and $pokerVote->value == $lowVote){
            	$class = 'pokerComplexitySelectedLow';
            }else if($pokerVote->id and $pokerVote->value == $pokerComplexity and $pokerVote->value == $highVote){
            	$class = 'pokerComplexitySelectedHigh';
            }else if($pokerVote->id and $pokerVote->value == $pokerComplexity and $pokerVote->value == $pokerItem->value){
            	$class = 'pokerComplexitySelectedValue';
            }
			echo '<tr>';
			echo '<td class="'.$class.'" style="width:50%;height:15px;text-align:center;" onclick="voteToPokerItem('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', '.$pokerComplexity.');">'.$pokerComplexity.'</td>';
			echo '</tr>';
		}
		echo '</table>';
		if($count >= 3){
			echo '</tr><tr><td><br></td></tr><tr>';
			$count = 0;
		}
	}
	echo '</table></td>';
	echo '<td align="center" class="imageColorNewGui" style="cursor:pointer" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'next\');"><div class="dijitButtonIcon dijitButtonIconNext"></div></td>';
}
echo '</table>';
echo '</div>';
echo '</table>';
?>