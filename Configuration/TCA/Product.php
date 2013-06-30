<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_t3sixshop_domain_model_product'] = array(
	'ctrl' => $TCA['tx_t3sixshop_domain_model_product']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, category, manufacturer, pgroup, name, description, discount, unit, price, image, instock, minorder, featured, related',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, category, manufacturer, pgroup, name, description,--div--;LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.tab.more, unit, price, discount, instock, minorder, image, featured, related,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_t3sixshop_domain_model_product',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_product.pid=###CURRENT_PID### AND tx_t3sixshop_domain_model_product.sys_language_uid IN (-1,0)',
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
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 8,
				'eval' => 'trim'
			),
		),
		'discount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.discount',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'double2'
			),
		),
		'unit' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.unit',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'trim'
			),
		),
		'price' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.price',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'double2'
			),
		),
		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image',
				array(
						'maxitems' => 5,
						'appearance' => array(
								'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
						),
						// custom configuration for displaying fields in the overlay/reference table
						// to use the imageoverlayPalette instead of the basicoverlayPalette
						'foreign_types' => array(
								'0' => array(
										'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
								),
								\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
										'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
								)
						)
				),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'php'
			),
		),
		'instock' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.instock',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'featured' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.featured',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'minorder' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.minorder',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'double2'
			),
		),
		'related' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.related',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3sixshop_domain_model_product',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_product.pid=###CURRENT_PID### AND tx_t3sixshop_domain_model_product.sys_language_uid IN (-1,0) AND tx_t3sixshop_domain_model_product.uid != ###THIS_UID### ORDER BY tx_t3sixshop_domain_model_product.name',		
				'maxitems' => 10,
                'size' => 5,
                'MM' => 'tx_t3sixshop_domain_model_product_related_mm',
			),
		),
		'category' => array(
			'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.category',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3sixshop_domain_model_category',
				'foreign_table_where' => 'AND tx_t3sixshop_domain_model_category.sys_language_uid IN (-1,0) ORDER BY tx_t3sixshop_domain_model_category.name',
				'items' => array(
					array('LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.category.0', 0)
				),
			),
		),
			'pgroup' => array(
					'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.pgroup',
					'config' => array(
							'type' => 'select',
							'foreign_table' => 'tx_t3sixshop_domain_model_pgroup',
							'foreign_table_where' => 'AND tx_t3sixshop_domain_model_pgroup.sys_language_uid IN (-1,0) ORDER BY tx_t3sixshop_domain_model_pgroup.name ',
							'items' => array(
									array('LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.pgroup.0', 0)
							),
					),
			),
			'manufacturer' => array(
					'label' => 'LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.manufacturer',
					'config' => array(
							'type' => 'select',
							'foreign_table' => 'tx_t3sixshop_domain_model_manufacturer',
							'foreign_table_where' => 'AND tx_t3sixshop_domain_model_manufacturer.sys_language_uid IN (-1,0) ORDER BY tx_t3sixshop_domain_model_manufacturer.name ',
							'items' => array(
									array('LLL:EXT:t3sixshop/Resources/Private/Language/locallang_db.xlf:tx_t3sixshop_domain_model_product.manufacturer.0', 0)
							),
					),
			),
	),
);

?>