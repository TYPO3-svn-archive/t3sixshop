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
class Cart extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * amount
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $amount;

	/**
	 * status
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $status;
	
	/**
	 * crdate
	 *
	 * @var \DateTime
	 */
	protected $crdate;


	/**
	 * cartitems
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Cartitem>
	 */
	protected $cartitems;

	/**
	 * __construct
	 *
	 * @return Cart
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
		$this->cartitems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Adds a Cartitem
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Cartitem $cartitem
	 * @return void
	 */
	public function addCartitem(\Arm\T3sixshop\Domain\Model\Cartitem $cartitem) {
		$this->cartitems->attach($cartitem);
	}

	/**
	 * Removes a Cartitem
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Cartitem $cartitemToRemove The Cartitem to be removed
	 * @return void
	 */
	public function removeCartitem(\Arm\T3sixshop\Domain\Model\Cartitem $cartitemToRemove) {
		$this->cartitems->detach($cartitemToRemove);
	}

	/**
	 * Returns the cartitems
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Cartitem> $cartitems
	 */
	public function getCartitems() {
		return $this->cartitems;
	}

	/**
	 * Sets the cartitems
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Cartitem> $cartitems
	 * @return void
	 */
	public function setCartitems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $cartitems) {
		$this->cartitems = $cartitems;
	}

}
?>