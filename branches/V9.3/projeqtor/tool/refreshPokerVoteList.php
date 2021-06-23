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
$user = getSessionUser();

$obj = new PokerSession($idPokerSession);

$pokerItem = new PokerItem($id);
$pokerMember = new PokerResource();
$pokerMember = $pokerMember->getSingleSqlElementFromCriteria('PokerResource', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id));
$pokerMemberList = $pokerMember->getSqlElementsFromCriteria(array('idPokerSession'=>$idPokerSession));
$pokerVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerSession'=>$idPokerSession, 'idResource'=>$user->id, 'idPokerItem'=>$pokerItem->id));

foreach ($pokerMemberList as $member){
  echo '<div style="float:left;padding: 0px 5px 10px 5px;"><table><tr>';
  echo '<td>';
  $pVote = PokerVote::getSingleSqlElementFromCriteria('PokerVote', array('idPokerItem'=>$pokerItem->id, 'idPokerSession'=>$obj->id, 'idResource'=>$member->idResource));
  $pComplex = PokerComplexity::getSingleSqlElementFromCriteria('PokerComplexity', array('value'=>$pVote->value));
  $style='';
  if($pVote->id and $pComplex->id){
    $style='background-color:'.$pComplex->color.';';
  }
  echo '<div class="card-on-table">';
    echo '<div class="card-wrapper-mini">';
      echo '<div class="card-container-mini">';
        echo '<div class="card-mini card-face" style="'.$style.'" align="center">';
          if($pVote->id and $pVote->flipped){
            echo '<div class="text-center player-vote-mini"><span>'.$pComplex->name.'</span></div>';
          }else if($pVote->id and !$pVote->flipped){
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
?>