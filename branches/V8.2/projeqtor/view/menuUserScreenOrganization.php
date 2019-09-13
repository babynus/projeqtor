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

include_once("../tool/projeqtor.php");
include_once '../tool/formatter.php';
$iconSize=32;
$showMenuBar=Parameter::getUserParameter('paramShowMenuBar');
$showMenuBar='YES';
if (! $iconSize or $showMenuBar=='NO') $iconSize=16;
//Param
$currentScreen="";
if(isset($_REQUEST['currentScreen'])){
  $currentScreen=$_REQUEST['currentScreen'];
}
debugLog($currentScreen);
if(sessionValueExists("paramScreen")){
  if(getSessionValue("paramScreen")=='5') {
  	  Parameter::storeUserParameter("paramScreen", '1');
  	  
  }
  setSessionValue("paramScreen", "0");
}
$paramScreen=Parameter::getUserParameter('paramScreen');
$paramRightDiv=Parameter::getUserParameter('paramRightDiv');
$paramObjectDetail=Parameter::getUserParameter('paramLayoutObjectDetail');
if($paramRightDiv=='3'){
  $ActivityStream=Parameter::getUserParameter('contentPaneRightDetailDivHeight'.$currentScreen);
  debugLog($ActivityStream);
}else{
  $ActivityStream=Parameter::getUserParameter('contentPaneRightDetailDivWidth'.$currentScreen);
}
debugLog($ActivityStream);
?>

<div id="mainDivMenu" class="container" >
 <table width="100%">
    <tr height="<?php echo $iconSize+8; ?>px">  
      <td width="<?php echo (isIE())?37:35;?>px" > 
        <div id="changeLayout" class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px;
        <?php if( $paramScreen=='5'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("buttonSwitchedMode");?>"
         onclick="<?php if($paramScreen=='1' or $paramScreen=='2'){echo 'switchModeLayout(\'5\')';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconChangeLayout22 iconChangeLayout iconSize22" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="horizontalLayout"  class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramScreen=='1'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("showListTop");?>"
        onclick="<?php if($paramScreen=='2' or $paramScreen=='5'){echo 'switchModeLayout(\'1\');';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="horizontalLayoutClass" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="verticalLayout" lass="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramScreen=='2'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("showListLeft"); ?>"
        onclick="<?php if($paramScreen=='1' or $paramScreen=='5' ){echo 'switchModeLayout(\'2\');';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="verticalLayoutClass" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
    </tr>
    <tr height="<?php echo $iconSize+8; ?>px">  
      <td width="<?php echo (isIE())?37:35;?>px"> 
        <div id="layoutList" class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramObjectDetail=='4'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("sectionMode");?>"
        onclick="<?php if($paramObjectDetail=='0'){echo 'switchModeLayout(\'4\');';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconLayoutList22 iconLayoutList iconSize22" style="position:absolute;top:2px;left:4px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="layoutTab" class="pseudoButton"   style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramObjectDetail=='0'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" 
        title="<?php echo i18n("tabularMode");?>"
        onclick="<?php if($paramObjectDetail=='4'){echo 'switchModeLayout(\'0\');';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconLayoutTab22 iconLayoutTab iconSize22 " style="position:absolute;top:2px;left:4px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="hideStreamButton" class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" 
        onclick="hideStreamMode(<?php if($paramRightDiv=='3'){echo'1';}else{echo'0';}?>,false);">
          <table >
            <tr>
              <td >
              <?php if($ActivityStream==0){ debugLog('ici');?>
                <div class="iconActivityStream22 iconActivityStream iconSize22 " style="position:absolute;top:2px;left:3px" title="<?php echo i18n("showActivityStream");?>"></div>
              <?php }else{?>
                <div class="iconActivityStreamClose22 iconActivityStreamClose iconSize22 " style="position:absolute;top:2px;left:3px" title="<?php echo i18n("hideActivityStream");?>"></div>
              <?php }?>
              </td>
            </tr>
          </table>    
       </div>
      </td>
    </tr>
    <tr>
    <td width="<?php echo (isIE())?37:35;?>px">
	   <div id="hideMenuBarBottom" class="pseudoButton" onClick="hideMenuBarShowMode();" title="<?php echo i18n('buttonShowLeftMenu')?>" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;"  >
	     <?php if (! isset($showModuleScreen)) {?>
		  <table>
          <tr>
            <td style="width:28x;text-align:center">
              <div class="iconHideStreamLeft22 iconHideStreamLeft iconSize22 " style="position:absolute;top:2px;left:3px" ></div>
            </td>
          </tr>
        </table>  
       <?php }?>  
   </div>
    </td>
    <td width="<?php echo (isIE())?37:35;?>px">   
      <div id="hideMenuBarShowButtonTop" class="pseudoButton"   onClick="hideMenuBarShowModeTop();" title="<?php echo i18n('buttonShowTopMenu')?>" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;"  >
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconHideStreamTop22 iconHideStreamTop iconSize22 " style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
	  </div>
    </td>
    <?php if (! isIE()) {?>
    <td width="<?php echo (isIE())?37:35;?>px"> 
      <div  class="pseudoButtonFullScreen " style="height:28px; position:relative;top:0px; z-index:30; width:30px; right:0px;" onclick="toggleFullScreen()" >
        <table>
          <tr>
            <td style="width:28px" >
              <?php echo formatIcon('FullScreen', 22,i18n("fullScreen"));?>
            </td>
          </tr>
        </table>
      </div>
    </td>
     <?php }?> 
    
    </tr>
  </table>
</div>