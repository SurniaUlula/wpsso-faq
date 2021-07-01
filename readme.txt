=== WPSSO FAQ Manager ===
Plugin Name: WPSSO FAQ Manager
Plugin Slug: wpsso-faq
Text Domain: wpsso-faq
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-faq/assets/
Tags: faq, faqpage, question, shortcode, schema, schema.org, answer, google, rich results, faqs, faq page
Contributors: jsmoriss
Requires PHP: 7.0
Requires At Least: 5.0
Tested Up To: 5.7.2
Stable Tag: 3.10.1

Create FAQ and Question / Answer Pages with optional shortcodes to include FAQs and Questions / Answers in your content.

== Description ==

<p><img class="readme-icon" src="https://surniaulula.github.io/wpsso-faq/assets/icon-256x256.png"> The WPSSO FAQ Manager allows you to easily manage Questions / Answers from a standard WordPress Question editing page. You can also categorize your Questions / Answers into FAQ categories, just like standard WordPress Posts.</p>

Use the standard WordPress FAQ category archive and question pages, and/or use `[faq]` and `[question]` shortcode(s) in your Post / Page content -- both will automatically reflect any change your make to your Questions / Answers or FAQ categories (ie. adding / removing questions, updating answers, etc.).

**Optional:**

If you need **Schema FAQPage** markup for the FAQ shortcode or FAQ categories you create, you will also need the [WPSSO Schema JSON-LD Markup add-on](https://wordpress.org/plugins/wpsso-schema-json-ld/) to generate the Schema FAQPage markup. The WPSSO FAQ Manager add-on manages Question / Answer pages and FAQ categories - it does not create Schema markup or meta tags.

**Optional:**

If you need to adjust the default FAQ category archive page layout, see the [WordPress Theme Handbook &gt; Custom Taxonomy section](https://developer.wordpress.org/themes/template-files-section/taxonomy-templates/#custom-taxonomy) for details on creating a new FAQ category archive page template based on your current theme archive page template.

<h3>WPSSO Core Required</h3>

WPSSO FAQ Manager (WPSSO FAQ) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/).

== Installation ==

<h3 class="top">Install and Uninstall</h3>

* [Install the WPSSO FAQ Manager add-on](https://wpsso.com/docs/plugins/wpsso-faq/installation/install-the-plugin/).
* [Uninstall the WPSSO FAQ Manager add-on](https://wpsso.com/docs/plugins/wpsso-faq/installation/uninstall-the-plugin/).

== Frequently Asked Questions ==

<h3 class="top">Frequently Asked Questions</h3>

* [How are questions sorted in the FAQ shortcode?](https://wpsso.com/docs/plugins/wpsso-faq/faqs/how-are-questions-sorted-in-the-faq-shortcode/)
* [How do I create a Schema FAQPage?](https://wpsso.com/docs/plugins/wpsso-faq/faqs/how-do-i-create-a-schema-faqpage/)

<h3>Notes and Documentation</h3>

* The [FAQ Shortcode](https://wpsso.com/docs/plugins/wpsso-faq/notes/faq-shortcode/)
* The [Question Shortcode](https://wpsso.com/docs/plugins/wpsso-faq/notes/question-shortcode/)

== Screenshots ==

01. The FAQs menu allows you to manage individual FAQs and their categories.
02. The FAQ editing page allows you to create and edit individual FAQs.

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-faq/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-faq/)

<h3>Changelog / Release Notes</h3>

**Version 3.10.1 (2021/06/16)**

* **New Features**
	* None.
* **Improvements**
	* Minor update for FAQ Manager settings page translation strings.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v5.0.
	* WPSSO Core v8.34.0.

**Version 3.10.0 (2021/05/15)**

* **New Features**
	* None.
* **Improvements**
	* Added new options in the SSO &gt; FAQ Settings page:
		* FAQ Shortcode Title Heading
		* Question Shortcode Title Heading
	* Added new 'heading' and 'title' shortcode attributes:
		* See the [FAQ shortcode documentation](https://wpsso.com/docs/plugins/wpsso-faq/notes/faq-shortcode/).
		* See the [Question shortcode documentation](https://wpsso.com/docs/plugins/wpsso-faq/notes/question-shortcode/).
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.28.2.

**Version 3.9.1 (2021/02/25)**

* **New Features**
	* None.
* **Improvements**
	* Updated the banners and icons of WPSSO Core and its add-ons.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.25.2.

**Version 3.9.0 (2020/12/11)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Updated the `get_posts_mods()` module object call for WPSSO Core v8.17.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.17.0.

**Version 3.8.0 (2020/12/02)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Included the `$addon` argument for library class constructors.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.5.
	* WPSSO Core v8.16.0.

**Version 3.7.1 (2020/10/17)**

* **New Features**
	* None.
* **Improvements**
	* Refactored the add-on class to extend a new WpssoAddOn abstract class.
* **Bugfixes**
	* Fixed backwards compatibility with older 'init_objects' and 'init_plugin' action arguments.
* **Developer Notes**
	* Added a new WpssoAddOn class in lib/abstracts/add-on.php.
	* Added a new SucomAddOn class in lib/abstracts/com/add-on.php.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.4.
	* WPSSO Core v8.13.0.

== Upgrade Notice ==

= 3.10.1 =

(2021/06/16) Minor update for FAQ Manager settings page translation strings.

= 3.10.0 =

(2021/05/15) Added new options in the SSO &gt; FAQ Settings page. Added new 'heading' and 'title' shortcode attributes.

= 3.9.1 =

(2021/02/25) Updated the banners and icons of WPSSO Core and its add-ons.

= 3.9.0 =

(2020/12/11) Updated the `get_posts_mods()` module object call for WPSSO Core v8.17.0.

= 3.8.0 =

(2020/12/02) Included the `$addon` argument for library class constructors.

= 3.7.1 =

(2020/10/17) Refactored the add-on class to extend a new WpssoAddOn abstract class.

