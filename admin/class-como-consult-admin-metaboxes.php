<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		https://comocreative.com
 * @since 		1.0.0
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/admin
 */

/**
 * The metabox-specific functionality of the plugin.
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/admin
 * @author 		Como Creative LLC <chris@Como Creative LLC.com>
 */
class Como_Consult_Admin_Metaboxes {

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

		$this->set_meta();

	}

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes() {

		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

		add_meta_box(
			'Como_Consult_formpage_additional_info',
			apply_filters( $this->plugin_name . '-metabox-title-form-info', esc_html__( 'Form Info', 'como-consult' ) ),
			array( $this, 'metabox' ),
			'formpage',
			'normal',
			'default',
			array(
				'file' => 'formpage-info'
			)
		);
		
		add_meta_box(
			'Como_Consult_formpage_after_fields',
			apply_filters( $this->plugin_name . '-metabox-title-form-info', esc_html__( 'Content After Form Fields', 'como-consult' ) ),
			array( $this, 'metabox' ),
			'formpage',
			'normal',
			'default',
			array(
				'file' => 'formpage-after-fields'
			)
		);


		/*add_meta_box(
			'Como_Consult_formpage_requirements',
			apply_filters( $this->plugin_name . '-metabox-title-requirements', esc_html__( 'formpage Requirements', 'como-consult' ) ),
			array( $this, 'metabox' ),
			'formpage',
			'normal',
			'default',
			array(
				'file' => 'formpage-requirements'
			)
		);*/

		/*add_meta_box(
			'Como_Consult_formpage_image',
			apply_filters( $this->plugin_name . '-metabox-title-requirements', esc_html__( 'FormPage Header Image', 'como-consult' ) ),
			array( $this, 'metabox' ),
			'formpage',
			'side',
			'default',
			array(
				'file' => 'formpage-image',
				'classes' => 'equal'
			)
		);*/

	} // add_metaboxes()

	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		$nonces 		= array();
		$nonce_check 	= 0;

		//$nonces[] 	= 'formpage_requirements_nonce';
		$nonces[] 		= 'formpage_additional_info';
		$nonces[] 		= 'formpage_after_fields';
		//$nonces[] 		= 'formpage_header_image';

		foreach ( $nonces as $nonce ) {

			if ( ! isset( $posted[$nonce] ) ) { $nonce_check++; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->plugin_name ) ) { $nonce_check++; }

		}

		return $nonce_check;

	} // check_nonces()

	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	private function get_metabox_fields() {
		$fields = array();
		$fields[] = array( 'como-field-repeater', 'repeater', array(array('field-label','text'), array('field-name','text'), array('field-type','select'), array('field-options','textarea'), array('field-sample-image','text'), array('field-required','radio')));
		$fields[] = array( 'forminfo-after', 'textarea' );
		$fields[] = array( 'formbutton-type', 'select' );
		$fields[] = array( 'formbutton-text', 'text' );
		$fields[] = array( 'formbutton-class', 'text' );
		return $fields;
	} // get_metabox_fields()

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function metabox( $post, $params ) {

		if ( ! is_admin() ) { return; }
		if ( 'formpage' !== $post->post_type ) { return; }

		if ( ! empty( $params['args']['classes'] ) ) {

			$classes = 'repeater ' . $params['args']['classes'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/como-consult-admin-metabox-' . $params['args']['file'] . '.php' );

	} // metabox()

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
	 * Saves button order when buttons are sorted.
	 */
	public function save_files_order() {

		check_ajax_referer( 'como-consult-file-order-nonce', 'fileordernonce' );

		$order 						= $this->meta['file-order'];
		$new_order 					= implode( ',', $_POST['file-order'] );
		$this->meta['file-order'] 	= $new_order;
		$update 					= update_post_meta( 'file-order', $new_order );

		esc_html_e( 'File order saved.', 'como-consult' );

		die();

	} // save_files_order()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'formpage' != $post->post_type ) { return; }

		//wp_die( '<pre>' . print_r( $post->ID ) . '</pre>' );

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 *  	Loops through meta fields
	 *  		Loops through submitted data
	 *  		Sanitizes each field into $clean array
	 *   	Gets max of $clean to use in FOR loop
	 *   	FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	int 		$post_id 		The post ID
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	public function validate_meta( $post_id, $object ) {

		//wp_die( '<pre>' . print_r( $_POST ) . '</pre>' );

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( 'formpage' !== $object->post_type ) { return $post_id; }

		$nonce_check = $this->check_nonces( $_POST );

		//wp_die( '<pre>$nonce_check: ' . $nonce_check . '</pre>' );
		
		if ( 0 < $nonce_check ) { return $post_id; }

		$metas = $this->get_metabox_fields();

		foreach ( $metas as $meta ) {

			$name = $meta[0];
			$type = $meta[1];

			if ( 'repeater' === $type && is_array( $meta[2] ) ) {

				$clean = array();

				foreach ( $meta[2] as $field ) {

					foreach ( $_POST[$field[0]] as $data ) {

						if ( empty( $data ) ) { continue; }

						$clean[$field[0]][] = $this->sanitizer( $field[1], $data );

					} // foreach

				} // foreach

				$count 		= Como_Consult_get_max( $clean );
				$new_value 	= array();

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$new_value[$i][$field_name] = $field[$i];

					} // foreach $clean

				} // for

			} else {

				$new_value = $this->sanitizer( $type, $_POST[$name] );

			}

			update_post_meta( $post_id, $name, $new_value );

		} // foreach

	} // validate_meta()

} // class
