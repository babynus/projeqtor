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
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/refreshSubTaskAttachmentDiv.php'); 


$refType=(RequestHandler::isCodeSet('refType'))?RequestHandler::getClass('refType'):null;
$refId=(RequestHandler::isCodeSet('refId'))?RequestHandler::getId('refId'):null;
$idResource=(RequestHandler::isCodeSet('idResource'))?RequestHandler::getValue('idResource'):null;
$view=(RequestHandler::isCodeSet('view'))?RequestHandler::getValue('view'):false;
if(!$view){
  traceHack("refreshSubTask.php called illegally ");
  exit;
}else{
  if($view=='Global')$view=true;
  else $view=false;
}
$obj= new $refType($refId);
$rightUpdate=securityGetAccessRightYesNo('menu'.get_class($obj),'update',$obj);
$rightRead=securityGetAccessRightYesNo('menu'.get_class($obj),'read',$obj);

      SubTask::drawSubtasksForObject($obj,$refType, $refId,$rightUpdate,$rightRead,true,$idResource,$view);

?>
