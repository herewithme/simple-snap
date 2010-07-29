<?php
function simple_snap_add_option_page() {
	add_options_page( __('Simple SNAP', 'simplesnap'), __('Simple SNAP', 'simplesnap'), 'manage_categories', 'simple-snap', 'simple_snap_options_subpanel' );
	add_meta_box( 'simplesnap', __( 'Glossary option', 'simplesnap' ), 'glossary_option' , GLOSSARY_POSTTYPE, 'side' );	
}

function simple_snap_options_subpanel() {
	if (isset($_POST['info_update'])) { 

		$whitespace = array(" ", "\t", "\n", "\r", "\0", "\x0B");
		$snap_fancyurl = strip_tags(str_replace($whitespace, '', $_POST['key_snap_fancyurlname']));

		check_admin_referer('simple_snap_update_options');
		update_option('key_snap_menu', (int) $_POST['key_snap_menu']);
		update_option('key_snap_menumisc', (int) $_POST['key_snap_menumisc']);
		update_option('key_snap_recent', (int) $_POST['key_snap_recent']);
		update_option('key_snap_csscls1', (string) $_POST['key_snap_csscls1']);
		update_option('key_snap_csscls2', (string) $_POST['key_snap_csscls2']);
		update_option('key_snap_exclude', $_POST['key_snap_exclude']);
		update_option('key_snap_fancyurl', (int) $_POST['key_snap_fancyurl']);
		if (!empty($snap_fancyurl)) {
			update_option('key_snap_fancyurlname', (string) $snap_fancyurl);
		}
		update_option('key_snap_tab1', (int) $_POST['key_snap_tab1']);

		echo '<div id="message" class="updated fade"><p><strong>'.__('Options successfully updated.', 'simplesnap').'</strong></p></div>';
	} 
	
	include( dirname(__FILE__) . '/admin.tpl.php' );
}
?>