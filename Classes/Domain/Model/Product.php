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
class Product extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	
	/**
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 * @inject
	 */
	protected $falRepository;

	/**
	 * name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * category
	 * @var \Arm\T3sixshop\Domain\Model\Category
	 */
	protected $category;
	
	/**
	 * manufacturer
	 * @var \Arm\T3sixshop\Domain\Model\Manufacturer
	 */
	protected $manufacturer;
	
	/**
	 * shorttext
	 * @var \string
	 */
	protected $shorttext;

	/**
	 * description
	 *
	 * @var \string
	 */
	protected $description;

	/**
	 * discount
	 *
	 * @var \float
	 */
	protected $discount;
	
	/**
	 * unit
	 *
	 * @var \string
	 */
	protected $unit;

	/**
	 * price
	 *
	 * @var \float
	 */
	protected $price;
	
	/**
	 * Effective price
	 * @var \float
	 */
	protected $currentprice;
	
	/**
	 * minorder
	 *
	 * @var \float
	 */
	protected $minorder;

	/**
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $image;
	
	/**
	 * @var \array
	 */
	protected $images;

	/**
	 * instock
	 *
	 * @var boolean
	 */
	protected $instock = FALSE;

	/**
	 * featured
	 *
	 * @var boolean
	 */
	protected $featured = FALSE;

	/**
	 * related
	 *
	 * @var  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Product>
	 */
	protected $related;
	
	/**
	 * Initialize
	 */
	public function initializeObject() {
		$this->initStorageObjects();
	}
	
	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->related = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}
	
	/**
	 * Return the category
	 * @return \Arm\T3sixshop\Domain\Model\Category
	 */
	public function getCategory() {
		return $this->category;
	}
	
	/**
	 * Sets the category
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Category $category
	 * @return void
	 */
	public function setCategory(\Arm\T3sixshop\Domain\Model\Category $category) {
		$this->category = $category;
	}
	
	/**
	 * Return the manufacturer
	 * @return \Arm\T3sixshop\Domain\Model\Manufacturer
	 */
	public function getManufacturer() {
		return $this->manufacturer;
	}
	
	/**
	 * Sets the manufacturer
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Manufacturer $manufacturer
	 * @return void
	 */
	public function setManufacturer(\Arm\T3sixshop\Domain\Model\Manufacturer $manufacturer) {
		$this->manufacturer = $manufacturer;
	}
	
	/**
	 * Return the shorttext
	 * @return \string
	 */
	public function getShorttext() {
		return $this->shorttext;
	}
	
	/**
	 * Sets the shorttext
	 *
	 * @param \string $shorttext
	 * @return void
	 */
	public function setShorttext($shorttext) {
		$this->shorttext = $shorttext;
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
	 * Returns the description
	 *
	 * @return \string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
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
	 * Returns the unit
	 *
	 * @return \string $unit
	 */
	public function getUnit() {
		return $this->unit;
	}
	
	/**
	 * Sets the unit
	 *
	 * @param \string $unit
	 * @return void
	 */
	public function setUnit($unit) {
		$this->unit = $unit;
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
	 * Returns the current price
	 *
	 * @return \float $currentprice
	 */
	public function getCurrentprice() {
		//Calculate the discount
		$this->setCurrentprice();
		return $this->currentprice;
	}
	
	/**
	 * Sets the current price
	 *
	 * @return void
	 */
	public function setCurrentprice() {
		$this->currentprice = ($this->price - $this->discount);
	}
	
	/**
	 * Returns the minorder
	 *
	 * @return \float $minorder
	 */
	public function getMinorder() {
		return $this->minorder;
	}
	
	/**
	 * Sets the minorder
	 *
	 * @param \float $minorder
	 * @return void
	 */
	public function setMinorder($minorder) {
		$this->minorder = $minorder;
	}
	
	/**
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getImage() {
		
		if ($this->image instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->image->_loadRealInstance();
		}
		return $this->image->getOriginalResource();
	}
	
	/**
	 * 
	 * @return \array
	 */
	public function getImages() {
		//reset the array
		$this->images = array();
		
		$fileReferences = $this->falRepository->findByRelation('tx_t3sixshop_domain_model_product', 'image', $this->getUid());

		//populate the array
		foreach ($fileReferences as $file) {
			$this->images[] = $file;
		}
		return $this->images;
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @return void
	 */
	public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->image = $image;
	}

	/**
	 * Returns the instock
	 *
	 * @return boolean $instock
	 */
	public function getInstock() {
		return $this->instock;
	}

	/**
	 * Sets the instock
	 *
	 * @param boolean $instock
	 * @return void
	 */
	public function setInstock($instock) {
		$this->instock = $instock;
	}

	/**
	 * Returns the boolean state of instock
	 *
	 * @return boolean
	 */
	public function isInstock() {
		return $this->getInstock();
	}

	/**
	 * Returns the featured
	 *
	 * @return boolean $featured
	 */
	public function getFeatured() {
		return $this->featured;
	}

	/**
	 * Sets the featured
	 *
	 * @param boolean $featured
	 * @return void
	 */
	public function setFeatured($featured) {
		$this->featured = $featured;
	}

	/**
	 * Returns the boolean state of featured
	 *
	 * @return boolean
	 */
	public function isFeatured() {
		return $this->getFeatured();
	}
	
	
	/**
	 * Adds a Product
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 * @return void
	 */
	public function addRelated(\Arm\T3sixshop\Domain\Model\Product $product) {
		$this->related->attach($product);
	}
	
	/**
	 * Removes a Product
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 * @return void
	 */
	public function removeRelated(\Arm\T3sixshop\Domain\Model\Product $product) {
		$this->related->detach($product);
	}

	/**
	 * Returns the related
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Product> $related
	 */
	public function getRelated() {
		return $this->related;
	}

	/**
	 * Sets the related
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Arm\T3sixshop\Domain\Model\Product> $related
	 * @return void
	 */
	public function setRelated(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $related) {
		$this->related = $related;
	}

}
?>