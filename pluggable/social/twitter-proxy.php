<?php
/**
 * Twitter proxy for UW Social theme.
 *
 * @category   Components
 * @package    WordPress
 * @subpackage uw_wp_theme
 */

header( 'Access-Control-Allow-Origin: https://www.washington.edu' );

/**
 *  Usage:
 *  Send the url you want to access url encoded in the url paramater, for example (This is with JS):
 *  /twitter-proxy.php?user=tom_z&count=10
 *
 * Inspired from: http://www.fullondesign.co.uk/coding/2516-how-use-twitter-oauth-1-1-javascriptjquery.htm
 * As of at least 20190619, the above link doesn't work anymore! TJS
 */

// The tokens, keys and secrets from the app you created at https://dev.twitter.com/apps.
$config = array(
	'oauth_access_token' => '27103822-QSTDJWTC84cH1QsEWKlifhjzLhIdX0bcXHWMFKbH9',
	'oauth_access_token_secret' => 'VhMI8TF6gsGjXdOlab6HLqvanmO1V2EAMYOrYlSFVU',
	'consumer_key' => '3CNAYpZpWmF5v90Oje2Esw',
	'consumer_secret' => 'OFeAmUwNBe05w23uQPFIkVNQ1abwhZFuU4iktDckGWk',
	'use_whitelist' => false, // If you want to only allow some requests to use this script.
	'base_url' => 'https://api.twitter.com/1.1/'
);

// Only allow certain users to twitter. Stop randoms using your server as a proxy.
$whitelist = array(
	'uw' => true
);

/*
* Ok, no more config should really be needed. Yay!
*/

// We'll get the user from $_GET[].
//
if ( !isset( $_GET['user'] ) ) {
	die( 'No user set' );
}

$user = $_GET['user'];

if ( $config['use_whitelist'] && !isset( $whitelist[$user] ) ) {
	die( 'user is not authorised' );
}

// make the url to call.
$url = 'statuses/user_timeline.json?screen_name=' . $user . '&count=' . $_GET['count'];

// Figure out the URL parmaters.
$url_parts = parse_url( $url );
parse_str( $url_parts['query'], $url_arguments );

$full_url = $config['base_url'] . $url; // Url with the query on it.
$base_url = $config['base_url'] . $url_parts['path']; // Url without the query.

/**
 * Build base URL for Twitter timeline
 *
 * @link http://stackoverflow.com/questions/12916539/simplest-php-example-retrieving-user-timeline-with-twitter-api-version-1-1 by Rivers
 * with a few modfications by Mike Rogers to support variables in the URL nicely
 *
 * @param string $baseURI Some description.
 * @param string $method The relation type the URLs are printed.
 * @param string $params Some description.
 */
function buildBaseString( $baseURI, $method, $params ) {
	$r = array();
	ksort( $params );
	foreach ( $params as $key => $value ) {
		$r[] = "$key=" . rawurlencode( $value );
	}
	return $method . '&' . rawurlencode( $baseURI ) . '&' . rawurlencode( implode( '&', $r ) );
}

function buildAuthorizationHeader( $oauth ) {
	$r = 'Authorization: OAuth ';
	$values = array();
	foreach ( $oauth as $key => $value )
		$values[] = "$key=\"" . rawurlencode( $value ) . "\"";
	$r .= implode( ', ', $values );
	return $r;
}

// Set up the oauth Authorization array.
$oauth = array(
	'oauth_consumer_key' => $config['consumer_key'],
	'oauth_nonce' => time(),
	'oauth_signature_method' => 'HMAC-SHA1',
	'oauth_token' => $config['oauth_access_token'],
	'oauth_timestamp' => time(),
	'oauth_version' => '1.0'
);

$base_info = buildBaseString( $base_url, 'GET', array_merge( $oauth, $url_arguments ) );
$composite_key = rawurlencode( $config['consumer_secret'] ) . '&' . rawurlencode( $config['oauth_access_token_secret'] );
$oauth_signature = base64_encode( hash_hmac( 'sha1', $base_info, $composite_key, true ) );
$oauth['oauth_signature'] = $oauth_signature;

// Make Requests.
$header = array(
	buildAuthorizationHeader( $oauth ),
	'Expect:'
);
$options = array(
	CURLOPT_HTTPHEADER => $header,
	CURLOPT_HEADER => false,
	CURLOPT_URL => $full_url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_SSL_VERIFYPEER => false
);

$feed = curl_init();
curl_setopt_array( $feed, $options );
$result = curl_exec( $feed );
$info = curl_getinfo( $feed );
curl_close( $feed );

// Send suitable headers to the end user.
if ( isset( $info['content_type'] ) && isset( $info['size_download'] ) ) {
	header( 'Content-Type: ' . $info['content_type'] );
	header( 'Content-Length: ' . $info['size_download'] );
}

echo $result;
