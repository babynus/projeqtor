<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.4.1
 * @author	acyba.com
 * @copyright	(C) 2009-2013 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php


class acyencodingHelper{

	function change($data,$input,$output){

		$input = strtoupper(trim($input));
		$output = strtoupper(trim($output));

		if($input == $output) return $data;

		if($input == 'UTF-8' && $output == 'ISO-8859-1'){
			$data = str_replace(array('€','„','“'),array('EUR','"','"'),$data);
		}

		if(function_exists('iconv')){
			set_error_handler('acymailing_error_handler_encoding');
			$encodedData = iconv($input, $output."//IGNORE", $data);
			restore_error_handler();
			if(!empty($encodedData) && !acymailing_error_handler_encoding('result')){
				return $encodedData;
			}
		}

		if(function_exists('mb_convert_encoding')){
			return mb_convert_encoding($data, $output, $input);
		}

		if($input == 'UTF-8' && $output == 'ISO-8859-1'){
			return utf8_decode($data);
		}

		if($input == 'ISO-8859-1' && $output == 'UTF-8'){
			return utf8_encode($data);
		}

		return $data;

	}

	function detectEncoding(&$content){

		if(!function_exists('mb_check_encoding')) return '';

		$toTest = array('UTF-8');
		$lang = JFactory::getLanguage();
		$tag = $lang->getTag();

		if($tag == 'el-GR'){
			$toTest[] = 'ISO-8859-7';
		}
		$toTest[] = 'ISO-8859-1';
		$toTest[] = 'ISO-8859-2';
		$toTest[] = 'Windows-1252';

		foreach($toTest as $oneEncoding){
			if(mb_check_encoding($content,$oneEncoding)) return $oneEncoding;
		}

		return '';
	}

}//endclass

function acymailing_error_handler_encoding($errno,$errstr=''){
	static $error = false;
	if(is_string($errno) && $errno=='result'){
		$currentError = $error;
		$error = false;
		return $currentError;
	}
	$error = true;
	return true;
}
