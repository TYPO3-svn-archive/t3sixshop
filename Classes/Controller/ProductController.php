<?php
namespace Arm\T3sixshop\Controller;

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
class ProductController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * productRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\ProductRepository
	 * @inject
	 */
	protected $productRepository;
	
	/**
	 * 
	 * @var \ARM\T3sixshop\Domain\Repository\CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;
	
	/**
	 * 
	 * @var \ARM\T3sixshop\Domain\Model\Category
	 */
	protected $category;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		//set the category
		if (isset($this->settings['category'])) {
			$catUid = intval($this->settings['category']);
		}
		
		//For jScroll
		if ($this->request->hasArgument('category')) {
			$catUid = intval($this->request->getArgument('category'));
		}
		if($catUid > 0) {
			$this->category = $this->categoryRepository->findByUid($catUid);
		}
		

		/*
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('type') == 99) {
			//This is ajax request for jScroll, redirect to jscroll
			$this->forward('jscroll');
		}
		*/
		
		if ($this->settings['feature'] == 1) {
			$products = $this->productRepository->findByFeatured($this->settings['feature_limit']);
		}
		else {
			//Assign code level JS
			if ($this->settings['jScroll'] == 1) {
				$armJsFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('t3sixshop') . 'Resources/Public/Js/jquery.armjscroll.js';
				$linkJs = '<script type="text/javascript" src="' . htmlspecialchars($armJsFile) . '"></script>';
				$this->response->addAdditionalHeaderData($linkJs);
			}
			if (($this->category instanceof \ARM\T3sixshop\Domain\Model\Category) && isset($this->category)) {
				$products = $this->productRepository->findByCategory($this->category);
			}
			else {
				$products = $this->productRepository->findAll();
			}
		}
		
		$this->view->assign('category', $catUid);
		$this->view->assign('products', $products);
	}

	/**
	 * AJAX action
	 */
	public function jscrollAction() {
		//set the category
		if (isset($this->settings['category'])) {
			$catUid = intval($this->settings['category']);
			
		}
		
		//For jScroll
		if ($this->request->hasArgument('category')) {
			$catUid = intval($this->request->getArgument('category'));
		}
		
		if($catUid > 0) {
			$this->category = $this->categoryRepository->findByUid($catUid);
		}
		
		if (($this->category instanceof \ARM\T3sixshop\Domain\Model\Category) && isset($this->category)) {
			$products = $this->productRepository->findByCategory($this->category);
		}
		else {
			$products = $this->productRepository->findAll();
		}
		$this->view->assign('category', $catUid);
		$this->view->assign('products', $products);
	}
	
	/**
	 * action show
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 * @return void
	 */
	public function showAction(\Arm\T3sixshop\Domain\Model\Product $product) {
		
		//Add valdate js file
		$linkVal = '<script type="text/javascript">
					$(document).ready(function(){
						$.validator.addMethod("quantity_greater_minorder", function() {
							var qty = parseFloat($("#quantity").val());
						   return  qty >= $("#minorder").val()
						}, "* Quantity should be greater than " + $("#minorder").val());
						$.validator.addClassRules({
							requiredMinorder: {required:true, number:true, quantity_greater_minorder:true}
						});
						$("#orderFrm").validate();
					});
				</script>
				';
		$this->response->addAdditionalHeaderData($linkVal);
		
		if ($this->request->hasArgument('quantity')) {
			$qty = (integer) $this->request->getArgument('quantity');
			$this->view->assign('qty', $qty);
		}
		$this->view->assign('product', $product);
	}
	
	/**
	 * 
	 */
	public function rateAction() {
		$products = $this->productRepository->findByInstock(1);
		$this->view->assign('products', $products);
	}

}
?>