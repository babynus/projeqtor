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
    <tr height="<?php echo $iconSize+8; ?>px">  
      <td width="<?php echo (isIE())?37:35;?>px" > 
        <div id="changeLayout" class="pseudoButton" onclick="switchMode();" style="height:28px; position:relative;top:-5px; z-index:30; width:30px;" title="<?php echo i18n("buttonSwitchedMode");?>">
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
        <div id="horizontalLayout"  class="pseudoButton" onclick="switchModeLayout('1');" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" title="<?php echo i18n("buttonSwitchedMode");?>">
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
        <div id="verticalLayout" lass="pseudoButton" onclick="switchModeLayout('2');" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" title="<?php echo i18n("buttonSwitchedMode");?>">
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
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="layoutList" class="pseudoButton" onclick="switchModeLayout('4');" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" title="<?php echo i18n("buttonSwitchedMode");?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconLayoutList22 iconLayoutList iconSize22" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="layoutTab" class="pseudoButton" onclick="switchModeLayout('0');" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" title="<?php echo i18n("buttonSwitchedMode");?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconLayoutTab22 iconLayoutTab iconSize22 " style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
    </tr>
    <tr>
     <?php if (! isIE()) {?>
    <td  width="28px" > 
      <div  class="pseudoButtonFullScreen <?php echo $simuClass;?>" style="height:28px; position:relative; top:-5px; z-index:30;margin-right:0px; width:28px;" onclick="toggleFullScreen()" >
        <table>
          <tr>
            <td style="width:28px" >
              <?php echo formatIcon('FullScreen', 32,i18n("fullScreen"));?>
            </td>
          </tr>
        </table>
      </div>
    </td>
     <?php }?> 
    <td width="29px" class="<?php echo $simuClass;?>">   
      <div id="hideMenuBarShowButtonTop" style="cursor:pointer;position:relative; top:-11px;right:0px; z-index:949" >
  		  <a onClick="hideMenuBarShowModeTop();" id="buttonSwitchedMenuBarTopShow" title="<?php echo i18n("buttonShowMenu");?>" >
  		    <span style='display:inline-block;width:24px;height:22px;'>
  		     <div style="position:absolute;top:1px;right:0px;height:26px;width:24px" dojoType="dijit.form.Button" iconClass="dijitButtonIcon iconHideStream22" class="detailButton">&nbsp;</div>
  		    </span>
  		  </a>
		  </div>
    </td> 
    </tr>
  </table>
</div>