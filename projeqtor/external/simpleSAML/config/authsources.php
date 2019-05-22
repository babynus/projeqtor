<?php
$idp = Parameter::getGlobalParameter('SAML_idp');
$config = [
	'projeqtor-sp' => [
		'saml:SP',
		'entityID' => 'projeqtor-sp',
		'idp' => $idp,
	],
];
