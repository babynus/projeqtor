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
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projeqtor.php";
  require_once "../tool/formatter.php";
  scriptLog('   ->/view/dynamicDialogShowTickets.php');
  
  $refType=RequestHandler::getClass('refType');
  $refId=RequestHandler::getId('refId');

  $list=array();
  $stPeriod = new StatusPeriod();
  $list=$stPeriod->getSqlElementsFromCriteria(array('refType'=>$refType, 'refId'=>$refId));
  echo '<table style="width:100%;text-align:center">';
  echo '<tr>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colType') . '</td>';
  echo '<td class="linkHeader" style="width:15%">' . i18n('colStartDate') . '</td>';
  echo '<td class="linkHeader" style="width:15%">' . i18n('colEndDate') . '</td>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colIdStatusStart') . '</td>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colIdStatusEnd') . '</td>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colIdUserStart') . '</td>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colIdUserEnd') . '</td>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colDuration') . '</td>';
  echo '<td class="linkHeader" style="width:10%">' . i18n('colDurationOpenTime') . '</td>';
  echo '</tr>';
  foreach ( $list as $statusPeriod ) {
    echo '<tr>';
        echo '<td class="linkData" style="white-space:nowrap;width:10%">'.i18n('col'.ucfirst($statusPeriod->type)).'</td>';
    echo '<td class="linkData" style="white-space:nowrap;width:15%">'.htmlFormatDateTime($statusPeriod->startDate).'</td>';
    echo '<td class="linkData" style="white-space:nowrap;width:15%">'.htmlFormatDateTime($statusPeriod->endDate).'</td>';
    $objStatus=new Status($statusPeriod->idStatusStart);
    echo '<td class="dependencyData colorNameData"  style="width:10%">' . colorNameFormatter($objStatus->name . "#split#" . $objStatus->color) . '</td>';
    $objStatus=new Status($statusPeriod->idStatusEnd);
    echo '<td class="dependencyData colorNameData"  style="width:10%">' . colorNameFormatter($objStatus->name . "#split#" . $objStatus->color) . '</td>';
    $userName = SqlList::getNameFromId('User', $statusPeriod->idUserStart);
    echo '<td class="linkData" style="white-space:nowrap;width:10%">'.formatUserThumb($statusPeriod->idUserStart, $userName, 'Creator').' '.$userName.'</td>';
    $userName = SqlList::getNameFromId('User', $statusPeriod->idUserEnd);
    echo '<td class="linkData" style="white-space:nowrap;width:10%">'.formatUserThumb($statusPeriod->idUserEnd, $userName, 'Creator').' '.$userName.'</td>';
    echo '<td class="linkData" style="white-space:nowrap;width:10%">'.$statusPeriod->duration.'</td>';
    echo '<td class="linkData" style="white-space:nowrap;width:10%">'.$statusPeriod->durationOpenTime.'</td>';
    echo '</tr>';
  }
  echo '</table>';
?>