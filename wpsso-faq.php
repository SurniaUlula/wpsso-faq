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
 * Description: Create FAQ and Question / Answer Pages with optional shortcodes to include FAQs and Questions / Answers in your content.
 * Requires PHP: 7.0
 * Requires At Least: 5.0
 * Tested Up To: 5.7.2
 * Version: 3.10.1
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 * 
 * Copyright 2019-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstracts/add-on.php';	// WpssoAddOn class.
}

if ( ! class_exists( 'WpssoFaq' ) ) {

	class WpssoFaq extends WpssoAddOn {

		public $filters;	// WpssoFaqFilters class object.
		public $post;		// WpssoFaqPost class object.
		public $style;		// WpssoFaqStyle class object.
		public $term;		// WpssoFaqTerm class object.

		protected $p;	// Wpsso class object.

		private static $instance = null;	// WpssoFaq class object.

		public function __construct() {

			parent::__construct( __FILE__, __CLASS__ );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain() {

			load_plugin_textdomain( 'wpsso-faq', false, 'wpsso-faq/languages/' );
		}

		/**
		 * $is_admin, $doing_ajax, and $doing_cron available since WPSSO Core v8.8.0.
		 */
		public function init_objects( $is_admin = false, $doing_ajax = false, $doing_cron = false ) {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return;	// Stop here.
			}

			$this->filters = new WpssoFaqFilters( $this->p, $this );
			$this->post    = new WpssoFaqPost( $this->p, $this );
			$this->style   = new WpssoFaqStyle( $this->p, $this );
			$this->term    = new WpssoFaqTerm( $this->p, $this );
		}
	}

        global $wpssofaq;

	$wpssofaq =& WpssoFaq::get_instance();
}
