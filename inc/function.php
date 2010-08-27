<?
/**
 * Get letters with posts associated
 * 
 * @access public
 * @return void
 * @author Nicolas Juen
 */
function get_letters_in_snap() {
	global $wpdb;
	$post_in = '';
	
	//If we have the right slug in url
	if( get_query_var( SNAP_CAT_GLOSSARY ) ){
		//Get the id of the current term
		$termId = get_term_by( 'slug', get_query_var( SNAP_CAT_GLOSSARY ), SNAP_CAT_GLOSSARY )->term_id;
		
		//If the term exists we get the related posts
		if( !empty( $termId ) || !is_wp_error( $termId ) ){	
			//Get related posts		
			$posts_id = get_objects_in_term( $termId, SNAP_CAT_GLOSSARY );
			
			//Build the additionnal query if we have relatd posts
			if( !empty( $posts_id ) && !is_wp_error( $posts_id ) ){
				$post_in = ' AND p.ID IN (';
				$post_in .= implode(',',$posts_id );
				$post_in .= ' )';
			}
		}
	}
	
	//Make the query and return it
	return $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT(LEFT(p.post_title, 1)) FROM  $wpdb->posts AS p WHERE p.post_type = '".SNAP_POSTTYPE."' AND p.post_status = 'publish'".$post_in) );
}


/**
 * Generate the right url by letter or not
 * 
 * @access public
 * @param bool $all. (default: false)
 * @param bool|string $letter. (default: false)
 * @return void
 * @author Nicolas Juen
 */
function get_snap_url( $allLetters = false, $letter = false ){
	//Get the taxonomy
	$tax = get_query_var( SNAP_CAT_GLOSSARY );
	
	//Get the permalink 
	$permalink = get_option( 'permalink_structure' );
	
	//Set the begining of the url
	if( $permalink != '' )
		$urlStr = '/'.SNAP_POSTTYPE;
	else
		$urlStr = '/?post_type='.SNAP_POSTTYPE;
	
	//If the taxonomy is not empty we add the tax in the url
	if( !empty($tax) )
		if( $permalink != '' )
			$urlStr .= '/'.SNAP_CAT_GLOSSARY.'/'.$tax;
		else
			$urlStr .= '&'.SNAP_CAT_GLOSSARY.'='.$tax;
		
	//If the don't want the global link and the letter isset add the letter in url
	if( !empty( $letter ) && $allLetters == false )
		if( $permalink != '' )
			$urlStr .= '/'.SNAP_SLUG.'/'.$letter;
		else
			$urlStr .= '&'.SNAP_SLUG.'='.$letter;
		
	//Return the url
	return  home_url($urlStr);
}

function get_the_snap( $args = '' ){
	
	//Set defaults values
	$defaults = array( 
		'style'				=> 'list',
		'class_container' 	=> 'glossary',
		'class_current'		=> 'current_letter',
		'title'				=> 'Navigation',
		'before_title'		=> '<h2>',
		'after_title'		=> '</h2>',
		'all_title' 		=> 'All',
		'echo'				=> 0,
		'exclude'			=> array()
	);
	
	// Parse the args
	$args = wp_parse_args( $args, $defaults );
	
	// Set the exclude array
	if( !empty( $args['exclude'] ) ){
		$excludes = explode( ',',$args['exclude'] );
	}
	
	//Set the title
	$output = $args['before_title'].$args['title'].$args['after_title'];
	
	// Set the start tag with the base class based on the the style of the navigation
	$output .= '<ul class="'.$args['class_container'].'">';
	if( $args['style'] != 'list' )
		$output = '<div class="'.$args['class_container'].'">';

	//Get the current letter
	$current_letter = get_query_var( SNAP_SLUG );
	
	//Set the active class foe the all link if needed
	$active = '';
	if( empty( $current_letter ) )
		$active ='class="'.$args['class_current'].'"';
	
	// Set the starting tag for the all link
	if( $args['style'] != 'list' )
		$output .= '<span ';
	else
		$output .= '<li ';
	
	//Add active class
	$output .= $active.'>';
	
	// Set the link for the all
	$output .= '<a href="'.get_snap_url( 'all' ).'">'.$args['all_title'].'</a>';
	
	// Set the ending tag for the all link
	if( $args['style'] != 'list' )
		$output .= '</span>';
	else
		$output .= '</li>';
	
	//Get the letters with posts
	$post_letters = get_letters_in_snap();
	
	//Make a range for A to Z
	foreach ( range ( 'A','Z' ) as $letter ) {
	
		//Exclude the letter if specified
		if( !empty( $excludes ) )
			if( in_array( $letter, $excludes ) )
				continue;
				
		//Display links only on the right letters
		if( in_array( $letter , $post_letters ) ){
			//Set the active class if needed
			$active = '';
			if( $letter == $current_letter  )
				$active ='class="'.$args['class_current'].'"';
			//Echo the li, and get the right url with the current letter of the foreach
			if( $args['style'] != 'list' )
				$output .= '<span ';
			else
				$output .= '<li ';
			
			//Set the class for the element
			$output .= $active.'>';
			
			//Set the link for the letter
			$output .= '<a href="'.get_snap_url( false, $letter ).'">'.$letter.'</a>';
				
			if( $args['style'] != 'list' )
				$output .= '</span>';
			else
				$output .= '</li>';
		}else{
			if( $args['style'] != 'list' )
				$output .= '<span class="empty"> ';
			else
				$output .= '<li><span>';

			//Echo the letter without link
			$output .= $letter;
			
			if( $args['style'] != 'list' )
				$output .= '</span>';
			else
				$output .= '</span></li>';
		}
	} 
	
	//End the container tag
	if( $args['style'] != 'list' )
		$output .= '</div>';
	else
	$output .= '</ul>';
	
	//Echo or return the links
	if( $args['echo'] != true )
		return $output;
	
	echo $output;
}
?>