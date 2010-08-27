=== WP-SNAP! ===
Contributors: momo360modena
Donate link: 
Tags: navigation, alphabetical, post, page, glossary, index, reviews
Requires at least: 3.0.1
Tested up to: 3.0
Stable tag: 2.0

WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an user interface for navigating alphabetized post titles.

== Description ==

WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an alphabetical listing of post titles on a Category or Page template file. Navigation through the listings WP-SNAP! generates is accomplished using the alphabet itself. (For example, if a site visitor clicked on the letter D, any post titles that began with that letter would be showcased.) WP-SNAP! will work on any Wordpress 2.1.x or higher site, but is particularly useful managing glossaries, indexes, reviews, or directories.
WP-SNAP! offers three different navigational styles and integration with both custom permalinks and the Wordpress loop. Plugin options can be managed both site-wide and on the template itself with results either restricted to one category or broadened to include child categories as well. The clever web developer should have no problem seamlessly integrating WP-SNAP! into their latest project. Options have also been added to allow the customization of css class names and the appearance of html mark-up.

== Installation ==

1. Download the WP-SNAP! WordPress Plugin, extract it and upload it to your WordPress Plugins folder on your site.
2. Activate the Plugin from the WordPress Administration Plugins tab.
3. Create a type-glossary.php file, you can copy/paste the content of the category.php file and add this code before the Wordpress loop :
    <?php if (function_exists('get_the_snap')) { echo get_the_snap(); } ?>
4. There is currently nine possible arguments : 		
	'style', 'class_container', 'class_current', 'title', 'before_title', 'after_title', 'all_title', 'echo', 'exclude'	
	You can exclude the letters by calling the navigation like this :
		<?php if (function_exists('get_the_snap')) { echo get_the_snap( exclude => 'A,B,C,D' ); } ?>
	So in this example the letters A,B,C,D wouldn't be displayed in the navigation
	Or you can change the title before the navigation like this :
		<?php if (function_exists('get_the_snap')) { echo get_the_snap( title => 'The navigation' ); } ?>
5. You can have taxonomy for your post_type so by default you can make:
	yoursiteurl/glossary/cat-lexique/yourterm/
	or :
	yoursiteurl/glossary/cat-lexique/yourterm/letter/A
	
	And the posts are directly filtered
	
6. Test it out and enjoy!


== Changelog ==
08.2010.27 Version 2.0
	* Totally change the plugin
	* Have his own rewrite rules
	* Template for main page and letter
	* Function for displaying the navigation menu with args

01.2010.13 Version 0.9
	* Place admin on right menu
	* Some technical ajustment
	
02.2009.20 Version 0.8.6
	* Fixed bug with posts beginning with misc. letters on sites not using
	  fancy URLs
	* Fixed bug with adminstrative menu

06.2008.10 Version 0.8.5
	* Added international language file support
	* Changed the method for passing data to the plugin
	* Tracked down bugs

06.2008.08 Version 0.8.4
	* Made the plugin compatible with Wordpress's new tagging system
	* Corrected problem with listing recent posts

04.2008.03 Version 0.8.3
	* Fixed a small -- but significant -- typo
	* Moved the administrative submenu to plugins.php
	* Added the ability to display All/None/Recent posts on first load

12.2007.02 Version 0.8.1
	* Fixed incompatibility with PHP 4

11.2007.28 Version 0.8
	* Added support for fancy URLs

10.2007.04 Version 0.7.3
	* Fixed error with Wordpress 2.3 database call

09.2007.28 Version 0.7.2
	* Made database call compatible with Wordpress 2.3

06.2007.02 Version 0.7.1
	* Fixed error with database call

05.2007.30 Version 0.7
	* Fixed issue preventing the display of more than 10 posts
	* Fixed issue with sorting uppercase/lowercase post titles
	* Restored ability to pass a category to the plugin
	* Added ability to include category children in returned results
	* Added ability to display all categories
	* Added ability to change navigation style when calling the plugin
	* Added support for Gengo (hopefully)

05.2007.12 Version 0.6.2
	* Restored the ability to exclude first words from being alphabetized
	* Cleaned-up some instructional text in the options menu

01.2007.21 Version 0.6.1
	* Fixed a minor error with the $simple_snap_category variable

01.2007.20 Version 0.6
	* Rebuilt the entire plugin to be better, stronger, faster
	* Changed how results are displayed; plugin now plays well with the
	  Wordpress loop
	* Removed option to pass a category number directly to the plugin,
	  making it incompatible with Pages (feature to return if requested)
	* Added nonce protection to the admin options panel
	* Added option to group posts beginning with a number under '#'
	* Fixed unencoded ampersands

09.2006.20 Version 0.5.4
	* Updated WP-SNAP! to ignore posts with post-dated timestamps

08.2006.02 Version 0.5.3
	* Fixed an error that affected certain navigational menu styles

08.2006.01 Version 0.5.2
	* Updated alphabetization to accomodate accent marks; still needs refinement
	* Fixed a logic error with the post title sort loop

06.2006.07 Version 0.5.1
	* Squashed some bugs in the new ignore filter

06.2006.06 Version 0.5
	* Words can now be filtered from the alphabetization process from the WP-SNAP!
	  admin options menu

06.2006.01 Version 0.4
	* Added '#' to catch category entries beginning with
	  non-alphanumeric characters
	* Tweaked the code here and there
	* Fixed the WP-SNAP! plugin url on the admin options page

05.2006.13 Version 0.3.1
	* Fixed the url structure of the navigation when used on a Page
	* Added 'apply_filters' to the post excerpt

05.2006.08 Version 0.3
	* Plugin no longer displays excerpts for password protected posts, if
	  the viewer is unauthorized
	* If there is no excerpt for a post and excerpts are turned on, plugin
	  now creates an excerpt from the post content
	* Fixed a typo

03.2006.29 Version 0.2
	* Added the ability to pass a category number directly to the plugin,
	  making WP-SNAP compatible with Pages

03.2006.29 Version 0.1
	* Inital release
