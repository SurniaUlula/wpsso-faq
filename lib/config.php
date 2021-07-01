<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2019-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoFaqConfig' ) ) {

	class WpssoFaqConfig {

		public static $cf = array(
			'plugin' => array(
				'wpssofaq' => array(			// Plugin acronym.
					'version'     => '3.10.1',	// Plugin version.
					'opt_version' => '9',		// Increment when changing default option values.
					'short'       => 'WPSSO FAQ',	// Short plugin name.
					'name'        => 'WPSSO FAQ Manager',
					'desc'        => 'Create FAQ and Question / Answer Pages with optional shortcodes to include FAQs and Questions / Answers in your content.',
					'slug'        => 'wpsso-faq',
					'base'        => 'wpsso-faq/wpsso-faq.php',
					'update_auth' => '',		// No premium version.
					'text_domain' => 'wpsso-faq',
					'domain_path' => '/languages',

					/**
					 * Required plugin and its version.
					 */
					'req' => array(
						'wpsso' => array(
							'name'          => 'WPSSO Core',
							'home'          => 'https://wordpress.org/plugins/wpsso/',
							'plugin_class'  => 'Wpsso',
							'version_const' => 'WPSSO_VERSION',
							'min_version'   => '8.34.0',
						),
					),

					/**
					 * URLs or relative paths to plugin banners and icons.
					 *
					 * Icon image array keys are '1x' and '2x'.
					 */
					'assets' => array(
						'icons' => array(
							'1x' => 'images/icon-128x128.png',
							'2x' => 'images/icon-256x256.png',
						),
					),

					/**
					 * Library files loaded and instantiated by WPSSO.
					 */
					'lib' => array(
						'shortcode' => array(
							'faq'      => 'FAQ Shortcode',
							'question' => 'Question Shortcode',
						),
						'submenu' => array(
							'faq-general' => 'FAQ Settings',
						),
					),
				),
			),

			/**
			 * Additional add-on setting options.
			 */
			'opt' => array(
				'defaults' => array(
					'faq_heading'          => 'h2',
					'faq_question_heading' => 'h3',
					'faq_answer_format'    => 'excerpt',	// Question Shortcode Answer Format.
					'faq_answer_toggle'    => 0,		// Clicking a Question Shows its Answer.
					'faq_public_disabled'  => 0,		// Disable FAQ and Question URLs.
				),
			),
			'form' => array(
				'html_headings' => array(
					'h1' => 'Heading 1',
					'h2' => 'Heading 2',
					'h3' => 'Heading 3',
					'h4' => 'Heading 4',
					'h5' => 'Heading 5',
					'h6' => 'Heading 6',
				),
			),
		);

		public static function get_version( $add_slug = false ) {

			$info =& self::$cf[ 'plugin' ][ 'wpssofaq' ];

			return $add_slug ? $info[ 'slug' ] . '-' . $info[ 'version' ] : $info[ 'version' ];
		}

		public static function set_constants( $plugin_file ) {

			if ( defined( 'WPSSOFAQ_VERSION' ) ) {	// Define constants only once.

				return;
			}

			$info =& self::$cf[ 'plugin' ][ 'wpssofaq' ];

			/**
			 * Define fixed constants.
			 */
			define( 'WPSSOFAQ_FILEPATH', $plugin_file );
			define( 'WPSSOFAQ_PLUGINBASE', $info[ 'base' ] );	// Example: wpsso-faq/wpsso-faq.php.
			define( 'WPSSOFAQ_PLUGINDIR', trailingslashit( realpath( dirname( $plugin_file ) ) ) );
			define( 'WPSSOFAQ_PLUGINSLUG', $info[ 'slug' ] );	// Example: wpsso-faq.
			define( 'WPSSOFAQ_URLPATH', trailingslashit( plugins_url( '', $plugin_file ) ) );
			define( 'WPSSOFAQ_VERSION', $info[ 'version' ] );

			define( 'WPSSOFAQ_CATEGORY_TAXONOMY', 'faq_category' );
			define( 'WPSSOFAQ_QUESTION_POST_TYPE', 'question' );

			/**
			 * Define variable constants.
			 */
			self::set_variable_constants();
		}

		public static function set_variable_constants( $var_const = null ) {

			if ( ! is_array( $var_const ) ) {

				$var_const = (array) self::get_variable_constants();
			}

			/**
			 * Define the variable constants, if not already defined.
			 */
			foreach ( $var_const as $name => $value ) {

				if ( ! defined( $name ) ) {

					define( $name, $value );
				}
			}
		}

		public static function get_variable_constants() {

			$var_const = array();

			$var_const[ 'WPSSOFAQ_FAQ_SHORTCODE_NAME' ]      = 'faq';
			$var_const[ 'WPSSOFAQ_QUESTION_SHORTCODE_NAME' ] = 'question';

			/**
			 * Maybe override the default constant value with a pre-defined constant value.
			 */
			foreach ( $var_const as $name => $value ) {

				if ( defined( $name ) ) {

					$var_const[$name] = constant( $name );
				}
			}

			return $var_const;
		}

		public static function require_libs( $plugin_file ) {

			require_once WPSSOFAQ_PLUGINDIR . 'lib/filters.php';
			require_once WPSSOFAQ_PLUGINDIR . 'lib/post.php';
			require_once WPSSOFAQ_PLUGINDIR . 'lib/register.php';
			require_once WPSSOFAQ_PLUGINDIR . 'lib/style.php';
			require_once WPSSOFAQ_PLUGINDIR . 'lib/term.php';

			add_filter( 'wpssofaq_load_lib', array( 'WpssoFaqConfig', 'load_lib' ), 10, 3 );
		}

		public static function load_lib( $success = false, $filespec = '', $classname = '' ) {

			if ( false === $success && ! empty( $filespec ) ) {

				$file_path = WPSSOFAQ_PLUGINDIR . 'lib/' . $filespec . '.php';

				if ( file_exists( $file_path ) ) {

					require_once $file_path;

					if ( empty( $classname ) ) {

						return SucomUtil::sanitize_classname( 'wpssofaq' . $filespec, $allow_underscore = false );

					}

					return $classname;
				}
			}

			return $success;
		}
	}
}
