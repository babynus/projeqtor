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
	$db = JFactory::getDBO();
	$db->setQuery('SELECT count(*) FROM `#__vemod_news_mailer_users`');
	$resultUsers = $db->loadResult();

	echo JText::sprintf('USERS_IN_COMP',$resultUsers,'Vemod News Mailer');
