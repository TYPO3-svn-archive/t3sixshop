<?php
namespace Arm\T3sixshop\ViewHelpers\Widget\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur Rahaman Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *   All rights reserved
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
 * @package t3sixshop
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class JscrollController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController {
	
	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	protected $objects;
	
	/**
	 * 
	 * @var \integer
	 */
	protected $itemScroll = 16;
	
	/**
	 * 
	 * @var \integer
	 */
	protected $jScrollPid;
	
	/**
	 * @var \integer
	 */
	protected $currentPage = 1;
	
	/**
	 * @var \integer
	 */
	protected $totalPages = 1;
	
	
	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->objects = $this->widgetConfiguration['objects'];
		$this->jScrollPid = (integer)$this->widgetConfiguration['jScrollPid'];
		$this->itemScroll = (integer)$this->widgetConfiguration['itemScroll'];
		$this->totalPages = ceil(count($this->objects) / $this->itemScroll);
	}
	
	/**
	 * @param \integer $currentPage
	 * @return void
	 */
	public function indexAction($currentPage = 1) {
		// set current page
		$this->currentPage = (integer) $currentPage;
		if ($this->currentPage < 1) {
			$this->currentPage = 1;
		}
		/*
		echo 'Current: '. $this->currentPage;
		echo 'Item per page: '. $this->itemScroll;
		echo 'Totla itme: '. count($this->objects);
		echo 'Total page: '. $this->totalPages;
		*/
		if ($this->currentPage > $this->totalPages) {
			// set $modifiedObjects to NULL if the page does not exist
			$modifiedObjects = NULL;
		} 
		else {
			// modify query
			$query = $this->objects->getQuery();
			$query->setLimit($this->itemScroll);
			
			if ($this->currentPage > 1) {
				$query->setOffset((integer) ($this->itemScroll * ($this->currentPage - 1)));
			}
			$modifiedObjects = $query->execute();
		}
		$this->view->assign('content', array(
			$this->widgetConfiguration['as'] => $modifiedObjects
		));
		$this->view->assign('pageUid', $this->jScrollPid);
		$this->view->assign('nextBlock', $this->nextBlock());
	}
	
	
	
	/**
	 * Returns "nextBlock"
	 *
	 * @return mixed
	 */
	protected function nextBlock() {
		if ($this->currentPage < $this->totalPages) {
			return $this->currentPage + 1;
		}
		return;
	}
}