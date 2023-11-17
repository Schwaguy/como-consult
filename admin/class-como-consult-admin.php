<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link 		https://comocreative.com
 * @since 		1.0.0
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/admin
 * @author 		Como Creative LLC <chris@Como Creative LLC.com>
 */
class Como_Consult_Admin {

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
	 * @param 		string 			$Como_Consult 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();

	}

	/**
     * Adds notices for the admin to display.
     * Saves them in a temporary plugin option.
     * This method is called on plugin activation, so its needs to be static.
     */
    public static function add_admin_notices() {

    	$notices 	= get_option( 'Como_Consult_deferred_admin_notices', array() );
  		//$notices[] 	= array( 'class' => 'updated', 'notice' => esc_html__( 'Como Consult: Custom Activation Message', 'como-consult' ) );
  		//$notices[] 	= array( 'class' => 'error', 'notice' => esc_html__( 'Como Consult: Problem Activation Message', 'como-consult' ) );

  		apply_filters( 'Como_Consult_admin_notices', $notices );
  		update_option( 'Como_Consult_deferred_admin_notices', $notices );

    } // add_admin_notices

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

		add_submenu_page(
			'edit.php?post_type=formpage',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Como Consult Settings', 'como-consult' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'como-consult' ) ),
			'manage_options',
			$this->plugin_name . '-settings',
			array( $this, 'page_options' )
		);

		/*add_submenu_page(
			'edit.php?post_type=formpage',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Como Consult Help', 'como-consult' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Help', 'como-consult' ) ),
			'manage_options',
			$this->plugin_name . '-help',
			array( $this, 'page_help' )
		);*/

	} // add_menu()

	/**
     * Manages any updates or upgrades needed before displaying notices.
     * Checks plugin version against version required for displaying
     * notices.
     */
	public function admin_notices_init() {

		$current_version = '1.0.0';

		if ( $this->version !== $current_version ) {

			// Do whatever upgrades needed here.

			update_option('my_plugin_version', $current_version);

			$this->add_notice();

		}

	} // admin_notices_init()

	/**
	 * Displays admin notices
	 *
	 * @return 	string 			Admin notices
	 */
	public function display_admin_notices() {

		$notices = get_option( 'Como_Consult_deferred_admin_notices' );

		if ( empty( $notices ) ) { return; }

		foreach ( $notices as $notice ) {

			echo '<div class="' . esc_attr( $notice['class'] ) . '"><p>' . $notice['notice'] . '</p></div>';

		}

		delete_option( 'Como_Consult_deferred_admin_notices' );

    } // display_admin_notices()

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/como-consult-admin.css', array(), $this->version, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

		global $post_type;

		$screen = get_current_screen();

		if ( 'formpage' === $post_type || $screen->id === $hook_suffix ) {

			//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/' . 'como-admin-image-uploader.min.js', array( 'jquery' ), $this->version, true );
			//wp_enqueue_script( $this->plugin_name . '-repeater', plugin_dir_url( __FILE__ ) . 'js/' . 'como-admin-repeater.min.js', array( 'jquery' ), $this->version, true );
			//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/' . 'como-consult-fieldOptions.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/' . 'como-consult-admin.min.js', array( 'jquery' ), $this->version, true );
			
			wp_enqueue_script( 'jquery-ui-datepicker' );

			$localize['repeatertitle'] = __( 'File Name', 'como-consult' );

			wp_localize_script( 'como-consult', 'nhdata', $localize );
			
			wp_enqueue_media();
		}

	} // enqueue_scripts()

	/**
	 * Creates a checkbox field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_checkbox( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		apply_filters( $this->plugin_name . '-field-checkbox-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-checkbox.php' );

	} // field_checkbox()

	/**
	 * Creates an editor field
	 *
	 * NOTE: ID must only be lowercase letter, no spaces, dashes, or underscores.
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_editor( $args ) {

		$defaults['description'] 	= '';
		$defaults['settings'] 		= array( 'textarea_name' => $this->plugin_name . '-options[' . $args['id'] . ']' );
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-editor-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-editor.php' );

	} // field_editor()

	/**
	 * Creates a set of radios field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_radios( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		apply_filters( $this->plugin_name . '-field-radios-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-radios.php' );

	} // field_radios()

	public function field_repeater( $args ) {

		$defaults['class'] 			= 'repeater';
		$defaults['fields'] 		= array();
		$defaults['id'] 			= '';
		$defaults['label-add'] 		= 'Add Item';
		$defaults['label-edit'] 	= 'Edit Item';
		$defaults['label-header'] 	= 'Item Name';
		$defaults['label-remove'] 	= 'Remove Item';
		$defaults['title-field'] 	= '';

/*
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
*/
		apply_filters( $this->plugin_name . '-field-repeater-options-defaults', $defaults );

		$setatts 	= wp_parse_args( $args, $defaults );
		$count 		= 1;
		$repeater 	= array();

		if ( ! empty( $this->options[$setatts['id']] ) ) {

			$repeater = maybe_unserialize( $this->options[$setatts['id']][0] );

		}

		if ( ! empty( $repeater ) ) {

			$count = count( $repeater );

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-repeater.php' );

	} // field_repeater()

	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {

		$defaults['aria'] 			= '';
		$defaults['blank'] 			= '';
		$defaults['class'] 			= 'widefat';
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-select-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

			$atts['aria'] = $atts['description'];

		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

			$atts['aria'] = $atts['label'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-select.php' );

	} // field_select()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {

		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-text.php' );

	} // field_text()
	
	/**
	 * Creates a Number field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_number( $args ) {

		$defaults['class'] 			= 'number widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'number';
		$defaults['min'] 			= '';
		$defaults['max'] 			= '';
		$defaults['step'] 			= '';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-number-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-number.php' );

	} // field_number()

	/**
	 * Creates a textarea field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_textarea( $args ) {
		$defaults['class'] 			= 'large-text';
		$defaults['cols'] 			= 50;
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['rows'] 			= 10;
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-textarea-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-textarea.php' );
	} // field_textarea()
	
	/**
	 * Creates a Image Upload field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_image_upload( $args ) {

		$defaults['class'] 				= 'widefat url-file';
		//$defaults['id'] 				= '';
		$defaults['label-add'] 			= 'Add Image';
		$defaults['label-edit'] 		= 'Edit Image';
		$defaults['label-header'] 		= 'Image Name';
		$defaults['label-remove'] 		= 'Remove Image';
		$defaults['label-upload'] 		= 'Choose/Upload Image';
		$defaults['name'] 				= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 		= '';
		$defaults['type'] 				= 'hidden';
		$defaults['value'] 				= '';
		
		apply_filters( $this->plugin_name . '-field-textarea-options-defaults', $defaults );
		
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-image-upload.php' );

	} // field_image_upload()
	
	/**
	 * Creates a radio field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_radio( $args ) {
		$defaults['class'] 			= 'radio-button';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-radio-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {
			$atts['aria'] = $atts['description'];
		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {
			$atts['aria'] = $atts['label'];
		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-admin-field-radio.php' );

	} // field_radio()

	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();

		//$options[] = array( 'default-friday-hours', 'text', '9am - 9pm' );
		//$options[] = array( 'default-saturday-hours', 'text', '9am - 8pm' );
		$options[] = array( 'default-form-title', 'text', 'Start Your Virtual Consultation' );
		$options[] = array( 'default-button-title', 'text', 'Virtual Consultation' );
		$options[] = array( 'form-logo-image', 'text', '' );
		$options[] = array( 'form-circle-image', 'text', '' );
		$options[] = array( 'smtp-email-server', 'text', '' );
		$options[] = array( 'smtp-email-name', 'text', '' );
		$options[] = array( 'smtp-email-from-address', 'email', '' );
		$options[] = array( 'smtp-email-un', 'text', '' );
		$options[] = array( 'smtp-email-pw', 'text', '' );
		$options[] = array( 'smtp-email-port', 'number', '' );
		$options[] = array( 'smtp-email-replyto-address', 'email', '' );
		$options[] = array( 'smtp-email-subject', 'text', '' );
		$options[] = array( 'smtp-email-to-email-address', 'email', '' );
		$options[] = array( 'smtp-cc-email-address', 'email', '' );
		//$options[] = array( 'repeat-test', 'repeater', array( array( 'test1', 'text' ), array( 'test2', 'text' ), array( 'test3', 'text' ) ) );

		return $options;

	} // get_options_list()

	/**
	 * Adds links to the plugin links row
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of row links
	 * @param 		string 		$file 		The name of the file
	 * @return 		array 					The modified array of row links
	 */
	public function link_row( $links, $file ) {

		if ( COMO_MERCHANTS_FILE === $file ) {

			$links[] = '<a href="http://twitter.com/Como Creative LLC">Twitter</a>';

		}

		return $links;

	} // link_row()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of links
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'edit.php?post_type=formpage&page=' . $this->plugin_name . '-settings' ) ), esc_html__( 'Settings', 'como-consult' ) );

		return $links;

	} // link_settings()

	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_formpage() {

		$cap_type 	= 'post';
		$plural 	= 'Form Pages';
		$single 	= 'Form Page';
		$cpt_name 	= 'formpage';

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= TRUE;
		$opts['has_archive']							= FALSE;
		$opts['hierarchical']							= FALSE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-camera';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title','editor','page-attributes','revisions');
		//$opts['taxonomies']								= array('post_tag');

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'como-consult' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'como-consult' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'como-consult' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'como-consult' );
		$opts['labels']['menu_name']					= esc_html__( 'Consultation Form', 'como-consult' );
		$opts['labels']['name']							= esc_html__( $plural, 'como-consult' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'como-consult' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'como-consult' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'como-consult' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'como-consult' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'como-consult' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'como-consult' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'como-consult' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'como-consult' );
		$opts['labels']['featured_image'] 				= esc_html__( "{$single} Logo", 'como-consult' );
		$opts['labels']['set_featured_image'] 			= esc_html__( "Set {$single} Logo", 'como-consult' );
		$opts['labels']['remove_featured_image'] 		= esc_html__( "Remove {$single} Logo", 'como-consult' );
		$opts['labels']['use_featured_image'] 			= esc_html__( "Use as {$single} Logo", 'como-consult' );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $single ), 'como-consult' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'como-consult-cpt-options', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} // new_cpt_formpage()

	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_type() {

		$plural 	= 'Form Page Types';
		$single 	= 'Form Page Type';
		$tax_name 	= 'formpage-type';

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'como-consult' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'como-consult' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'como-consult' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'como-consult' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'como-consult');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'como-consult' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'como-consult' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'como-consult' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'como-consult' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'como-consult' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'como-consult' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'como-consult' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'como-consult' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'como-consult' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'como-consult' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'como-consult' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'como-consult' );
		
		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'como-consult' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'como-consult-taxonomy-options', $opts );

		register_taxonomy( $tax_name, 'formpage', $opts );

	} // new_taxonomy_type()

	/**
	 * Creates the help page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_help() {

		include( plugin_dir_path( __FILE__ ) . 'partials/como-consult-admin-page-help.php' );

	} // page_help()

	/**
	 * Creates the options page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_options() {

		include( plugin_dir_path( __FILE__ ) . 'partials/como-consult-admin-page-settings.php' );

	} // page_options()

	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		/*add_settings_field(
			'default-friday-hours',
			apply_filters( $this->plugin_name . 'label-default-friday-hours', esc_html__( 'Default Friday Hours', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Default Friday Hours of none are specified',
				'id' 			=> 'default-friday-hours',
				'value' 		=> '9am – 9pm',
			)
		);
		
		add_settings_field(
			'default-saturday-hours',
			apply_filters( $this->plugin_name . 'label-default-saturday-hours', esc_html__( 'Default Saturday Hours', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Default Saturday Hours of none are specified',
				'id' 			=> 'default-saturday-hours',
				'value' 		=> '9am – 8pm',
			)
		);*/
		
		add_settings_field(
			'default-form-title',
			apply_filters( $this->plugin_name . 'label-default-form-title', esc_html__( 'Form Pop-up Title', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'This is the default form popup title',
				'id' 			=> 'default-form-title',
				'value' 		=> 'Start Your Virtual Consultation',
			)
		);
		
		add_settings_field(
			'default-button-title',
			apply_filters( $this->plugin_name . 'label-default-button-title', esc_html__( 'Form Button Title', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'This is the default form button title',
				'id' 			=> 'default-button-title',
				'value' 		=> 'Virtual Consultation',
			)
		);
		
		add_settings_field(
			'form-logo-image',
			apply_filters( $this->plugin_name . 'label-form-logo-image', esc_html__( 'Form Logo Image', 'como-consult' ) ),
			array( $this, 'field_image_upload' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Logo for popup form.',
				'id' 			=> 'form-logo-image',
				'value' 		=> '',
			)
		);
		
		add_settings_field(
			'form-circle-image',
			apply_filters( $this->plugin_name . 'label-form-circle-image', esc_html__( 'Form Circle Image', 'como-consult' ) ),
			array( $this, 'field_image_upload' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Circle image on contact form',
				'id' 			=> 'form-circle-image',
				'value' 		=> '',
			)
		);
		
		add_settings_field(
			'smtp-email-server',
			apply_filters( $this->plugin_name . 'label-smtp-email-server', esc_html__( 'Form SMTP Email Server', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email server that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-server',
				'value' 		=> '',
			)
		);
		
		add_settings_field(
			'smtp-email-name',
			apply_filters( $this->plugin_name . 'label-smtp-email-name', esc_html__( 'Form Email From Name', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email from name that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-name',
				'value' 		=> '',
			)
		);
		
		add_settings_field(
			'smtp-email-from-address',
			apply_filters( $this->plugin_name . 'label-smtp-email-from-address', esc_html__( 'Form From Email Address', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email from address that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-from-address',
				'value' 		=> '',
				'type'			=> 'email',
			)
		);
		
		add_settings_field(
			'smtp-email-un',
			apply_filters( $this->plugin_name . 'label-smtp-email-un', esc_html__( 'Form SMTP Username', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email username that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-un',
				'value' 		=> '',
				'type'			=> 'text',
			)
		);
		
		add_settings_field(
			'smtp-email-pw',
			apply_filters( $this->plugin_name . 'label-smtp-email-pw', esc_html__( 'Form SMTP Email Password', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email password that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-pw',
				'value' 		=> '',
				'type'			=> 'password'
			)
		);
		
		add_settings_field(
			'smtp-email-port',
			apply_filters( $this->plugin_name . 'label-smtp-email-port', esc_html__( 'Form SMTP Email Port', 'como-consult' ) ),
			array( $this, 'field_number' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email Port that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-port',
				'value' 		=> '',
				'min'	 		=> '0',
				'max' 			=> '999',
				'step' 			=> '1',
			)
		);
		
		add_settings_field(
			'smtp-email-replyto-address',
			apply_filters( $this->plugin_name . 'label-smtp-email-replyto-address', esc_html__( 'Form Email Reply To Address', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email reply to address that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-replyto-address',
				'value' 		=> '',
				'type'			=> 'email',
			)
		);
		
		add_settings_field(
			'smtp-email-subject',
			apply_filters( $this->plugin_name . 'label-smtp-email-subject', esc_html__( 'Form Email Subject', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email subject line that will be used to send the consultation forms',
				'id' 			=> 'smtp-email-subject',
				'value' 		=> '',
			)
		);
		
		add_settings_field(
			'smtp-email-to-email-address',
			apply_filters( $this->plugin_name . 'label-smtp-email-to-email-address', esc_html__( 'Form to Email Address', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email address that consultation forms will be sent to',
				'id' 			=> 'smtp-email-to-email-address',
				'value' 		=> '',
				'type'			=> 'email',
			)
		);
		
		add_settings_field(
			'smtp-cc-email-address',
			apply_filters( $this->plugin_name . 'label-smtp-cc-email-address', esc_html__( 'Form CC Email Address', 'como-consult' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Email CC address that consultation forms will be sent to',
				'id' 			=> 'smtp-cc-email-address',
				'value' 		=> '',
				'type'			=> 'email',
			)
		);

		/*add_settings_field(
			'how-to-apply',
			apply_filters( $this->plugin_name . 'label-how-to-apply', esc_html__( 'How to Apply', 'como-consult' ) ),
			array( $this, 'field_editor' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Instructions for applying (contact email, phone, fax, address, etc).',
				'id' 			=> 'consult-single'
			)
		);

		add_settings_field(
			'repeater-test',
			apply_filters( $this->plugin_name . 'label-repeater-test', esc_html__( 'Repeater Test', 'como-consult' ) ),
			array( $this, 'field_repeater' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Instructions for applying (contact email, phone, fax, address, etc).',
				'fields' 		=> array(
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'test1',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[test1]',
							'placeholder' 	=> 'Test 1',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'test2',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[test2]',
							'placeholder' 	=> 'Test 2',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'test3',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[test3]',
							'placeholder' 	=> 'Test 3',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
				),
				'id' 			=> 'repeater-test',
				'label-add' 	=> 'Add Test',
				'label-edit' 	=> 'Edit Test',
				'label-header' 	=> 'TEST',
				'label-remove' 	=> 'Remove Test',
				'title-field' 	=> 'test1'

			)
		);*/

	} // register_fields()

	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-messages',
			apply_filters( $this->plugin_name . 'section-title-messages', esc_html__( 'Messages', 'como-consult' ) ),
			array( $this, 'section_messages' ),
			$this->plugin_name
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }

		$return 	= '';
		$sanitizer 	= new Como_Consult_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );

		$return = $sanitizer->clean();

		unset( $sanitizer );

		return $return;

	} // sanitizer()

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function section_messages( $params ) {

		include( plugin_dir_path( __FILE__ ) . 'partials/como-consult-admin-section-messages.php' );

	} // section_messages()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		//wp_die( print_r( $input ) );

		$valid 		= array();
		$options 	= $this->get_options_list();

		foreach ( $options as $option ) {

			$name = $option[0];
			$type = $option[1];

			if ( 'repeater' === $type && is_array( $option[2] ) ) {

				$clean = array();

				foreach ( $option[2] as $field ) {

					foreach ( $input[$field[0]] as $data ) {

						if ( empty( $data ) ) { continue; }

						$clean[$field[0]][] = $this->sanitizer( $field[1], $data );

					} // foreach

				} // foreach

				$count = Como_Consult_get_max( $clean );

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$valid[$option[0]][$i][$field_name] = $field[$i];

					} // foreach $clean

				} // for

			} else {

				$valid[$option[0]] = $this->sanitizer( $type, $input[$name] );

			}

			/*if ( ! isset( $input[$option[0]] ) ) { continue; }

			$sanitizer = new Como_Consult_Sanitize();

			$sanitizer->set_data( $input[$option[0]] );
			$sanitizer->set_type( $option[1] );

			$valid[$option[0]] = $sanitizer->clean();

			if ( $valid[$option[0]] != $input[$option[0]] ) {

				add_settings_error( $option[0], $option[0] . '_error', esc_html__( $option[0] . ' error.', 'como-consult' ), 'error' );

			}

			unset( $sanitizer );*/

		}

		return $valid;

	} // validate_options()

} // class