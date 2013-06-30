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
class Orderitem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * qty
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $qty;
	
	/**
	 * newqty
	 *
	 * @var \float
	 */
	protected $newqty;

	/**
	 * rate
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $rate;

	/**
	 * amount
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $amount;
	
	
	/**
	 * newamount
	 *
	 * @var \float
	 */
	protected $newamount;
	
	/**
	 * status
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $status;

	/**
	 * product
	 *
	 * @var \Arm\T3sixshop\Domain\Model\Product 
	 */
	protected $product;
	
	/**
	 * name
	 *
	 * @var \string
	 */
	protected $name;
	
	/**
	 * remark
	 *
	 * @var \string
	 */
	protected $remark;
	
	/**
	 * orders
	 *
	 * @var \Arm\T3sixshop\Domain\Model\Order
	 */
	protected $orders;


	/**
	 * Returns the qty
	 *
	 * @return \float $qty
	 */
	public function getQty() {
		return $this->qty;
	}

	/**
	 * Sets the qty
	 *
	 * @param \float $qty
	 * @return void
	 */
	public function setQty($qty) {
		$this->qty = $qty;
	}

	/**
	 * Returns the qty
	 *
	 * @return \float $qty
	 */
	public function getNewqty() {
		return $this->newqty;
	}
	
	/**
	 * Sets the qty
	 *
	 * @param \float $qty
	 * @return void
	 */
	public function setNewqty($qty) {
		$this->newqty = $qty;
	}
	
	/**
	 * Returns the rate
	 *
	 * @return \float $rate
	 */
	public function getRate() {
		return $this->rate;
	}

	/**
	 * Sets the rate
	 *
	 * @param \float $rate
	 * @return void
	 */
	public function setRate($rate) {
		$this->rate = $rate;
	}

	/**
	 * Returns the amount
	 *
	 * @return \float $amount
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Sets the amount
	 *
	 * @param \float $amount
	 * @return void
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	
	/**
	 * Returns the amount
	 *
	 * @return \float $amount
	 */
	public function getNewamount() {
		return $this->newamount;
	}
	
	/**
	 * Sets the amount
	 *
	 * @param \float $amount
	 * @return void
	 */
	public function setNewamount($amount) {
		$this->newamount = $amount;
	}


	/**
	 * Returns the product
	 *
	 * @return \Arm\T3sixshop\Domain\Model\Product  $product
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * Sets the product
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Product  $product
	 * @return void
	 */
	public function setProduct(\Arm\T3sixshop\Domain\Model\Product  $product) {
		$this->product = $product;
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
	 * Returns the remark
	 *
	 * @return \string $remark
	 */
	public function getRemark() {
		return $this->remark;
	}
	
	/**
	 * Sets the remark
	 *
	 * @param \string $remark
	 * @return void
	 */
	public function setRemark($remark) {
		$this->remark = $remark;
	}
	
	/**
	 * Returns the status
	 *
	 * @return \integer $status
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * Sets the status
	 *
	 * @param \integer $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Returns the orders
	 *
	 * @return \Arm\T3sixshop\Domain\Model\Order  $orders
	 */
	public function getOrders() {
		return $this->orders;
	}
	
	/**
	 * Sets the orders
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Order  $orders
	 * @return void
	 */
	public function setOrders(\Arm\T3sixshop\Domain\Model\Order  $orders) {
		$this->orders = $orders;
	}
}
?>