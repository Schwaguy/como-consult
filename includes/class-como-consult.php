<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link 		https://comocreative.com
 * @since 		1.0.0
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 		1.0.0
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/includes
 * @author 		Como Creative LLC <chris@Como Creative LLC.com>
 */
class Como_Consult {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		Como_Consult_Loader 		$loader 		Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$plugin_name 		The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Sanitizer for cleaning user input
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Como_Consult_Sanitize    $sanitizer    Sanitizes data
	 */
	private $sanitizer;

	/**
	 * The current version of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$version 		The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'como-consult';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_template_hooks();

		//$this->define_shared_hooks();

		$this->define_widget_hooks();
		$this->define_metabox_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Como_Consult_Loader. Orchestrates the hooks of the plugin.
	 * - Como_Consult_i18n. Defines internationalization functionality.
	 * - Como_Consult_Admin. Defines all hooks for the dashboard.
	 * - Como_Consult_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-como-consult-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-como-consult-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-como-consult-admin.php';

		/**
		 * The class responsible for defining all actions relating to metaboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-como-consult-admin-metaboxes.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-como-consult-public.php';

		/**
		 * The class responsible for defining all actions creating the templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-como-consult-template-functions.php';

		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/como-consult-global-functions.php';

		/**
		 * The class responsible for defining all actions shared by the Dashboard and public-facing sides.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-como-consult-shared.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-como-consult-widget.php';

		/**
		 * The class responsible for sanitizing user input
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-como-consult-sanitize.php';

		$this->loader = new Como_Consult_Loader();
		$this->sanitizer = new Como_Consult_Sanitize();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Como_Consult_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function set_locale() {

		$plugin_i18n = new Como_Consult_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Como_Consult_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_cpt_formpage' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_taxonomy_type' );
		$this->loader->add_filter( 'plugin_action_links_' . COMO_MERCHANTS_FILE, $plugin_admin, 'link_settings' );
		$this->loader->add_action( 'plugin_row_meta', $plugin_admin, 'link_row', 10, 2 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_sections' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_fields' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'display_admin_notices' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_notices_init' );

	} // define_admin_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_public_hooks() {

		$plugin_public = new Como_Consult_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', $this->get_version(), TRUE );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', $this->get_version(), TRUE );
		$this->loader->add_filter( 'single_template', $plugin_public, 'single_cpt_template' );

		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );

		/**
		 * Action instead of template tag.
		 *
		 * do_action( 'Como_Consult' );
		 *
		 * @link 	http://nacin.com/2010/05/18/rethinking-template-tags-in-plugins/
		 */
		$this->loader->add_action( 'consult-form', $plugin_public, 'form_consult' );
		$this->loader->add_action( 'consult-single', $plugin_public, 'consult_single' );


	} // define_public_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new Como_Consult_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		// Loop
		$this->loader->add_action( 'como-consult-before-loop', $plugin_templates, 'form_wrap_start', 10 );
		$this->loader->add_action( 'como-consult-before-loop-content', $plugin_templates, 'content_wrap_start', 10, 2 );
		$this->loader->add_action( 'como-consult-loop-content', $plugin_templates, 'content_formpage_title', 10, 2 );
		$this->loader->add_action( 'como-consult-loop-content', $plugin_templates, 'content_formpage_intro', 10, 2 );
		$this->loader->add_action( 'como-consult-loop-content', $plugin_templates, 'content_formpage_questions', 10, 2 );
		$this->loader->add_action( 'como-consult-after-loop-content', $plugin_templates, 'content_wrap_end', 90, 2 );
		$this->loader->add_action( 'como-consult-after-loop', $plugin_templates, 'form_wrap_end', 10 );

		// Loop Fixed
		//$this->loader->add_action( 'como-consult-fixed-before-loop', $plugin_templates, 'form_fixed_wrap_start', 10 );
		//$this->loader->add_action( 'como-consult-fixed-before-loop-content', $plugin_templates, 'content_fixed_wrap_start', 10, 2 );
		//$this->loader->add_action( 'como-consult-fixed-loop-content', $plugin_templates, 'content_fixed_formpage_title', 10, 2 );
		//$this->loader->add_action( 'como-consult-fixed-loop-content', $plugin_templates, 'content_fixed_formpage_intro', 10, 2 );
		//$this->loader->add_action( 'como-consult-fixed-loop-content', $plugin_templates, 'content_fixed_formpage_questions', 10, 2 );
		//$this->loader->add_action( 'como-consult-fixed-after-loop-content', $plugin_templates, 'content_fixed_wrap_end', 90, 2 );
		//$this->loader->add_action( 'como-consult-fixed-after-loop', $plugin_templates, 'form_fixed_wrap_end', 10 );
		
	} // define_template_hooks()

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_shared_hooks() {

		$plugin_shared = new Como_Consult_Shared( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'widgets_init', $plugin_shared, 'widgets_init' );
		$this->loader->add_action( 'save_post_formpage', $plugin_shared, 'flush_widget_cache' );
		$this->loader->add_action( 'deleted_post', $plugin_shared, 'flush_widget_cache' );
		$this->loader->add_action( 'switch_theme', $plugin_shared, 'flush_widget_cache' );

	} // define_shared_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$plugin_metaboxes = new Como_Consult_Admin_Metaboxes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes', $plugin_metaboxes, 'add_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes_formpage', $plugin_metaboxes, 'set_meta' );
		$this->loader->add_action( 'save_post_formpage', $plugin_metaboxes, 'validate_meta', 10, 2 );

	} // define_metabox_hooks()

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 		1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 		1.0.0
	 * @return 		string 					The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 		1.0.0
	 * @return 		Como_Consult_Loader 		Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since 		1.0.0
	 * @return 		string 					The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}




	// Option 2

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_widget_hooks() {

		$this->loader->add_action( 'widgets_init', $this, 'widgets_init' );
		$this->loader->add_action( 'save_post_formpage', $this, 'flush_widget_cache' );
		$this->loader->add_action( 'deleted_post', $this, 'flush_widget_cache' );
		$this->loader->add_action( 'switch_theme', $this, 'flush_widget_cache' );

	}



	/**
	 * Flushes widget cache
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		int 		$post_id 		The post ID
	 * @return 		void
	 */
	public function flush_widget_cache( $post_id ) {

		if ( wp_is_post_revision( $post_id ) ) { return; }

		$post = get_post( $post_id );

		/*if ( 'formpage' == $post->post_type ) {

			wp_cache_delete( $this->plugin_name, 'widget' );

		}*/

	}



	/**
	 * Registers widgets with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function widgets_init() {

		register_widget( 'Como_Consult_widget' );

	} // widgets_init()

}
