<?php
function install_simple_snap() {
	add_option('key_snap_menu', '1');
	add_option('key_snap_menumisc', '2');
	add_option('key_snap_recent', '10');
	add_option('key_snap_csscls1', 'snap_nav');
	add_option('key_snap_csscls2', 'snap_selected');
	add_option('key_snap_exclude', '');
	add_option('key_snap_fancyurl', '2');
	add_option('key_snap_fancyurlname', 'browse');
	add_option('key_snap_tab1', '0');
}
?>