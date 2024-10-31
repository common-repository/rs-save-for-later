<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ratkosolaja.info/
 * @since      1.0.0
 *
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    RS_Save_For_Later
 * @subpackage RS_Save_For_Later/public
 * @author     Ratko Solaja <me@ratkosolaja.info>
 */
class RS_Save_For_Later_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Get Toggled Logged in Setting
	 *
	 * @since    1.0.2
	 */
	public function get_toggle_logged_in() {

		$options = get_option( $this->plugin_name . '-settings' );
		if ( ! empty( $options['toggle-logged-in'] ) ) {
			$toggle_logged_in = $options['toggle-logged-in'];
		} else {
			$toggle_logged_in = 0;
		}

		return $toggle_logged_in;

	}

	/**
	 * Get cookie value
	 *
	 * @since    1.0.6
	 */
	public function get_cookie() {

		if ( array_key_exists( 'rs_save_for_later', $_COOKIE ) ) {
			if ( isset( $_COOKIE[ 'rs_save_for_later' ] ) ) {
				return json_decode( base64_decode( stripslashes( $_COOKIE[ 'rs_save_for_later' ] ) ), true );
			}
			return array();
		}

		return array();

	}

	/**
	 * Set cookie value
	 *
	 * @since    1.0.6
	 */
	public function set_cookie( $value ) {

		return base64_encode( json_encode( stripslashes_deep( $value ) ) );

	}

	/**
	 * Get number of saved items
	 *
	 * @since    1.0.2
	 * @version  1.0.6
	 */
	public function get_number_of_saved_items() {

		if ( is_user_logged_in() ) {
			$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
			if ( empty( $matches ) ) {
				$matches = array();
			}
			$count = count( $matches );
		} else {
			if ( $this->get_toggle_logged_in() == 1 ) {
				$count = 0;
			} else {
				$cookie_values = $this->get_cookie();

				$count = count( $cookie_values );
			}
		}

		return $count;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$options = get_option( $this->plugin_name . '-settings' );

		if ( ! empty( $options['toggle-css'] ) && $options['toggle-css'] == 1 ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rs-save-for-later-public.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @version  1.0.8
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$page_id = get_option( 'rs_save_for_later_page_id' );
		$page_link = get_permalink( $page_id );

		$options = get_option( $this->plugin_name . '-settings' );
		$save = __( 'Save for Later', 'rs-save-for-later' );
		$unsave = __( 'Remove', 'rs-save-for-later' );
		$saved = __( 'See Saved', 'rs-save-for-later' );
		$number = __( 'Saved: ', 'rs-save-for-later' );

		if ( ! empty( $options['save-text'] ) ) {
			$save = $options['save-text'];
		}
		if ( ! empty( $options['unsave-text'] ) ) {
			$unsave = $options['unsave-text'];
		}
		if ( ! empty( $options['saved-text'] ) ) {
			$saved = $options['saved-text'];
		}
		if ( ! empty( $options['number-text'] ) ) {
			$number = $options['number-text'];
		}

		// Saved objects
		if ( is_user_logged_in() ) {
			$is_user_logged_in = true;
		} else {
			$is_user_logged_in = false;
		}

		$toggle_logged_in = $this->get_toggle_logged_in();

		wp_enqueue_script( $this->plugin_name . 'js-cookie', plugin_dir_url( __FILE__ ) . 'js/js.cookie.js', array( 'jquery' ), '2.1.4', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rs-save-for-later-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'rs_save_for_later_ajax',
			array(
				'ajax_url'          => admin_url( 'admin-ajax.php', 'relative' ),
				'save_txt'          => $save,
				'unsave_txt'        => $unsave,
				'saved_txt'         => $saved,
				'number_txt'        => $number,
				'saved_page_url'    => esc_url( $page_link ),
				'is_user_logged_in' => $is_user_logged_in,
				'toggle_logged_in'  => $toggle_logged_in
			)
		);

	}

	/**
	 * Set nocache constants and headers.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private static function nocache() {
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( "DONOTCACHEPAGE", true );
		}
		if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
			define( "DONOTCACHEOBJECT", true );
		}
		if ( ! defined( 'DONOTCACHEDB' ) ) {
			define( "DONOTCACHEDB", true );
		}
		nocache_headers();
	}

	/**
	 * Add HTML to the end of the page.
	 *
	 * @since    1.0.0
	 */
	public function add_saved_items_to_footer() {

		$options = get_option( $this->plugin_name . '-settings' );

		$page_id = get_option( 'rs_save_for_later_page_id' );
		$page_link = get_permalink( $page_id );

		$saved_txt = __( 'See Saved', 'rs-save-for-later' );

		if ( ! empty( $options['saved-text'] ) ) {
			$saved_txt = $options['saved-text'];
		}

		// Saved objects
		$count = $this->get_number_of_saved_items();
		$toggle_logged_in = $this->get_toggle_logged_in();

		if ( $toggle_logged_in == 1 && is_user_logged_in() || $toggle_logged_in == 0 ) {
			echo '<a href="' . esc_url( $page_link ) . '" class="rs-saved-trigger empty" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $saved_txt ) . '"><svg width="15px" height="15px" viewBox="200 89 46 55" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs></defs><path d="M241.571429,89.7142857 C242.11905,89.7142857 242.642855,89.8214275 243.142857,90.0357143 C243.928575,90.3452396 244.553569,90.83333 245.017857,91.5 C245.482145,92.16667 245.714286,92.9047579 245.714286,93.7142857 L245.714286,139.75 C245.714286,140.559528 245.482145,141.297616 245.017857,141.964286 C244.553569,142.630956 243.928575,143.119046 243.142857,143.428571 C242.690474,143.619049 242.16667,143.714286 241.571429,143.714286 C240.428566,143.714286 239.44048,143.333337 238.607143,142.571429 L222.857143,127.428571 L207.107143,142.571429 C206.249996,143.357147 205.26191,143.75 204.142857,143.75 C203.595235,143.75 203.071431,143.642858 202.571429,143.428571 C201.78571,143.119046 201.160717,142.630956 200.696429,141.964286 C200.232141,141.297616 200,140.559528 200,139.75 L200,93.7142857 C200,92.9047579 200.232141,92.16667 200.696429,91.5 C201.160717,90.83333 201.78571,90.3452396 202.571429,90.0357143 C203.071431,89.8214275 203.595235,89.7142857 204.142857,89.7142857 L241.571429,89.7142857 Z" id="rs-bookmark-button" stroke="none" fill="#000000" fill-rule="evenodd"></path></svg><span class="rs-count">' . esc_html( $count ) . '</span></a>';
		}

	}

	/**
	 * Override 'the_content'.
	 *
	 * @since    1.0.0
	 */
	public function override_content( $content ) {

		$options = get_option( $this->plugin_name . '-settings' );
		$post_types = array();
		$toggle = 0;

		if ( ! empty( $options['post-type'] ) ) {
			$post_types = $options['post-type'];
		}
		if ( ! empty( $options['toggle-content-override'] ) ) {
			$toggle = $options['toggle-content-override'];
		}

		$toggle_logged_in = $this->get_toggle_logged_in();

		$page_id = get_option( 'rs_save_for_later_page_id' );

		if ( $toggle == 1 && ! empty( $post_types ) && is_singular() && ! is_page( $page_id ) ) {
			$post_id = get_queried_object_id();
			foreach ( $post_types as $post_type ) {
				$current_post_type = get_post_type( $post_id );
				if ( $current_post_type == $post_type ) {
					$custom_content = '';
					ob_start();
					echo $this->get_save_for_later_button_display();
					$custom_content .= ob_get_contents();
					ob_end_clean();
					$content = $content . $custom_content;
				}
			}
		}

		return $content;

	}

	/**
	 * Save/Unsave for Later
	 *
	 * @since    1.0.0
	 * @version  1.0.6
	 */
	public function save_unsave_for_later() {

		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'rs_object_save_for_later' ) ) {
			die;
		}

		$count = $this->get_number_of_saved_items();

		$no_content = __( 'You don’t have any saved content.', 'rs-save-for-later' );
		if ( ! empty( $options['no-content-text'] ) ) {
			$no_content = $options['no-content-text'];
		}

		$toggle_logged_in = $this->get_toggle_logged_in();

		// Object ID
		$object_id = isset( $_REQUEST['object_id'] ) ? intval( $_REQUEST['object_id'] ) : 0;

		// Check cookie if object is saved
		$saved = false;

		// Cookies
		$cookie_values = $this->get_cookie();

		if ( is_user_logged_in() ) {
			$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
			if ( empty( $matches ) ) {
				$matches = array();
			}
			if ( in_array( $object_id, $matches ) ) {
				$saved = true;
				unset( $matches[array_search( $object_id, $matches )] );
			} else {
				$saved = false;
				array_push( $matches, $object_id );
			}
			update_user_meta( get_current_user_id(), 'rs_saved_for_later', $matches );
		} else {
			if ( in_array( $object_id, $cookie_values ) ) {
				$saved = true;
				unset( $cookie_values[array_search( $object_id, $cookie_values )] );
				$cookie_values_js = $this->set_cookie( $cookie_values );
			} else {
				$saved = false;
				array_push( $cookie_values, $object_id );
				$cookie_values_js = $this->set_cookie( $cookie_values );
			}
		}

		if ( $saved == true ) {
			$count = $count - 1;
		} else {
			$count = $count + 1;
		}

		$return = array(
			'status'  => is_user_logged_in(),
			'update'  => $saved,
			'message' => esc_attr( $no_content ),
			'count'   => esc_attr( $count )
		);

		if ( ! is_user_logged_in() ) {
			$return['cookie'] = $cookie_values_js;
		}

		return wp_send_json( $return );

	}

	/**
	 * Save for Later button.
	 *
	 * @since    1.0.0
	 * @version  1.0.6
	 */
	public function get_save_for_later_button_display() {

		self::nocache();

		// Object ID
		$object_id = get_queried_object_id();

		$page_id = get_option( 'rs_save_for_later_page_id' );
		$page_link = get_permalink( $page_id );

		$toggle_logged_in = $this->get_toggle_logged_in();

		// Check cookie if object is saved
		$saved = false;

		if ( is_user_logged_in() ) {
			$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
			if ( empty( $matches ) ) {
				$matches = array();
			}
			if ( in_array( $object_id, $matches ) ) {
				$saved = true;
			} else {
				$saved = false;
			}
		} else {
			$cookie_values = $this->get_cookie();
			if ( in_array( $object_id, $cookie_values ) ) {
				$saved = true;
			} else {
				$saved = false;
			}
		}

		// Get tooltip text
		$options = get_option( $this->plugin_name . '-settings' );
		$save = __( 'Save for Later', 'rs-save-for-later' );
		$unsave = __( 'Remove', 'rs-save-for-later' );
		$saved_txt = __( 'See Saved', 'rs-save-for-later' );
		$number = __( 'Saved: ', 'rs-save-for-later' );

		if ( ! empty( $options['save-text'] ) ) {
			$save = $options['save-text'];
		}
		if ( ! empty( $options['unsave-text'] ) ) {
			$unsave = $options['unsave-text'];
		}
		if ( ! empty( $options['saved-text'] ) ) {
			$saved_txt = $options['saved-text'];
		}
		if ( ! empty( $options['number-text'] ) ) {
			$number = $options['number-text'];
		}

		// Saved objects
		$count = $this->get_number_of_saved_items();

		if ( $toggle_logged_in == 1 && is_user_logged_in() || $toggle_logged_in == 0 ) {
			if ( $saved == true ) {
				return '<a href="#" class="rs-save-for-later-button saved" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $unsave ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later' ) . '" data-object-id="' . esc_attr( $object_id ) . '"><svg width="15px" height="15px" viewBox="200 89 46 55" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs></defs><path d="M241.571429,89.7142857 C242.11905,89.7142857 242.642855,89.8214275 243.142857,90.0357143 C243.928575,90.3452396 244.553569,90.83333 245.017857,91.5 C245.482145,92.16667 245.714286,92.9047579 245.714286,93.7142857 L245.714286,139.75 C245.714286,140.559528 245.482145,141.297616 245.017857,141.964286 C244.553569,142.630956 243.928575,143.119046 243.142857,143.428571 C242.690474,143.619049 242.16667,143.714286 241.571429,143.714286 C240.428566,143.714286 239.44048,143.333337 238.607143,142.571429 L222.857143,127.428571 L207.107143,142.571429 C206.249996,143.357147 205.26191,143.75 204.142857,143.75 C203.595235,143.75 203.071431,143.642858 202.571429,143.428571 C201.78571,143.119046 201.160717,142.630956 200.696429,141.964286 C200.232141,141.297616 200,140.559528 200,139.75 L200,93.7142857 C200,92.9047579 200.232141,92.16667 200.696429,91.5 C201.160717,90.83333 201.78571,90.3452396 202.571429,90.0357143 C203.071431,89.8214275 203.595235,89.7142857 204.142857,89.7142857 L241.571429,89.7142857 Z" id="rs-bookmark-button" stroke="none" fill="#000000" fill-rule="evenodd"></path></svg></a><a href="' . esc_url( $page_link ) . '" class="rs-see-saved" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $number ) . ' ' . esc_attr( $count ) . '">' . esc_html( $saved_txt ) . '</a>';
			} else {
				return '<a href="#" class="rs-save-for-later-button" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $save ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later' ) . '" data-object-id="' . esc_attr( $object_id ) . '"><svg width="15px" height="15px" viewBox="200 89 46 55" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs></defs><path d="M241.571429,89.7142857 C242.11905,89.7142857 242.642855,89.8214275 243.142857,90.0357143 C243.928575,90.3452396 244.553569,90.83333 245.017857,91.5 C245.482145,92.16667 245.714286,92.9047579 245.714286,93.7142857 L245.714286,139.75 C245.714286,140.559528 245.482145,141.297616 245.017857,141.964286 C244.553569,142.630956 243.928575,143.119046 243.142857,143.428571 C242.690474,143.619049 242.16667,143.714286 241.571429,143.714286 C240.428566,143.714286 239.44048,143.333337 238.607143,142.571429 L222.857143,127.428571 L207.107143,142.571429 C206.249996,143.357147 205.26191,143.75 204.142857,143.75 C203.595235,143.75 203.071431,143.642858 202.571429,143.428571 C201.78571,143.119046 201.160717,142.630956 200.696429,141.964286 C200.232141,141.297616 200,140.559528 200,139.75 L200,93.7142857 C200,92.9047579 200.232141,92.16667 200.696429,91.5 C201.160717,90.83333 201.78571,90.3452396 202.571429,90.0357143 C203.071431,89.8214275 203.595235,89.7142857 204.142857,89.7142857 L241.571429,89.7142857 Z" id="rs-bookmark-button" stroke="none" fill="#000000" fill-rule="evenodd"></path></svg></a>';
			}
		} elseif ( $toggle_logged_in == 1 && ! is_user_logged_in() ) {
			$login_url = wp_login_url( get_permalink() );
			$register_url = wp_registration_url();
			$return = sprintf( __( '%1$sLog in%2$s or %3$sRegister%4$s to save this content for later.', 'rs-save-for-later' ), '<a href="' . esc_url( $login_url ) . '">', '</a>', '<a href="' . esc_url( $register_url ) . '">', '</a>' );
			return apply_filters( 'rs_save_for_later_message', $return );
		}

	}

	/**
	 * Create Save for Later shortcode.
	 *
	 * @since    1.0.0
	 */
	public function save_for_later_shortcode() {

		return $this->get_save_for_later_button_display();

	}

	/**
	 * Create Saved shortcode.
	 *
	 * @since    1.0.0
	 * @version  1.0.6
	 */
	public function saved_for_later_shortcode() {

		// Get tooltip text
		$options = get_option( $this->plugin_name . '-settings' );
		$save = __( 'Save for Later', 'rs-save-for-later' );
		$unsave = __( 'Remove', 'rs-save-for-later' );
		$remove_all = __( 'Remove All', 'rs-save-for-later' );
		$no_content = __( 'You don’t have any saved content.', 'rs-save-for-later' );

		if ( ! empty( $options['save-text'] ) ) {
			$save = $options['save-text'];
		}
		if ( ! empty( $options['unsave-text'] ) ) {
			$unsave = $options['unsave-text'];
		}
		if ( ! empty( $options['remove-all-text'] ) ) {
			$remove_all = $options['remove-all-text'];
		}
		if ( ! empty( $options['no-content-text'] ) ) {
			$no_content = $options['no-content-text'];
		}

		// Saved objects
		$matches = array();
		if ( is_user_logged_in() ) {
			$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
		} else {
			$cookie_values = $this->get_cookie();
			foreach ( $cookie_values as $key => $value ) {
				$matches[] = $value;
			}
		}

		// Post types
		$options = get_option( $this->plugin_name . '-settings' );
		$post_types = array();

		if ( ! empty( $options['post-type'] ) ) {
			$post_types = $options['post-type'];
		}

		if ( ! empty( $matches ) ) {
			$saved_args = array(
				'post_type'      => $post_types,
				'posts_per_page' => -1,
				'post__in'       => $matches
			);
			$saved_loop = new WP_Query( $saved_args );

			if ( $saved_loop->have_posts() ) {
				echo '<ul class="rs-saved-for-later">';
				while ( $saved_loop->have_posts() ) : $saved_loop->the_post();
					echo '<li class="rs-item-saved-for-later" id="rs-item-' . esc_attr( get_the_ID() ) . '">';
						echo '<div class="rs-item-content">';
							echo '<a href="' . esc_url( get_the_permalink() ) . '">';
								$html = '';
								if ( has_post_thumbnail() ) {
									$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
									$html .= '<div class="rs-item-image" style="background-image: url(' . $thumbnail[0] . ');"></div>';
								}
								$html .= '<div class="rs-item-float">';
									$html .= '<div class="rs-item-title">' . get_the_title() . '</div>';
									$html .= '<div class="rs-item-date">' . get_the_date() . '</div>';
								$html .= '</div>';
								echo apply_filters( 'rs_saved_for_later_item_html', $html );
							echo '</a>';
							echo '<div class="rs-item-nav">';
								echo '<a href="#" class="rs-save-for-later-button saved saved-in-list" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $unsave ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later' ) . '" data-object-id="' . esc_attr( get_the_ID() ) . '"><svg width="15px" height="15px" viewBox="200 89 46 55" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs></defs><path d="M241.571429,89.7142857 C242.11905,89.7142857 242.642855,89.8214275 243.142857,90.0357143 C243.928575,90.3452396 244.553569,90.83333 245.017857,91.5 C245.482145,92.16667 245.714286,92.9047579 245.714286,93.7142857 L245.714286,139.75 C245.714286,140.559528 245.482145,141.297616 245.017857,141.964286 C244.553569,142.630956 243.928575,143.119046 243.142857,143.428571 C242.690474,143.619049 242.16667,143.714286 241.571429,143.714286 C240.428566,143.714286 239.44048,143.333337 238.607143,142.571429 L222.857143,127.428571 L207.107143,142.571429 C206.249996,143.357147 205.26191,143.75 204.142857,143.75 C203.595235,143.75 203.071431,143.642858 202.571429,143.428571 C201.78571,143.119046 201.160717,142.630956 200.696429,141.964286 C200.232141,141.297616 200,140.559528 200,139.75 L200,93.7142857 C200,92.9047579 200.232141,92.16667 200.696429,91.5 C201.160717,90.83333 201.78571,90.3452396 202.571429,90.0357143 C203.071431,89.8214275 203.595235,89.7142857 204.142857,89.7142857 L241.571429,89.7142857 Z" id="rs-bookmark-button" stroke="none" fill="#000000" fill-rule="evenodd"></path></svg></a>';
							echo '</div>';
						echo '</div>';
					echo '</li>';
				endwhile; wp_reset_postdata();
				echo '</ul>';
				echo '<button class="rs-save-for-later-remove-all" data-nonce="' . wp_create_nonce( 'rs_save_for_later_remove_all' ) . '">' . esc_html( $remove_all ) . '</button>';
			}
		} else {
			echo '<p class="nothing-saved">' . esc_html( $no_content ) . '</p>';
		}

	}

	/**
	 * Remove All
	 *
	 * @since    1.0.3
	 * @version  1.0.6
	 */
	public function save_for_later_remove_all() {

		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'rs_save_for_later_remove_all' ) ) {
			die;
		}

		$no_content = __( 'You don’t have any saved content.', 'rs-save-for-later' );
		if ( ! empty( $options['no-content-text'] ) ) {
			$no_content = $options['no-content-text'];
		}

		if ( is_user_logged_in() ) {
			$saved_items = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
			if ( ! empty( $saved_items ) ) {
				delete_user_meta( get_current_user_id(), 'rs_saved_for_later' );
			}
			$return = array(
				'user_type' => 'logged_in',
				'message'   => esc_attr( $no_content )
			);
		} else {
			$cookie = $this->set_cookie( array() );
			$return = array(
				'user_type' => 'not_logged_in',
				'cookie'    => $cookie,
				'message'   => esc_attr( $no_content )
			);
		}

		return wp_send_json( $return );

	}

}