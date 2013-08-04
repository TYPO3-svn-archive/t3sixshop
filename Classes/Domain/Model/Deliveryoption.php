<?php
namespace Arm\T3sixshop\Domain\Model;

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
class Deliveryoption extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * price
	 *
	 * @var \float
	 */
	protected $price;
	
	/**
	 * 
	 * @var \float
	 */
	protected $freeprice;
	
	/**
	 * 
	 * @var \string
	 */
	protected $schedule;

	/**
	 * order
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Order>
	 */
	protected $orders;

	/**
	 * __construct
	 *
	 * @return pgroup
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->orders = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Returns the price
	 *
	 * @return \float $price
	 */
	public function getPrice() {
		return $this->price;
	}
	
	/**
	 * Sets the price
	 *
	 * @param \float $price
	 * @return void
	 */
	public function setPrice($price) {
		$this->price = $price;
	}
	
	/**
	 * Returns the freeprice
	 *
	 * @return \float $freeprice
	 */
	public function getFreeprice() {
		return $this->freeprice;
	}
	
	/**
	 * Sets the freeprice
	 *
	 * @param \float $freeprice
	 * @return void
	 */
	public function setFreeprice($freeprice) {
		$this->freeprice = $freeprice;
	}

	/**
	 * Adds a Order
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Order $order
	 * @return void
	 */
	public function addOrder(\Arm\T3sixshop\Domain\Model\Order $order) {
		$this->orders->attach($order);
	}

	/**
	 * Removes a Order
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Order $orderToRemove The Order to be removed
	 * @return void
	 */
	public function removeOrder(\Arm\T3sixshop\Domain\Model\Order $orderToRemove) {
		$this->orders->detach($orderToRemove);
	}

	/**
	 * Returns the orders
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Order> $orders
	 */
	public function getOrders() {
		return $this->orders;
	}

	/**
	 * Sets the orders
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Order> $orders
	 * @return void
	 */
	public function setOrders(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $orders) {
		$this->orders = $orders;
	}

	/**
	 * Returns the schedule
	 *
	 * @return \string $schedule
	 */
	public function getSchedule() {
		return $this->schedule;
	}
	
	/**
	 * Sets the schedule
	 *
	 * @param \string $schedule
	 * @return void
	 */
	public function setSchedule($schedule) {
		$this->schedule = $schedule;
	}
}
?>