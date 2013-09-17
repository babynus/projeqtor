<?php
/**
* @file
* @brief    sigplus Image Gallery Plus boxplus carousel engine
* @author   Levente Hunyadi
* @version  1.4.2
* @remarks  Copyright (C) 2009-2011 Levente Hunyadi
* @remarks  Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
* @see      http://hunyadi.info.hu/projects/sigplus
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_PLUGINS.DS.'content'.DS.'sigplus'.DS.'params.php';

/**
* Support class for jQuery-based boxplus carousel engine.
* @see http://hunyadi.info.hu/projects/boxplus/
*/
class SIGPlusBoxPlusCarouselEngine extends SIGPlusSliderEngine {
	public function getIdentifier() {
		return 'boxplus.carousel';
	}

	public function addStyles() {
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).'/plugins/content/sigplus/engines/boxplus/slider/css/'.$this->getStyleFilename('boxplus.paging'));
		$document->addStyleSheet(JURI::base(true).'/plugins/content/sigplus/engines/boxplus/slider/css/'.$this->getStyleFilename());
		$language = JFactory::getLanguage();
		if ($language->isRTL()) {
			$document->addStyleSheet(JURI::base(true).'/plugins/content/sigplus/engines/boxplus/slider/css/boxplus.paging.rtl.css');
			$document->addStyleSheet(JURI::base(true).'/plugins/content/sigplus/engines/boxplus/slider/css/boxplus.carousel.rtl.css');
		}
		$this->addCustomTag('<!--[if lt IE 8]><link rel="stylesheet" href="'.JURI::base(true).'/plugins/content/sigplus/engines/boxplus/slider/css/boxplus.carousel.ie7.css" type="text/css" /><![endif]-->');
	}

	public function addScripts($id, SIGPlusGalleryParameters $params) {
		$this->addJQuery();
		$this->addScript('/plugins/content/sigplus/engines/boxplus/slider/js/'.$this->getScriptFilename());
		$this->addScript('/plugins/content/sigplus/engines/boxplus/lang/'.$this->getScriptFilename('boxplus.lang'));

		$language = JFactory::getLanguage();
		list($lang, $country) = explode('-', $language->getTag());
		$script =
			'__jQuery__("#'.$id.' ul:first").boxplusCarousel(__jQuery__.extend('.$this->getCustomParameters($params).', { '.
			'rtl:'.($language->isRTL() ? 'true' : 'false').', '.
			'orientation:"'.$params->orientation.'", '.
			'navigation:"'.$params->navigation.'", '.
			'showButtons:'.($params->buttons ? 'true' : 'false').', '.
			'showLinks:'.($params->links ? 'true' : 'false').', '.
			'showOverlayButtons:'.($params->overlay ? 'true' : 'false').', '.
			'duration:'.$params->duration.', '.
			'delay:'.$params->animation.' })); '.
			'__jQuery__.boxplusLanguage("'.$lang.'", "'.$country.'");';
		$this->addOnReadyScript($script);
	}
}