<?php

/**
 * Fired during plugin activation
 *
 * @link 		https://comocreative.com
 * @since 		1.0.0
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 		1.0.0
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/includes
 * @author 		Como Creative LLC <chris@Como Creative LLC.com>
 */
class Como_Consult_Activator {

	/**
	 * Declare custom post types, taxonomies, and plugin settings
	 * Flushes rewrite rules afterwards
	 *
	 * @since 		1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-como-consult-admin.php';

		Como_Consult_Admin::new_cpt_formpage();
		Como_Consult_Admin::new_taxonomy_type();

		flush_rewrite_rules();

		$opts 		= array();
		$options 	= Como_Consult_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'como-consult-options', $opts );

		Como_Consult_Admin::add_admin_notices();

	} // activate()
} // class
