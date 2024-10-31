<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://ratkosolaja.info/
 * @since      1.0.0
 *
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/includes
 * @author     Ratko Solaja <me@ratkosolaja.info>
 */
class RS_Save_For_Later_Deactivator {

	/**
	 * Deactivate this plugin.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Get Page ID
		$page_id = get_option( 'rs_save_for_later_page_id' );

		// Delete Page
		if ( $page_id ) {
			wp_delete_post( $page_id, true );
		}

		// Delete our Page ID
		delete_option( 'rs_save_for_later_page_id' );

	}

}