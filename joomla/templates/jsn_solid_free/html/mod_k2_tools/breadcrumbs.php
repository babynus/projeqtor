<?php
/**
 * @version		$Id: breadcrumbs.php 1492 2012-02-22 17:40:09Z joomlaworks@gmail.com $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2BreadcrumbsBlock">
	<?php
	$output = '';
	if ($params->get('home')) {
		$output .= '<span class="bcTitle">'.JText::_('K2_YOU_ARE_HERE').'</span>';
		$output .= '<a href="'.JURI::root().'">'.$params->get('home',JText::_('K2_HOME')).'</a>';
		if (count($path)) {
			foreach ($path as $link) {
				$output .= '<span class="bcSeparator">'.$params->get('seperator','&raquo;').'</span>'.$link;
			}
		}
		if($title){
			$output .= '<span class="bcSeparator">'.$params->get('seperator','&raquo;').'</span>'.$title;
		}
	} else {
		if($title){
			$output .= '<span class="bcTitle">'.JText::_('K2_YOU_ARE_HERE').'</span>';
		}
		if (count($path)) {
			foreach ($path as $link) {
				$output .= $link.'<span class="bcSeparator">'.$params->get('seperator','&raquo;').'</span>';
			}
		}
		$output .= $title;
	}

	echo $output;
	?>
</div>
