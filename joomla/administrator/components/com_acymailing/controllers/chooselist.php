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

class ChooselistController extends acymailingController{

	function customfields(){
		JRequest::setVar( 'layout', 'customfields'  );
		return parent::display();
	}
}
