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
?>
<div id="mainDivMenu" class="container" >
 <table width="100%">
  <?php if(RequestHandler::getValue('paramScreen')==Parameter::getUserParameter('paramScreen')){?>
    <tr height="<?php echo $iconSize+8; ?>px">  
      <td width="<?php echo (isIE())?37:35;?>px" > 
        <div class="pseudoButton" onclick="switchMode();" style="height:28px; position:relative;top:-5px; z-index:30; width:30px;" title="<?php echo i18n("buttonSwitchedMode");?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="dijitButtonIcon dijitButtonIconSwitchMode" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
    </tr>
   <?php }?>
   <tr height="<?php echo $iconSize+8; ?>px">
      <td width="24px" >   
        <div id="hideMenuBarShowButtonTop"style="height:28px; position:relative;top:-5px; z-index:30; width:30px;" onclick="hideMenuBarShowModeTop();">
            <table>
              <tr>
                <td style="width:28x;text-align:center">
                   <div style="position:absolute;top:2px;left:5px"  Class="dijitButtonIcon iconHideStream22" >&nbsp;</div>
                </td>
              </tr>
            </table>    
  		</div>
      </td>
    </tr>
    <tr>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div class="pseudoButton" onclick="switchMode2('1');" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" title="<?php echo i18n("buttonSwitchedMode");?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
              <?php if(RequestHandler::getValue('paramScreen')==Parameter::getUserParameter('paramScreen')){?>
                <div class="horizontalLayoutClass" style="position:absolute;top:2px;left:3px" ></div>
              <?php }else{?>
                <div class="verticalLayoutClass" style="position:absolute;top:2px;left:3px" ></div>
              <?php }?>
              </td>
            </tr>
          </table>    
       </div>
      </td>
    </tr>
  </table>
</div>