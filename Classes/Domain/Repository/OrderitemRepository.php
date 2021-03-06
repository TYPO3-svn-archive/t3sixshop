<?php
namespace Arm\T3sixshop\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *   free software; you can redistribute it and/or modify
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
class OrderitemRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Order $order
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findByOrderProduct(\Arm\T3sixshop\Domain\Model\Order $order, \Arm\T3sixshop\Domain\Model\Product $product) {
		
		//Create the query instance
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->equals('orders', $order);
		$constraints[] = $query->equals('product', $product);
		//Add the constraints in query
		$query->matching(
			$query->logicalAnd($constraints)
		);
		//Return the item
		return $query->execute()->getFirst();
	}
}
?>