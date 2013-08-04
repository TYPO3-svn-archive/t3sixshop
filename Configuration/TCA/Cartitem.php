<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_t3sixshop_domain_model_cartitem'] = array(
	'ctrl' => $TCA['tx_t3sixshop_domain_model_cartitem']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, cart, qty, rate, amount, product, name, unit',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, cart, product, name, unit, qty, rate, amount,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_t3sixshop_domain_model_cartitem',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_cartitem.pid=###CURRENT_PID### AND tx_t3sixshop_domain_model_cartitem.sys_language_uid IN (-1,0)',
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
		'unit' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cartitem.unit',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'readOnly' => TRUE
			),
		),
		'qty' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cartitem.qty',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'double2',
				'readOnly' => TRUE
			),
		),
		'rate' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cartitem.rate',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'double2,required',
				'readOnly' => TRUE
			),
		),
		'amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cartitem.amount',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'double2',
				'readOnly' => TRUE
			),
		),
		'cart' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cartitem.cart',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3sixshop_domain_model_cart',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_cart.sys_language_uid IN (-1,0) ORDER BY tx_t3sixshop_domain_model_cart.uid',
				'size' => 1,
				'readOnly' => TRUE,
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => TRUE,
			),
		),
		'product' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_cartitem.product',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3sixshop_domain_model_product',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_product.sys_language_uid IN (-1,0) ORDER BY tx_t3sixshop_domain_model_product.name',
				'size' => 1,
				'maxitems' => 1,
				'readOnly' => TRUE,
			),
		),
	),
);

?>