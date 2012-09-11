<?php

/**
 * Parser hook in which free dates will be refactored to meet the
 * user's date formatting preference
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgAutoloadClasses['DateParser'] = dirname( __FILE__ ) . '/DateParser.php';
$wgAutoloadClasses['FormattableDate'] = dirname( __FILE__ ) . '/FormattableDate.php';
$wgHooks['ParserFirstCallInit'][] = 'efFormatDatesSetHook';

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Date Formatter',
	'version' => '1.0.1-alpha.1',
	'author' => array('Rob Church', 'Larry Gilbert'),
	'description' => 'Reformats \'\'unlinked\'\' dates marked up with the <code><nowiki><date></nowiki></code> tag',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Date_Formatter',
);

function efFormatDatesSetHook( Parser $parser ) {
	$parser->setHook( 'date', 'efFormatDate' );
	return true;
}

function efFormatDate( $text, array $args, Parser $parser, PPFrame $frame ) {
	global $wgUseDynamicDates, $wgContLang;
	if( $wgUseDynamicDates ) {
		$dp = new DateParser( $wgContLang, DateParser::convertPref( $parser->getOptions()->getDateFormat() ) );
		return $dp->reformat( $parser->recursiveTagParse( $text, $frame ) );
	} else {
		return $text;
	}
}


