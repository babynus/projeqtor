<?php
/**
 * Kunena Component
 * @package Kunena.Administrator.Template
 * @subpackage Categories
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

$document = JFactory::getDocument();
$document->addStyleSheet ( JURI::base(true).'/components/com_kunena/media/css/admin.css' );
if (JFactory::getLanguage()->isRTL()) $document->addStyleSheet ( JURI::base().'components/com_kunena/media/css/admin.rtl.css' );
$errormsg = JText::_('COM_KUNENA_ERROR1', true);
$document->addScriptDeclaration("
function submitbutton(pressbutton)
{
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform(pressbutton);
		return;
	}
	// do field validation
	if (typeof form.onsubmit == 'function') form.onsubmit();
	if (form.name.value == '') {
		alert('{$errormsg}');
	} else {
		submitform(pressbutton);
	}
}
");
?>
<div id="kadmin">
	<div class="kadmin-left"><?php include KPATH_ADMIN.'/views/common/tmpl/menu.php'; ?></div>
	<div class="kadmin-right">
	<div class="kadmin-functitle icon-adminforum"><?php echo $this->category->exists() ? JText::sprintf('COM_KUNENA_A_CATEGORY_EDIT_TITLE', $this->escape ( $this->category->name )) : JText::_('COM_KUNENA_A_CATEGORY_CREATE_TITLE') ?></div>
		<form action="<?php echo KunenaRoute::_('administrator/index.php?option=com_kunena&view=categories') ?>" method="post" id="adminForm" name="adminForm">
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="catid" value="<?php echo intval($this->category->id); ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>

		<?php jimport('joomla.html.pane');
		$myTabs = JPane::getInstance('tabs', array('startOffset'=>0)); ?>
		<dl class="tabs" id="pane">
		<dt title="<?php echo JText::_('COM_KUNENA_CATEGORY_INFO'); ?>"><?php echo JText::_('COM_KUNENA_CATEGORY_INFO'); ?></dt>
		<dd>
		<fieldset>
				<legend><?php echo JText::_('COM_KUNENA_BASICSFORUMINFO'); ?></legend>
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_KUNENA_PARENT'); ?></td>
						<td>
							<?php echo $this->options ['categories']; ?>
							<div class="clr"></div>
							<?php echo JText::_('COM_KUNENA_PARENTDESC'); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo JText::_('COM_KUNENA_NAMEADD'); ?></td>
						<td><input class="inputbox" type="text" name="name" size="80" value="<?php echo $this->escape ( $this->category->name ); ?>" /></td>
					</tr>
					<tr>
						<td><?php echo JText::_('COM_KUNENA_A_CATEGORY_ALIAS'); ?></td>
						<td><input class="inputbox" type="text" name="alias" size="80" value="<?php echo $this->escape ( $this->category->alias ); ?>" /></td>
					</tr>
					<?php if ($this->options ['aliases']) : ?>
					<tr>
						<td>&nbsp;</td>
						<td><?php echo $this->options ['aliases']; ?></td>
					</tr>
					<?php endif ?>
					<tr>
						<td valign="top"><?php echo JText::_('COM_KUNENA_PUBLISHED'); ?>:</td>
						<td valign="top"><?php echo $this->options ['published']; ?></td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_KUNENA_DESCRIPTIONADD'); ?></td>
						<td>
							<textarea class="inputbox" cols="50" rows="6" name="description" id="description" style="width: 500px"><?php echo $this->escape ( $this->category->description ); ?></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_KUNENA_HEADERADD'); ?></td>
						<td>
							<textarea class="inputbox" cols="50" rows="6" name="headerdesc" id="headerdesc" style="width: 500px"><?php echo $this->escape ( $this->category->headerdesc ); ?></textarea>
						</td>
					</tr>
				</table>
			</fieldset>

			<fieldset>
				<legend><?php echo JText::_('COM_KUNENA_ADVANCEDDISPINFO'); ?></legend>
				<table class="kadmin-adminform">
					<tr>
						<td><?php echo JText::_('COM_KUNENA_CLASS_SFX'); ?></td>
						<td><input class="inputbox" type="text" name="class_sfx" size="20" maxlength="20" value="<?php echo $this->escape ( $this->category->class_sfx ); ?>" /></td>
						<td><?php echo JText::_('COM_KUNENA_CLASS_SFXDESC'); ?></td>
					</tr>
				</table>
			</fieldset>
			</dd>
			<dt title="<?php echo JText::_('COM_KUNENA_PERMISSIONS'); ?>"><?php echo JText::_('COM_KUNENA_PERMISSIONS'); ?></dt>
			<dd>
				<fieldset>
					<legend><?php echo JText::_('COM_KUNENA_CATEGORY_PERMISSIONS'); ?></legend>
					<table class="kadmin-adminform">
						<tr>
							<td class="nowrap" valign="top" width="25%"><?php echo JText::_('COM_KUNENA_A_ACCESSTYPE_TITLE'); ?></td>
							<td valign="top" width="25%"><?php echo $this->options ['accesstypes']; ?></td>
							<td><?php echo JText::_('COM_KUNENA_A_ACCESSTYPE_DESC'); ?></td>
						</tr>
						<?php
						foreach ($this->options ['accesslists'] as $accesstype=>$accesslist) :
							foreach ($accesslist as $accessinput) :
						?>
						<tr class="kaccess kaccess-<?php echo $accesstype ?>" style="<?php echo $this->category->accesstype != $accesstype ? 'display:none' : '' ?>">
							<td width="30%" class="nowrap" valign="top"><?php echo $accessinput['title'] ?></td>
							<td width="35%" valign="top"><?php echo $accessinput['input'] ?></td>
							<td width="35%" valign="top"><?php echo $accessinput['desc'] ?></td>
						</tr>
						<?php endforeach; endforeach ?>
					</table>
				</fieldset>
			</dd>

			<?php if (!$this->category->id || !$this->category->isSection()): ?>
			<dt title="<?php echo JText::_('COM_KUNENA_ADVANCEDDESC'); ?>"><?php echo JText::_('COM_KUNENA_ADVANCEDDESC'); ?></dt>
			<dd>
				<fieldset>
					<legend><?php echo JText::_('COM_KUNENA_ADVANCEDDESCINFO'); ?></legend>
					<table class="kadmin-adminform">
						<tr>
							<td><?php echo JText::_('COM_KUNENA_LOCKED1'); ?></td>
 							<td><?php echo $this->options ['forumLocked']; ?></td>
							<td><?php echo JText::_('COM_KUNENA_LOCKEDDESC'); ?></td>
						</tr>
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_REV'); ?></td>
							<td valign="top"><?php echo $this->options ['forumReview']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_REVDESC'); ?></td>
						</tr>
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_ANONYMOUS_ALLOW'); ?>:</td>
							<td valign="top"><?php echo $this->options ['allow_anonymous']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_ANONYMOUS_ALLOW_DESC'); ?></td>
						</tr>
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_ANONYMOUS_DEFAULT'); ?>:</td>
							<td valign="top"><?php echo $this->options ['post_anonymous']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_ANONYMOUS_DEFAULT_DESC'); ?></td>
						</tr>
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_A_POLL_CATEGORIES_ALLOWED'); ?>:</td>
							<td valign="top"><?php echo $this->options ['allow_polls']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_A_POLL_CATEGORIES_ALLOWED_DESC'); ?></td>
						</tr>
						<?php /* TODO: enable features
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_CHANNELS'); ?>:</td>
							<td valign="top"><?php echo $this->options ['channels']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_CHANNELS_DESC'); ?></td>
						</tr>
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_TOPIC_ORDERING'); ?>:</td>
							<td valign="top"><?php echo $this->options ['topic_ordering']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_CATEGORY_TOPIC_ORDERING_DESC'); ?></td>
						</tr>
						<tr>
							<td class="nowrap" valign="top"><?php echo JText::_('COM_KUNENA_A_CATEGORY_TOPICICONSET'); ?>:</td>
							<td valign="top"><?php echo $this->options ['category_iconset']; ?></td>
							<td valign="top"><?php echo JText::_('COM_KUNENA_A_POLL_CATEGORY_TOPICICONSET_DESC'); ?></td>
						</tr>
						*/ ?>
					</table>
				</fieldset>
				</dd>
				<dt title="<?php echo JText::_('COM_KUNENA_MODNEWDESC'); ?>"><?php echo JText::_('COM_KUNENA_MODNEWDESC'); ?></dt>
				<dd>
				<fieldset>
					<legend><?php echo JText::_('COM_KUNENA_MODHEADER'); ?></legend>

					<div class="kadmin-funcsubtitle"><?php echo JText::_('COM_KUNENA_MODSASSIGNED'); ?></div>

					<table class="adminlist">
						<thead>
							<tr>
								<th width="5">#</th>
								<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count ( $this->moderators ); ?>);" /></th>
								<th align="left"><?php echo JText::_('COM_KUNENA_USRL_NAME'); ?></th>
								<th align="left"><?php echo JText::_('COM_KUNENA_USRL_USERNAME'); ?></th>
								<th align="center"><?php echo JText::_('COM_KUNENA_PUBLISHED'); ?></th>
							</tr>
						</thead>

						<tbody>
						<?php if (count ( $this->moderators ) == 0) : ?>
							<tr>
								<td colspan="5" align="center"><?php echo JText::_('COM_KUNENA_NOMODS') ?></td>
							</tr>
						<?php else :
							$k = 1;
							$i = 0;
							foreach ( $this->moderators as $ml ) : $k = 1 - $k; ?>
							<tr class="row<?php echo $k; ?>">
								<td width="5"><?php echo $i + 1; ?></td>
								<td width="5">
									<input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo intval($ml->userid); ?>" onclick="isChecked(this.checked);" />
								</td>
								<td><?php echo $this->escape($ml->name); ?></td>
								<td><?php echo $this->escape($ml->username); ?></td>
								<td align="center"><img src="images/tick.png" alt="" /></td>
							</tr>
							<?php 	$i ++;
							endforeach;
						endif;
						?>
						</tbody>
					</table>
				</fieldset>
				<?php endif; ?>
			</dd>
		</dl>
		</form>
	</div>
	<div class="kadmin-footer">
		<?php echo KunenaVersion::getLongVersionHTML (); ?>
	</div>
</div>
