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
$id=RequestHandler::getId('idPokerItem');
$mode = RequestHandler::getValue('mode');
$pokerItem = new PokerItem($id);
if($mode=='open'){
  $pokerItem->isOpen = 1;
}else if($mode=='pause'){
  $pokerItem->isOpen = 0;
}else if($mode=='close'){
  $idComplexity = RequestHandler::getValue('idComplexity');
  $comp = new PokerComplexity($idComplexity);
  $pokerItem->value = $comp->value;
  $pokerItem->isOpen = 0;
}
$pokerItem->save();
?>