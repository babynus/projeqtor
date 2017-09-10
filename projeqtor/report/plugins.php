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

include_once '../tool/projeqtor.php';
//echo 'versionReport.php';

$plg=new Component();
$plgList=$plg->getSqlElementsFromCriteria(array('idComponentType'=>'141'),false,null,'designation asc');
$style='padding:2px 10px';
$border='border:1px solid #000000;';
$borderLeft='border-left:1px solid #000000';
$borderRight='border-right:1px solid #000000';
echo "<table style='font-family:arial;border-collapse:collapse;'>";
echo "<tr style='color:white;background:#545381'>";
echo "<td style='$style;$border'>Unique Code</td>";
echo "<td style='$style;$border'>Plugin</td>";
echo "<td style='$style;$border'>Ticket</td>";
echo "<td style='$style;$border'>Version</td>";
echo "<td style='$style;$border'>Compatibility</td>";
echo "</tr>";
echo "<tr><td colspan='5'><span style='font-size:50%'>&nbsp;</span></td></tr>";
$currentVers=null;
foreach ($plgList as $plg) {
  echo "<tr>";
  $vers=new ComponentVersion();
  $versList=$vers->getSqlElementsFromCriteria(array('idComponent'=>$plg->id));
  $color=(count($versList)==0)?'#FFE0E0':'#E0FFE0';
  echo "<td style='$style;background:$color;$border;text-align:center;'>$plg->designation</td>";
  echo "<td style='$style;background:$color;$border'>$plg->name</td>";
  foreach ($versList as $vers) {
    $tkt=new Ticket();
    $tktList=$tkt->getSqlElementsFromCriteria(array('idTargetComponentVersion'=>$vers->id));
    foreach($tktList as $tkt) {
      $borderTop=($vers->id!=$currentVers)?'border-top:1px solid #000000':'';
      $currentVers=$vers->id;
      $pos=strrpos($vers->name, ' V');
      $vnum=substr($vers->name,$pos+1);
      $color=($tkt->done)?'#E0FFE0':'#FFE0E0';
      $tktName='#'.$tkt->id.' - '.$tkt->name;
      echo "<td style='$borderLeft;$borderTop;$style;background:$color;'>$tktName</td>";
      $color=($vers->isEis)?'#E0FFE0':'#FFE0E0';
      echo "<td style='$borderTop;$style;background:$color;text-align:center;'>$vnum</td>";
      echo "<td style='$borderRight;$borderTop;$style;background:$color;text-align:center;'></td>";
      echo "</tr>";
      echo "<tr>";
      echo "<td><span style='font-size:50%'>&nbsp;</span></td>";
      echo "<td><span style='font-size:50%'>&nbsp;</span></td>";
    }
  }
}
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "</table>";
?>