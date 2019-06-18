<?php

    $spBaseUrl = 'http://localhost/projeqtorV8.1/sso'; 
    $spCert='sp.crt';
	$spKey='sp.key';
	$idpCert='MIIDXTCCAkWgAwIBAgIJAO1WcQ4NM6yfMA0GCSqGSIb3DQEBCwUAMEUxCzAJBgNVBAYTAkZSMRIwEAYDVQQIDAlPY2NpdGFuaWUxDjAMBgNVBAcMBU1VUkVUMRIwEAYDVQQKDAlQUk9KRVFUT1IwHhcNMTkwNjE0MDgwMzM2WhcNMjkwNjEzMDgwMzM2WjBFMQswCQYDVQQGEwJGUjESMBAGA1UECAwJT2NjaXRhbmllMQ4wDAYDVQQHDAVNVVJFVDESMBAGA1UECgwJUFJPSkVRVE9SMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwAD2J95aag/Fj/3oUxjdAaUFCOiTZOhPGNPjw6j714kPkKKv18aITxt2zBZ+EZnUyCVDPcZHJJdVktUllx7dkhvRS0csfa4bZDzA8v92wqhlZIKijgdq0NE253T51UWHcAhjzOm+3OR9+psQ8BueqX9IUeXYuFAC/zl7Zq1u6hui3MF7yJvSU6hcTgCQmi/dZihrwYT0ilkKO4jrLSQDbZZMxqUuko/LmYZLoYUifqkq2DcghwPo5DUiUbER9ROroJAjKenKaJ16V7LLZb3QJmr64SYXLslf1sFzQ6O5p5+Vn4GqazORIBLQw9CzlJXbgHnkDi4CvQ+EM09gJ3orCQIDAQABo1AwTjAdBgNVHQ4EFgQUAn++7aPrFOZuzKxa0peNAJqqbkAwHwYDVR0jBBgwFoAUAn++7aPrFOZuzKxa0peNAJqqbkAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAFZ/erKCj7gw8AmQZNCrqILr3B80oEGDxzbMjLZuSIJsy+q0JYC/RnSu7sOFP9CQgHHos6pXIae8vWc5nC0DicJsnjTQSiV0x6YMhHrImwPJ5KPfjLJyAmjj86f29e2PFRE0Fm3DaqvU2QItttCxi7F397IjyhZbNS6sM5Wx8cU231uflApzQXitoqJthqR302cWXO83v2bjBLImXRyHVm9ZW/L3hE5BMbyJEXNuUmKe8ArDVfeTA2Ikw4M+jj27b0BYHyR7vKnPq3PxBd5493+yfZRq8ZcPgXOFOG4mamKio+XZfGv3VpWRDasK/00X8q/RUrvwvb8zM2E8HzZFoxA==';
    //$idpCert='idp.crt';
	$singleSignOnServiceUrl='https://sso.projeqtor.net/saml2/idp/SSOService.php';
	$singleLogoutServiceUrl='https://sso.projeqtor.net/saml2/idp/SingleLogoutService.php';
    $idpEntityId='https://sso.projeqtor.net/saml2/idp/metadata.php';
	$technicalContactName='support';
	$technicalContactEmail='support@projeqtor.org';
	
$settingsInfo = array (
    'baseurl' => $spBaseUrl,
    'strict' => false, // If 'strict' is True, then will reject unsigned or unencrypted messages or messages if not strictly follow the SAML standard
    'debug' => false,
	'sp' => array (
		'entityId' => $spBaseUrl.'/projeqtor/metadata.php',
		'assertionConsumerService' => array (
			'url' => $spBaseUrl.'/projeqtor/index.php?acs',
		),
		'singleLogoutService' => array (
			'url' => $spBaseUrl.'/projeqtor/index.php?sls',
		),
		'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
	),
	'idp' => array (
		'entityId' => $idpEntityId,
		'singleSignOnService' => array (
			'url' => $singleSignOnServiceUrl,
		),
		'singleLogoutService' => array (
			'url' => $singleLogoutServiceUrl,
		),
		'x509cert' => $idpCert,
	),
    'compress' => array (
        'requests' => true,
        'responses' => true
    ),
    'security' => array (
        'nameIdEncrypted' => false,
        'authnRequestsSigned' => false,
        'logoutRequestSigned' => false,
        'logoutResponseSigned' => false,
        'signMetadata' => false,
        'wantMessagesSigned' => false,
        'wantAssertionsEncrypted' => false,
        'wantAssertionsSigned' => false,
        'wantNameId' => true,
        'wantNameIdEncrypted' => false,
        'requestedAuthnContext' => false,
        'requestedAuthnContextComparison' => 'exact',
        'wantXMLValidation' => true,
        'relaxDestinationValidation' => true, //false,
        'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
        'digestAlgorithm' => 'http://www.w3.org/2001/04/xmlenc#sha256',
        // ADFS URL-Encodes SAML data as lowercase, and the toolkit by default uses
        // uppercase. Turn it True for ADFS compatibility on signature verification
        'lowercaseUrlencoding' => false,
    ),

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => array (
        'technical' => array (
            'givenName' => $technicalContactName,
            'emailAddress' => $technicalContactEmail
        ),
        'support' => array (
            'givenName' => $technicalContactName,
            'emailAddress' => $technicalContactEmail
        ),
    ),
);
