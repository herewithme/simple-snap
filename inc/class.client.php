<?php 
class SimpleSnap_Client{
	/**
	 * register post-type
	 *
	 * @return void
	 * @author Nicolas Juen
	 */
	function SimpleSnap_Client(){
		add_action('init', array(&$this, 'add_post_type_snap'), 9);
		add_action('init', array(&$this, 'add_taxonomy_snap'), 9);
	}
	
	function add_post_type_snap(){
			register_post_type( SNAP_POSTTYPE, array(
			'labels' => array(
				'name' => __( SNAP_POSTTYPE_NAME, 'simple-snap'),
				'singular_name' => __( SNAP_POSTTYPE_NAME, 'simple-snap'),
				'add_new' => __('Add New', 'simple-snap'),
				'add_new_item' => __('Add New Case', 'simple-snap'),
				'edit_item' => __('Edit Case', 'simple-snap'),
				'new_item' => __('New Case', 'simple-snap'),
				'view_item' => __('View Case', 'simple-snap'),
				'search_items' => __('Search Cases', 'simple-snap'),
				'not_found' =>  __('No cases found', 'simple-snap'),
				'not_found_in_trash' => __('No cases found in Trash', 'simple-snap'),
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title', 'editor', 'author', 'thumbnail')
		));
	}
	
	/**
	 * create the taxonomie page the post type "case"
	 *
	 * @return void
	 * @author Tugdual Magre
	 */
	function add_taxonomy_snap() {
		register_taxonomy( SNAP_TAX_GLOSSARY, SNAP_POSTTYPE, array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( SNAP_TAX_NAME, 'simple-snap' ),
				'singular_name' => __( SNAP_TAX_NAME, 'simple-snap' ),
				'search_items' =>  __( 'Search '.SNAP_TAX_NAME, 'simple-snap' ),
				'popular_items' => __( 'Popular '.SNAP_TAX_NAME, 'simple-snap' ),
				'all_items' => __( 'All '.SNAP_TAX_NAME, 'simple-snap' ),
				'edit_item' => __( 'Edit '.SNAP_TAX_NAME, 'simple-snap' ),
				'update_item' => __( 'Update '.SNAP_TAX_NAME, 'simple-snap' ),
				'add_new_item' => __( 'Add New '.SNAP_TAX_NAME, 'simple-snap' ),
				'new_item_name' => __( 'New '.SNAP_TAX_NAME.' Name', 'simple-snap' ),
				'separate_items_with_commas' => __( 'Separate '.SNAP_TAX_NAME.' with commas', 'simple-snap' ),
				'add_or_remove_items' => __( 'Add or remove '.SNAP_TAX_NAME.'', 'simple-snap' ),
				'choose_from_most_used' => __( 'Choose from the most used '.SNAP_TAX_NAME.'', 'simple-snap' )
			),
			'show_in_nav_menu' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => SNAP_TAX_GLOSSARY )
		));
	}
}
?>