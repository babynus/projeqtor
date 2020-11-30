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

/* ============================================================================
 * Connnexion page of application.
 */
   require_once "../tool/projeqtor.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/passwordChange.php'); 
   $mobile=false;
   debugLog(isNewGui());
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<?php if (! isset($debugIEcompatibility) or $debugIEcompatibility==false) {?>  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php }?> 
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="css/projeqtor.css" />
  <link rel="stylesheet" type="text/css" href="css/projeqtorFlat.css" />
    <?php if(isNewGui()){?>
   <link rel="stylesheet" type="text/css" href="../view/css/projeqtorNew.css" />
   <script type="text/javascript" src="js/dynamicCss.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/dojox/mobile/deviceTheme.js" data-dojo-config="mblUserAgent: 'Custom'"></script>
   <?php }?>
  <script type="text/javascript" src="../external/CryptoJS/rollups/sha256.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtor.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialog.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/dojo/dojo.js?version=<?php echo $version.'.'.$build;?>"
    djConfig='modulePaths: {"i18n":"../../tool/i18n",
                            "i18nCustom":"../../plugin"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString(Parameter::getGlobalParameter('paramDebugMode'));?>'></script>
  <script type="text/javascript" src="../external/dojo/projeqtorDojo.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript"> 
    var isNewGui=<?php echo (isNewGui())?'true':'false';?>;
    var customMessageExists=<?php echo(file_exists(Plugin::getDir()."/nls/$currentLocale/lang.js"))?'true':'false';?>;
    dojo.require("dojo.parser");
    dojo.require("dojo.i18n");
    dojo.require("dijit.Dialog"); 
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");
    dojo.require("dijit.form.Form");
    dojo.require("dijit.form.FilteringSelect");
    if (isNewGui){
      dojo.require("dojox.mobile.parser");
      dojo.require("dojox.mobile.Switch");
      dojo.require("dojox.mobile.SwapView");
      dojo.require("dojox.mobile.PageIndicator");
    }
    dojo.require("dojox.form.PasswordValidator");
    var fadeLoading=<?php echo getBooleanValueAsString(Parameter::getGlobalParameter('paramFadeLoadingMode'));?>;
    dojo.addOnLoad(function(){
      if (isNewGui) {
        changeTheme('<?php echo getTheme();?>');
        setColorTheming('<?php echo '#'.Parameter::getUserParameter('newGuiThemeColor');?>','<?php echo '#'.Parameter::getUserParameter('newGuiThemeColorBis');?>');
      }
      currentLocale="<?php echo $currentLocale?>";
      hideWait();
      changePassword=false;
      dojo.byId('dojox_form__NewPWBox_0').focus();
    }); 
  </script>
</head>

<?php 
if(isNewGui()){
$firstColor=Parameter::getGlobalParameter('newGuiThemeColor');
if(!$firstColor){
$firstColor= getTheme();
}

?>
<body id="body" class="nonMobile tundra <?php echo getTheme();?>" >
<?php 
}else{
?>
<body class="<?php echo getTheme();?>"  >
<?php }?>
  <div id="wait" >
  </div> 
  <table align="center" width="100%" height="100%" class="<?php echo (isNewGui())?'loginBackgroundNewGui':'loginBackground';?>" style="<?php if (isNewGui()) echo 'background-color:#'.$firstColor;?>">
    <tr height="100%">
      <td width="100%" align="center">
        <div class="background  <?php  echo (isNewGui())?'loginFrameNewGui':'loginFrame' ;?>" <?php if(isNewGui()) echo 'style="height:320px;width:550px!important;"';?> >
        <table  align="center" >
          <tr style="height:10px;" >
            <td align="left" style="position:relative;height: 1%;" valign="top">
			        <div style="position:relative;width: 400px; height: 54px;">
			          <div style="z-index:10;overflow:visible;position:absolute;width: 480px; height: 50px;top:<?php echo (isNewGui())?'12px':'15px'?>;text-align: center">
				        <img style="max-height:60px" src="<?php 
				          if (file_exists("../logo.gif")) echo '../logo.gif';
				          else if (file_exists("../logo.jpg")) echo '../logo.jpg';
				          else if (file_exists("../logo.png")) echo '../logo.png';
				          else echo 'img/titleSmall.png';?>" />
			          </div>
			        </div>
            </td>
          </tr>
          <tr style="height:100%" height="100%">
            <td style="height:99%" align="left" valign="middle">
              <div  id="formDiv" dojoType="dijit.layout.ContentPane" region="center" style="<?php echo (isNewGui())?' height:200px;width:500px;':' height:210px;width:450px;'?>overflow:visible;position: relative;">
             <form  dojoType="dijit.form.Form" id="passwordForm" jsId="passwordForm" name="passwordForm" encType="multipart/form-data" action="" method="" >
             <script type="dojo/method" event="onSubmit" >
              dojo.byId('goButton').focus();
              var extDate=new Date();
              var userSalt=CryptoJS.SHA256('projeqtor'+extDate.getTime());
              dojo.byId('userSalt').value=userSalt;
              var pwd=dijit.byId('password').get('value')+userSalt;
              var crypted=CryptoJS.SHA256(pwd);
              dojo.byId('hashString').value=crypted;
              dojo.byId('passwordLength').value=dijit.byId('password').get('value').length;
              loadContent("../tool/changePassword.php","passwordResultDiv", "passwordForm");
              return false;       
            </script>
            <?php
            $topMsg=230;
            if (isset($ssoUserCreated) and $ssoUserCreated==true) {
            	echo '<b>'.i18n('newUserSSO').'</b><br/>'; 
            	$topMsg+=20;
            }
            if (SSO::isEnabled()) {
            	echo i18n('ssoChangePasswordMessage',array(SSO::getCommonName())).'<br/>';
            	$topMsg+=40;
            }
            ?> 
            <br/>
            <br/>
            <div dojoType="dojox.form.PasswordValidator" id="password" onkeydown="setTimeout('controlChar();',20);" class="input rounded"  style="color:#000000;margin-left:15px;<?php echo (isNewGui())?'border:unset !important;width:450px;':'padding:10px;';?>">
              <?php if (isNewGui()) echo '<div class="loginDivContainer container" style="margin-bottom:15px;">';?>
              <label class="label" style="<?php echo (isNewGui())?"position: relative;text-align:center;width:180px;":"width:150px;";?>;"><?php echo i18n('newPassword');?>&nbsp;:&nbsp;</label>
              <input type="password" pwType="new" class="input rounded"  style="color:#000000;"><br/>
              <?php if (isNewGui()){
                echo '</div>';
              }else{?>
              <br/>
              <?php
              }
               if(isNewGui())echo '<div class="loginDivContainer container" ><div style="float:left">'; ?>
              <label class="label" style="<?php echo (isNewGui())?"position: relative;text-align:center;width:180px;":"width:150px;";?>"><?php echo i18n('validatePassword');?>&nbsp;:&nbsp;</label>
              <input type="password" pwType="verify" class="input rounded"  style="color:#000000;">
              <?php if(isNewGui()){
                 echo  '</div>';
                 echo '<div class="iconView iconSize22" style="cursor:pointer;float:right;position:relative;top:8px;filter:grayscale(1)" 
                       onClick="dojo.setAttr(\'newPass\',\'type\',((dojo.getAttr(\'newPass\',\'type\')==\'password\')?\'text\':\'password\'));dojo.setAttr(\'validatedPass\',\'type\',((dojo.getAttr(\'validatedPass\',\'type\')==\'password\')?\'text\':\'password\'))" ></div>';
                 echo '</div>';
               }?>
              <br/>
              <br/>
              <p><progress  id="progress" max="4" style="margin-left:<?php echo (isNewGui())?'145px':'148px';?>;width:185px;" value="0" ></progress> <span id="error" style="float:right;" ></span></p>
              <div style="width:200px;height:20px; <?php echo (isNewGui())?'position: relative;top: 4px;left: 145px;':'position:absolute; left:170px;';?>text-align:center;">
                <span id="strength"></span> 
              </div>
            <?php if(!isNewGui()) echo '<br/>';?>    
            <!-- florent 4088 -->
            </div>
            <input type="hidden" id="parmPwdSth"  value="<?php echo Parameter::getGlobalParameter('paramPasswordStrength');?>"/>
            <input type="hidden" id="paramPwdLth"  value="<?php echo Parameter::getGlobalParameter('paramPasswordMinLength');?>"/>
            <input type="hidden" id="hashString" name="password" value=""/>
            <input type="hidden" id="userSalt" name="userSalt" value=""/>
            <input type="hidden" id="passwordLength" name="passwordLength" value=""/>
            <input type="hidden" id="passwordValidate" name="passwordValidate" value=""/>
            <input type="hidden" id="criteria" name="criteria" value=""/>
            <!-- florent -->
            <?php if(!isNewGui()) echo '<br/>';?>
            <button type="submit" style="<?php echo (isNewGui())?'margin-left:160px;height:20px !important;':'margin-left:150px;';?>width:200px;color:#555555;" class="largeTextButton" id="goButton" dojoType="dijit.form.Button" showlabel="true">OK
              <script type="dojo/connect" event="onClick" args="evt">
                //loadContent("../tool/changePassword.php","passwordResultDiv", "passwordForm");
              </script>
            </button>
            <?php if(!isNewGui()) echo '<br/>';?>
            <div style="height:5px">&nbsp;</div>
            <?php if ( $user->password != md5($user->getRandomPassword()) ) {?>
            <button class="largeTextButton" type="button" style="<?php echo (isNewGui())?'margin-left:160px;height:20px !important;':'margin-left:150px;';?>width:200px;color:#555555;<?php if(isNewGui())echo ''?>" id="cancelButton" dojoType="dijit.form.Button" showlabel="true"><?php echo i18n('buttonCancel');?>
              <script type="dojo/connect" event="onClick" args="evt">
              showWait(); 
              window.location=".";
              </script>
            </button>  
            <?php }?>  
            <br/><br/>
            <div id="passwordResultDiv" dojoType="dijit.layout.ContentPane" region="none" style="overflow:visible;top:<?php echo $topMsg;?>px;">
            </div>
            </form>
            </div>
     
            </td>
          </tr>
        </table>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>
