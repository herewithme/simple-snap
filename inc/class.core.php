<?php
class simple_snap_core {
	var $cat;
	var $tag;
	var $ifchildren;
	var $first_letters;
	var $menustyle;
	var $firstload;
	var $first_letter_all_posts;
	var $slug;
	var $exclude;
	var $simple_snap_options;

	function accents($str) {
		$str = htmlentities($str);
		$str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$str);
		return html_entity_decode($str);
	}

	function navigation() {
		global $wpdb, $wp_query, $user_ID, $gengo, $wp_version;

		// Define variables
		$this->simple_snap_options = array(
			'menu' => get_option('key_snap_menu'),
			'menumisc' => get_option('key_snap_menumisc'),
			'recent' => get_option('key_snap_recent'),
			'csscls1' => get_option('key_snap_csscls1'),
			'csscls2' => get_option('key_snap_csscls2'),
			'tab1' => get_option('key_snap_tab1'),
			'fancyurlname' => get_option('key_snap_fancyurlname'));
		
		$this->slug = empty( $this->simple_snap_options['fancyurlname'] ) ? $this->simple_snap_options['fancyurlname'] : GLOSSARY_POSTTYPE ;
		
		$ver = (float)$wp_version;
		$url = home_url();
		
		$date = gmdate('Y-m-d H:i:59');
		$sch = array('&quote;', '&apost;', ' ');
		$rst = array('"', '\'', ''); // '"
		$this->exclude[0] = str_replace($sch, $rst, get_option('key_snap_exclude'));
		$excsch = array('/[\|]+[0-9A-Z]+[\|]*|[\|]*[0-9A-Z]+[\|]+/i', '/^[0-9A-Z]+$/i');
		$excrst = array('|', '');
		$this->exclude[1] = preg_replace($excsch, $excrst, $this->exclude[0]);
		$excsch = array('/[\|]+[^0-9A-Z]+[\|]*|[\|]*[^0-9A-Z]+[\|]+/i', '/^[^0-9A-Z]+$/i');
		$excrst = array('|', '');
		$this->exclude[2] = preg_replace($excsch, $excrst, $this->exclude[0]);
		$tempstr['1']['0'] = '#' . __('ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'simplesnap');
		$tempstr['1']['1'] = '#' . __('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'simplesnap');
		$tempstr['2']['0'] = '#' . __('A-DE-HI-LM-PQ-TU-Z', 'simplesnap');
		$tempstr['2']['1'] = '#' . __('0-9A-DE-HI-LM-PQ-TU-Z', 'simplesnap');
		$tempstr['2']['2'] = '#';
		$tempstr['2']['3'] = __('0123456789', 'simplesnap');
		$tempstr['2']['4'] = __('ABCD', 'simplesnap');
		$tempstr['2']['5'] = __('EFGH', 'simplesnap');
		$tempstr['2']['6'] = __('IJKL', 'simplesnap');
		$tempstr['2']['7'] = __('MNOP', 'simplesnap');
		$tempstr['2']['8'] = __('QRST', 'simplesnap');
		$tempstr['2']['9'] = __('UVWXYZ', 'simplesnap');
		$tempstr['3']['0'] = '#' . __('A-MN-Z', 'simplesnap');
		$tempstr['3']['1'] = '#' . __('0-9A-MN-Z', 'simplesnap');
		$tempstr['3']['2'] = '#';
		$tempstr['3']['3'] = __('0123456789', 'simplesnap');
		$tempstr['3']['4'] = __('ABCDEFGHIJKLM', 'simplesnap');
		$tempstr['3']['5'] = __('NOPQRSTUVWXYZ', 'simplesnap');
		
		foreach($this->exclude as $index => $value){
			if( empty( $this->exclude[$index] ) )
				$this->exclude[$index] = ' ';
		}
			
		
		if (empty($this->menustyle)) {
			$this->menustyle = $this->simple_snap_options['menu'];
		}

		// Database query
		
		$where = " AND (post_type = '".GLOSSARY_POSTTYPE."' AND (post_status = 'publish'";

		if (is_admin()) {
			$where .= " OR post_status = 'future' OR post_status = 'draft' OR post_status = 'pending'";
		}
		$where .= '))';
		
		$groupby = " GROUP BY $wpdb->posts.ID";
		$request = "SELECT SQL_CALC_FOUND_ROWS $wpdb->posts.* FROM $wpdb->posts WHERE 1=1" . $where . $groupby . " ORDER BY post_date DESC";
		$request = apply_filters('posts_request', $request);
		
		$all_posts = $wpdb->get_results($request);	
		
		if ( $all_posts == false ) {
			return false;
		}	
		
		$all_posts = $this->get_posts_filtered($all_posts);

		$all_posts = array_values($all_posts);

		// Creates where statement needed to modify the wordpress loop
		$wp_query->post_count = count($all_posts);
		$wp_query->posts = $all_posts;

		// Test for post titles beginning with numbers
		$numlogic = '0';
		$numtest = '0';

		for ($i = 0; $i < strlen($this->first_letter_all_posts); $i++) {
			if (is_numeric(substr($this->first_letter_all_posts, $i, 1))) {
				$numlogic = '1';
				$numtest = '1';
			}
		}

		if ($this->simple_snap_options['menumisc'] == '1') {
			$numtest = '0';
		}
		
		// Create tabs based on number input in admin menu
		$num_tabs = '';
		for ($y = 0; $y < $this->simple_snap_options['tab1']; $y++) {
			$num_tabs .= "\t";
		}

		// Insert ordered list tag for navigational menu, include class information
		$results = $num_tabs . '<ol';
		if ($this->simple_snap_options['csscls1']) {
			$results .= ' class="' . $this->simple_snap_options['csscls1'] . '">' . "\n";
		} else {
			$results .= ">\n";
		}

		// Check if ALL posts are to be displayed on first load
		if ($this->firstload == 'ALL') {
			$results .= $num_tabs . "\t<li";
			if ($this->first_letters == '#0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
				$results .= ' class="' . $this->simple_snap_options['csscls2'] . '"';
			} else {
				$results .= '><a href="' . $url . '"';
			}
			$results .= '><span class="all-letters">'.__('ALL', 'simplesnaap').'</span>';
			if ($this->first_letters !== '#0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
				$results .= '</a>';
			}
			$results .= "</li>\n";
		}

		// Test to see if non-alphanumeric characters were used in titles
		if (($numlogic == '0' || $this->simple_snap_options['menumisc'] == '2') && (preg_match('/[0-9A-Z]+/i', substr($this->first_letter_all_posts, 0, 1)))) {
			$tempstr[$this->menustyle][$numtest] = str_replace('#', '', $tempstr[$this->menustyle][$numtest]);
		} else {
			$simple_snap_misc = TRUE;
		}

		// Create navigational menu list items
		switch ($this->menustyle) {
			case 1:
				for ($i = 0; $i < strlen($tempstr[$this->menustyle][$numtest]); $i++) {
					$l = substr($tempstr[$this->menustyle][$numtest], $i, 1);
					$nav_entry_test = FALSE;
					$results .= $num_tabs . "\t<li";

					if ($l == $this->first_letters)
						$results .= ' class="' . $this->simple_snap_options['csscls2'] . '"';

					$nav_entry = '><span>' . $l . "</span></li>\n";

					for ($y = 0; $y <  strlen($this->first_letter_all_posts); $y++) {
						if ($nav_entry_test !== TRUE && ($l == substr($this->first_letter_all_posts, $y, 1) || ($l == '#' && preg_match('/[^0-9A-Z]+/i', substr($this->first_letter_all_posts, 0, 1))) || ($l == '#' && $this->simple_snap_options['menumisc'] == '1' && preg_match('/[^A-Z]+/i', substr($this->first_letter_all_posts, 0, 1))))) {
							
							$nav_entry = '>';
							$nav_entry .= '<a href="'.$this->generate_url( $l ).'">';
							$nav_entry .= $l;
							$nav_entry .= '</a>';
							$nav_entry .= "</li>\n";
								
							$nav_entry_test = TRUE;
						}
					}
					$results .= $nav_entry;;
				}
				break;
			case 2:
			case 3:
				// Create a count that will allow $tempstr to be used in creating the URL query
				if (substr($tempstr[$this->menustyle][$numtest], 0, 1) == '#') {
					$simple_snap_count = 2;
				} else {
					$simple_snap_count = 4 - $numtest;
				}
				for ($i = 0; $i < strlen($tempstr[$this->menustyle][$numtest]); $i = $i + $simple_snap_adv) {
					if ($tempstr[$this->menustyle][$simple_snap_count] == '#') {
						$l = '#';
						$simple_snap_adv = 1;
					} else {
						$l = substr($tempstr[$this->menustyle][$numtest], $i, 3);
						$simple_snap_adv = 3;
					}

					$results .= $num_tabs . "\t<li";
					if (strstr($this->first_letters, substr($l, 0, 1))) {
						$results .= ' class="' . $this->simple_snap_options['csscls2'] . '"';
					}
					$nav_entry = '>' . $l . "</li>\n";

					if (preg_match('/[' . $this->first_letter_all_posts . ']+/i', $tempstr[$this->menustyle][$simple_snap_count]) || ($l == '#' && preg_match('/[^0-9A-Z]+/i', $this->first_letter_all_posts)) || ($l == '#' && $this->simple_snap_options['menumisc'] == '1' && preg_match('/[^A-Z]+/i', $this->first_letter_all_posts))) {
						
						$nav_entry = '>';
						$nav_entry .= '<a href="'.$this->generate_url( $l ).'">';
						$nav_entry .= $l;
						$nav_entry .= '</a>';
						$nav_entry .= '</li>';
					}
					$results .= $nav_entry;
					if ($simple_snap_count == 2) {
						$simple_snap_count = 4 - $numtest;
					} else {
						++$simple_snap_count;
					}
				}
				break;
		}
		$results .= $num_tabs . "</ol>\n";
		
		return $results;
	}
	
	function generate_url( $letter ) {
		$permalink_structure = get_option('permalink_structure');
		if ( '' == $permalink_structure ) {
			$link = home_url("?post_type=" .GLOSSARY_POSTTYPE.'&letter='.$letter);
		} else {
			$link = home_url( get_option( 'key_snap_fancyurlname').'/'.$letter );
			$link = trailingslashit($link);
		}		
		return $link;
	}
	
	function get_posts_filtered($all_posts){
	
		// Create a string containing the first letters of the post titles retrieved above
		for ($i=0; $i < count($all_posts); $i++) {
			$word_results[$i] = preg_replace('/^(' . $this->exclude[1] . ')+((' . $this->exclude[2] . ')[\s]+)*|^(' . $this->exclude[2] . ')[\s]+/i', '', remove_accents($all_posts[$i]->post_title));
		}
	
		// Performs a "natural sort" then re-orders the array's key values to match the new order
		natcasesort($word_results);
		$word_results = array_values($word_results);
		
		foreach ($word_results as $word_result) {
			$this->first_letter_all_posts .= strtoupper(substr($word_result, 0, 1));
		}
		
		// If no query is found in the url, select first post title letter
		if ($this->first_letters == NULL && $this->firstload !== 'RECENT') {
			if ($this->firstload == 'NONE') {
				$this->first_letters = ' ';
			} elseif ($this->firstload == 'ALL') {
				$this->first_letters = '#0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			} elseif ((preg_match('/[^0-9A-Z]+/i', substr($this->first_letter_all_posts, 0, 1))) || (($this->simple_snap_options['menumisc'] == '1') && (preg_match('/[^A-Z]+/i', substr($this->first_letter_all_posts, 0, 1))))) {
				$this->first_letters = '#';
			} elseif ($this->menustyle == '1') {
				for ($i=0; $i < strlen($this->first_letter_all_posts); $i++)
					$temp_letter[$i] = substr($this->first_letter_all_posts, $i, 1);
				natsort($temp_letter);
				$temp_letter = array_values($temp_letter);
				$this->first_letters = $temp_letter['0'];
			} else { 
				for ($i=3; $i < count($tempstr[$this->menustyle]); $i++)
					if (strstr($tempstr[$this->menustyle][$i], substr($this->first_letter_all_posts, 0, 1)))
						$this->first_letters = $tempstr[$this->menustyle][$i];
			}
		}
		
		if ($this->firstload == 'RECENT' && $this->first_letters == NULL) {
			for ($i=0; $i < count($all_posts); $i++) {
				if ($this->simple_snap_options['recent'] <= $i) {
					$all_posts[$i] = NULL;
				}
			}
		} else {
			// Resorts $simple_snap_posttitles, taking excluded words into account
			for ($i=0; $i < count($all_posts); $i++) {
				if (preg_replace('/^(' . $this->exclude[1] . ')+((' . $this->exclude[2] . ')[\s]+)*|^(' . $this->exclude[2] . ')[\s]+/i', '',  remove_accents($all_posts[$i]->post_title)) !== $word_results[$i]) {
					$simple_snap_holdtitle = $all_posts[$i];
					for ($j=$i+1; $j < count($all_posts); $j++) {
						if (preg_replace('/^(' . $this->exclude[1] . ')+((' . $this->exclude[2] . ')[\s]+)*|^(' . $this->exclude[2] . ')[\s]+/i', '',  remove_accents($all_posts[$j]->post_title)) == $word_results[$i]) {
							$all_posts[$i] = $all_posts[$j];
							$all_posts[$j] = $simple_snap_holdtitle;
							break;
						}
					}
				}
if (($this->simple_snap_options['menumisc'] == '2' && $this->first_letters == '#' && preg_match('/^[0-9A-Z]+/i', substr($word_results[$i], 0, 1))) || ($this->simple_snap_options['menumisc'] == '1' && $this->first_letters == '#' && preg_match('/^[A-Z]+/i', substr($word_results[$i], 0, 1))) || ($this->first_letters !== '#' && preg_match('/^[^' . $this->first_letters . ']+/i', substr($word_results[$i], 0, 1)))) {
					$all_posts[$i] = NULL;
				}
			}
		}
		
		foreach ($all_posts as $key => $value) {
			if ($value == NULL) { 
				unset($all_posts[$key]);
			}
		}
		
		return $all_posts;
	}
}
?>