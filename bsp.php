<?php
/**
 * Plugin Name: BetterStack Press
 * Description: Simple integration for logger WP and BetterStack Logs. const BETTERSTACK_LOGS_SOURCE_TOKEN get here https://logs.betterstack.com/
 * Version: 0.2
 */

namespace BetterStackPress;

if ( defined( 'BETTERSTACK_LOGS_SOURCE_TOKEN' ) ) {
	add_action( 'shutdown', function () {

		$error = error_get_last();

		if ( is_null( $error ) ) {
			return;
		}

		if ( $error['type'] != E_ERROR ) {
			return;
		}

		send_to_betterstack( $error );
	}, 1 );

	add_filter( 'wp_php_error_message', function ($message, $error) {

		send_to_betterstack( $error );

		return $message;
	}, 11, 2 );

}


function send_to_betterstack( $error ) {
	$error = [ 
		'message' => wp_trim_words( $error['message'], 11, '...' ),
		'nested' => $error,
	];

	if ( $user_id = get_current_user_id() ) {
		$error['nested']['user_id'] = $user_id;
	}

	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$error['nested']['request'] = $_SERVER['REQUEST_URI'];
	}

	if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
		$error['nested']['referer'] = urlencode( $_SERVER['HTTP_REFERER'] );
	} else {
		$error['nested']['referer'] = 'unknown';
	}

	$json = json_encode( $error );

	$result = wp_remote_post( 'https://in.logs.betterstack.com', [ 
		'headers' => [ 
			'Authorization' => 'Bearer ' . BETTERSTACK_LOGS_SOURCE_TOKEN,
			'Content-Type' => 'application/json'
		],
		'body' => $json,
	] );

	return $result;
}