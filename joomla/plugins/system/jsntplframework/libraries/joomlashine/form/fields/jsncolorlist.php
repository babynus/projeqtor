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
 * JSNColorList field
 *
 * @package     JSNTPL
 * @subpackage  Form
 * @since       1.0.0
 */
class JFormFieldJSNColorList extends JSNTplFormField
{
	public $type = 'JSNColorList';

	protected $defaultOptions = array();
	protected $optionKeys = array();
	protected $optionColors = array();

	/**
	 * Disable label by default.
	 *
	 * @return  string
	 */
	protected function getLabel()
	{
		return '';
	}

	public function getInput ()
	{
		$defaultValues = array(
			'list' => array(),
			'colors' => array()
		);

		foreach ($this->element->option AS $option)
		{
			$value = (string) $option['value'];

			$this->defaultOptions[$value] = array(
				'label' => (string) $option,
				'value' => $value
			);

			$defaultValues['list'][]	= $value;
			$defaultValues['colors'][]	= $value;
		}

		$this->optionList = array_keys($this->defaultOptions);
		$this->optionChecked = $this->optionList;

		// Get template model
		$templateModel = class_exists('JModelLegacy') ? JModelLegacy::getInstance('Style', 'TemplatesModel') : JModel::getInstance('Style', 'TemplatesModel');

		// Get style data
		$this->data = $templateModel->getItem(JFactory::getApplication()->input->getInt('id'));

		if (isset($this->data->params['sitetoolsColors']))
		{
			$decodedValue = json_decode($this->data->params['sitetoolsColors']);

			if (is_array($decodedValue->list))
			{
				$optionList = array();

				foreach ($decodedValue->list AS $item)
				{
					if (isset($this->defaultOptions[$item]))
					{
						$optionList[] = $item;
					}
				}

				$this->optionList = array_merge($optionList, array_diff($this->optionList, $optionList));
			}

			if (@is_array($decodedValue->colors))
			{
				$this->optionChecked = $decodedValue->colors;
			}
		}
		else
		{
			$this->data->params['sitetoolsColors'] = array(
				'list' => $this->optionList,
				'colors' => $this->optionChecked
			);
		}

		$this->disabled = isset($this->element['disabled']) AND $this->element['disabled'] == 'true';
		$this->disabledClass = $this->disabled ? 'disabled' : '';

		return parent::getInput();
	}
}
