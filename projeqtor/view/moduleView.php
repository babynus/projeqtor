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

/*
 * ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/view/module.php');
$user=getSessionUser();
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Module" />
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div style="height:48px" id="listDiv" dojoType="dijit.layout.ContentPane" region="top" 
    style="text-align:center;width:100%;font-size:250%;font-weight:bold; " class="listTitle">
      <div style="text-align:center;width:100%;padding-top:5px;font-size:250%;font-weight:bold; ">
        <?php echo i18n("menuModule")?>
      </div>
      <button id="saveParameterButton" dojoType="dijit.form.Button" showlabel="true" 
        title="<?php echo i18n("applyChanges");?>"
        style="position:absolute;top:10px;right:20px;color:#707070;font-weight:bold" class="" enabled="true"
        iconClass="dijitButtonIcon dijitButtonIconSave" class="detailButton">
        <script type="dojo/connect" event="onClick" args="evt">
		        var url="../tool/resetModuleTablesInSession.php";
            dojo.xhrPost({
            url : url,
            load : function(data, args) {
              dojo.byId("saveParameterButton").blur();
              disableWidget("applyButton");
              showWait();
              noDisconnect=true;
              quitConfirmed=true;
<?php         if (getSessionValue('showModule')) {
                $firstPage=getSessionValue('showModule');
                unsetSessionValue('showModule');?>
                dojo.byId("directAccessPage").value="<?php echo $firstPage;?>";
<?php         } else { ?> 
                dojo.byId("directAccessPage").value="moduleView.php";
<?php         } ?>
              dojo.byId("menuActualStatus").value=menuActualStatus;
              dojo.byId("p1name").value="type";
              dojo.byId("p1value").value=forceRefreshMenu;
              forceRefreshMenu="";
              dojo.byId("directAccessForm").submit();
            },
            error : function () {
             consoleTraceLog("error resetting module tables in session");
            }
          });
        </script>
       <?php echo i18n("applyChanges");?>
      </button>
    </div> 
    
    <?php $mod=new Module();
          $modList=$mod->getSqlElementsFromCriteria(null,null,null,'sortOrder asc');
          $nbTotal = count($modList);
          $simuIndex=Parameter::getGlobalParameter('simuIndex');
          global $hosted;
          if ($hosted===true) $simuIndex=1; // Will hide Simulation Module for hosted 
          $moduleEnable = array();
          foreach ($modList as $mod){
            if($mod->active){
              $moduleEnable[$mod->id]=$mod->id;
            }
          }
          ?>
    
    <div style="overflow-y:auto;overflow-x:hidden;padding:10px" id="detailDiv" dojoType="dijit.layout.ContentPane" region="center" >
    <table style="margin:20px; width:100%">
    <tr>
      <td>
      
      <div style="margin-bottom:50px;width:100%;height:130px; ">
       <div style="cursor:pointer;border-radius:5px;float:left;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;"
            onclick="filterMenuModule(1,<?php echo $nbTotal; ?>);">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px;" class=" <?php if(isNewGui()){?>imageColorNewGui<?php }?> iconPlanning iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('allModule');?></div>
       </div>
       
         <div onclick="filterMenuModule(2,<?php echo $nbTotal; ?>);" style="cursor:pointer;border-radius:5px;float:left;margin-left:35px;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px" class="<?php if(isNewGui()){?>imageColorNewGui<?php }?> iconPlanning iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('menuPlanning');?></div>
       </div>
       
       <div onclick="filterMenuModule(3,<?php echo $nbTotal; ?>);" style="cursor:pointer;border-radius:5px;float:left;margin-left:35px;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px" class="<?php if(isNewGui()){?>imageColorNewGui<?php }?> iconPlanning iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('moduleTimeTracking');?></div>
       </div>
       
      <div onclick="filterMenuModule(4,<?php echo $nbTotal; ?>);" style="cursor:pointer;border-radius:5px;float:left;margin-left:35px;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px" class="<?php if(isNewGui()){?>imageColorNewGui<?php }?> iconSteering  iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('menuSteering');?></div>
       </div>
       
   <div onclick="filterMenuModule(5,<?php echo $nbTotal; ?>);" style="cursor:pointer;border-radius:5px;float:left;margin-left:35px;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px" class="<?php if(isNewGui()){?>imageColorNewGui<?php }?> iconFinancial iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('menuFinancial');?></div>
       </div>
       
      <div onclick="filterMenuModule(6,<?php echo $nbTotal; ?>);" style="cursor:pointer;border-radius:5px;float:left;margin-left:35px;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px" class="<?php if(isNewGui()){?>imageColorNewGui<?php }?> iconAdministration iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('moduleTechnical');?></div>
       </div>
       
       <div  onclick="filterMenuModuleDisable(<?php echo $nbTotal; ?>);" style="cursor:pointer;border-radius:5px;float:left;margin-left:35px;position:relative;width:120px;height:120px;border:solid 1px #e6e6e6;box-shadow:2px 2px #e6e6e6;background-color:white;">
        <div style="background-size:60px;width:60px;height:60px;position:absolute;left:0;right:0;margin:auto;top:10px" class="<?php if(isNewGui()){?>imageColorNewGui<?php }?> iconAdministration iconSize32"></div>
        <div style="position:absolute;left:0;right:0;margin:auto;bottom:10px;text-align:center;"> <?php echo i18n('moduleDisable');?></div>
       </div>
      </div>
    
    <?php 
    
    foreach ($modList as $mod) {
      if($simuIndex and $mod->name == 'moduleDataCloning'){
        continue;
      }?>
          <div id="moduleMenuDiv_<?php echo $mod->id;?>" style="width:330px;"  <?php if($mod->active){?> class="activeModuleMenu"<?php }?> >
            <div id="module_<?php echo $mod->id;?>" style="margin-top:5px;float:left;" dojoType="dijit.form.CheckBox" 
                 parent="<?php if ($mod->idModule) {echo $mod->idModule;}?>" type="checkbox" <?php echo ($mod->active)?'checked="checked"':'';?> 
                 class="moduleClass <?php if ($mod->idModule) {echo 'parentModule'.$mod->idModule;}?>" 
                 onclick="saveModuleStatus(<?php echo $mod->id?>,this.checked);" data-dojo-props="" >
            </div>
            <div id="moduleTitle_<?php echo $mod->id;?>"  style="cursor:pointer;z-index:100;border-radius:4px;display: flex; align-items: center;font-family: Verdana, Arial, Tahoma, sans-serif !important;font-size: 10pt !important;width:260px;height:28px;
                   margin-left:35px;margin-bottom:3px;<?php if (!$mod->idModule){?>color:white; <?php if($mod->active){?> background-color:#B0D0B0; <?php }else{?>background-color:#B0B0B0; <?php } ?><?php  }else{ if($mod->active){?>color:white !important; background-color:#91db8f; <?php }else{?>color:#B0B0B0; background-color:#e6e6e6;<?php } }?>" onClick="showDisplayModule(<?php echo $mod->id;?>,<?php echo $nbTotal;?>);">
              <?php if ($mod->idModule) echo "<div style='height:100%;background-color:white;width:40px;float:left'></div>";?>
              <div style="margin-left:10px;"><?php echo i18n($mod->name);?></div>
            </div>
          </div>
          
          <?php $modMenu=new ModuleMenu();
                $modMenuList=$modMenu->getSqlElementsFromCriteria(array('idModule'=>$mod->id),null,null,'id asc');
               $height = 'height:350px';
               if(count($modMenuList)>=10){
                $height = 'height:450px';
               }
               if(count($modMenuList)>=20){
                $height = 'height:550px';
               }
               if(count($modMenuList)>=30){
                $height = 'height:650px';
               }
               if(count($modMenuList)>40){
                $height = 'height:750px';
               }
               if($mod->id==15){
                 $height='height:450px';
               }
          ?>
          
          <div id="displayModule<?php echo $mod->id;?>" style="<?php echo $height;?>;width:900px;display:none;z-index:-1;position:absolute;top:205px;margin-left:280px;background-color:#f2f2f2; -webkit-transition: opacity 600ms, visibility 600ms;transition: opacity 600ms, visibility 600ms;  opacity: 0;
                   visibility: hidden;">
            <div style="font-size:18px;margin-top:20px;margin-left:70px;"><?php echo i18n($mod->name);?></div>
            <div style="margin-top:40px;width:100%">
              <div class="simpleText" style="margin-left:70px;width:300px;vertical-align:top; text-align:justify;margin-right:50px;"><?php echo i18n($mod->name.'Comment');?></div>
              <div style="margin-right:100px;margin-left:450px;position:absolute;top:86px;border-left:solid 1px black;">
                    <div style="margin-left:30px;margin-bottom:20px;"><?php  if($mod->id != 5)echo i18n('activateScreen');?></div>
                <?php
                  foreach ($modMenuList as $modMenu) {
                    if ($modMenu->hidden) continue;
                    $menuName=SqlList::getNameFromId('Menu', $modMenu->idMenu,false);
                    $class=substr($menuName,4);
                    $imageColorNewGui = "";
                    if(isNewGui()){
                      $imageColorNewGui = 'imageColorNewGui';
                    }
                    echo "<div style='margin-left:30px;float:left;clear:left;padding-top:10px' class='$imageColorNewGui icon$class iconSize22 icon".$class."22'></div>";
                    echo "<div style='float:left;padding-left:10px;padding-top:3px;' class='simpleText bold'>".i18n($menuName)."</div>"; 
                  }
                  ?>
              </div>
            </div>
          </div>
          
    <?php }?>
    </td></tr>
    </table>
  </div>
</div>