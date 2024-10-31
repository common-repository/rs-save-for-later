<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://ratkosolaja.info/
 * @since      1.0.0
 *
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap rs-plugin-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="rs-page-header">
					<h1 class="rs-page-heading"><?php _e( 'Simplicity Save For Later', 'rs-save-for-later' ); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="rs-box">
					<div class="rs-box-title">
						<h3><?php _e( 'Settings', 'rs-save-for-later' ); ?></h3>
					</div>
					<div class="rs-box-container">
						<form method="post" action="options.php">
							<?php
								settings_fields( 'rs-save-for-later-settings' );
								do_settings_sections( 'rs-save-for-later-settings' );
								submit_button();
							?>
						</form>
					</div>
				</div>
				<div class="rs-box">
					<div class="rs-box-title">
						<h3><?php _e( 'Customization', 'rs-save-for-later' ); ?></h3>
					</div>
					<div class="rs-box-container">
						<p><?php _e( 'If you want to use Save for Later anywhere on the website, you can use our shortcode:', 'rs-save-for-later' ); ?></p>
						<input type="text" value="[simplicity-save-for-later]" readonly>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>