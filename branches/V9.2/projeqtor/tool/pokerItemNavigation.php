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
$pos = array_search($idItem, $itemList);
if($pos < 0)$pos=0;
$lenght = count($itemList)-1;
if($lenght < 0)$lenght=0;
if($nav == 'next'){
  $idItem = (isset($itemList[$pos+1]))?$itemList[$pos+1]:$itemList[$lenght];
}else if($nav == 'previous'){
  $idItem = (isset($itemList[$pos-1]))?$itemList[$pos-1]:itemList[0];
}
$pos = array_search($idItem, $itemList);
if($pos < 0)$pos=0;
$previous = ($pos>0)?true:false;
$lenght = count($itemList)-1;
if($lenght < 0)$lenght=0;
$next = ($pos<$lenght)?true:false;

$pokerComplexity = new PokerComplexity();
$pokerComplexityList = $pokerComplexity->getSqlElementsFromCriteria(array('idle'=>'0'), null, null, "sortOrder ASC");
$pokerItem = new PokerItem($idItem);
$pokerMember = new PokerResource();
$pokerMember = $pokerMember->getSingleSqlElementFromCriteria('PokerResource', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id));
$pokerMemberList = $pokerMember->getSqlElementsFromCriteria(array('idPokerSession'=>$idPokerSession));
$pokerVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id, 'idPokerItem'=>$pokerItem->id));
$pokerVoteList = SqlList::getListWithCrit('pokerVote', array('idPokerSession'=>$idPokerSession, 'idPokerItem'=>$pokerItem->id), 'value');
sort($pokerVoteList);
$lowVote = (isset($pokerVoteList[0]))?$pokerVoteList[0]:1;
$highVote = (isset($pokerVoteList[count($pokerVoteList)-1]))?$pokerVoteList[count($pokerVoteList)-1]:99;
echo '<table style="width: 100%;"><tr><td>';
echo '<div id="pokerVoteDescription" dojoType="dijit.layout.ContentPane" region="center" align="center" style="width: 100%;"><table><tr>';
echo '<td class="" style="width:50%;text-align: right;padding-right: 10px;padding-top: 5px;">'.i18n('colType').'</td>';
echo '<td class="noteData" style="position:absolute;min-width:232px;height:15px;border-radius: 5px;">'.$pokerItem->refType.' #'.$pokerItem->refId.'</td>';
echo '</tr><tr><td><br></td></tr><tr>';
echo '<td class="" style="width:50%;text-align: right;padding-right: 10px;padding-top: 5px;" coslpan="2">'.i18n('colName').'</td>';
echo '<td class="noteData" style="position:absolute;min-width:232px;height:15px;border-radius: 5px;">'.$pokerItem->name.' #'.$pokerItem->id.'</td>';
echo '</tr>';
echo '</tr><tr><td><br></td></tr><tr>';
echo '<td class="" style="width:50%;text-align: right;padding-right: 10px;padding-top: 5px;">'.i18n('colDescription').'</td>';
echo '<td class="noteData" style="position:absolute;min-width:232px;height:15px;border-radius: 5px;">'.htmlEncode($pokerItem->comment).'</td>';
echo '</tr>';
echo '</table></div></td></tr>';
echo '<tr><td><br><br></td></tr><tr>';
echo '<tr><td>';
echo '<div id="pokerVoteResult" dojoType="dijit.layout.ContentPane" region="center" align="center" style="width: 100%;">';
$pokerMember = new PokerResource();
$pokerMember = $pokerMember->getSingleSqlElementFromCriteria('PokerResource', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id));
$pokerMemberList = $pokerMember->getSqlElementsFromCriteria(array('idPokerSession'=>$idPokerSession));
$pokerVote = new PokerVote();
$pokerVote = $pokerVote->getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id, 'idPokerItem'=>$pokerItem->id));
$pokerVoteList = SqlList::getListWithCrit('pokerVote', array('idPokerSession'=>$idPokerSession, 'idPokerItem'=>$pokerItem->id), 'value');
sort($pokerVoteList);
$lowVote = (isset($pokerVoteList[0]))?$pokerVoteList[0]:1;
$highVote = (isset($pokerVoteList[count($pokerVoteList)-1]))?$pokerVoteList[count($pokerVoteList)-1]:1;
if(!$pokerVote->id and !$pokerItem->value and $pokerMember->id and !$obj->done){
  echo '<table>';
  echo '<tr>';
  echo '<td align="center" class="imageColorNewGui" style="width:32px">';
  if($previous){
    echo '<div class="dijitButtonIcon dijitButtonIconPrevious" style="cursor:pointer;position:absolute;top:10px;" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'previous\');"></div>';
  }
  echo '</td>';
  echo '<td><table style="width:200px;margin: 5px;" class="pokerComplexityTable"><tr><td>';
  echo '<tr><td style="width:50%;text-align:center;border-bottom: unset;" class="noteHeader">'.i18n('colMyPokerVote').'</td></tr>';
  foreach ($pokerComplexityList as $pokerComplexity){
    echo '<tr>';
    echo '<td class="pokerComplexity" style="width:50%;height:15px;text-align:center;cursor:pointer;" onclick="voteToPokerItem('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', '.$pokerComplexity->value.');">'.$pokerComplexity->name.'</td>';
    echo '</tr>';
  }
  echo '</td></tr></table></td>';
  echo '<td align="center" class="imageColorNewGui" style="width:32px">';
  if($next){
    echo '<div class="dijitButtonIcon dijitButtonIconNext" style="cursor:pointer;position:absolute;top:10px;" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'next\');"></div>';
  }
  echo '</td>';
  echo '</tr>';
}else{
  echo '<table>';
  echo '<tr>';
  echo '<td align="center" class="imageColorNewGui" style="width:32px">';
  if($previous){
    echo '<div class="dijitButtonIcon dijitButtonIconPrevious" style="cursor:pointer;position:absolute;top:10px;" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'previous\');"></div>';
  }
  echo '</td>';
  echo '<td><table><tr><td>';
  $count = 0;
  foreach ($pokerMemberList as $member){
    $pokerVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$member->idResource, 'idPokerItem'=>$pokerItem->id));
    $count++;
    echo '<div style="float:left"><table style="width:200px;margin: 5px;">';
    echo '<tr><td style="width:50%;text-align:center;border-bottom: unset;" class="noteHeader">'.htmlEncode(SqlList::getNameFromId("Resource", $member->idResource)).'</td></tr>';
    foreach ($pokerComplexityList as $pokerComplexity){
        $class = 'pokerComplexityResult';
        if($pokerVote->id and $pokerVote->value == $pokerComplexity->value and $pokerVote->value == $lowVote){
          $class = 'pokerComplexitySelectedLow';
        }else if($pokerVote->id and $pokerVote->value == $pokerComplexity->value and $pokerVote->value == $highVote){
          $class = 'pokerComplexitySelectedHigh';
        }else if($pokerVote->id and $pokerVote->value == $pokerComplexity->value and $pokerVote->value == $pokerItem->value){
          $class = 'pokerComplexitySelectedValue';
        }
        $onclick='';
        if($member->idResource == $user->id){
          $class .= ' pokerComplexity';
          $onclick='voteToPokerItem('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', '.$pokerComplexity->value.');';
        }
    	echo '<tr>';
    	echo '<td class="'.$class.'" style="width:50%;height:15px;text-align:center;" onclick="'.$onclick.'">'.$pokerComplexity->name.'</td>';
    	echo '</tr>';
    }
    echo '</table></div>';
  }
  echo '</table>';
  echo '<td align="center" class="imageColorNewGui" style="width:32px">';
  if($next){
    echo '<div class="dijitButtonIcon dijitButtonIconNext" style="cursor:pointer;position:absolute;top:10px;" onclick="pokerItemNav('.$idPokerSession.','.$pokerItem->id.',\''.$list.'\', \'next\');"></div>';
  }
  echo '</td>';
}
echo '</table>';
echo '</div>';
echo '</table>';
?>