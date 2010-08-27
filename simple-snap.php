<?php
/*
Plugin Name: Simple Glossary
Plugin URI: http://www.beapi.fr
Description: Use the custom post type Glossary for displaying glossary items with filter
Version: 2.0
Author: Beapi
Author URI: http://www.beapi.fr

Doc :
	Use get_the_snap, for display the filters ! 
	Create a template file type-youtposttype.php
	Create templates type-youtposttype-A.php etc... for customize letters

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
define( 'SNAP_POSTTYPE', 'glossary' );
define( 'SNAP_POSTTYPE_NAME', 'Glossary' );

define( 'SNAP_SLUG', 'letter' );
define( 'SNAP_CAT_GLOSSARY', 'cat-lexique' );

define( 'SNAP_TAX_GLOSSARY', 'glossary-category' );
define( 'SNAP_TAX_NAME', 'Categories' );

define( 'SIMPLE_SNAP_VER', '2.0' );
define( 'SIMPLE_SNAP_URL', plugins_url('/', __FILE__) );
define( 'SIMPLE_SNAP_DIR', dirname(__FILE__) );

require( SIMPLE_SNAP_DIR . '/inc/class.client.php' );
require( SIMPLE_SNAP_DIR . '/inc/class.core.php' );
require( SIMPLE_SNAP_DIR . '/inc/function.php' );

// Init Simple Snap
function simple_snap_init() {	

	//Add post type
	new SimpleSnap_Client();
	
	// Instanciate the core
	new SimpleSnap_Core();
}
add_action( 'plugins_loaded', 'simple_snap_init' );
?>