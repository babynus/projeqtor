<?php

/*
 * Copyright (c) 2005-2007 Jon Abernathy <jon@chuggnutt.com>
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU Affero General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

//namespace Html2Text;

class SSO
{
    public static function isEnabled() {
      $SSOenabled = strtolower(Parameter::getGlobalParameter('SAML_allow_login')); // If SAML is enabled
      if ($SSOenabled=='true' and !self::issetAvoidSSO()) {
        return true;
      } else 
        return false;
    }
    public static function isSamlEnabled() {
      return self::isEnabled(); // To change if other SSO exist
    }
    public static function setAvoidSSO() {
      setSessionValue('avoidSSOAuth',true);
    }
    public static function unsetAvoidSSO() {
      unsetSessionValue('avoidSSOAuth');
    }
    public static function issetAvoidSSO() {
      if (sessionValueExists('avoidSSOAuth')) {
        return true;
      } else {
        return false;
      }
    }
    public static function setAccessFromLoginScreen() {
      setSessionValue('accessFromLoginScreen',true);
    }
    public static function unsetAccessFromLoginScreen() {
      unsetSessionValue('accessFromLoginScreen');
    }
    public static function issetAccessFromLoginScreen() {
      if (sessionValueExists('accessFromLoginScreen')) {
        return true;
      } else {
        return false;
      }
    }
    
    public static function getSettingValue($setting) {
      if ($setting=='spBaseUrl') return SqlElement::getBaseUrl().'/sso'; //http://localhost/projeqtorV8.1/sso';
      else if ($setting=='entityId') return self::getSettingValue('spBaseUrl').'/projeqtor/metadata.php';
      else if ($setting=='singleSignOnServiceUrl') return Parameter::getGlobalParameter('SAML_SingleSignOnService');
      else if ($setting=='singleLogoutServiceUrl') return Parameter::getGlobalParameter('SAML_SingleLogoutService');
      else if ($setting=='idpEntityId') return Parameter::getGlobalParameter('SAML_idpId');
      else if ($setting=='idpCert') return Parameter::getGlobalParameter('SAML_idpCert');
      else if ($setting=='isADFS') return (Parameter::getGlobalParameter('SAML_isADFS')=='YES')?true:false;      
      else if ($setting=='technicalContactName') return 'ProjeQtOr';
      else if ($setting=='technicalContactEmail') return Parameter::getGlobalParameter('paramAdminMail');
      else if ($setting=='sloReturnUrl') return SqlElement::getBaseUrl().'/view/welcome.php';
      return null;
    }
    public static function getAttributeName($attribute) {
      return Parameter::getGlobalParameter('SAML_attribute'.ucfirst($attribute));
    }
    
    public static function addTry() {
      $try=getSessionValue('SamlCnxTry',0,true);
      $try++;
      setSessionValue('SamlCnxTry', $try,true);
    }
    public static function resetTry() {
      setSessionValue('SamlCnxTry', 0,true);
    }
    public static function isFirstTry() {
      $try=getSessionValue('SamlCnxTry',0,true);
      if (intval($try) <= 1) return true;
      else return false;
    }
    
    public static function createNewUser($authAttr) {
      global $loginSave;
      $user=new User();
      $loginAttr=SSO::getAttributeName('userId');
      $mailAttr=SSO::getAttributeName('mail');
      $fullNameAttr=SSO::getAttributeName('commonName');
      $user->name=$authAttr[$loginAttr][0];
      if ($mailAttr and isset($authAttr[$mailAttr]) and isset($authAttr[$mailAttr][0]) ) {
        $user->email=$authAttr[$mailAttr][0];
      }
      if ($fullNameAttr and isset($authAttr[$fullNameAttr]) and isset($authAttr[$fullNameAttr][0]) ) {
        $user->resourceName=$authAttr[$fullNameAttr][0];
      }
      $user->idProfile=Parameter::getGlobalParameter('SAML_defaultProfile');
      $createAction=Parameter::getGlobalParameter('SAML_creationAction');
      if ($createAction=='createResource' or $createAction=='createResourceAndContact') {
        $user->isResource=1;
      }
      if ($createAction=='createContact' or $createAction=='createResourceAndContact') {
        $user->isContact=1;
      }
      if (! $user->resourceName and ($user->isResource or $user->isContact)) {
        $user->resourceName=$this->name;
      }
      $loginSave = true;
      $resultSaveUser=$user->save();
      $idProject = Parameter::getGlobalParameter('SAML_defaultProject');
      $aff = new Affectation();
      $aff->idProject = $idProject;
      $aff->idResource = $user->id;
      $resultSaveAffectation=$aff->save();
      $loginSave = false;
      $sendAlert=Parameter::getGlobalParameter('SAML_msgOnUserCreation');
      if ($sendAlert!='NO') {
        $title="ProjeQtOr - " . i18n('newUser');
        $message=i18n("newUserMessage",array($user->name));
        if ($sendAlert=='MAIL' or $sendAlert=='ALERT&MAIL') {
          $paramAdminMail=Parameter::getGlobalParameter('paramAdminMail');
          sendMail($paramAdminMail, $title, $message);
        }
        if ($sendAlert=='ALERT' or $sendAlert=='ALERT&MAIL') {
          $prof=new Profile();
          $crit=array('profileCode'=>'ADM');
          $lstProf=$prof->getSqlElementsFromCriteria($crit,false);
          foreach ($lstProf as $prof) {
            $crit=array('idProfile'=>$prof->id);
            $lstUsr=$this->getSqlElementsFromCriteria($crit,false);
            foreach($lstUsr as $usr) {
              $alert=new Alert();
              $alert->idUser=$usr->id;
              $alert->alertType='INFO';
              $alert->alertInitialDateTime=date('Y-m-d H:i:s');
              $alert->message=$message;
              $alert->title=$title;
              $alert->alertDateTime=date('Y-m-d H:i:s');
              $alert->save();
            }
          }
        }
      }
      return $user;
    }
}
