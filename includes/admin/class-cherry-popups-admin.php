<?php
/**
 * Sets up the admin functionality for the plugin.
 *
 * @package    Cherry_Popups
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2002-2016, Cherry Team
 */

// If class `Cherry_Popups_Admin` doesn't exists yet.
if ( ! class_exists( 'Cherry_Popups_Admin' ) ) {

	/**
	 * Cherry_Popups_Admin class.
	 */
	class Cherry_Popups_Admin {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Include libraries from the `includes/admin`
			$this->includes();

			// Load the admin menu.
			add_action( 'admin_menu', array( $this, 'menu' ) );

			// Load admin stylesheets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			// Load admin JavaScripts.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Include libraries from the `includes/admin`.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function includes() {

			// Include plugin pages.
			require_once( trailingslashit( CHERRY_POPUPS_DIR ) . 'includes/admin/pages/class-plugin-main-page.php' );
			require_once( trailingslashit( CHERRY_POPUPS_DIR ) . 'includes/admin/pages/class-plugin-options-page.php' );
		}

		/**
		 * Register the admin menu.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function menu() {
			add_menu_page(
				esc_html__( 'Blank Plugin', 'blank-plugin' ),
				esc_html__( 'Blank Plugin', 'blank-plugin' ),
				'edit_theme_options',
				'blank-plugin',
				array( 'Blank_Plugin_Main_Page', 'get_instance' ),
				'',
				58
			);

			add_submenu_page(
				'blank-plugin',
				esc_html__( 'Options Example', 'blank-plugin' ),
				esc_html__( 'Options Example', 'blank-plugin' ),
				'edit_theme_options',
				'blank-plugin-options-page',
				array( 'Blank_Plugin_Options_Page', 'get_instance' )
			);
		}

		/**
		 * Enqueue admin stylesheets.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $hook The current admin page.
		 * @return void
		 */
		public function enqueue_styles( $hook ) {
			if ( Cherry_Popups_Admin::is_plugin_page() ) {
				wp_enqueue_style(
					'cherry-popups-admin-styles',
					esc_url( CHERRY_POPUPS_URI . 'assets/admin/css/min/cherry-popups-admin-styles.min.css' ),
					array(), CHERRY_POPUPS_VERSION,
					'all'
				);
			}
		}

		/**
		 * Enqueue admin JavaScripts.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $hook The current admin page.
		 * @return void
		 */
		public function enqueue_scripts( $hook ) {
			if ( Cherry_Popups_Admin::is_plugin_page() ) {
				wp_enqueue_script(
					'cherry-popups-admin-scripts',
					esc_url( CHERRY_POPUPS_URI . 'assets/admin/js/min/cherry-popups-admin-scripts.min.js' ),
					array( 'cherry-js-core' ),
					CHERRY_POPUPS_VERSION,
					true
				);
			}
		}

		/**
		 * Check current plugin page.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return bool
		 */
		public static function is_plugin_page() {
			$screen = get_current_screen();

			return ( ! empty( $screen->base ) && false !== strpos( $screen->base, CHERRY_POPUPS_SLUG ) ) ? true : false ;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}

}

if ( ! function_exists( 'cherry_popups_admin' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_popups_admin() {
		return Cherry_Popups_Admin::get_instance();
	}
}

cherry_popups_admin();
