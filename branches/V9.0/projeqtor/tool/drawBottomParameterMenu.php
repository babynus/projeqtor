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
 * Presents left menu of application.
*/
require_once "../tool/projeqtor.php";

$screen=(RequestHandler::isCodeSet('currentScreen'))?RequestHandler::getValue('currentScreen'):'';
$isObject=(RequestHandler::isCodeSet('isObject'))?RequestHandler::getValue('isObject'):'false';
$result='';

if($isObject=='true' and $screen!=''){
  $obj=new $screen();
  $lstParam=array();
  foreach ( $obj as $key=>$val){
    if(substr($key, 0,2)=='id' and $key!='idle' and $key!='idleDateTime' and $key!='id' and $key!='id'.$screen){
      if(strpos($key,'idContext')!==false){
        $lstParam[]='Context';
      }else{
        $lstParam[]=substr($key,2);
      }
    }
  }
  
}else{
  switch ($screen){
  	case 'Today':
  	  break;
  	case 'Planning':
  	    break;
  	case  'PortfolioPlanning':
  	    break;
    case 'ResourcePlanning': 
        break;
    case  'GlobalPlanning':
        break;
    case  'HierarchicalBudget':
        break;
    case  'GanttClientContract' :
        break;
    case 'GanttSupplierContract':
        break;
    case  'Imputation':
        break;
    case  'Diary':
        break;
    case  'ActivityStream':
        break;
    case  'ImportData':
        break;
    case  'Reports':
        break;
    case  'Absence':
        break;
    case  'PlannedWorkManual' :
        break;
    case 'ConsultationPlannedWorkManual':
        break;
    case  'ImputationValidation':
        break;
    case 'ConsultationValidation':
        break;
    case  'AutoSendReport':
        break;
    case  'DataCloning':
        break;
    case 'DataCloningParameter': 
      break;
    case 'VersionsPlanning':   
      break;
    case 'VersionsComponentPlanning':
      break;
    case 'UserParameter': 
      break;
    case 'ProjectParameter': 
      break;
    case 'GlobalParameter': 
      break;
    case 'Habilitation': 
      break;
    case 'HabilitationReport': 
      break;
    case 'HabilitationOther': 
      break;
    case 'AccessRight': 
      break;
    case 'AccessRightNoProject': 
      break;
    case 'Admin': 
      break;
    case 'Plugin':  
      break;
    case 'PluginManagement': 
      break;
    case 'Calendar': 
      break;
    case 'Gallery': 
      break;
    case 'DashboardTicket': 
      break;
    case 'DashboardRequirement': 
       break;
    case "LeaveCalendar": 
      break;
    case "LeavesSystemHabilitation": 
      break;
    case "DashboardEmployeeManager" :
       break;
    case "Module" :
       break;
    case "Kanban": 
      break;
    default:
      break;
  }
}

$result.='<div style="margin-top:10px;color:white;margin-left:10px;">'.$screen.'</div>';





echo $result;
?>