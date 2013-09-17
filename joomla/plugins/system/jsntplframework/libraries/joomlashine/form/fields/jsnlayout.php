<?php
/**
 * @version     $Id$
 * @package     JSNExtension
 * @subpackage  JSNTPL
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * JSNLayout field
 *
 * @package     JSNTPL
 * @subpackage  Form
 * @since       2.0.0
 */
class JFormFieldJSNLayout extends JSNTplFormField
{
	public $type = 'JFormFieldJSNLayout';

	/**
	 * Column options.
	 *
	 * @var  array
	 */
	protected $options = array();

	/**
	 * Disable label by default.
	 *
	 * @return  string
	 */
	protected function getLabel()
	{
		return '';
	}

	/**
	 * Parse field declaration to render input.
	 *
	 * @return  void
	 */
	public function getInput()
	{
		// Make sure we have options declared
		if ( ! isset($this->element->option))
		{
			return JText::_('JSN_TPLFW_LAYOUT_MISSING_COLUMN_DECLARATION');
		}

		// Get template model
		$templateModel = class_exists('JModelLegacy') ? JModelLegacy::getInstance('Style', 'TemplatesModel') : JModel::getInstance('Style', 'TemplatesModel');

		// Get style data
		$this->data = $templateModel->getItem(JFactory::getApplication()->input->getInt('id'));

		// Instantiate helper class of JSN Template Framework
		$helper = JSNTplTemplateHelper::getInstance();

		// Finalize template parameters
		$this->data->params = $helper->loadParams($this->data->params, $this->data->template);

		// Check for layout ajustment image
		$this->hasHelper = is_readable(JPATH_ROOT . '/templates/' . $this->data->template . '/template_layout_adjustment.jpg');

		// Parse column declaration
		foreach ($this->element->option AS $group)
		{
			$gname = (string) $group['name'];

			// Pass values to options array
			if (@is_array($this->data->params[$gname]))
			{
				foreach ($this->data->params[$gname] AS $oname => $value)
				{
					$this->options[$gname][preg_replace('/^\d+:/', '', $oname)] = $value;
				}
			}

			// Parse columns
			$this->parseColumns($group, $this->options[$gname]);
		}

		return parent::getInput();
	}

	/**
	 * Function to parse column declaration.
	 *
	 * @param   array  $group    Array of SimpleXMLElement object respresent  a group of columns.
	 * @param   array  &$option  Option array to store column data.
	 *
	 * @return  void
	 */
	protected function parseColumns($group, &$option)
	{
		foreach ($group->children() AS $column)
		{
			$cname = (string) $column['name'];
			$value = isset($option[$cname]) ? $option[$cname] : (string) $column['default'];
			$order = ($order = (int) $column['sourceCodeOrder']) < 10 ? "0{$order}" : $order;

			// Store option
			$option[$cname] = array(
				'label' => (string) $column['label'],
				'value' => $value,
				'order' => $order
			);

			// Does this column has nested column?
			if (count($column->children()))
			{
				$option[$cname]['columns'] = array();

				// Pass values to options array
				if (@is_array($this->data->params["{$cname}Columns"]))
				{
					foreach ($this->data->params["{$cname}Columns"] AS $oname => $value)
					{
						$option[$cname]['columns'][preg_replace('/^\d+:/', '', $oname)] = $value;
					}
				}

				// Parse nested columns
				$this->parseColumns($column, $option[$cname]['columns']);
			}
		}
	}
}
