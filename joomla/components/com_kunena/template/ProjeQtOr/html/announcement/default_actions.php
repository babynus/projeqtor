<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Announcement
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

if (empty($this->buttons)) return;
?>
<div class="kactions">
	<?php echo implode(' ', $this->buttons) ?>
</div>