<?php 
/**
 * Plugin Name: LD Mail Spam
 * Plugin URI: https://www.logicdesign.co.uk
 * Description: Prevent spam emails sending through wp_mail()
 * Version: 1.0.1
 * Author: Logic Design & Consultancy Ltd
 * Author URI: https://www.logicdesign.co.uk
 */

if( ! class_exists( 'Ld_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

$updater = new Ld_Updater( __FILE__ );
$updater->set_username( 'logic-design' );
$updater->set_repository( 'ld-mail-spam' );
$updater->initialize();

require_once __DIR__ . '/vendor/autoload.php';

use SpamDetector\Detector;

add_filter( 'wpcf7_spam', 'ld_mail_spam' );
function ld_mail_spam($spam)
{
	// IF ALREADY KNOWN AS SPAM - RETURN TRUE
	if ( $spam ) {
		return true;
	}

	// GET ALL POST DATA
	$params = array(
		'content' => '' );

	// GET POST
	foreach ( (array) $_POST as $key => $val ) {

		if ( '_wpcf7' == substr( $key, 0, 6 ) || '_wpnonce' == $key ) {
			continue;
		}

		if ( is_array( $val ) ) {
			$val = implode( ', ', wpcf7_array_flatten( $val ) );
		}

		$val = trim( $val );

		if ( 0 == strlen( $val ) ) {
			continue;
		}

		$params['content'] .= "\n\n" . $val;
	}

	// NEW BLACKLIST
	$blackListDetector = new SpamDetector\Detector\BlackList();

	// ADD RULES
	$blackListDetector->add('__MUST_HAVE_ONE_RULE__');
	$blackListDetector->setListFile( __DIR__ . '/spam.txt' );

	// REGISTER DETECTOR
	$spamDetector = new SpamDetector\SpamDetector();
	$spamDetector->registerDetector($blackListDetector);

	// SCAN CONTENT
	$spamDetectorResult = $spamDetector->check([
		'text' => $params['content'],
	]);

	// RETURN RESULT
	return ! $spamDetectorResult->passed();
}
