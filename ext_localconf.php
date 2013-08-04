<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'List',
	array(
		'Product' => 'list, jscroll, show',
	),
	// non-cacheable actions
	array(
		'Product' => 'list, jscroll, show',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'Show',
	array(
		'Product' => 'show',
	),
	// non-cacheable actions
	array(
		'Product' => 'show',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'Rate',
	array(
		'Product' => 'rate',
	),
	// non-cacheable actions
	array(
		'Product' => 'rate',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'Mini',
	array(
		'Order' => 'minilist',
	),
	// non-cacheable actions
	array(
		'Order' => 'minilist',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'Cart',
	array(
		'Order' => 'list, cart, update, delete, form, confirm',
	),
	// non-cacheable actions
	array(
		'Order' => 'list, cart, update, delete, form, confirm',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'Myorder',
	array(
			'Order' => 'mylist, show',
	),
	// non-cacheable actions
	array(
			'Order' => 'mylist, show',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Arm.' . $_EXTKEY,
	'Track',
	array(
			'Order' => 'track',
	),
	// non-cacheable actions
	array(
			'Order' => 'track',
	)
);

?>