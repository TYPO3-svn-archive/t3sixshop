<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'List',
	'Product List'
);
//Add flexform
$pluginSignature = str_replace('_','',$_EXTKEY) . '_list';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Show',
	'Product Details'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'Rate',
		'Rate Chart'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Mini',
	'Mini Basket'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Basket',
	'Basket'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Myorder',
	'My Orders'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Track',
	'Track Order'
);

/*
$pluginSignature = str_replace('_','',$_EXTKEY) . '_basket';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_basket.xml');
*/

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'T3 Shop for V6');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3sixshop_domain_model_category', 'EXT:t3sixshop/Resources/Private/Language/locallang_csh_tx_t3sixshop_domain_model_category.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3sixshop_domain_model_category');
$TCA['tx_t3sixshop_domain_model_category'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_category',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'crdate' => 'crdate',
		),
		'searchFields' => 'name,products,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3sixshop_domain_model_category.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3sixshop_domain_model_manufacturer', 'EXT:t3sixshop/Resources/Private/Language/locallang_csh_tx_t3sixshop_domain_model_manufacturer.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3sixshop_domain_model_manufacturer');
$TCA['tx_t3sixshop_domain_model_manufacturer'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_manufacturer',
				'label' => 'name',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => TRUE,
				'sortby' => 'sorting',
				'versioningWS' => 2,
				'versioning_followPages' => TRUE,
				'origUid' => 't3_origuid',
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
				'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
						'crdate' => 'crdate',
				),
				'searchFields' => 'name,products,',
				'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Manufacturer.php',
				'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3sixshop_domain_model_category.gif'
		),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3sixshop_domain_model_pgroup', 'EXT:t3sixshop/Resources/Private/Language/locallang_csh_tx_t3sixshop_domain_model_pgroup.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3sixshop_domain_model_pgroup');
$TCA['tx_t3sixshop_domain_model_pgroup'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_pgroup',
				'label' => 'name',
				'label_alt' => 'price',
				'label_alt_force' => TRUE,
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => TRUE,
				'sortby' => 'sorting',
				'versioningWS' => 2,
				'versioning_followPages' => TRUE,
				'origUid' => 't3_origuid',
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
				'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
						'crdate' => 'crdate',
				),
				'searchFields' => 'name,price,products,',
				'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Pgroup.php',
				'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3sixshop_domain_model_category.gif'
		),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3sixshop_domain_model_product', 'EXT:t3sixshop/Resources/Private/Language/locallang_csh_tx_t3sixshop_domain_model_product.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3sixshop_domain_model_product');
$TCA['tx_t3sixshop_domain_model_product'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product',
		'label' => 'name',
		'label_alt' => 'price',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,description,discount,price,image,instock,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Product.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3sixshop_domain_model_product.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3sixshop_domain_model_order', 'EXT:t3sixshop/Resources/Private/Language/locallang_csh_tx_t3sixshop_domain_model_order.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3sixshop_domain_model_order');
$TCA['tx_t3sixshop_domain_model_order'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order',
		'label' => 'orderid',
		'label_alt' => 'status',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY uid DESC',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'user,email,phone,apartment,address,zip,amount,status,discount,deliveryon,orderid,orderitems,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Order.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3sixshop_domain_model_order.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3sixshop_domain_model_orderitem', 'EXT:t3sixshop/Resources/Private/Language/locallang_csh_tx_t3sixshop_domain_model_orderitem.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3sixshop_domain_model_orderitem');
$TCA['tx_t3sixshop_domain_model_orderitem'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_orderitem',
		'label' => 'product',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY uid DESC',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'qty,rate,amount,product,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Orderitem.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3sixshop_domain_model_orderitem.gif'
	),
);

$tmp_t3sixshop_columns = array(

	'apartment' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_customer.apartment',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'voucher' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_customer.voucher',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'orders' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_customer.orders',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_t3sixshop_domain_model_order',
			'foreign_field' => 'user',
			'maxitems'      => 9999,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_t3sixshop_columns, 1);
t3lib_extMgm::addToAllTCAtypes('fe_users', 'apartment, voucher,orders');

//t3lib_extMgm::addToAllTCATypes('fe_users','--div--;Direct mail,module_sys_dmail_html;;;;1-1-1');

/*
$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_T3sixshop_Customer','Tx_T3sixshop_Customer');

$TCA['fe_users']['types']['Tx_T3sixshop_Customer']['showitem'] = $TCA['fe_users']['types']['1']['showitem'];
$TCA['fe_users']['types']['Tx_T3sixshop_Customer']['showitem'] .= ',--div--;LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_customer,';
$TCA['fe_users']['types']['Tx_T3sixshop_Customer']['showitem'] .= 'voucher, orders';
*/

?>