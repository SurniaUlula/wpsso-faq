<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoFaqFiltersMessages' ) ) {

	class WpssoFaqFiltersMessages {

		private $p;	// Wpsso class object.
		private $a;	// WpssoFaq class object.

		/**
		 * Instantiated by WpssoFaqFilters->__construct().
		 */
		public function __construct( &$plugin, &$addon ) {

			$this->p =& $plugin;
			$this->a =& $addon;

			$this->p->util->add_plugin_filters( $this, array( 
				'messages_tooltip' => 2,
			) );
		}

		public function filter_messages_tooltip( $text, $msg_key ) {

			if ( strpos( $msg_key, 'tooltip-faq_' ) !== 0 ) {

				return $text;
			}

			switch ( $msg_key ) {

				case 'tooltip-faq_heading':		// FAQ Shortcode Title Heading.

					$text = __( 'Select an HTML heading level for the FAQ category shortcode title.', 'wpsso-faq' );

					break;

				case 'tooltip-faq_question_heading':	// Question Shortcode Title Heading.

					$text = __( 'Select an HTML heading level for the question shortcode title.', 'wpsso-faq' );

					break;

				case 'tooltip-faq_answer_format':	// Question Shortcode Answer Format.

					$text = __( 'Select the type of answer text to include under the question title.', 'wpsso-faq' );

					break;

				case 'tooltip-faq_answer_toggle':	// Clicking a Question Shows its Answer.

					$text = __( 'Hide the answer text by default and show when the question title is clicked.', 'wpsso-faq' );

					break;
				case 'tooltip-faq_public_disabled':	// Disable FAQ and Question URLs.

					$text = __( 'The FAQ and question pages have publicly accessible URLs by default.', 'wpsso-faq' ) . ' ';

					$text .= __( 'If you enable this option, the FAQs and questions will only be accessible by using their shortcodes.', 'wpsso-faq' );

					break;
			}

			return $text;
		}
	}
}
