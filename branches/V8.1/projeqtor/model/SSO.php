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
      else if ($setting=='technicalContactName') return 'ProjeQtOr Support';
      else if ($setting=='technicalContactEmail') return 'support@projeqtor.org';
      else if ($setting=='sloReturnUrl') return SqlElement::getBaseUrl().'/view/welcome.php';
      return null;
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
}
