<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://comocreative.com
 * @since      1.0.0
 *
 * @package    Como_Consult
 * @subpackage Como_Consult/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Como_Consult
 * @subpackage Como_Consult/public
 *
 */
class Como_Consult_Template_Functions {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

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
	 * @param      string    $version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		self::$_this = $this;

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	} // __construct()

	/**
	 * Includes the como-consult-formpage-title template
	 *
	 * @hooked 		como-consult-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_formpage_title( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-formpage-title' );
	} // content_formpage_title()

	/**
	 * Includes the employee name template file
	 *
	 * @hooked 		como-consult-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_formpage_questions( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-formpage-questions' );
	} // content_formpage_location()

	/**
	 * Includes the link end template file
	 *
	 * @hooked 		como-consult-after-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_link_end( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-content-link-end' );
	} // content_link_end()

	/**
	 * Includes the link start template file
	 *
	 * @hooked 		como-consult-before-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_link_start( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-content-link-start' );
	} // content_link_start()

	/**
	 * Includes the content wrap end template file
	 *
	 * @hooked 		como-consult-after-loop-content 		90
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_wrap_end( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-content-wrap-end' );
	} // content_wrap_end()

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		como-consult-before-loop-content 		10
	 */
	public function content_wrap_start( $item ) {
		include Como_Consult_get_template( 'como-consult-content-wrap-start' );
	} // content_wrap_start()

	/**
	 * Includes the single formpage post metadata for the page intro
	 *
	 * @hooked 		como-consult-loop-content	50
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_formpage_intro( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-formpage-intro' );
	} // formpage_intro()	
	
	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		The post ID
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images()

	/**
	 * Includes the list wrap end template file
	 *
	 * @hooked 		como-consult-after-loop 		10
	 */
	public function form_wrap_end() {
		include Como_Consult_get_template( 'como-consult-modal-end' );
	} // form_wrap_end()

	/**
	 * Includes the list wrap start template file
	 *
	 * @hooked 		como-consult-before-loop 		10
	 */
	public function form_wrap_start( $postID ) {
		include Como_Consult_get_template( 'como-consult-modal-start' );
	} // form_wrap_start()
	
	/**
	 * Includes the como-consult-fixed-formpage-title template
	 *
	 * @hooked 		como-consult-fixed-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_fixed_formpage_title( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-fixed-formpage-title' );
	} // content_fixed_formpage_title()

	/**
	 * Includes the employee name template file
	 *
	 * @hooked 		como-consult-fixed-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_fixed_formpage_questions( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-fixed-formpage-questions' );
	} // content_fixed_formpage_location()

	/**
	 * Includes the link end template file
	 *
	 * @hooked 		como-consult-fixed-after-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_fixed_link_end( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-fixed-content-link-end' );
	} // content_fixed_link_end()

	/**
	 * Includes the link start template file
	 *
	 * @hooked 		como-consult-fixed-before-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_fixed_link_start( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-fixed-content-link-start' );
	} // content_fixed_link_start()

	/**
	 * Includes the content wrap end template file
	 *
	 * @hooked 		como-consult-fixed-after-loop-content 		90
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_fixed_wrap_end( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-fixed-content-wrap-end' );
	} // content_fixed_wrap_end()

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		como-consult-fixed-before-loop-content 		10
	 */
	public function content_fixed_wrap_start( $item ) {
		include Como_Consult_get_template( 'como-consult-fixed-content-wrap-start' );
	} // content_fixed_wrap_start()

	/**
	 * Includes the single formpage post metadata for the page intro
	 *
	 * @hooked 		como-consult-fixed-loop-content	50
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_fixed_formpage_intro( $item, $meta ) {
		include Como_Consult_get_template( 'como-consult-fixed-formpage-intro' );
	} // formpage_intro()	
	
	/**
	 * Includes the list wrap end template file
	 *
	 * @hooked 		como-consult-fixed-after-loop 		10
	 */
	public function form_fixed_wrap_end() {
		include Como_Consult_get_template( 'como-consult-fixed-modal-end' );
	} // form_fixed_wrap_end()

	/**
	 * Includes the list wrap start template file
	 *
	 * @hooked 		como-consult-fixed-before-loop 		10
	 */
	public function form_fixed_wrap_start( $postID ) {
		include Como_Consult_get_template( 'como-consult-fixed-modal-start' );
	} // form_fixed_wrap_start()			

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared using an object of this class.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

} // class