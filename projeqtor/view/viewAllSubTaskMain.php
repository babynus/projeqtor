<?php 
use PhpOffice\PhpPresentation\Shape\Chart\Type\Area;
use Mpdf\Utils\Arrays;
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
 * Presents an object. 
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
  scriptLog('   ->/view/imputationValidationMain.php');  
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="SubTask" />
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top"  style="height:<?php if(isNewGui()){?>70px;<?php }else{?>64px;<?php }?>">
   <?php  include 'viewAllSubTaskList.php' ;?>
  </div>
  <div id="subTaskListDiv" name="subTaskListDiv" dojoType="dijit.layout.ContentPane" region="center"  style="<?php if(isNewGui()){?>max-height:95%;overflow-y: auto;<?php }else{?>height:95%;overflow-y:scroll;<?php }?>" >
    <form dojoType="dijit.form.Form" name="SubTaskForm" id="SubTaskForm"  method="Post" >
      <div  align="center" style="margin-top:20px;margin-bottom:30px; overflow-y:auto; width:100%;">
        <?php 
        if(trim($idVersion)=='')$idVersion=0;
        if(trim($idResource)=='')$idVersion=0;
        SubTask::drawAllSubTask($idProject,$idResource,$element,$idVersion);
        ?>
      </div>
    </form>
  </div>
