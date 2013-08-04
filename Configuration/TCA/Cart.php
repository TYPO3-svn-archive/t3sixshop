<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_t3sixshop_domain_model_cart'] = array(
	'ctrl' => $TCA['tx_t3sixshop_domain_model_cart']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, session, user, fname, lname, email, phone, apartment, address, zip, amount, status, cartitems',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, crdate, session, amount, status, cartitems,--div--;LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_order.tab.customer, user, fname, lname, email, phone, apartment, address, zip,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table_where' => 'cart BY sys_language.title',
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
				'foreign_table' => 'tx_t3sixshop_domain_model_cart',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_cart.pid=###CURRENT_PID### AND tx_t3sixshop_domain_model_cart.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cart.crdate',
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
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cart.session',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => TRUE,
			),
		),
		'user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cart.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.disable=0 cart BY fe_users.first_name',
				'items' => array(
					array('-- Unregistered --', 0),
				),
				'readOnly' => TRUE,
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
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cart.amount',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'double2',
				'readOnly' => TRUE,
			),
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cart.status',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Trash --', 0),
					array('Order', 1),
				),
				'size' => 1,
				'maxitems' => 1,
				'readOnly' => TRUE,
			),
		),
		'cartitems' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cart.cartitems',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_t3sixshop_domain_model_cartitem',
				'foreign_field' => 'cart',
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
	),
);

?>