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
class Order extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * user
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $user;
	
	/**
	 * session
	 *
	 * @var \string
	 */
	protected $session;

	/**
	 * fname
	 *
	 * @var \string
	 */
	protected $fname;
	
	/**
	 * lname
	 *
	 * @var \string
	 */
	protected $lname;
	
	/**
	 * email
	 *
	 * @var \string
	 */
	protected $email;

	/**
	 * phone
	 *
	 * @var \string
	 */
	protected $phone;

	/**
	 * apartment
	 *
	 * @var \string
	 */
	protected $apartment;

	/**
	 * address
	 *
	 * @var \string
	 */
	protected $address;

	/**
	 * zip
	 *
	 * @var \string
	 */
	protected $zip;
	
	/**
	 * remark
	 *
	 * @var \string
	 */
	protected $remark;

	/**
	 * amount
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $amount;
	
	/**
	 * totalamount
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $totalamount;

	/**
	 * status
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $status;

	/**
	 * discount
	 *
	 * @var \float
	 */
	protected $discount;
	
	/**
	 * crdate
	 *
	 * @var \DateTime
	 */
	protected $crdate;

	/**
	 * deliveryon
	 *
	 * @var \DateTime
	 */
	protected $deliveryon;

	/**
	 * orderid
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $orderid;

	/**
	 * orderitems
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Orderitem>
	 */
	protected $orderitems;

	/**
	 * __construct
	 *
	 * @return Order
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
		$this->orderitems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the user
	 *
	 * @return \integer $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param \integer $user
	 * @return void
	 */
	public function setUser($user) {
		$this->user = $user;
	}

	/**
	 * Returns the email
	 *
	 * @return \string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param \string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	
	/**
	 * Returns the fname
	 *
	 * @return \string $fname
	 */
	public function getFname() {
		return $this->fname;
	}
	
	/**
	 * Sets the fname
	 *
	 * @param \string $fname
	 * @return void
	 */
	public function setFname($fname) {
		$this->fname = $fname;
	}
	
	/**
	 * Returns the lname
	 *
	 * @return \string $lname
	 */
	public function getLname() {
		return $this->lname;
	}
	
	/**
	 * Sets the lname
	 *
	 * @param \string $lname
	 * @return void
	 */
	public function setLname($lname) {
		$this->lname = $lname;
	}
	
	/**
	 * Returns the session
	 *
	 * @return \string $session
	 */
	public function getSession() {
		return $this->session;
	}
	
	/**
	 * Sets the session
	 *
	 * @param \string $session
	 * @return void
	 */
	public function setSession($session) {
		$this->session = $session;
	}

	/**
	 * Returns the phone
	 *
	 * @return \string $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets the phone
	 *
	 * @param \string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the apartment
	 *
	 * @return \string $apartment
	 */
	public function getApartment() {
		return $this->apartment;
	}

	/**
	 * Sets the apartment
	 *
	 * @param \string $apartment
	 * @return void
	 */
	public function setApartment($apartment) {
		$this->apartment = $apartment;
	}

	/**
	 * Returns the address
	 *
	 * @return \string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param \string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the zip
	 *
	 * @return \string $zip
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Sets the zip
	 *
	 * @param \string $zip
	 * @return void
	 */
	public function setZip($zip) {
		$this->zip = $zip;
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
	public function getTotalamount() {
		return $this->totalamount;
	}
	
	/**
	 * Sets the amount
	 *
	 * @param \float $amount
	 * @return void
	 */
	public function setTotalamount($amount) {
		$this->totalamount = $amount;
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
	 * Returns the deliveryon
	 *
	 * @return \DateTime $deliveryon
	 */
	public function getDeliveryon() {
		return $this->deliveryon;
	}

	/**
	 * Sets the deliveryon
	 *
	 * @param \DateTime $deliveryon
	 * @return void
	 */
	public function setDeliveryon($deliveryon) {
		$this->deliveryon = $deliveryon;
	}

	/**
	 * Returns the crdate
	 *
	 * @return \DateTime $crdate
	 */
	public function getCrdate() {
		return $this->crdate;
	}
	
	/**
	 * Sets the crdate
	 *
	 * @param \DateTime $crdate
	 * @return void
	 */
	public function setCrdate($crdate) {
		$this->crdate = $crdate;
	}
	
	/**
	 * Returns the orderid
	 *
	 * @return \string $orderid
	 */
	public function getOrderid() {
		return strtoupper($this->orderid);
	}

	/**
	 * Sets the orderid
	 *
	 * @param \string $orderid
	 * @return void
	 */
	public function setOrderid($orderid) {
		$this->orderid = strtoupper($orderid);
	}

	/**
	 * Adds a Orderitem
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Orderitem $orderitem
	 * @return void
	 */
	public function addOrderitem(\Arm\T3sixshop\Domain\Model\Orderitem $orderitem) {
		$this->orderitems->attach($orderitem);
	}

	/**
	 * Removes a Orderitem
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Orderitem $orderitemToRemove The Orderitem to be removed
	 * @return void
	 */
	public function removeOrderitem(\Arm\T3sixshop\Domain\Model\Orderitem $orderitemToRemove) {
		$this->orderitems->detach($orderitemToRemove);
	}

	/**
	 * Returns the orderitems
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Orderitem> $orderitems
	 */
	public function getOrderitems() {
		return $this->orderitems;
	}

	/**
	 * Sets the orderitems
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Orderitem> $orderitems
	 * @return void
	 */
	public function setOrderitems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $orderitems) {
		$this->orderitems = $orderitems;
	}

}
?>