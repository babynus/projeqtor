<?php
/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */
$SingleSignOnService = Parameter::getGlobalParameter('SAML_SingleSignOnService');
$SingleLogoutService = Parameter::getGlobalParameter('SAML_SingleLogoutService');
$metadata['projeqtor-ipd'] = [
  'metadata-set' => 'saml20-idp-remote',
  'entityid' => 'projeqtor-ipd',
  'SingleSignOnService' => 
  [
    0 => 
    [
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => $SingleSignOnService,
    ],
  ],
  'SingleLogoutService' => 
  [
    0 => 
    [
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => $SingleLogoutService,
    ],
  ],
  'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
];
?>