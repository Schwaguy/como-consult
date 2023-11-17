<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link 		https://comocreative.com
 * @since 		1.0.0
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/public
 * @author 		Como Creative LLC <chris@Como Creative LLC.com>
 */
class Como_Consult_Public {

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Como_Consult 		The name of the plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/como-consult-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/como-consult-public-combined.min.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Processes shortcode consult-single
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function consult_single() {

		if ( empty( $this->options['consult-single'] ) ) { return; }

		ob_start();

		include Como_Consult_get_template( 'como-consult-single' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // consult_single()

	/**
	 * Processes shortcode consult-form
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function form_consult( $atts = array() ) {

		ob_start();

		$defaults['loop-template'] 	= $this->plugin_name . '-loop';
		$defaults['orderby'] 		= 'menu_order';
		$defaults['order'] 			= 'ASC';
		$defaults['quantity'] 		= 200;
		$args						= shortcode_atts( $defaults, $atts, 'consult-form' );
		$shared 					= new Como_Consult_Shared( $this->plugin_name, $this->version );
		$items 						= $shared->get_consult( $args );
	
		if ( is_array( $items ) || is_object( $items ) ) {
			include Como_Consult_get_template($args['loop-template']);
		} else {
			echo $items;
		}

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // form_consult()

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'consult-form', array( $this, 'form_consult' ) );
		add_shortcode( 'consult-single', array( $this, 'consult_single' ) );

	} // register_shortcodes()

	/**
	 * Adds a default single view template for a formpage
	 *
	 * @param 	string 		$template 		The name of the template
	 * @return 	mixed 						The single template
	 */
	public function single_cpt_template( $template ) {

		global $post;

		$return = $template;

	    if ( $post->post_type == 'formpage' ) {

			$return = Como_Consult_get_template( 'single-formpage' );

		}

		return $return;

	} // single_cpt_template()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()

} // class
