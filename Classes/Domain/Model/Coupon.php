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
class Coupon extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * code
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $code;
	
	/**
	 * price
	 *
	 * @var \float
	 */
	protected $discount;
	
	/**
	 * 
	 * @var \string
	 */
	protected $cuse;
	
	/**
	 * 
	 * @var \string
	 */
	protected $dtype;

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
	 * Returns the code
	 *
	 * @return \string $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * Sets the code
	 *
	 * @param \string $code
	 * @return void
	 */
	public function setCode($code) {
		$this->code = $code;
	}
	
	/**
	 * Returns the discount
	 *
	 * @return \float $discount
	 */
	public function getDiscount() {
		return $this->discount;
	}
	
	/**
	 * Sets the discount
	 *
	 * @param \float $discount
	 * @return void
	 */
	public function setDiscount($discount) {
		$this->discount = $discount;
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
	 * Returns the dtype
	 *
	 * @return \string $dtype
	 */
	public function getDtype() {
		return $this->dtype;
	}
	
	/**
	 * Sets the dtype
	 *
	 * @param \string $dtype
	 * @return void
	 */
	public function setDtype($dtype) {
		$this->dtype = $dtype;
	}
	
	/**
	 * Returns the usage
	 *
	 * @return \string $cuse
	 */
	public function getCuse() {
		return $this->cuse;
	}
	
	/**
	 * Sets the cuse
	 *
	 * @param \string $cuse
	 * @return void
	 */
	public function setCuse($cuse) {
		$this->cuse = $cuse;
	}
}
?>