<?php
	function simple_snap($snapquery = '') {
	if (!empty($snapquery)) {
		parse_str($snapquery, $snapqueryarray);
	}

	$nav = new simple_snap_core();	

	if (isset($snapqueryarray['child'])) {
		$nav->ifchildren = true;
	} else {
		$nav->ifchildren = false;
	}

	if (isset($snapqueryarray['menu'])) {
		$nav->menustyle = $snapqueryarray['menu'];
	}

	if (isset($snapqueryarray['firstload'])) {
		$nav->firstload = strtoupper(trim($snapqueryarray['firstload']));
	}
	
	$letter = get_query_var('letter');
	$nav->first_letters = empty( $letter ) ? "ABCDEFGHIJKLMNOPQRSTUVWXYZ" : $letter ;

	$results = $nav->navigation();

	return $results;
}
?>