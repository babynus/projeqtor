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
$imgUrl=Affectable::getThumbUrl('User',$user->id, 80,true);
$obj=new Parameter();
$listTheme=getThemesList(); // keep 'random' as last value to assure it is not selected via getTheme()
$userLang = getSessionValue('currentLocale');
if (!$userLang and isset($currentLocale)) $userLang=$currentLocale;
$userTheme = getSessionValue('theme');
$startPage = getSessionValue('startPage');
$listStartPage=array();
$listStartPage['welcome.php']=i18n('paramNone');
if (securityCheckDisplayMenu(null,'Today')) {$listStartPage['today.php']=i18n('menuToday');}
if (securityCheckDisplayMenu(null,'DashboardTicket')) {$listStartPage['dashboardTicketMain.php']=i18n('menuDashboardTicket');}
if (securityCheckDisplayMenu(null,'Diary')) {$listStartPage['diaryMain.php']=i18n('menuDiary');}
if (securityCheckDisplayMenu(null,'Imputation')) {$listStartPage['imputationMain.php']=i18n('menuImputation');}
if (securityCheckDisplayMenu(null,'Planning')) {$listStartPage['planningMain.php']=i18n('menuPlanning');}
if (securityCheckDisplayMenu(null,'PortfolioPlanning')) {$listStartPage['portfolioPlanningMain.php']=i18n('menuPortfolioPlanning');}
if (securityCheckDisplayMenu(null,'ResourcePlanning')) {$listStartPage['resourcePlanningMain.php']=i18n('menuResourcePlanning');}
if (securityCheckDisplayMenu(null,'GlobalPlanning')) {$listStartPage['globalPlanningMain.php']=i18n('menuGlobalPlanning');}
if (securityCheckDisplayMenu(null,'Kanban')) {$listStartPage['kanbanViewMain.php']=i18n('menuKanban');}
$arrayItem=array('Project','Document','Ticket','TicketSimple','Activity','Action','Requirement','ProjectExpense','ProductVersion','ComponentVersion','GlobalView');
foreach  ($arrayItem as $item) {
  if (securityCheckDisplayMenu(null,$item)) {$listStartPage['objectMain.php?objectClass='.$item]=i18n('menu'.$item);}
}

$prf=new Profile(getSessionUser()->idProfile);
if ($prf->profileCode=='ADM') {
  $listStartPage['startGuide.php']=i18n('startGuideTitle');
}
$menu=SqlElement::getSingleSqlElementFromCriteria('Menu', array('name'=>'menuUserParameter'));
$showUserParameters=securityCheckDisplayMenu($menu->id,substr($menu->name,4));
?>
<input type="hidden" id="userMenuIdUser" value="<?php echo getCurrentUserId();?>"/>
<table style="width:99%;" id="userMenuPopup">
  <tr style="height:40px">
    <td <?php if ($showUserParameters) echo'rowspan="2"';?> style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"><?php if ($imgUrl) { echo '<img style="border-radius:40px;height:80px" src="'.$imgUrl.'" />'; } else { ?>
            <div style="overflow-x:hidden;position: relative; width:80px;height:60px;border-radius:40px; border: 1px solid grey;color: grey;font-size:80%; text-align:center;cursor: pointer;" 
              onClick="addAttachment('file');" title="<?php echo i18n('addPhoto');?> "><div style="font-size:80%;position:relative;top:32px"><?php echo i18n('addPhoto');?></div></div> 
   <?php } ?></td>
    <td>
      <div class="pseudoButton"  title="<?php echo i18n('changePassword');?>" onClick="requestPasswordChange();">
        <table style="width:100%">
          <tr>
            <td style="padding-left: 10px;width: 22px !important;vertical-align: middle;">
              <div style="height:22px;width: 22px" class="iconLoginPassword iconSize22 imageColorNewGui">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;font-size:9pt;color: var(--color-dark);">&nbsp;&nbsp;<?php echo i18n('changePassword');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
