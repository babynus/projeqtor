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
?>

<table style="width:99%;" id="userMenuInterrogation">
  <tr><td>
  <table><tr>
    <td style="color:<?php echo '#'.Parameter::getUserParameter('newGuiThemeColor');?>;width:60%;font-size:26px;"><?php echo i18n('aboutMenuInterrogation');?></td><td>  <div class="roundedVisibleButton roundedButton generalColClass"
        title="<?php echo('reportBug'); ?>"
        style="text-align:left;margin-right:10px;margin-top:10px;height:23px;width:160px;
        onClick="showFilterDialog();">
        <img src="css/customIcons/new/iconResolution.svg" style="-webkit-filter : hue-rotate(var(--image-hue-rotate)) saturate(var(--image-saturate)) brightness(var(--image-brightness))
             filter : hue-rotate(var(--image-hue-rotate)) saturate(var(--image-saturate)) brightness(var(--image-brightness));position:relative;left:5px;top:2px;background-repeat:no-repeat;width:20px;background-size:20px;"/>
         <div style="color:grey;position:relative;top:-19px;left:38px;"><?php echo i18n('reportBug'); ?></div>
          </div></td></tr></table>
  </td></tr>
  
  <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td style="cursor:pointer;">
      <div style="margin-top:15px;" title="<?php echo i18n('help');?>" onClick="showHelp();">
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
      <div   title="<?php echo i18n('keyboardShortcuts');?>" onClick="showHelp('ShortCut');">
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
      <div  title="<?php echo i18n('aboutMessage');?>" onClick="showAbout(aboutMessage);">
        <table style="width:100%">
          <tr>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('aboutMessage');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td style="cursor:pointer;">
      <div  title="<?php echo i18n('linkToPlugin');?>" onClick="showAbout(aboutMessage);">
        <table style="width:100%">
          <tr>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('linkToPlugin');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <tr style="color:grey;height:15px;border-bottom:1px dotted;">
    <td style="cursor:pointer;">
      <div  title="<?php echo i18n('linkToForum');?>" onClick="showAbout(aboutMessage);">
        <table style="width:100%">
          <tr>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('linkToForum');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <td>
  <table style="margin-top:15px;">
    <tr>
    <?php $urlGetNews = "http://projeqtor.org/admin/getNews.php";
          $currentVersion=null;
         if (ini_get('allow_url_fopen')) {
           enableCatchErrors();
           $currentVersion=file_get_contents($urlGetNews);
           disableCatchErrors();
         }
         $json = file_get_contents($urlGetNews);
         $obj = json_decode($json);
         $i=0;
         foreach ($obj as $objV=>$val){
            if($val!="id"){
              foreach ($val as $value){
                if($i%2==0){?> <tr><?php } ?>
              <td>
                <table>
                  <tr>
                    <td><div style="border-top-left-radius:5px;border-top-right-radius:5px;<?php if($i==0){?>margin-right:20px;<?php }?>width:150px;overflow:hidden;height:30px;background:<?php echo '#'.Parameter::getUserParameter('newGuiThemeColor');?>;" id="divMsg<?php echo $i;?>" name="divMsgFull<?php echo $i;?>" onClick="showMsg(divMsg<?php echo $i;?>,test;);"><?php echo $value->title;?></div></td>
                  </tr>
                  <tr>
                    <td><div style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:150px;height:50px;overflow:hidden;background:#f2f5f5;" id="divMsgFull<?php echo $i;?>" name="divMsgFull<?php echo $i;?>"><?php echo $value->introtext;?></div></td>
                  </tr>
                </table>
              </td>
              <?php $i++;
                if($i%2==0){?></tr><?php }
              }
            }
         }
    ?>
    </tr>
   </table>
   </td>
  </tr>
</table>