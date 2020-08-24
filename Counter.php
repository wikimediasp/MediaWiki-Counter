<?php
if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'Counter' );
	$wgExtensionMessagesFiles['CounterMagic'] = __DIR__ . '/Counter.magic.php';
	wfWarn(
		'Deprecated PHP entry point used for the Counter extension. ' .
		'Please use wfLoadExtension() instead, ' .
		'see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the Counter extension requires MediaWiki 1.29+' );
}

