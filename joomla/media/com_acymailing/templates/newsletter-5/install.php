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
$name = 'Newspaper';
$thumb = 'media/com_acymailing/templates/newsletter-5/newsletter-5.png';
$body = JFile::read(dirname(__FILE__).DS.'index.html');

$styles['tag_h1'] = 'color:#454545 !important; font-size:24px; font-weight:bold; margin:0px;';
$styles['tag_h2'] = 'color:#b20000 !important; font-size:18px; font-weight:bold; margin:0px; margin-bottom:10px; padding-bottom:4px; border-bottom: 1px solid #d6d6d6;';
$styles['tag_h3'] = 'color:#b20101 !important; font-weight:bold; font-size:18px; margin:10px 0px;';
$styles['tag_h4'] = 'color:#e52323 !important; font-weight:bold; margin:0px; padding:0px';
$styles['tag_a'] = 'cursor:pointer; color:#9d0000; text-decoration:none; border:none;';
$styles['acymailing_readmore'] = 'cursor:pointer; color:#ffffff; background-color:#9d0000; border-top:1px solid #9d0000; border-bottom:1px solid #9d0000; padding:3px 5px; font-size:13px;';
$styles['acymailing_online'] = 'color:#dddddd; text-decoration:none; font-size:13px; margin:10px; text-align:center; font-family:Times New Roman, Times, serif; padding-bottom:10px;';
$styles['color_bg'] = '#454545';
$styles['acymailing_content'] = '';
$styles['acymailing_unsub'] = 'color:#dddddd; text-decoration:none; font-size:13px; text-align:center; font-family:Times New Roman, Times, serif; padding-top:10px';

$stylesheet = '.acyfooter a{
	color:#454545;
}
.dark{
	color:#454545;
	font-weight:bold;
}
div,table,p{font-family:"Times New Roman", Times, serif;font-size:13px;color:#575757;}



@media (max-width:450px){
	table[class=w600], td[class=w600], table[class=w540], td[class=w540], img[class=w600]{ width:100% !important; }
	td[class=w30] { width:20px !important; }
	.pict img {max-width:260px; height:auto !important;}
}

@media (min-width: 450px) and (max-width: 600px){
	table[class=w600], td[class=w600], table[class=w540], td[class=w540], img[class=w600] { width:100% !important; }
	td[class=w30] { width:20px !important; }
	.pict img {max-width:410px; height:auto !important;}
}

@media (min-width:600px){
	body {width:600px !important; margin:auto !important;}
	.pict img {max-width:540px !important;  height:auto !important;}
}';
