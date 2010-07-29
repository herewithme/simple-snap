<?php
class glossary_rewrite{

	function glossary_rewrite(){
		//Flush the rewrite rules
		add_filter( 'init', array( &$this,'flushRules' ) );
		
		//Generate new rewrite rules
		add_action( 'generate_rewrite_rules', array( &$this, 'rewriteRules') );
		
		//Add the templates if needed
		add_action( 'template_redirect', array( &$this, 'templateRedirect') );
		
		//Add query vars
		add_filter( 'query_vars',  array( &$this, 'addQueryVar' ) );
		
	}
	

	/**
	 * Flush rewrite rules
	 *
	 * @return void
	 * @author Nicolas JUEN
	 */
	function flushRules(){
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}

	/**
	 * Generate rewrite rules for custom post type archives
	 *
	 * @param object $wp_rewrite
	 * @return void
	 * @author Nicolas JUEN
	 */
	function rewriteRules( $wp_rewrite ) {
	
			// Use default slug or user defined ?
			$option = get_option( 'key_snap_fancyurlname' );
			$slug = ( empty( $option ) ) ? 'glossary' : $option;
			
			// Build array for rewriting
			$new_rules = array(	
				$slug . '/?$' => 'index.php?post_type=glossary',	
				$slug . '/([A-Za-z]*)$' => 'index.php?post_type=glossary&letter='.$wp_rewrite->preg_index(1),
				$slug . '/([A-Za-z]-[A-Za-z])' => 'index.php?post_type=glossary&letter='.$wp_rewrite->preg_index(1)
			);
			$wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);
	}
	
 	/**
	 * Add letter to the wuery vars
	 *
	 * @return void
	 * @author Nicolas JUEN
	 */
	function addQueryVar( $qvars ) {
		  $qvars[] = 'letter';
		  return $qvars;
	}
	
	/**
	 * Custom template files for custom post type glossary
	 *
	 * @return void
	 * @author Nicolas JUEN
	 */
	function templateRedirect() {
		global $wp_query;
		
		if ( get_query_var('post_type') == 'glossary' && !is_robots() && !is_feed() && !is_trackback() ) {
			$this->loadCustomTemplate(); // Load specific template
			$wp_query->is_home = false;	// correct is_home variable
		}
	}
	
	/**
	 * Allow redirection to specific template when custom post view glossary
	 *
	 * @return void
	 * @author Nicolas JUEN
	 */
	function loadCustomTemplate() {

		$templates[] = "glossary-".get_query_var('letter').".php";
		$templates[] = "glossary.php";		

		locate_template( $templates, true );
		exit();
	}
}
?>