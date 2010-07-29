<?php
/*
Plugin Name: Simple Glossary
Plugin URI: http://www.beapi.fr
Description: Use the custom post type Glossary for displaying glossary items with filter
Version: 1.0
Author: Amaury Balmer
Author URI: http://www.beapi.fr

Doc :
	Use simple_snap(), for display the filters ! 
	Create a template file glossary.php
	Create templates glossary-A.php etc... for customize letters

Original work from WP-SNAP! by Nathan Olsen - http://www.nateomedia.com/

---
Copyright 2010 Amaury Balmer http://www.beapi.fr

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Define the default glossary post type slug
define( 'GLOSSARY_POSTTYPE', 'glossary' );
define( 'SNAP_SLUG', 'letter' );

require( dirname(__FILE__) . '/inc/class.core.php' );
require( dirname(__FILE__) . '/inc/class.rewrite.php' );
require( dirname(__FILE__) . '/inc/base.php' );
require( dirname(__FILE__) . '/inc/client.php' );

// Installation
register_activation_hook(__FILE__, 'install_simple_snap' );

// Init Simple Snap
function simple_snap_init() {	
	// Add new rewriting rules
	new glossary_rewrite();
	
	// Localization
	load_plugin_textdomain ( 'simplesnap', false, str_replace ( ABSPATH, '', dirname(__FILE__) ) . '/languages' );
	
	// Admin and XML-RPC
	if ( is_admin() || ( defined('XMLRPC_REQUEST') && XMLRPC_REQUEST ) ) {
		require( dirname(__FILE__) . '/inc/admin.php' );
		add_action('admin_menu',  'simple_snap_add_option_page');
	}
}
add_action( 'plugins_loaded', 'simple_snap_init' );

//Add new custom post type glossary
add_action('init', 'add_glossary');	
function add_glossary(){
	register_post_type( 'glossary', array(
		'labels' => array(
					'name' => __( 'Lexique' ),
					'singular_name' => __( 'Lexique' ),
				),
		'public'  => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'custom-fields', 'revisions' ),
	) );
}
?>