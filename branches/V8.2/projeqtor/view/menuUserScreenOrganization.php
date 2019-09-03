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
$paramScreen=Parameter::getUserParameter('paramScreen');
$paramObjectDetail=Parameter::getUserParameter('paramLayoutObjectDetail');
?>

<div id="mainDivMenu" class="container" >
 <table width="100%">
    <tr height="<?php echo $iconSize+8; ?>px">  
      <td width="<?php echo (isIE())?37:35;?>px" > 
        <div id="changeLayout" class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px;
        <?php if( $paramScreen=='5'){echo 'opacity:0.5;cursor:not-allowed';}?>" title="<?php echo i18n("buttonSwitchedMode");?>"
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
        <?php if($paramScreen=='1'){echo 'opacity:0.5;cursor:not-allowed';}?>" title="<?php echo i18n("buttonSwitchedMode");?>"
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
        <?php if($paramScreen=='2'){echo 'opacity:0.5;cursor:not-allowed';}?>" title="<?php echo i18n("buttonSwitchedMode");?>"
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
        <?php if($paramObjectDetail=='4'){echo 'opacity:0.5;cursor:not-allowed';}?>" title="<?php echo i18n("buttonSwitchedMode");?>"
        onclick="<?php if($paramObjectDetail=='0'){echo 'switchModeLayout(\'4\');';}?>">
          <table >
            <tr>
              <td style="width:28x;text-align:center">
                <div class="iconLayoutList22 iconLayoutList iconSize22" style="position:absolute;top:2px;left:3px" ></div>
              </td>
            </tr>
          </table>    
       </div>
      </td>
      <td width="<?php echo (isIE())?37:35;?>px" >
      </td>
      <td width="<?php echo (isIE())?37:35;?>px"  > 
        <div id="layoutTab" class="pseudoButton"  style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;
        <?php if($paramObjectDetail=='0'){echo 'opacity:0.5;cursor:not-allowed';}?>" 
        title="<?php echo i18n("buttonSwitchedMode");?>"
        onclick="<?php if($paramObjectDetail=='4'){echo 'switchModeLayout(\'0\');';}?>">
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
    <td width="<?php echo (isIE())?37:35;?>px">   
      <div id="hideMenuBarShowButtonTop" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;"  >
  		  <a onClick="hideMenuBarShowModeTop();" id="buttonSwitchedMenuBarTopShow" title="<?php echo i18n("buttonShowMenu");?>" >
  		    <span style='display:inline-block;width:24px;height:22px;'>
  		     <div style="position:absolute;top:1px;height:26px;width:24px" dojoType="dijit.form.Button" iconClass="dijitButtonIcon iconHideStream22" class="detailButton">&nbsp;</div>
  		    </span>
  		  </a>
	  </div>
    </td>
    <td width="<?php echo (isIE())?37:35;?>px">
  	  <div id="hideMenuBarShowButton2" style="height:28px; position:relative;top:-5px; z-index:30; width:30px; right:0px;" title="<?php echo i18n("buttonShowMenu");?>" >
  	  <?php if (! isset($showModuleScreen)) {?>
  		  <a onClick="hideMenuBarShowMode();" id="buttonSwitchedMenuBarTopShow"  >
  		    <span style='display:inline-block;width:24px;height:22px;'>
  		     <div style="position:absolute;top:1px;height:26px;width:24px" dojoType="dijit.form.Button" iconClass="dijitButtonIcon iconHideStream22" class='detailButton'>&nbsp;</div>
  		    </span>
  		  </a>
      <?php }?>  
	  </div>
    </td> 
    </tr>
  </table>
</div>