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

//Param
$user=getSessionUser();
$linkPlugin = "https://www.projeqtor.net/en/shop/plugins";
$linkForum = "https://www.projeqtor.org/en/forum/index";
$linkToForumRules="https://www.projeqtor.org/en/forum/aide";
$userLang = getSessionValue('currentLocale');
$lang = "en";
if(substr($userLang,0,2)=="fr")$lang="fr";
if($lang=="fr"){
  $linkForum = "https://www.projeqtor.org/fr/forum-fr/index";
  $linkPlugin = "https://www.projeqtor.net/fr/shop-fr/plugins";
  $linkToForumRules="https://www.projeqtor.org/fr/forum-fr/aide";
}
?>

<table style="width:99%;" id="userMenuInterrogation">
  <tr><td>
  <table><tr>
    <td style="color:<?php echo '#'.Parameter::getUserParameter('newGuiThemeColor');?>;width:60%;font-size:26px;"><?php echo i18n('aboutMenuInterrogation');?></td>
    <td> <a target="#" href="<?php echo $linkToForumRules;?>"> <div class="roundedVisibleButton roundedButton generalColClass"
        title="<?php echo('reportBug'); ?>"
        style="text-align:left;margin-right:10px;margin-top:10px;height:23px;width:160px;
        onClick="showFilterDialog();">
        <img  class="imageColorNewGui" src="css/customIcons/new/iconHelpBug.svg" style="position:relative;left:5px;top:2px;background-repeat:no-repeat;width:20px;background-size:20px;"/>
         <div style="color:grey;position:relative;top:-19px;left:38px;"><?php echo i18n('reportBug'); ?></div>
          </div> </a></td></tr></table>
  </td></tr>
  
  <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td style="cursor:pointer;">
      <div style="margin-top:15px;margin-left:16px;" title="<?php echo i18n('help');?>" onClick="showHelp();">
        <table style="width:100%">
          <tr>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('help');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td style="cursor:pointer;">
      <div  style="margin-top:6px;margin-left:16px;" title="<?php echo i18n('keyboardShortcuts');?>" onClick="showHelp('ShortCut');">
        <table style="width:100%">
          <tr>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('keyboardShortcuts');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td style="cursor:pointer;">
      <div style="margin-top:6px;margin-left:16px;" title="<?php echo i18n('aboutMessage');?>" onClick="showAbout(aboutMessage);">
        <table style="width:100%">
          <tr>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('aboutMessage');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="color:grey !important;height:15px;border-bottom:1px dotted;">
    <td>
    <table>
      <tr>
        <td style="cursor:pointer;"><a target="#" href="<?php echo $linkPlugin;?>"><div class="imageColorNewGui iconButtonLink16 iconSize16 "> </div></a></td>
        <td>
          <div style="margin-top:6px;" title="<?php echo i18n('linkToPlugin');?>">
            <table style="width:100%">
              <tr>
                <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('linkToPlugin');?>&nbsp;&nbsp;</td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td>
      <table>
        <tr>
          <td style="cursor:pointer;"><a target="#" href="<?php echo $linkForum;?>"><div class="imageColorNewGui iconButtonLink16 iconSize16 "> </div></a></td>
          <td><div style="margin-top:6px;" title="<?php echo i18n('linkToForum');?>">
                <table style="width:100%">
                  <tr>
                    <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('linkToForum');?>&nbsp;&nbsp;</td>
                  </tr>
                </table>
              </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr><td><div style="margin-bottom:15px;"></div></td></tr>
  <tr>
    <td>
    <div  class="container" dojoType="dijit.layout.ContentPane" id="getLastNews"></div>
    </td>
  </tr>
</td></tr></table>