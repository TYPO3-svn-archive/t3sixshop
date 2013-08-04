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
class OrderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	const intNextDay = 1;
	
	const intWeek = 2;
	
	/**
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;
	
	/**
	 * productRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\ProductRepository
	 * @inject
	 */
	protected $productRepository;
	
	/**
	 * cartRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\CartRepository
	 * @inject
	 */
	protected $cartRepository;
	
	/**
	 * cartitemRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\CartitemRepository
	 * @inject
	 */
	protected $cartitemRepository;
	
	/**
	 * couponRepository
	 * 
	 * @var \ARM\T3sixshop\Domain\Repository\CouponRepository
	 * @inject
	 */
	protected $couponRepository;
	
	/**
	 * deliveryoptionRepository
	 * 
	 * @var \ARM\T3sixshop\Domain\Repository\DeliveryoptionRepository
	 * @inject
	 */
	protected $deliveryoptionRepository;
	
	/**
	 * orderRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\OrderRepository
	 * @inject
	 */
	protected $orderRepository;
	
	/**
	 * itemRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\OrderitemRepository
	 * @inject
	 */
	protected $orderitemRepository;
	
	/**
	 * customerRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\CustomerRepository
	 * @inject
	 */
	protected $customerRepository;
	
	/**
	 * 
	 * @var \float
	 */
	private $minOrderValue;
	
	/**
	 * This action is called every time any action is called
	 */
	public function initializeAction() {
		
		session_start();
		
		//Check whether logged in user and update the order
		$cartId = $GLOBALS["TSFE"]->fe_user->getKey("ses", "cart");
		$this->minOrderValue = $this->settings['minOrderAmt'];
		
		if ($GLOBALS['TSFE']->fe_user->user['uid'] != '' && $cartId != '') {
			
			$cart = $this->cartRepository->findByUid(intval($cartId));
			
			if ($cart instanceof \Arm\T3sixshop\Domain\Model\Cart) {
				
				if ($cart->getFname() == '' || $cart->getAddress() == '' || $cart->getPhone()=='') {
				
					$cart->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
					$cart->setFname($GLOBALS['TSFE']->fe_user->user['first_name']);
					$cart->setLname($GLOBALS['TSFE']->fe_user->user['last_name']);
					$cart->setEmail($GLOBALS['TSFE']->fe_user->user['email']);
					$cart->setApartment($GLOBALS['TSFE']->fe_user->user['apartment']);
					$cart->setAddress($GLOBALS['TSFE']->fe_user->user['address']);
					$cart->setPhone($GLOBALS['TSFE']->fe_user->user['telephone']);
					$cart->setZip($GLOBALS['TSFE']->fe_user->user['zip']);
					
					$this->cartRepository->update($cart);
				} 
			}	
		}
	}
	
	/**
	 * List orders of a customer
	 */
	public function mylistAction() {
		
		if ($GLOBALS['TSFE']->fe_user->user['uid'] != '') {
			//Find all the orders of this customer
			$orders = $this->orderRepository->findByUser($GLOBALS['TSFE']->fe_user->user['uid']);
			$this->view->assign('orders', $orders);
		}
	}
	
	/**
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Order $orders
	 */
	public function showAction(\Arm\T3sixshop\Domain\Model\Order $orders) {
		
	}

	/**
	 * Track the status of order
	 */
	public function trackAction() {
		//Check whether requested
		if ($this->request->hasArgument('orderid')) {
			
			$orderId = strip_tags($this->request->getArgument('orderid'));
			
			if ('' != trim($orderId)) {
				$order = $this->orderRepository->findOneByOrderid($orderId);
				
				if ($order instanceof \Arm\T3sixshop\Domain\Model\Order) {
					$this->view->assign('order', $order);
				}
				else {
					$this->controllerContext->getFlashMessageQueue()->addMessage(
							new \TYPO3\CMS\Core\Messaging\FlashMessage(
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_order.invalid_orderid','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
							)
					);
				}
			}
		}
	}
	
	/**
	 * Confirm form
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @validate
	 */
	public function confirmAction(\Arm\T3sixshop\Domain\Model\Cart $cart) {
		
		if ($this->request->hasArgument('deliveryoption')) {
			$deliveryUid = (integer)$this->request->getArgument('deliveryoption');
			$deliveryoption = $this->deliveryoptionRepository->findByUid($deliveryUid);
		}
		
		if ($this->request->hasArgument('shipping')) {
			$shipping = $this->request->getArgument('shipping');
		}
		
		if ($this->request->hasArgument('coupon')) {
			$couponUid = (integer)$this->request->getArgument('coupon');
			$coupon = $this->couponRepository->findByUid($couponUid);
		}
		
		if ($this->request->hasArgument('discount')) {
			$discount = $this->request->getArgument('discount');
		}
	
		
		$this->processOrder($cart, $deliveryoption, $shipping, $coupon, $discount);
		
		if ($GLOBALS['TSFE']->fe_user->user['uid'] == '') {
			
			if($this->request->hasArgument('registerme')) {
				
				if ($this->request->getArgument('registerme') == "1") {
					//Process for registration
					$registerPid = $this->settings['registerPid'];
					
					$arguments = array(
							'FE' => array(
									'fe_users' => array(
												'first_name' => $cart->getFname(),
												'last_name' => $cart->getLname(),
												'email' => $cart->getEmail(),
												'address' => $cart->getAddress(),
												'telephone' => $cart->getPhone(),
												'zip' => $cart->getZip(),
												'apartment' => $cart->getApartment()
											)
									)
							);
					
					if ($registerPid != '') {
						$link = $this->uriBuilder->setArguments($arguments)->setTargetPageUid($registerPid)->setNoCache(true)->build();
						$this->redirectToUri($link);
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @param \Arm\T3sixshop\Domain\Model\Deliveryoption $deliveryoption
	 * @param \float $shipping
	 * @param \Arm\T3sixshop\Domain\Model\Coupon $coupon
	 * @param \float $discount
	 */
	protected function processOrder(\Arm\T3sixshop\Domain\Model\Cart $cart, \Arm\T3sixshop\Domain\Model\Deliveryoption $deliveryoption = NULL, $shipping = NULL, \Arm\T3sixshop\Domain\Model\Coupon $coupon = NULL, $discount = NULL) {
		//Store the order
		$cart->setStatus(1);
		$this->cartRepository->update($cart);
		
		//Now new logic to create order and also separate order based on separate invoice
		$categories = array();
		
		$itemNormal = array();
		
		//Get the items from cart
		$cartItems = $cart->getCartitems();
		$this->createOrder($cart,$cartItems,$deliveryoption,$shipping,$coupon,$discount);
		
		//destroy the session
		$GLOBALS["TSFE"]->fe_user->setKey("ses", "session_id", NULL);
		$GLOBALS["TSFE"]->fe_user->setKey("ses","cart", NULL);
		$GLOBALS["TSFE"]->fe_user->sesData_change = true;
		$GLOBALS["TSFE"]->fe_user->storeSessionData();
	}
	
	/**
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @param \array $items
	 * @param \Arm\T3sixshop\Domain\Model\Deliveryoption $deliveryoption
	 * @param \float $shipping
	 * @param \Arm\T3sixshop\Domain\Model\Coupon $coupon
	 * @param \float $discount
	 */
	private function createOrder(\Arm\T3sixshop\Domain\Model\Cart $cart, $items, \Arm\T3sixshop\Domain\Model\Deliveryoption $deliveryoption = NULL, $shipping = NULL, \Arm\T3sixshop\Domain\Model\Coupon $coupon = NULL, $discount = NULL) {
		
		//Create persistence manager
		$persistanceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		
		//create the order object
		$order =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Order');
		$order->setUser($cart->getUser());
		$order->setSession($cart->getSession());
		$order->setFname($cart->getFname());
		$order->setLname($cart->getLname());
		$order->setEmail($cart->getEmail());
		$order->setApartment($cart->getApartment());
		$order->setAddress($cart->getAddress());
		$order->setPhone($cart->getPhone());
		$order->setZip($cart->getZip());
		$order->setStatus(1);
		
		if ($deliveryoption instanceof \Arm\T3sixshop\Domain\Model\Deliveryoption) {
			$order->setDeliveryoption($deliveryoption);
		}
		
		if(isset($shipping)) {
			$order->setShipping($shipping);
		}
		
		if($coupon instanceof \Arm\T3sixshop\Domain\Model\Coupon) {
			$order->setCoupon($coupon);
		}
		if(isset($discount)) {
			$order->setDiscount($discount);
		}
		
		$this->orderRepository->add($order);
		//this will immediately save to DB and uid will be generated
		$persistanceManager->persistAll();
		//get the uid
		$orderId = $order->getUid();
		$genId = $this->generateOrderid($orderId);
		$order->setOrderid($genId);
		
		$orderAmount = 0;
		
		//Create the items
		foreach ($items as $item) {
			
			$orderitem =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Orderitem');
			$orderitem->setProduct($item->getProduct());
			$orderitem->setName($item->getName());
			$orderitem->setQty($item->getQty());
			$orderitem->setRate($item->getRate());
			$orderitem->setAmount($item->getAmount());
			$orderitem->setUnit($item->getUnit());
			$orderitem->setOrders($order);
			$this->orderitemRepository->add($orderitem);
			
			//update for orders
			$orderAmount += $item->getAmount();
			$order->addOrderitem($orderitem);
			$persistanceManager->persistAll();
		}
		
		$order->setAmount($orderAmount);
		$totalAmount = $orderAmount;
		
		if (isset($shipping)) {
			$totalAmount += $shipping;
		}
		
		if (isset($discount)) {
			$totalAmount -= $discount;
		}
		//Set the totalamount
		$order->setTotalamount($totalAmount);
		
		//update the user repository
		if ($GLOBALS['TSFE']->fe_user->user['uid']) {
			//Create the customer
			$customer = $this->customerRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
			if ($customer instanceof \Arm\T3sixshop\Domain\Model\Customer) {
				$customer->addOrder($order);
				$this->customerRepository->update($customer);
			}
		}
		
		$this->orderRepository->update($order);
		$persistanceManager->persistAll();
		
		//Create the PDF
		$pdf = $this->generatePdf($order);
		
		//Email template
		$template = 'Order';
		
		//Email sender
		$sender = array(
				$this->settings['senderEmail'] => $this->settings['senderEmailName']
		);
		//Email recipient
		$recipient = array(
				$this->settings['orderEmail'] => $this->settings['orderEmailName']
		);
		//CC email to user
		$cc = array(
				$order->getEmail() => $order->getFname().' '.$order->getLname()
		);
			
		$subject = 'Order ['. $order->getOrderid().'] placed at newtownhomedelivery.com';
			

		$emailArr['fname'] = $order->getFname();
		$emailArr['lname'] = $order->getLname();
		$emailArr['email'] = $order->getEmail();
		$emailArr['phone'] = $order->getPhone();
		$emailArr['address'] = $order->getAddress();
		$emailArr['zip'] = $order->getZip();
		$emailArr['apartment'] = $order->getApartment();
		$emailArr['orderid'] = $order->getOrderid();
		$emailArr['amount'] = sprintf("%.02f", $order->getAmount());
		$emailArr['delivery'] = $order->getDeliveryoption()->getName();
		$emailArr['shipping'] = sprintf("%.02f", $order->getShipping());
		$emailArr['discount'] = sprintf("%.02f", $order->getDiscount());
		$emailArr['netamount'] = sprintf("%.02f", $order->getTotalamount());
		
		//Send Email
		if(!$this->sendTemplateEmail($recipient, $sender, $subject, $template, $cc, $emailArr, $pdf, 'order-'.$order->getUid().'.pdf')) {
			die('Failed to send order email!');
		}
	}
	
	/**
	 * Get the expected delivery date
	 * 
	 * @param \string
	 * @return \string
	 */
	private function getDeliveryDate($mode='W') {
		
		if ($mode == 'W') {
			$today = date('w');
			if ($today == 6) {
				return date("j-m-Y", strtotime("+1 day"));
			}
			else{
				return date("j-m-Y", strtotime("next Saturday"));
			}
		}
		
		if($mode == 'N') {
			return date("j-m-Y", strtotime("+1 day"));
		}
	}
	
	/**
	 * Checkout form
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @validate
	 */
	public function formAction(\Arm\T3sixshop\Domain\Model\Cart $cart) {
		
		if ($cart->getAmount() >= (integer) $this->settings['minOrderAmt']) {
			//Add validate js file
			$valFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('t3sixshop') . 'Resources/Public/Js/jquery.validate.pack.js';
			$linkVal = '<script type="text/javascript" src="' . htmlspecialchars($valFile) . '"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#checkoutFrm").validate();
						$("#loginFrm").validate();
					});
				</script>
				';
			$this->response->addAdditionalHeaderData($linkVal);
			//Check if fe-user logged in
			if ($GLOBALS['TSFE']->fe_user->user['uid']) {
				$user = $this->customerRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
				
				if ($user instanceof \Arm\T3sixshop\Domain\Model\Customer) {
					$this->view->assign('user', $user);
				}
			}
			if ($this->request->hasArgument('coupon')) {
				$coupon = (string)$this->request->getArgument('coupon');
				$this->view->assign('coupon', $coupon);
			}
			
			if ($this->request->hasArgument('deliveryoption')) {
				$deliveryUid = (integer)$this->request->getArgument('deliveryoption');
				$this->view->assign('delivery', $deliveryUid);
			}
			//deliveryoption
			$deliveryoption = $this->deliveryoptionRepository->findAll();
			$this->view->assign('deliveryoption', $deliveryoption);
			$this->view->assign('cart', $cart);
		}
		else {
			$this->redirect("list");
		}
	}
	
	/**
	 * Checkout form
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @validate
	 */
	public function preconfirmAction(\Arm\T3sixshop\Domain\Model\Cart $cart) {
		
		$cartAmount = $cart->getAmount();
		$this->cartRepository->update($cart);
		
		if ($this->request->hasArgument('registerme')) {
			$this->view->assign('registerme', $this->request->getArgument('registerme'));			
		}
		
		if ($this->request->hasArgument('loginBtn')) {
				
			$loginData['uname'] =  $this->request->getArgument('username');
			$loginData['uident'] =  $this->request->getArgument('password');
			$loginData['status'] =  'login';
				
			$GLOBALS['TSFE']->fe_user->checkPid=0;
			$info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
			$user = $GLOBALS['TSFE']->fe_user->fetchUserRecord($info['db_user'] ,$loginData['uname']);
				
			$validPass = FALSE;
				
			if (\t3lib_extMgm::isLoaded('saltedpasswords')) {
		
				if (\TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility::isUsageEnabled('FE')) {
					$md5Salt = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Saltedpasswords\Salt\Md5Salt');
					$validPass = $md5Salt->checkPassword($loginData['uident'], $user['password']);
				}
			}
			else {
				$validPass = ($user['password'] == $loginData['uident']);
			}
				
			if ($validPass) {
		
				$GLOBALS['TSFE']->fe_user->createUserSession($user);
				//Set the information in the orders
				$cart->setUser($user['uid']);
				$cart->setFname($user['first_name']);
				$cart->setLname($user['last_name']);
				$cart->setEmail($user['email']);
				$cart->setApartment($user['apartment']);
				$cart->setAddress($user['address']);
				$cart->setPhone($user['telephone']);
				$cart->setZip($user['zip']);
				$this->view->assign('user', $user);
			}
			else {
				$this->controllerContext->getFlashMessageQueue()->addMessage(
						new \TYPO3\CMS\Core\Messaging\FlashMessage(
								\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_customer.login_failed','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
						)
				);
			}
		}
		
		
		if ($this->request->hasArgument('deliveryoption')) {
			
			$deliveryUid = (integer)$this->request->getArgument('deliveryoption');
			$deliveryoption = $this->deliveryoptionRepository->findByUid($deliveryUid);
			
			if ($deliveryoption instanceof \Arm\T3sixshop\Domain\Model\Deliveryoption) {
				
				$this->view->assign('deliveryoption', $deliveryoption);
				$freeAmount = $deliveryoption->getFreeprice();
				
				if ($freeAmount > 0) {
					
					if ($cart->getAmount() >= $freeAmount) {
						$shipping = 0;
					}
					else {
						$shipping = $deliveryoption->getPrice();
					}
				}
				$cartAmount += $shipping;
			}
		}
	
		//Check for coupon
		if ($this->request->hasArgument('coupon')) {
			
			$couponCode = (string)$this->request->getArgument('coupon');
			$this->view->assign('couponcode', $couponCode);
			//find the coupon
			$coupon = $this->couponRepository->findOneByCode($couponCode);
			
			if ($coupon instanceof \Arm\T3sixshop\Domain\Model\Coupon) {
				
				$discount = $this->getDiscount($cart, $coupon);
				$this->view->assign('discount', $discount);
				$this->view->assign('coupon', $coupon);
				$cartAmount -= $discount;
			}
			else {
				$this->controllerContext->getFlashMessageQueue()->addMessage(
						new \TYPO3\CMS\Core\Messaging\FlashMessage(
								\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_order.couponinvalid','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
						)
				);	
			}
		}
		
		if ($cart->getAmount() >= (integer) $this->settings['minOrderAmt']) {
			$this->view->assign('shipping', $shipping);
			$this->view->assign('cart', $cart);
			$this->view->assign('calcAmount', $cartAmount);
		}
		else {
			$this->redirect("list");
		}
	}
	
	/**
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @param \Arm\T3sixshop\Domain\Model\Coupon $coupon
	 * @return \float
	 */
	private function getDiscount(\Arm\T3sixshop\Domain\Model\Cart $cart, \Arm\T3sixshop\Domain\Model\Coupon $coupon) {
		
		$usage = $coupon->getCuse();
		
		if ($usage == 'O') {

			$cpnCnt = $this->orderRepository->findByCoupon($coupon);
			
			if (count($cpnCnt) == 0) {
				
				if ($coupon->getDtype() == 'P') {
					
					$percent = $coupon->getDiscount();
					$amount = $cart->getAmount();
					$discount = ($amount * $percent / 100);
					return $discount;
				}
				else {
					
					$discount = $coupon->getDiscount();
					$amount = $cart->getAmount();
					
					if ($discount < $amount) {
						return $discount;
					}
					else {
						return $amount;
					}
				}
			}
			else {
				$this->controllerContext->getFlashMessageQueue()->addMessage(
						new \TYPO3\CMS\Core\Messaging\FlashMessage(
								\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_order.couponused','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
						)
				);
					
				return 0.00;
			}
		}
		else {
			if ($coupon->getDtype() == 'P') {
				
				$percent = $coupon->getDiscount();
				$amount = $cart->getAmount();
				$discount = ($amount * $percent / 100);
				return $discount;
			}
			else {
				
				$discount = $coupon->getDiscount();
				$amount = $cart->getAmount();
				
				if ($discount < $amount) {
					return $discount;
				}
				else {
					return $amount;
				}
			}
		}
	}
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		$session_id = $GLOBALS["TSFE"]->fe_user->getKey("ses", "session_id");
		$cartId = (integer)$GLOBALS["TSFE"]->fe_user->getKey("ses", "cart");
		//Get the order of this session
		if (!empty($session_id) && !empty($cartId)) {
			
			$cart = $this->cartRepository->findByUid($cartId);
			
			if ($cart instanceof \Arm\T3sixshop\Domain\Model\Cart) {
				//Get all the order items
				$cartitems = $this->cartitemRepository->findByCart($cart);
				
				if (count($cartitems) == 0) {
					//set the order to zero
					$cart->setAmount(0);
					$this->cartRepository->update($cart);
				}
				else {
					foreach ($cartitems as $item) {
						if($item instanceof \Arm\T3sixshop\Domain\Model\Cartitem) {
							$itemcategory = $item->getProduct()->getCategory();
							if ($itemcategory instanceof \Arm\T3sixshop\Domain\Model\Category) {
								if ($this->minOrderValue < $itemcategory->getMinorderval()) {
									$this->minOrderValue = $itemcategory->getMinorderval();
								}
							}
						}
					}
				}
				$this->view->assign('cart', $cart);
				$this->view->assign('cartitems', $cartitems);
				$this->view->assign('minordervalue', $this->minOrderValue);
				if ($this->request->hasArgument('category')) {
					$category = $this->request->getArgument('category');
				}
				$this->view->assign('category', $category);
			}
		}
	}

	/**
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 */
	public function updateAction(\Arm\T3sixshop\Domain\Model\Product $product) {
		//Check set session, allow for non logged user
		$session_id = $GLOBALS["TSFE"]->fe_user->getKey("ses", "session_id");
		$cartId = $GLOBALS["TSFE"]->fe_user->getKey("ses", "cart");
		$category = $product->getCategory();
		
		if (empty($session_id)) {
			$GLOBALS['TSFE']->fe_user->start();
			$GLOBALS['TSFE']->fe_user->checkPid = 0;
			$session_id = md5(time());
			$GLOBALS["TSFE"]->fe_user->setKey("ses","session_id", $session_id);
		}
		
		if ($this->request->hasArgument('quantity') && ($product instanceof \Arm\T3sixshop\Domain\Model\Product)) {
			
			$qty = $this->request->getArgument('quantity');
			$rate = $product->getCurrentprice();
			$amt = $qty * $rate;
			
			//Check whether any order is present in the session
			if ($cartId) {
				$cart = $this->cartRepository->findByUid($cartId);
			}
			
			if (!($cart instanceof \Arm\T3sixshop\Domain\Model\Cart)) { 
				//new order
				//Create persistence manager
				$persistanceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
					
				$cart = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Cart');
				
				if ($GLOBALS['TSFE']->fe_user->user['uid']) {
					
					$cart->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
					//do not use the md5 session but typo3 session
					$session_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
					$cart->setFname($GLOBALS['TSFE']->fe_user->user['first_name']);
					$cart->setLname($GLOBALS['TSFE']->fe_user->user['last_name']);
					$cart->setEmail($GLOBALS['TSFE']->fe_user->user['email']);
					$cart->setApartment($GLOBALS['TSFE']->fe_user->user['apartment']);
					$cart->setAddress($GLOBALS['TSFE']->fe_user->user['address']);
					$cart->setPhone($GLOBALS['TSFE']->fe_user->user['telephone']);
					$cart->setZip($GLOBALS['TSFE']->fe_user->user['zip']);
				}
				
				//Check for duplicate session
				$dupObj = $this->cartRepository->findBySession($session_id);
				
				if (!empty($dupObj)) {
					//duplicate, regenerate the session
					$session_id = md5(time());
				}
				//Check for empty session
				$GLOBALS["TSFE"]->fe_user->setKey("ses","session_id", $session_id);
				$cart->setSession($session_id);
				
				$this->cartRepository->add($cart);
				//this will immediately save to DB and uid will be generated
				$persistanceManager->persistAll(); 
				//get the uid
				$cartId = $cart->getUid();
				//Store the order is to session
				$GLOBALS["TSFE"]->fe_user->setKey("ses", "cart", $cartId);
				
				//$genId = $this->generateOrderid($orderId);
				//$order->setOrderid($genId);
				
				//Add to the order item
				$cartItem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Cartitem');
				$cartItem->setCart($cart);
				$cartItem->setProduct($product);
				$cartItem->setName($product->getName());
				$cartItem->setQty($qty);
				$cartItem->setRate($rate);
				$cartItem->setAmount($amt);
				$cartItem->setUnit($product->getUnit());
				
				$this->cartitemRepository->add($cartItem);
				$cart->addCartitem($cartItem);
				$cart->setAmount($amt);
				$persistanceManager->persistAll();
				
				$this->controllerContext->getFlashMessageQueue()->addMessage(
						new \TYPO3\CMS\Core\Messaging\FlashMessage(
								\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_added','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
						)
				);
				
			}
			else {
				
				//Check whether this order has the product
				$dbCartitem = $this->cartitemRepository->findByCartProduct($cart,$product);
				
				if ($dbCartitem instanceof \Arm\T3sixshop\Domain\Model\Cartitem) {
					
					//matching item with same product
					$existQty = $dbCartitem->getQty();
					//Check for quantity
					if ($existQty != $qty) {
						//Need to update
						$existAmt = $dbCartitem->getAmount();
						$diffAmt = $amt - $existAmt;
						$dbCartitem->setAmount($amt);
						$dbCartitem->setQty($qty);
						$this->cartitemRepository->update($dbCartitem);
						
						//update the order
						$currentCartAmt = $cart->getAmount();
						$updatedCartAmt = $currentCartAmt + $diffAmt;
						$cart->setAmount($updatedCartAmt);
						$this->cartRepository->update($cart);
						
						$this->controllerContext->getFlashMessageQueue()->addMessage(
								new \TYPO3\CMS\Core\Messaging\FlashMessage(
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_updated','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
								)
						);
							
					}
					else {
						$this->controllerContext->getFlashMessageQueue()->addMessage(
								new \TYPO3\CMS\Core\Messaging\FlashMessage(
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.same_product_qty','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
								)
						);
					}
				}
				else {
					//Add to the order item
					$cartItem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Cartitem');
					$cartItem->setCart($cart);
					$cartItem->setName($product->getName());
					$cartItem->setProduct($product);
					$cartItem->setQty($qty);
					$cartItem->setRate($rate);
					$cartItem->setAmount($amt);
					$cartItem->setUnit($product->getUnit());
					$this->cartitemRepository->add($cartItem);
					
					//Update Cart
					$cart->addCartitem($cartItem);
					$currentCartAmt = $cart->getAmount();
					$updatedCartAmt = $currentCartAmt + $amt;
					$cart->setAmount($updatedCartAmt);
					$this->cartRepository->update($cart);
					
					$this->controllerContext->getFlashMessageQueue()->addMessage(
							new \TYPO3\CMS\Core\Messaging\FlashMessage(
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_added','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
							)
					);	
				}
			}
		}
		$this->redirect('list', 'Order', 't3sixshop', array('category' => $category));
	}

	/**
	 * @param \Arm\T3sixshop\Domain\Model\Cart $cart
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 */
	public function deleteAction(\Arm\T3sixshop\Domain\Model\Cart $cart, \Arm\T3sixshop\Domain\Model\Product $product) {
		//Check set session, allow for non logged user
		$session_id = $GLOBALS["TSFE"]->fe_user->getKey("ses", "session_id");
	
		if (empty($session_id)) {
			//Redirect with message
			$GLOBALS['TSFE']->fe_user->start();
			$GLOBALS['TSFE']->fe_user->checkPid = 0;
			$session_id = session_id();
			$GLOBALS["TSFE"]->fe_user->setKey("ses","session_id", $session_id);
			
			$this->controllerContext->getFlashMessageQueue()->addMessage(
					new \TYPO3\CMS\Core\Messaging\FlashMessage(
							\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_order.session_expired','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
					)
			);
			$this->redirect('list');
		}
	
		if (($product instanceof \Arm\T3sixshop\Domain\Model\Product) && ($cart instanceof \Arm\T3sixshop\Domain\Model\Cart)) {
				//Check whether this cart has the product
				$dbCartitem = $this->cartitemRepository->findByCartProduct($cart,$product);
	
				if ($dbCartitem instanceof \Arm\T3sixshop\Domain\Model\Cartitem) {
						
					$amt = $dbCartitem->getAmount();
					$currentCartAmt = $cart->getAmount();
					$updatedCartAmt = $currentCartAmt - $amt;
					$cart->setAmount($updatedCartAmt);
					$this->cartRepository->update($cart);
					
					$this->cartitemRepository->remove($dbCartitem);
					
					$this->controllerContext->getFlashMessageQueue()->addMessage(
							new \TYPO3\CMS\Core\Messaging\FlashMessage(
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_remove','t3sixshop'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
							)
					);
					
				}
		}
		$this->redirect('list');
	}
	
	/**
	 * PDF generation
	 *
	 * @param \Arm\T3sixshop\Domain\Model\Order $orders
	 */
	public function generatePdf(\Arm\T3sixshop\Domain\Model\Order $orders) {
		
		\Arm\T3sixshop\Library\Pdf\Pdf::init('P');
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',18,'B');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("        ",80,12,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("INVOICE",50,12,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("        ",65,10,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',14,'B');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("newtownhomedelivery.com",50,10,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',10,'');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Order #: " . $orders->getOrderid(),160,10,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell(date("d.m.Y"),20,10,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',9,'');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("NAME: ",25,6,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($orders->getFname().' '.$orders->getLname(),100,6,0,1);
		
		if (trim($orders->getApartment()) != '') {
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("APARTMENT: ",25,6,0,0);
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($orders->getApartment(),100,6,0,1);
		}
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("ADDRESS: ",25,6,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($orders->getAddress().', '.$orders->getZip(),100,6,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("PHONE: ",25,6,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($orders->getPhone(),100,6,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("EMAIL: ",25,6,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($orders->getEmail(),100,6,0,1);
		
		\Arm\T3sixshop\Library\Pdf\Pdf::$pdf->Ln();
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',8,'B');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Sr. #",15,7,1,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Product",75,7,1,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Rate",30,7,1,0, 'C');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Qty",30,7,1,0,'C');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Amount (Rs.)",30,7,1,1,'C');
		
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',8,'');
		
		$items = $orders->getOrderitems();
		$count = 1;
		
		foreach ($items as $oitem) {
			
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($count++,15,7,0,0,'R');
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($oitem->getName(),75,7,0,0);
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell(sprintf("%.02f", $oitem->getRate()).'/'.$oitem->getUnit(),30,7,0,0, 'C');
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell($oitem->getQty(), 30,7,0,0,'C');
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell(sprintf("%.02f", $oitem->getAmount()),30,7,0,1,'R');
		}
		
		
		//Get the y position
		$y = \Arm\T3sixshop\Library\Pdf\Pdf::$pdf->GetY()+7;
		\Arm\T3sixshop\Library\Pdf\Pdf::drawLine(140,$y,190,$y);
		\Arm\T3sixshop\Library\Pdf\Pdf::$pdf->SetY($y);
		//\Arm\T3sixshop\Library\Pdf\Pdf::$pdf->Ln(10);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("        ",100,7,0,0);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("TOTAL (Rs.)",50,7,0,0, 'R');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell(sprintf("%.02f",$orders->getAmount()),30,7,0,1, 'R');
		//Get the y position
		$y = \Arm\T3sixshop\Library\Pdf\Pdf::$pdf->GetY();
		\Arm\T3sixshop\Library\Pdf\Pdf::drawLine(140,$y,190,$y);
		
		\Arm\T3sixshop\Library\Pdf\Pdf::$pdf->SetY($y+7);
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',8,'');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell('ORDER AMOUNT IN WORDS: '.$this->getAmountInWord($orders->getAmount()),170,5,0,1);
		
		$y = \Arm\T3sixshop\Library\Pdf\Pdf::$pdf->GetY();
		\Arm\T3sixshop\Library\Pdf\Pdf::$pdf->SetY($y+7);
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',7,'');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("* The delivery of this order is FREE!",180,6,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Please pay in cash the exact amount mentioned in the invoice. Thank you, purchase again.",180,5,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("For any clarification, please call ". $GLOBALS['TSFE']->tmpl->setup['page.']['10.']['variables.']['contact_no.']['value'] ." OR send email to ". $this->settings['orderEmail'] .".",180,5,0,1);
		return \Arm\T3sixshop\Library\Pdf\Pdf::generatePDF('order-'.$orders->getUid().'.pdf',FALSE);
	}
	
	/**
	 * 
	 * @param \float $number
	 * @return \string
	 */
	private function getAmountInWord($number) {
		return \Arm\T3sixshop\Library\Converter::getAmountInWords($number);
	}
	/**
	 * Generates the orderId
	 * 
	 * @param \integer $id
	 * @return \string
	 */
	protected function generateOrderid($id) {
		$prefix = strtoupper($this->settings['orderPrefix']);
		$dt = \date("/y/M/");
		$orderId = $prefix . $dt . $id;
		return $orderId;
	}
	
	/**
	 * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
	 * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
	 * @param string $subject subject of the email
	 * @param string $templateName template name (UpperCamelCase)
	 * @param array $cc Cc of the email in the format array('recipient@domain.tld' => 'Recipient Name')
	 * @param array $variables variables to be passed to the Fluid view
	 * @param string $attachments
	 * @param string $filename
	 * @return boolean TRUE on success, otherwise false
	 */
	protected function sendTemplateEmail(array $recipient, array $sender , $subject, $templateName, array $cc = array(), array $variables = array(), $attachments = NULL, $filename=NULL) {
	
		$emailView = $this->objectManager->create('Tx_Fluid_View_StandaloneView');
		$emailView->setFormat('html');
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		$templatePathAndFilename = $templateRootPath . 'Email/' . $templateName . '.html';
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		$emailView->assignMultiple($variables);
		$emailBody = $emailView->render();
		
		// Define mail headers
		$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$message->setTo($recipient)->setSubject($subject);
		$message->setFrom($sender);
		
		if (count($cc) > 0) {
			$message->setCc($cc);
		}

		if (!is_null($attachments)) {
			
			require_once PATH_typo3 . 'contrib/swiftmailer/classes/Swift/Attachment.php';
			require_once PATH_typo3 . 'contrib/swiftmailer/classes/Swift/Mime/Attachment.php';
			require_once PATH_typo3 . 'contrib/swiftmailer/classes/Swift/Mime/SimpleMimeEntity.php';
			$attachment = \Swift_Attachment::newInstance($attachments,$filename,'application/pdf');
			$message->attach($attachment);
		}
		
		// Plain text example
		$message->setBody($emailBody, 'text/plain');
	
		// HTML Email
		#$message->setBody($emailBody, 'text/html');
		$message->send();
		return $message->isSent();
	}
}
?>