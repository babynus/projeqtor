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

/** ===========================================================================
 * Acknowledge an operation
 */
if (!isset($user)) {
  $user=getSessionUser();
}
if ( ! isset($specific) or ! $specific) {
  errorLog("drawResourceListForSpecificAccess.php : specific variable not set");
  $specific="null"; // Avoid error
}
$table=array();
if (! $user->isResource) {
  $table[0]=' ';
}
$table = getListForSpecificRights($specific);

$selectedProject=getSessionValue('project');
if ($selectedProject and $selectedProject!='*' and (!isset($limitResourceByProj) or $limitResourceByProj=='on') ) {
	$restrictTable=array();
	$prj=new Project( $selectedProject , true);
	$lstTopPrj=$prj->getTopProjectList(true);
	$in=transformValueListIntoInClause($lstTopPrj);
	$crit='idProject in ' . $in;
	$aff=new Affectation();
	$lstAff=$aff->getSqlElementsFromCriteria(null, false, $crit, null, true);
	foreach ($lstAff as $id=>$aff) {
		if (array_key_exists($aff->idResource,$table)) {
			$restrictTable[$aff->idResource]=$table[$aff->idResource];
		}
	}
	$table=$restrictTable;
}
if (!isset($table[$user->id])) {
  $table[$user->id]=$user->name;
}
foreach($table as $key => $val) {
  echo '<option value="' . $key . '"';
  if ( $key==$user->id and ! isset($specificDoNotInitialize)) { echo ' SELECTED '; }
  echo '>' . $val . '</option>';
}
?>
