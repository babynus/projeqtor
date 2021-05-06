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
$objectExist="";
 if(RequestHandler::isCodeSet('objectExist')){
   $objectExist=RequestHandler::getValue('objectExist');
 }else if (Parameter::getUserParameter('startPage')){
   $objectExist='true';
   $tabPage=array( "today.php", "startGuide.php", "diaryMain.php","imputationMain.php","dashBoardTicketMain.php");
     foreach ($tabPage as $page){
       if(Parameter::getUserParameter('startPage')== $page){
          $objectExist='false';
       }
     }
 }
if(RequestHandler::isCodeSet('objectClass') and Parameter::getUserParameter('paramScreen_'.RequestHandler::getValue('objectClass'))){
  $paramScreen=Parameter::getUserParameter('paramScreen_'.$objectClass);
}elseif (isset($currentScreen) and  Parameter::getUserParameter('paramScreen_'.$currentScreen)){
  $paramScreen=Parameter::getUserParameter('paramScreen_'.$currentScreen);
}elseif (RequestHandler::isCodeSet('paramScreen')){
  $paramScreen=RequestHandler::getValue('paramScreen');
}
else{
  $paramScreen=Parameter::getUserParameter('paramScreen');
}





?>

<div id="mainDivMenuScreenLayout" class="container" style="margin-top:10px;">
 <input type="hidden" id="objectExist" name="objectExist" value="<?php echo $objectExist;?>" />
 <table width="100%">
    <tr height="<?php echo $iconSize+8; ?>px">  
      <td width="<?php echo (isIE())?37:35;?>px" > 
        <div id="changeLayout" class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px;
        <?php if( $paramScreen=='switch'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("buttonSwitchedMode");?>"
         onclick="<?php if($paramScreen!='switch') {echo 'switchModeLayout(\'switch\',true)';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconChangeLayout22 iconChangeLayout iconSize22 <?php if(isNewGui()) echo 'imageColorNewGui';?>" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="horizontalLayout"  class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramScreen=='top'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("showListTop");?>"
        onclick="<?php if($paramScreen!='top' ){echo 'switchModeLayout(\'top\');';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="horizontalLayoutClass iconSize22 <?php if(isNewGui()) echo 'imageColorNewGui';?>" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="verticalLayout" lass="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramScreen=='left'){echo 'Background:#D1D1D1;border-radius:4px;cursor:not-allowed;';}?>" title="<?php echo i18n("showListLeft"); ?>"
        onclick="<?php if($paramScreen!='left' ){echo 'switchModeLayout(\'left\',true);';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="verticalLayoutClass iconSize22 <?php if(isNewGui()) echo 'imageColorNewGui';?>" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
    </tr>

  </table>
</div>