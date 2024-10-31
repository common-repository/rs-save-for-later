<?php

/**
 * Fired during plugin activation
 *
 * @link       http://ratkosolaja.info/
 * @since      1.0.0
 *
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/includes
 * @author     Ratko Solaja <me@ratkosolaja.info>
 */
class RS_Save_For_Later_Activator {

	/**
	 * Activate the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Current User ID
		$current_user = get_current_user_id();

		// Create a New Page
		$page_args = array(
			'post_type' => 'page',
			'post_title' => __( 'Saved for Later', 'rs-save-for-later' ),
			'post_content' => '[simplicity-saved-for-later]',
			'post_status' => 'publish',
			'post_author' => $current_user
		);
		$page_id = wp_insert_post( $page_args );

		// Save our Page ID
		add_option( 'rs_save_for_later_page_id', $page_id );

	}

}