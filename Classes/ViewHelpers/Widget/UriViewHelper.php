<?php
namespace Arm\T3sixshop\ViewHelpers\Widget;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur Rahaman Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package t3sixshop
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class UriViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Widget\UriViewHelper {
    
    /**
	 * Get the URI for a non-AJAX Request.
	 *
	 * @return string the Widget URI
	 */
	protected function getWidgetUri() {
		
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$argumentPrefix = $this->controllerContext->getRequest()->getArgumentPrefix();
		$arguments = $this->hasArgument('arguments') ? $this->arguments['arguments'] : array();
		$pluginPrefix = substr($argumentPrefix, 0, strpos($argumentPrefix, '['));
		
		if ($this->hasArgument('action')) {
			$arguments['action'] = $this->arguments['action'];
		}
		
		if ($this->hasArgument('format') && $this->arguments['format'] !== '') {
			$arguments['format'] = $this->arguments['format'];
		}
		
		$uriBuilder->reset();
		
		if ($arguments['id'] != '') {		
			$uriBuilder->setTargetPageUid($arguments['id']);
			unset($arguments['id']);
		}
		
		if ($arguments['category'] != '') {	
			$plugin['category'] = $arguments['category'];
			unset($arguments['category']);
		}
		
		
		$flagType = 0;
		$dynamicArg = array();
		
		if ($arguments['type']!= '') {
			$flagType = 1;
			$this->arguments['type'] = $arguments['type'];
			unset($arguments['type']);
			$dynamicArg['type'] = $this->arguments['type'];
		}
		
		if (isset($plugin['category'])) {
			$dynamicArg[$pluginPrefix] = $plugin;
		}
		
		$dynamicArg[$argumentPrefix] = $arguments;
		
		if ($flagType == 1) {
			$uri = $uriBuilder->setTargetPageType($this->arguments['type'])->setArguments($dynamicArg)->setSection($this->arguments['section'])->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array($argumentPrefix,'cHash'))->setFormat($this->arguments['format'])->build();
		}
		else {
			$uri = $uriBuilder->setArguments($dynamicArg)->setSection($this->arguments['section'])->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array($argumentPrefix,'cHash'))->setFormat($this->arguments['format'])->build();
		}

		return str_replace('&', '&amp;', $uri);
	}
    
}