<?php
if ($showUserParameters) { // Do not give access to user parameters if locked ?>
  <tr style="height:40px">
    <td style="white-space:nowrap;">
      <div class="pseudoButton"  title="<?php echo i18n('menuUserParameter');?>" onClick="loadMenuBarItem('UserParameter','UserParameter','bar');dijit.byId('iconMenuUserPhoto').closeDropDown();">
        <table style="width:100%">
          <tr>
            <td style="padding-left: 10px;width: 22px !important;">
              <div style="height:22px;width: 22px" class="iconUserParameter iconSize22 imageColorNewGui">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;font-size:9pt;color: var(--color-dark);">&nbsp;&nbsp;<?php echo i18n('menuUserParameter');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="height:40px">
    <td width="120px" style="text-align:right"><?php echo i18n("paramLang");?>&nbsp;:&nbsp;</td>
    <td>  
      <select dojoType="dijit.form.FilteringSelect" class="input" name="langMenuUserTop" id="langMenuUserTop" 
        <?php echo autoOpenFilteringSelect();?>
        title="<?php echo i18n('helpLang');?>" style="width:225px">
        <script type="dojo/connect" event="onChange" >
          changeLocale(this.value,true);
        </script>
<?php   $listValues=Parameter::getList('lang');
        foreach ($listValues as $value => $valueLabel ) {
          $selected = ($userLang==$value)?'selected':'';
          $value=str_replace(',','#comma#',$value); // Comma sets an isse (not selected) when in value
          echo '<option value="' . $value . '" ' . $selected . '>' . $valueLabel . '</option>';
        }?>
      </select>
    </td>
  </tr>
  <?php if (!isNewGui()) {?>
  <tr style="height:40px">
    <td width="120px" style="text-align:right"><?php echo i18n("paramTheme");?>&nbsp;:&nbsp;</td>
    <td>
      <select dojoType="dijit.form.FilteringSelect" class="input" name="themeMenuUserTop" id="themeMenuUserTop"
        <?php echo autoOpenFilteringSelect();?>
        title="<?php echo i18n('helpTheme');?>" style="width:225px">
<?php   echo $obj->getValidationScript('theme');
        $listValues=$listTheme;
        foreach ($listValues as $value => $valueLabel ) {
          $selected = ($userTheme==$value)?'selected':'';
          $value=str_replace(',','#comma#',$value); // Comma sets an isse (not selected) when in value
          echo '<option value="' . $value . '" ' . $selected . '>' . $valueLabel . '</option>';
        }?>
      </select>
    </td>
  </tr>
<?php } else {?>
  <tr style="height:40px">
    <td width="120px" style="text-align:right"><?php echo i18n("paramTheme");?> 1&nbsp;:&nbsp;</td>
    <td>
       <input type="color" id="menuUserColorPicker" onInput="setColorTheming(this.value,null);" onChange="saveDataToSession('newGuiThemeColor',this.value.substr(1),true);setColorTheming(this.value,null);" value="<?php echo '#'.Parameter::getUserParameter('newGuiThemeColor');?>" style="height: 24px;width: 98%;border-radius: 5px 5px 5px 5px;" />
    </td>
  </tr>  
  <tr style="height:40px">
    <td width="120px" style="text-align:right"><?php echo i18n("paramTheme");?> 2&nbsp;:&nbsp;</td>
    <td>
       <input type="color" id="menuUserColorPickerBis" onInput="setColorTheming(null,this.value);" onChange="saveDataToSession('newGuiThemeColorBis',this.value.substr(1),true);setColorTheming(null,this.value);" value="<?php echo '#'.Parameter::getUserParameter('newGuiThemeColorBis');?>" style="height: 24px;width: 98%;border-radius: 5px 5px 5px 5px;" />
    </td>
  </tr> 
 <?php }?>
  <tr style="height:40px">
    <td width="120px" style="text-align:right"><?php echo i18n("menuUserStartPage");?>&nbsp;:&nbsp;</td>
    <td>  
      <select dojoType="dijit.form.FilteringSelect" class="input" name="firstPageMenuUserTop" id="firstPageMenuUserTop" 
        <?php echo autoOpenFilteringSelect();?>
        title="<?php echo i18n('menuUserStartPage');?>" style="width:225px">
<?php   echo $obj->getValidationScript('startPage');
        $listValues=$listStartPage;
        foreach ($listValues as $value => $valueLabel ) {
          $selected = ($startPage==$value)?'selected':'';
          $value=str_replace(',','#comma#',$value); // Comma sets an isse (not selected) when in value
          echo '<option value="' . $value . '" ' . $selected . '>' . $valueLabel . '</option>';
        }?>
      </select>
    </td>
  </tr>
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
        <td style="float:right;padding-right:20px">
    <?php if (Parameter::getGlobalParameter('simuIndex')){?>
     <div class="pseudoButton disconnectTextClass" style="width:120px;height:35px;" title="<?php echo i18n('disconnectMessage');?>" onclick="disconnectDataCloning('welcome','simu');">
        <table style="width:122px;">
          <tr>
            <td> <div class="disconnectClass">&nbsp;</div> </td>
            <td>&nbsp;&nbsp;<?php echo i18n('disconnect');?></td>
          </tr>
        </table>
      </div>
    <?php }else if (SSO::isEnabled()) {?>
     <div class="pseudoButton disconnectTextClass" style="width:120px;height:35px;" title="<?php echo i18n('disconnectMessage');?>" onclick="disconnectSSO('welcome','<?php echo SSO::getCommonName(true);?>');">
        <table style="width:122px;">
          <tr>
            <td> <div class="disconnectClass">&nbsp;</div> </td>
            <td>&nbsp;&nbsp;<?php echo i18n('disconnect');?></td>
          </tr>
        </table>
      </div>
     <div class="pseudoButton disconnectTextClass" style="width:120px;height:35px;" title="<?php echo i18n('ssoDisconnectLoginMessage',array(SSO::getCommonName()));?>" onclick="disconnectSSO('login','<?php echo SSO::getCommonName(true);?>');">
        <table style="width:122px;">
          <tr>
            <td> <div class="disconnectClass">&nbsp;</div> </td>
            <td style="white-space:nowrap">&nbsp;&nbsp;<?php echo i18n('ssoDisconnectLogin');?></td>
          </tr>
        </table>
      </div>
      <?php if (isset($_SESSION['samlNameId'])) {?>
      <div class="pseudoButton disconnectTextClass" style="width:120px;height:30px;" title="<?php echo i18n('ssoDisconnectSSOMessage',array(SSO::getCommonName()));?>" onclick="disconnectSSO('SSO','<?php echo SSO::getCommonName(true);?>');">
        <table style="width:122px;">
          <tr>
            <td> <div class="disconnectClass">&nbsp;</div> </td>
            <td style="white-space:nowrap">&nbsp;&nbsp;<?php echo i18n('ssoDisconnectSSO',array(SSO::getCommonName()));?></td>
          </tr>
        </table>
      </div>
      <?php }?>
    <?php } else { ?>
          <div class="pseudoButton disconnectTextClass" style="width:120px;" title="<?php echo i18n('disconnectMessage');?>" onclick="disconnect(true);">
        <table style="width:122px;">
          <tr>
            <td> <div class="disconnectClass">&nbsp;</div> </td>
            <td>&nbsp;&nbsp;<?php echo i18n('disconnect');?></td>
          </tr>
        </table>
      </div>
     <?php } ?>
    </td>
  </tr>
  <?php if(!isNewGui()){?>
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
      <td>
      <div class="pseudoButton"  title="<?php echo i18n('help');?>" onClick="showHelp();">
        <table style="width:100%">
          <tr>
            <td style="width:24px;padding-top:2px;">
              <div class="iconCatalog22">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('help');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
    <td>
      <div class="pseudoButton"  title="<?php echo i18n('keyboardShortcuts');?>" onClick="showHelp('ShortCut');">
        <table style="width:100%">
          <tr>
            <td style="width:24px;padding-top:2px;">
              <div class="iconShortCut">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('keyboardShortcuts');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
    <td>
      <div class="pseudoButton"  title="<?php echo i18n('aboutMessage');?>" onClick="showAbout(aboutMessage);">
        <table style="width:100%">
          <tr>
            <td style="width:24px;padding-top:2px;">
              <div class="iconInfo22">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('aboutMessage');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
<?php } } // End of if ($showUserParameters)?>
</table>