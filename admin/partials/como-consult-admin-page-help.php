<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://comocreative.com
 * @since      1.0.0
 *
 * @package    Como Consult
 * @subpackage Como Consult/admin/partials
 */

?><h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
<h2><?php esc_html_e( 'Shortcode', 'como-consult' ); ?></h2>
<p><?php esc_html_e( 'The simplest version of the shortcode is:', 'como-consult' ); ?></p>
<pre><code>[comoConsult]</code></pre>
<p><?php esc_html_e( 'Enter that in the Editor on any page or post to display all the formpage opening posts.', 'como-consult' ); ?></p>
<p><?php esc_html_e( 'This is an example with all the default attributes used:', 'como-consult' ); ?></p>
<pre><code>[comoConsult order="rand" quantity="10" location="Decatur"]</code></pre>

<h3><?php esc_html_e( 'Shortcode Attributes', 'como-consult' ); ?></h3>
<p><?php esc_html_e( 'There are currently three attributes that can be added to the shortcode to filter formpage opening posts:', 'como-consult' ); ?></p>
<ol>
	<li><?php esc_html_e( 'order', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'quantity', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'location', 'como-consult' ); ?></li>
</ol>
<h4><?php esc_html_e( 'order', 'como-consult' ); ?></h4>
<p><?php printf( wp_kses( __( 'Changes the display order of the formpage opening posts. Default value is "date", but can use any of <a href="%1$s">the "orderby" parameters for WP_Query</a>.', 'como-consult' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( 'https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters' ) ); ?></p>
<p><?php esc_html_e( 'Examples of the order attribute:', 'como-consult' ); ?></p>
<ul>
	<li><?php esc_html_e( 'order="title" (order by post title)', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'order="name" (order by post slug)', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'order="rand" (random order)', 'como-consult' ); ?></li>
</ul>

<h4><?php esc_html_e( 'quantity', 'como-consult' ); ?></h4>
<p><?php esc_html_e( 'Determines how many formpage opening posts are displayed. The default value is 100. Must be a positive value. To display all, use a high number.', 'como-consult' ); ?></p>
<p><?php esc_html_e( 'Examples of the quantity attribute:', 'como-consult' ); ?></p>
<ul>
	<li><?php esc_html_e( 'quantity="3" (only show 3 openings)', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'quantity="125" (only show 125 openings)', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'quantity="999" (large number to display to all openings)', 'como-consult' ); ?></li>
</ul>

<h4><?php esc_html_e( 'location', 'como-consult' ); ?></h4>
<p><?php esc_html_e( 'Filters formpage openings based on the value of the formpage location metabox field. The value should be the ', 'como-consult' ); ?></p>
<p><?php esc_html_e( 'Examples of the location attribute:', 'como-consult' ); ?></p>
<ul>
	<li><?php esc_html_e( 'location="St Louis"', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'location="Decatur"', 'como-consult' ); ?></li>
	<li><?php esc_html_e( 'location="Chicago"', 'como-consult' ); ?></li>
</ul>

<h4><?php esc_html_e( 'WP_Query', 'como-consult' ); ?></h4>
<p><?php printf( wp_kses( __( 'The shortcode will also accept any of <a href="%1$s">the parameters for WP_Query</a>.', 'como-consult' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( 'https://codex.wordpress.org/Class_Reference/WP_Query' ) ); ?></p>