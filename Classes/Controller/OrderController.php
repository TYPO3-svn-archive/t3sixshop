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
	
	/**
	 * productRepository
	 *
	 * @var \ARM\T3sixshop\Domain\Repository\ProductRepository
	 * @inject
	 */
	protected $productRepository;
	
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
	 * This action is called every time any action is called
	 */
	public function initializeAction() {
		session_start();
		
		//Check whether logged in user and update the order
		$orderId = $GLOBALS["TSFE"]->fe_user->getKey("ses", "order");

		
		if ($GLOBALS['TSFE']->fe_user->user['uid'] != '' && $orderId != '') {
			
			$orders = $this->orderRepository->findByUid(intval($orderId));
			
			if ($orders instanceof \Arm\T3sixshop\Domain\Model\Order) {
				
				if ($orders->getFname() == '' || $orders->getAddress() == '' || $orders->getPhone()=='') {
				
					$orders->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
					$orders->setFname($GLOBALS['TSFE']->fe_user->user['first_name']);
					$orders->setLname($GLOBALS['TSFE']->fe_user->user['last_name']);
					$orders->setEmail($GLOBALS['TSFE']->fe_user->user['email']);
					$orders->setApartment($GLOBALS['TSFE']->fe_user->user['apartment']);
					$orders->setAddress($GLOBALS['TSFE']->fe_user->user['address']);
					$orders->setPhone($GLOBALS['TSFE']->fe_user->user['telephone']);
					$orders->setZip($GLOBALS['TSFE']->fe_user->user['zip']);
					
					$this->orderRepository->update($orders);
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
					$this->flashMessageContainer->flush();
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_order.invalid_orderid','t3sixshop'));
				}
			}
		}
	}
	
	/**
	 * Confirm form
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Order $orders
	 * @validate
	 */
	public function confirmAction(\Arm\T3sixshop\Domain\Model\Order $orders) {
		
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
				$orders->setUser($user['uid']);
				$orders->setFname($user['first_name']);
				$orders->setLname($user['last_name']);
				$orders->setEmail($user['email']);
				$orders->setApartment($user['apartment']);
				$orders->setAddress($user['address']);
				$orders->setPhone($user['telephone']);
				$orders->setZip($user['zip']);
				
				$this->processOrder($orders);
			}
			else {
				$this->flashMessageContainer->flush();
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_customer.login_failed','t3sixshop'));
				$this->redirect("form","Order","t3sixshop",array('orders' => $orders));
			}
		}
		else {
			
			$this->processOrder($orders);
			
			if ($GLOBALS['TSFE']->fe_user->user['uid'] == '') {
				
				if ($this->request->getArgument('registerme') == "1") {
					//Process for registration
					$registerPid = $this->settings['registerPid'];
					
					$arguments = array(
							'FE' => array(
									'fe_users' => array(
												'first_name' => $orders->getFname(),
												'last_name' => $orders->getLname(),
												'email' => $orders->getEmail(),
												'address' => $orders->getAddress(),
												'telephone' => $orders->getPhone(),
												'zip' => $orders->getZip(),
												'apartment' => $orders->getApartment()
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
	 * @param \Arm\T3sixshop\Domain\Model\Order $orders
	 */
	protected function processOrder(\Arm\T3sixshop\Domain\Model\Order $orders) {
		//Store the order
		$orders->setStatus(1);
		//Set the totalamount
		$orders->setTotalamount($orders->getAmount());
		$this->orderRepository->update($orders);
		
		//update the user repository
		if ($GLOBALS['TSFE']->fe_user->user['uid']) {
			//Create the customer
			$customer = $this->customerRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
			
			if ($customer instanceof \Arm\T3sixshop\Domain\Model\Customer) {
				$customer->addOrder($orders);
				$this->customerRepository->update($customer);
			}
		}
		
		//Create the PDF
		$pdf = $this->generatePdf($orders);

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
			$orders->getEmail() => $orders->getFname().' '.$orders->getLname()
		);
			
		$subject = 'Order ['. $orders->getOrderid().'] placed at newtownhomedelivery.com';
			
			
			
		$emailArr['fname'] = $orders->getFname();
		$emailArr['lname'] = $orders->getLname();
		$emailArr['email'] = $orders->getEmail();
		$emailArr['phone'] = $orders->getPhone();
		$emailArr['address'] = $orders->getAddress();
		$emailArr['zip'] = $orders->getZip();
		$emailArr['apartment'] = $orders->getApartment();
		$emailArr['orderid'] = $orders->getOrderid();
		$emailArr['amount'] = sprintf("%.02f", $orders->getAmount());
		
		//Send Email
		if(!$this->sendTemplateEmail($recipient, $sender, $subject, $template, $cc, $emailArr, $pdf, 'order-'.$orders->getUid().'.pdf')) {
			die('Failed to send order email!');
		}
		//destroy the session
		$GLOBALS["TSFE"]->fe_user->setKey("ses", "session_id", NULL);
		$GLOBALS["TSFE"]->fe_user->setKey("ses","order", NULL);
		$GLOBALS["TSFE"]->fe_user->sesData_change = true;
		$GLOBALS["TSFE"]->fe_user->storeSessionData();
	}
	
	/**
	 * Checkout form
	 * 
	 * @param \Arm\T3sixshop\Domain\Model\Order $orders
	 * @validate
	 */
	public function formAction(\Arm\T3sixshop\Domain\Model\Order $orders) {
		
		if ($orders->getAmount() >= (integer) $this->settings['minOrderAmt']) {
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
			$this->view->assign('orders', $orders);
		}
		else {
			$this->redirect("list");
		}
	}
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		$session_id = $GLOBALS["TSFE"]->fe_user->getKey("ses", "session_id");
		$orderId = (integer)$GLOBALS["TSFE"]->fe_user->getKey("ses", "order");
		//Get the order of this session
		if (!empty($session_id) && !empty($orderId)) {
			
			$orders = $this->orderRepository->findByUid($orderId);
			
			if ($orders instanceof \Arm\T3sixshop\Domain\Model\Order) {
				//Get all the order items
				$orderitems = $this->orderitemRepository->findByOrders($orders);
				
				if (count($orderitems) == 0) {
					//set the order to zero
					$orders->setAmount(0);
					$this->orderRepository->update($orders);
				}
				$this->view->assign('orders', $orders);
				$this->view->assign('orderitems', $orderitems);
			}
		}
	}

	/**
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 */
	public function updateAction(\Arm\T3sixshop\Domain\Model\Product $product) {
		//Check set session, allow for non logged user
		$session_id = $GLOBALS["TSFE"]->fe_user->getKey("ses", "session_id");
		$orderId = $GLOBALS["TSFE"]->fe_user->getKey("ses", "order");
		
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
			if ($orderId) {
				$orderObj = $this->orderRepository->findByUid($orderId);
			}
			
			if (!($orderObj instanceof \Arm\T3sixshop\Domain\Model\Order)) { 
				//new order
				//Create persistence manager
				$persistanceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
					
				$order = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Order');
				
				if ($GLOBALS['TSFE']->fe_user->user['uid']) {
					
					$order->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
					$order->setFname($GLOBALS['TSFE']->fe_user->user['first_name']);
					$order->setLname($GLOBALS['TSFE']->fe_user->user['last_name']);
					$order->setEmail($GLOBALS['TSFE']->fe_user->user['email']);
					$order->setApartment($GLOBALS['TSFE']->fe_user->user['apartment']);
					$order->setAddress($GLOBALS['TSFE']->fe_user->user['address']);
					$order->setPhone($GLOBALS['TSFE']->fe_user->user['telephone']);
					$order->setZip($GLOBALS['TSFE']->fe_user->user['zip']);
					
					//do not use the md5 session but typo3 session
					$session_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
				}
				
				//Check for duplicate session
				$dupObj = $this->orderRepository->findBySession($session_id);
				
				if (!empty($dupObj)) {
					//duplicate, regenerate the session
					$session_id = md5(time());
				}
				//Check for empty session
				$GLOBALS["TSFE"]->fe_user->setKey("ses","session_id", $session_id);
				$order->setSession($session_id);
				
				$this->orderRepository->add($order);
				//this will immediately save to DB and uid will be generated
				$persistanceManager->persistAll(); 
				//get the uid
				$orderId = $order->getUid();
				//Store the order is to session
				$GLOBALS["TSFE"]->fe_user->setKey("ses","order", $orderId);
				
				$genId = $this->generateOrderid($orderId);
				$order->setOrderid($genId);
				
				//Add to the order item
				$orderItem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Orderitem');
				$orderItem->setOrders($order);
				$orderItem->setProduct($product);
				$orderItem->setName($product->getName());
				$orderItem->setQty($qty);
				$orderItem->setRate($rate);
				$orderItem->setAmount($amt);
				$this->orderitemRepository->add($orderItem);
				$order->addOrderitem($orderItem);
				$order->setAmount($amt);
				$persistanceManager->persistAll();
				
				$this->flashMessageContainer->flush();
				$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_added','t3sixshop'));
			}
			else {
				
				//Check whether this order has the product
				$dbOrderitem = $this->orderitemRepository->findByOrderProduct($orderObj,$product);
				
				if ($dbOrderitem instanceof \Arm\T3sixshop\Domain\Model\Orderitem) {
					
					//matching item with same product
					$existQty = $dbOrderitem->getQty();
					//Check for quantity
					if ($existQty != $qty) {
						//Need to update
						$existAmt = $dbOrderitem->getAmount();
						$diffAmt = $amt - $existAmt;
						$dbOrderitem->setAmount($amt);
						$dbOrderitem->setQty($qty);
						$this->orderitemRepository->update($dbOrderitem);
						
						//update the order
						$currentOrderAmt = $orderObj->getAmount();
						$updatedOrderAmt = $currentOrderAmt + $diffAmt;
						$orderObj->setAmount($updatedOrderAmt);
						$this->orderRepository->update($orderObj);
						
						$this->flashMessageContainer->flush();
						$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_updated','t3sixshop'));
							
					}
					else {
						$this->flashMessageContainer->flush();
						$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.same_product_qty','t3sixshop'));
					}
				}
				else {
					//Add to the order item
					$orderItem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Arm\\T3sixshop\\Domain\\Model\\Orderitem');
					$orderItem->setOrders($orderObj);
					$orderItem->setName($product->getName());
					$orderItem->setProduct($product);
					$orderItem->setQty($qty);
					$orderItem->setRate($rate);
					$orderItem->setAmount($amt);
					$this->orderitemRepository->add($orderItem);
					
					//Update Order
					$orderObj->addOrderitem($orderItem);
					$currentOrderAmt = $orderObj->getAmount();
					$updatedOrderAmt = $currentOrderAmt + $amt;
					$orderObj->setAmount($updatedOrderAmt);
					$this->orderRepository->update($orderObj);
					
					$this->flashMessageContainer->flush();
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_added','t3sixshop'));
						
				}
			}
		}
		$this->redirect('list');
	}

	/**
	 * @param \Arm\T3sixshop\Domain\Model\Order $orders
	 * @param \Arm\T3sixshop\Domain\Model\Product $product
	 */
	public function deleteAction(\Arm\T3sixshop\Domain\Model\Order $orders, \Arm\T3sixshop\Domain\Model\Product $product) {
		//Check set session, allow for non logged user
		$session_id = $GLOBALS["TSFE"]->fe_user->getKey("ses", "session_id");
	
		if (empty($session_id)) {
			//Redirect with message
			$GLOBALS['TSFE']->fe_user->start();
			$GLOBALS['TSFE']->fe_user->checkPid = 0;
			$session_id = session_id();
			$GLOBALS["TSFE"]->fe_user->setKey("ses","session_id", $session_id);
			
			$this->flashMessageContainer->flush();
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_order.session_expired','t3sixshop'));
			$this->redirect('list');
		}
	
		if (($product instanceof \Arm\T3sixshop\Domain\Model\Product) && ($orders instanceof \Arm\T3sixshop\Domain\Model\Order)) {
				//Check whether this order has the product
				$dbOrderitem = $this->orderitemRepository->findByOrderProduct($orders,$product);
	
				if ($dbOrderitem instanceof \Arm\T3sixshop\Domain\Model\Orderitem) {
						
					$amt = $dbOrderitem->getAmount();
					$currentOrderAmt = $orders->getAmount();
					$updatedOrderAmt = $currentOrderAmt - $amt;
					$orders->setAmount($updatedOrderAmt);
					$this->orderRepository->update($orders);
					
					$this->orderitemRepository->remove($dbOrderitem);
					$this->flashMessageContainer->flush();
					$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3sixshop_domain_model_orderitem.product_remove','t3sixshop'));	
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
			\Arm\T3sixshop\Library\Pdf\Pdf::writeCell(sprintf("%.02f", $oitem->getRate()),30,7,0,0, 'C');
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
		
		\Arm\T3sixshop\Library\Pdf\Pdf::$pdf->SetY($y+10);
		\Arm\T3sixshop\Library\Pdf\Pdf::setFont('helvetica',7,'');
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("* The delivery of this order is FREE!",80,5,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("Please pay in cash the exact amount mentioned in the invoice. Thank you, purchase again.",180,5,0,1);
		\Arm\T3sixshop\Library\Pdf\Pdf::writeCell("For any clarification, please call ". $GLOBALS['TSFE']->tmpl->setup['page.']['10.']['variables.']['contact_no.']['value'] ." OR send email to ". $this->settings['orderEmail'] .".",180,5,0,1);
		return \Arm\T3sixshop\Library\Pdf\Pdf::generatePDF('order-'.$orders->getUid().'.pdf',FALSE);
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