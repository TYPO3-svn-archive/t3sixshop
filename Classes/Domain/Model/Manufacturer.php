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
class Manufacturer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * products
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Product>
	 */
	protected $products;

	/**
	 * __construct
	 *
	 * @return manufacturer
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
		$this->products = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Adds a Product
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 * @return void
	 */
	public function addProduct(\Arm\T3sixshop\Domain\Model\Product $product) {
		$this->products->attach($product);
	}

	/**
	 * Removes a Product
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Product $productToRemove The Product to be removed
	 * @return void
	 */
	public function removeProduct(\Arm\T3sixshop\Domain\Model\Product $productToRemove) {
		$this->products->detach($productToRemove);
	}

	/**
	 * Returns the products
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Product> $products
	 */
	public function getProducts() {
		return $this->products;
	}

	/**
	 * Sets the products
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Product> $products
	 * @return void
	 */
	public function setProducts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $products) {
		$this->products = $products;
	}

}
?>