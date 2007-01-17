<?php

/**
 * Parser hook in which free dates will be refactored to meet the
 * user's date formatting preference
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgAutoloadClasses['DateParser'] = dirname( __FILE__ ) . '/DateParser.php';
	$wgAutoloadClasses['FormattableDate'] = dirname( __FILE__ ) . '/FormattableDate.php';
	
	$wgExtensionCredits['other'][] = array( 'name' => 'Date Formatter', 'author' => 'Rob Church' );
	$wgExtensionFunctions[] = 'efFormatDates';

	function efFormatDates() {
		global $wgParser;
		$wgParser->setHook( 'date', 'efFormatDate' );
	}
	
	function efFormatDate( $text, $args, &$parser ) {
		global $wgUseDynamicDates, $wgContLang;
		if( $wgUseDynamicDates ) {
			$dp = new DateParser( $wgContLang, DateParser::convertPref( $parser->getOptions()->getDateFormat() ) );
			return $dp->reformat( $text );
		} else {
			return $text;
		}
	}

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

?>
