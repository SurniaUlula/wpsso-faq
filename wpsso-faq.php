<?php
/**
 * Plugin Name: WPSSO FAQ Manager
 * Plugin Slug: wpsso-faq
 * Text Domain: wpsso-faq
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-faq/
 * Assets URI: https://surniaulula.github.io/wpsso-faq/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Manage FAQ categories with Question and Answer pages.
 * Requires At Least: 3.9
 * Tested Up To: 5.3
 * Version: 1.0.3
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 * 
 * Copyright 2016-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoFaq' ) ) {

	class WpssoFaq {

		/**
		 * Wpsso plugin class object variable.
		 */
		public $p;		// Wpsso

		/**
		 * Library class object variables.
		 */
		public $filters;	// WpssoFaqFilters
		public $reg;		// WpssoFaqRegister

		/**
		 * Reference Variables (config, options, modules, etc.).
		 */
		private $have_req_min = true;	// Have minimum wpsso version.

		private static $instance;

		public function __construct() {

			require_once dirname( __FILE__ ) . '/lib/config.php';

			WpssoFaqConfig::set_constants( __FILE__ );

			WpssoFaqConfig::require_libs( __FILE__ );	// Includes the register.php class library.

			$this->reg = new WpssoFaqRegister();		// Activate, deactivate, uninstall hooks.

			if ( is_admin() ) {
				add_action( 'admin_init', array( __CLASS__, 'required_check' ) );
			}

			/**
			 * Add WPSSO filter hooks.
			 */
			add_filter( 'wpsso_get_config', array( $this, 'wpsso_get_config' ), 10, 2 );	// Checks core version and merges config array.
			add_filter( 'wpsso_get_avail', array( $this, 'wpsso_get_avail' ), 10, 1 );

			/**
			 * Add WPSSO action hooks.
			 */
			add_action( 'wpsso_init_textdomain', array( __CLASS__, 'wpsso_init_textdomain' ) );
			add_action( 'wpsso_init_options', array( $this, 'wpsso_init_options' ), 10 );	// Sets the $this->p reference variable.
			add_action( 'wpsso_init_objects', array( $this, 'wpsso_init_objects' ), 10 );
			add_action( 'wpsso_init_plugin', array( $this, 'wpsso_init_plugin' ), 10 );
		}

		public static function &get_instance() {

			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public static function required_check() {

			if ( ! class_exists( 'Wpsso' ) ) {
				add_action( 'all_admin_notices', array( __CLASS__, 'required_notice' ) );
			}
		}

		public static function required_notice() {

			self::wpsso_init_textdomain();

			$info = WpssoFaqConfig::$cf[ 'plugin' ][ 'wpssofaq' ];

			$error_msg = __( 'The %1$s add-on requires the %2$s plugin &mdash; install and activate the %3$s plugin or <a href="%4$s">deactivate the %5$s add-on</a>.', 'wpsso-faq' );

			$deactivate_url = html_entity_decode( wp_nonce_url( add_query_arg( array(
				'action'        => 'deactivate',
				'plugin'        => $info[ 'base' ],
				'plugin_status' => 'all',
				'paged'         => 1,
				's'             => '',
			), admin_url( 'plugins.php' ) ), 'deactivate-plugin_' . $info[ 'base' ] ) );

			echo '<div class="notice notice-error error"><p>';
			echo sprintf( $error_msg, $info[ 'name' ], $info[ 'req' ][ 'name' ], $info[ 'req' ][ 'short' ], $deactivate_url, $info[ 'short' ] );
			echo '</p></div>';
		}

		public static function wpsso_init_textdomain() {

			load_plugin_textdomain( 'wpsso-faq', false, 'wpsso-faq/languages/' );
		}

		/**
		 * Checks the core plugin version and merges the extension / add-on config array.
		 */
		public function wpsso_get_config( $cf, $plugin_version = 0 ) {

			$info = WpssoFaqConfig::$cf[ 'plugin' ][ 'wpssofaq' ];

			if ( version_compare( $plugin_version, $info[ 'req' ][ 'min_version' ], '<' ) ) {

				$this->have_req_min = false;

				return $cf;
			}

			return SucomUtil::array_merge_recursive_distinct( $cf, WpssoFaqConfig::$cf );
		}

		public function wpsso_get_avail( $avail ) {

			if ( ! $this->have_req_min ) {

				$avail[ 'p_ext' ][ 'faq' ] = false;	// Signal that this extension / add-on is not available.

				return $avail;
			}

			$avail[ 'p_ext' ][ 'faq' ] = true;		// Signal that this extension / add-on is available.

			return $avail;
		}

		/**
		 * Sets the $this->p reference variable for the core plugin instance.
		 */
		public function wpsso_init_options() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}
		}

		public function wpsso_init_objects() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {
				return;	// Stop here.
			}

			$this->filters = new WpssoFaqFilters( $this->p );
		}

		public function wpsso_init_plugin() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->have_req_min ) {

				$this->min_version_notice();

				return;	// Stop here.
			}
		}

		private function min_version_notice() {

			if ( ! is_admin() ) {
				return;
			}

			$info = WpssoFaqConfig::$cf[ 'plugin' ][ 'wpssofaq' ];

			$error_msg = sprintf( __( 'The %1$s version %2$s add-on requires %3$s version %4$s or newer (version %5$s is currently installed).',
				'wpsso-faq' ), $info[ 'name' ], $info[ 'version' ], $info[ 'req' ][ 'short' ], $info[ 'req' ][ 'min_version' ],
					$this->p->cf[ 'plugin' ][ 'wpsso' ][ 'version' ] );

			$this->p->notice->err( $error_msg );

			if ( method_exists( $this->p->admin, 'get_check_for_updates_link' ) ) {

				$update_msg = $this->p->admin->get_check_for_updates_link();

				if ( ! empty( $update_msg ) ) {
					$this->p->notice->inf( $update_msg );
				}
			}
		}
	}

        global $wpssofaq;

	$wpssofaq =& WpssoFaq::get_instance();
}