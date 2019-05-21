<?php
/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */
$metadata['http://localhost/simplesamlphp/www/saml2/idp/metadata.php'] = [
  'metadata-set' => 'saml20-idp-remote',
  'entityid' => 'http://localhost/simplesamlphp/www/saml2/idp/metadata.php',
  'SingleSignOnService' => 
  [
    0 => 
    [
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'http://localhost/simplesamlphp/www/saml2/idp/SSOService.php',
    ],
  ],
  'SingleLogoutService' => 
  [
    0 => 
    [
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'http://localhost/simplesamlphp/www/saml2/idp/SingleLogoutService.php',
    ],
  ],
  'certData' => 'MIIDTzCCAjegAwIBAgIJAN1DKFR/2d+HMA0GCSqGSIb3DQEBCwUAMD4xCzAJBgNVBAYTAkZSMQswCQYDVQQIDAIzMTEOMAwGA1UEBwwFTXVyZXQxEjAQBgNVBAoMCVByb2plcXRvcjAeFw0xOTA1MTMxMzQ0NDRaFw0yOTA1MTIxMzQ0NDRaMD4xCzAJBgNVBAYTAkZSMQswCQYDVQQIDAIzMTEOMAwGA1UEBwwFTXVyZXQxEjAQBgNVBAoMCVByb2plcXRvcjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANP3+MhPOUNHOvVzlygBDyaULfSMzgV7+KlE1UV+z5u/+tawva3KB+clxiJ7EbOCj2gK3i0ubgRFq82RhhFgz97wYw8a9f74ggxGWnhQ6t92HG8xOBgouY5GSvqCO0KmnI4R0WqGGtNjnJ5plEMHh9APzky5fzzlTogr2sc6E74Ifh1Ji7i1+im1qw4Kfh+Hir7ChoMryGtWpmRgvfrNaZ01i+kH/9Jxl75sJnGv8wn0qjIWgGQSqZApjUOeGG79MkebjCFQxVGxm3EZCgbOyalCYuUdDy6pbbQxJcwGLQ5NsPGB8Q5rgbrDe3wwePNkk9+oqlUSnA1Gnv5Gap5I57UCAwEAAaNQME4wHQYDVR0OBBYEFP3neKAU1UhIrSD2W7F9VlmNzNNvMB8GA1UdIwQYMBaAFP3neKAU1UhIrSD2W7F9VlmNzNNvMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBAFgkf4Wcdbr2/UjF/cmu2pNu1UzpNYUuOo4eayxaG53OG4E108z+1AeyHEYdUF5BAaJMeUeUfIKn96kBdJYlHPJxaF35BcTYfDdLjqhDBOcnZDchX6Em++Q8eJ3dQ870IVxr9LX+HgWF4X/ZukZRc0Jt6LVxKnWG3r7HNb6iwRW7CnTgBxSAdDXm9vzSTg4UiIoZH95HRMhVXzXADD9a+TXL5aIDucfCmSr4KawWbXsnrWSV1Xa5ygT2M0zB7L/RV0XbKzt+OIDjzqsMVzp3/POd2jMqdkNTuK/vZ+wGfXRqKnpqj+wn/iwHeYDrFOYo7z73uoeE0pimuUYWDuDFVRA=',
  'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  'contacts' => 
  [
    0 => 
    [
      'emailAddress' => 'admin@example.org',
      'contactType' => 'technical',
      'givenName' => 'admin',
    ],
  ],
];
?>