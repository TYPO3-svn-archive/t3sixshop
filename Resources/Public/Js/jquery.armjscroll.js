$(document).ready(function() {
	$('.infinite-scroll').jscroll({
		loadingHtml: '<img src="typo3conf/ext/t3sixshop/Resources/Public/Images/loading.gif" alt="Loading" /> Loading...',
	    nextSelector: '.jscroll-next',
	});
});