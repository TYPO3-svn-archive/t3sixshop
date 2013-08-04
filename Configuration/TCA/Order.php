<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_t3sixshop_domain_model_order'] = array(
	'ctrl' => $TCA['tx_t3sixshop_domain_model_order']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, session, user, fname, lname, email, phone, apartment, address, zip, amount, totalamount, status, remark, discount, shipping, deliveryon, orderid, coupon, deliveryoption, orderitems',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, crdate, session, orderid, totalamount, discount, amount, status, remark, coupon, deliveryoption, shipping, deliveryon, orderitems,--div--;LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.tab.customer, user, fname, lname, email, phone, apartment, address, zip,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_t3sixshop_domain_model_order',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_order.pid=###CURRENT_PID### AND tx_t3sixshop_domain_model_order.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'crdate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.crdate',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'readOnly' => 1,
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'session' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.session',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => TRUE,
			),
		),
		'user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.disable=0 ORDER BY fe_users.first_name',
				'items' => array(
					array('-- Unregistered --', 0),
				),
			),
		),
		'fname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.fname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'lname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.lname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'phone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'apartment' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.apartment',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'zip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.amount',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'double2,required'
			),
		),
		'totalamount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.totalamount',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'double2'
			),
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.status',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Trash --', 0),
					array('Pending', 1),
					array('Processing', 2),
					array('In shipping', 3),
					array('Delivered', 4),
					array('Returned', 5),
					array('Cancelled', 6),
				),
				'size' => 1,
				'maxitems' => 1
			),
		),
		'remark' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.remark',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'discount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.discount',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'coupon' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.coupon',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3sixshop_domain_model_coupon',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_coupon.hidden=0 ORDER BY tx_t3sixshop_domain_model_coupon.uid',
				'items' => array(
						array('-- none --', 0),
				),
			),
		),
		'deliveryoption' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.deliveryoption',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3sixshop_domain_model_deliveryoption',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_deliveryoption.hidden=0 ORDER BY tx_t3sixshop_domain_model_deliveryoption.price',
			),
		),
		'shipping' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.shipping',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'double2'
			),
		),
		'deliveryon' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.deliveryon',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'orderid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.orderid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
					'readOnly' => TRUE
			),
		),
		'orderitems' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.orderitems',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_t3sixshop_domain_model_orderitem',
				'foreign_field' => 'orders',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'customer' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>