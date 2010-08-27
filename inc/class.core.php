<?php
class SimpleSnap_Core {
	function SimpleSnap_Core() {
		add_action( 'generate_rewrite_rules', array(&$this, 'createRewriteRules') );
		add_action( 'parse_query', array(&$this, 'parseQuery') );
		add_filter( 'query_vars', array(&$this, 'addQueryVar') );
	}	
	
	function createRewriteRules( $wp_rewrite ) {
	
		$new_rules = array( SNAP_POSTTYPE.'?$' => 'index.php?post_type='.SNAP_POSTTYPE );
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
		
		$new_rules = array( SNAP_POSTTYPE.'/'.SNAP_SLUG.'/([^/]+)?$' => 'index.php?post_type='.SNAP_POSTTYPE.'&'.SNAP_SLUG.'='. $wp_rewrite->preg_index( 1 ) );
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
		
		$new_rules = array( SNAP_POSTTYPE.'/'.SNAP_CAT_GLOSSARY.'/([^/]+)?$' => 'index.php?post_type='.SNAP_POSTTYPE.'&'.SNAP_CAT_GLOSSARY.'='. $wp_rewrite->preg_index( 1 ) );
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
		
		$new_rules = array( SNAP_POSTTYPE.'/'.SNAP_CAT_GLOSSARY.'/([^/]+)/'.SNAP_SLUG.'/([^/]+)?$' => 'index.php?post_type='.SNAP_POSTTYPE.'&'.SNAP_CAT_GLOSSARY.'='. $wp_rewrite->preg_index( 1 ).'&'.SNAP_SLUG.'='. $wp_rewrite->preg_index( 2 ) );
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}
	
	function addQueryVar( $wpvar ) {
		$wpvar[] = SNAP_SLUG;
		$wpvar[] = SNAP_CAT_GLOSSARY;
		return $wpvar;
	}
	
	function parseQuery( $query ) {
		$query->is_snap_letter = false;
		
		//If we have the letter set
		if ( isset( $query->query_vars[SNAP_SLUG] ) ) {
			//Reset flags
			$query->init_query_flags();
			
			//Get the posts post_title begining by the right letter
			$object_ids = $this->getPostsWithTitleStartBy( $query->query_vars[SNAP_SLUG] );
			if ( $object_ids != false ) {
				$query->query_vars['post__in'] = $object_ids;
			} else {
				$query->query_vars['post__in'] = array(0);
			}
			
			//Set tax and inidivdu to true
			$query->is_tax = true;
			$query->is_snap_letter = true;

			//Remove pagination
			$query->query_vars['nopaging'] = true;	
			
			//If we have the terms set add them to the query
			if( isset( $query->query_vars[SNAP_CAT_GLOSSARY] ) ){
				$query->query_vars['taxonomy'] = SNAP_TAX_GLOSSARY;
				$query->query_vars['term'] = $query->query_vars[SNAP_CAT_GLOSSARY];
			}
			
			//Get the right template
			add_action( 'template_redirect', array( &$this,'includeTemplate' ), 9 );
			
		}elseif( isset( $query->query_vars[SNAP_CAT_GLOSSARY] ) ){
			//Reset flags
			$query->init_query_flags();
			
			//Set tax and individu to true
			$query->is_snap_letter = true;
			$query->is_tax = true;
			
			//Remove pagination and add taxonomy and term to the query
			$query->query_vars['nopaging'] = true;
			$query->query_vars['taxonomy'] = SNAP_TAX_GLOSSARY;
			$query->query_vars['term'] = $query->query_vars[SNAP_CAT_GLOSSARY];
			
			//Get the right template
			add_action( 'template_redirect', array( &$this,'includeTemplate'), 9 );

		}elseif( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == SNAP_POSTTYPE && empty( $query->query_vars['post_name'] ) ){
			//Remove pagination in all the other pages
			$query->query_vars['nopaging'] = true;
			add_action( 'template_redirect', array( &$this,'includeTemplate'), 9 );	
		}
	}
	
	/**
	 * Load correct templates
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	function includeTemplate() {
		$templates[] = "type-".SNAP_POSTTYPE."-".SNAP_SLUG.".php";
		$templates[] = "type-".SNAP_POSTTYPE.".php";
		locate_template( $templates, true );
		exit();
	}
	
	/**
	 * Get IDs object from post title that start by the specified letter!
	 *
	 * @param string $letter 
	 * @return array|false
	 * @author Amaury Balmer
	 */
	function getPostsWithTitleStartBy( $letter = '' ) {
		global $wpdb;
		return $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT(ID) FROM $wpdb->posts WHERE post_type = '".SNAP_POSTTYPE."' AND post_status = 'publish' AND LEFT(post_title, 1) = '%s' ORDER BY post_title", $letter) );
	}
	
	/**
	 * Get IDs object from post meta key with meta value start by the specified letter!
	 *
	 * @param string $meta_key 
	 * @param string $letter 
	 * @return array|false
	 * @author Amaury Balmer
	 */
	function getPostsWithPostMetaStartBy( $meta_key = '', $letter = '' ) {
		global $wpdb;
		return $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT(post_id) FROM $wpdb->postmeta AS pm, $wpdb->posts AS p WHERE pm.post_id = p.ID AND p.post_type = '".SNAP_POSTTYPE."' AND p.post_status = 'publish' AND pm.meta_key = %s AND LEFT(pm.meta_value, 1) = %s", $meta_key, $letter) );
	}
}