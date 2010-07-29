=== WP-SNAP! ===
Contributors: momo360modena
Donate link: 
Tags: navigation, alphabetical, post, page, glossary, index, reviews
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.0

WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an user interface for navigating alphabetized post titles.

== Description ==

WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an alphabetical listing of post titles on a Category or Page template file. Navigation through the listings WP-SNAP! generates is accomplished using the alphabet itself. (For example, if a site visitor clicked on the letter D, any post titles that began with that letter would be showcased.) WP-SNAP! will work on any Wordpress 2.1.x or higher site, but is particularly useful managing glossaries, indexes, reviews, or directories.
WP-SNAP! offers three different navigational styles and integration with both custom permalinks and the Wordpress loop. Plugin options can be managed both site-wide and on the template itself with results either restricted to one category or broadened to include child categories as well. The clever web developer should have no problem seamlessly integrating WP-SNAP! into their latest project. Options have also been added to allow the customization of css class names and the appearance of html mark-up.

== Installation ==

1. Download the WP-SNAP! WordPress Plugin, extract it and upload it to your WordPress Plugins folder on your site.
2. Activate the Plugin from the WordPress Administration Plugins tab.
3. Edit the category templates your Theme uses, such as category.php, and add the following code above the start of the Wordpress Loop:
    <?php if (function_exists('simple_snap')) { echo simple_snap(); } ?>
4. Copy the CSS example below and paste it into your WordPress Theme stylesheet (you can style it better later).
5. Upload the files and refresh the category page on your WordPress blog to see it in action.
6. For further customization, go to the Options > WP-SNAP! panel and change the alphabetical structure to something different and click Update Options. You may also change the categories to be displayed and the menu navigational structure by passing variables as a query-string to the plugin like so:  
    <?php if (function_exists('simple_snap')) { echo simple_snap('arguments'); ?>
There are currently four possible arguments: Category ('cat'), Include Category Children ('child'), Navigational Menu Style ('menu'), and First Load ('firstload'). Category must equal a category number from your WordPress installation, Include Category Children must equal true or false as to whether to include child categories (the default value is false), Navigational Menu Style must equal a number between 1 and 3 (corresponding with the three navigational styles offered in the admin options panel), and First Load must equal ALL, NONE or RECENT and will affect how WP-SNAP! displays posts/tags when it is first called on a template. Note that if RECENT is selected, the number of recent posts/tags to display can be controlled from the admin options page. For instance, to create a navigational menu for all posts in category 15, including child categories, using the default menu navigational style, and displaying recent posts on first load, WP-SNAP! would be called like this:
    <?php if (function_exists('simple_snap')) { echo simple_snap('cat=15&child=true&firstload=recent'); } ?>
To create a navigational menu for the current category, excluding children and using navigational menu style 3, WP-SNAP! would be called like this:
    <?php if (function_exists('simple_snap')) { echo simple_snap('menu=3'); } ?>
To create a navigational menu for all categories, using default navigational menu style, WP-SNAP! would be called like this:
    <?php if (function_exists('simple_snap')) { echo simple_snap('cat=all'); } ?>
7. Test it out and enjoy!

Note: For the Plugin to work, you must have access to edit your WordPress Theme files. You must also have a category.php template file in your WordPress Theme. If you do not, you can create one following the instructions on the WordPress Codex for creating a category template file.

== Frequently Asked Questions ==

= When will the next version of your plugin be released? =
As soon as I find the time, I will update the plugin and release a new version. I understand how frustrating it can be to be so close to having the perfect Wordpress installation only to be held up by a plugin that just needs a little more work to be exactly what's needed. However, please remember that I am not paid write this plugin and that, like you, I have a family and responsibilities that extend far beyond this little piece of code. I really appreciate your enthusiasm, but if you wish to reap the benefits of my freely given labor, then you must be satisfied with doing so on my timetable. Otherwise, if you simply cannot wait, you are more than welcome to modify and extend the capabilities of my plugin yourself.

= Why do the results WP-SNAP! returns look funky? Why is it numbering every item? =
A web page is composed of two parts: a document containing HTML code and a document containing styling code (known as a Cascading Style Sheet, or CSS for short). Because WordPress templates can look so drastically different from one another, I have intentionally avoided injecting any CSS information into WP-SNAP! However, I have included several ID selectors (that can even be modified from within wp-admin) that should allow you to style WP-SNAP! to look however you'd like. Those numbered lists? You can turn them off. I do ask that you try to refrain from asking me CSS related questions -- while I would love to help you, my time is limited. If you would like to learn more about CSS, I suggest visiting A List Apart or Vitamin.

= I tried using your plugin, but it just won't work. What am I doing wrong? =
Unfortunately, I don't have the time to troubleshoot every installation of this plugin. However, if you believe you have discovered a bug, I encourage you to post a comment to my website and I will reply as soon as I can. I do request that you be as specific as possible when asking for assistance. Please provide a detailed account of the steps you took that resulted in the error you encountered so that I can try to reproduce it and more quickly deduce how to fix it.

== Changelog ==

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
