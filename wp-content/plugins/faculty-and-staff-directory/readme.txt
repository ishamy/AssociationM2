=== Faculty and Staff Directory ===
Contributors: jcummings1974
Donate link: http://www.jcummings.net/
Tags: directory,faculty,staff,university
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: /trunk/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A Faculty and Staff Directory listing for a college, university, or other school.

== Description ==

This plugin was developed to provide a simple and flexible faculty and staff directory for a small college or university. 

After installing and activating, a new custom post type is registered for directory profiles. You’ll also be able to chose an output style from the accompanying settings menu.

The directory itself can be output on any page by using the short code [fsdirectory] anywhere you would like the profile listing to appear.  

See the FAQ section for more information on usage and options.

**Bug Reports or Feature Requests**
https://trello.com/b/6Dni5S3n

**Follow me on Twitter**
https://twitter.com/jcummings1974

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a new faculty/staff profile in the Faculty/Staff Profiles section of the Wordpress admin
4. Place '[fsdirectory]' in your page or post where you want the directory to display
5. Visit the “FS Settings” settings sub-menu to choose your sort and display styles.

== Frequently Asked Questions ==

= Can I control how the directory is output? =

Yes. The plugin adds a submenu to the settings panel that allows you to choose a display type, as well as how you would like the directory sorted.  The menu is located beneath the main settings menu as a sub-menu.

= Can I control the display order of directory entires? =

Yes. When you're creating an entry, use the "Order" input to insert a numerical sort value to be associated with the page, then visit the settings panel and choose to sort by "Sort Value".

= What are the different display options? =

There are four primary display options (most are self explanatory) that include a 1, 2 and 3 columnar display, and a simple list option that outputs the directory entries as list items in a UL.

= Can I add my own styles to the output? =

Yes - the “Simple List” display option is provided to be the easiest way for you to apply your own styling to the directory information.   It includes as little styling as possible to make it easier for people to make changes/overrides.

If you want to change the other display styles, a faculty-staff-style-override.css stylesheet is included and called by the plugin.  Any changes you make to styles in this stylesheet will take precedence over the default styles.  

Each entry is included in a div with the class ‘fsentry’. All entries are wrapped in a parent section block with a class of ‘facstaff’.

= Can I disable the default thumbnail images for users with no picture? =

Yes, this is a setting in the settings menu and it applies to any of the three columnar styles.  The simple list style doesn’t include the images because it’s just that, a simple list.

= Can I export my entries to a file? =

Because this plugin registers and makes use of built-in Wordpress custom post type functionality, all faculty-staff profile entires will be available for XML export using the standard Wordpress post export functionality.  

A link is included directly to the export section of the admin on the directory settings menu for simplicity, but all of the export functionality is core Wordpress.

= Are there any plans to add vCard or hCard compatibility? =

Yes.  Right now, if you choose the “Simple List” display option, you’ll find that the list that is produced includes valid hCard markup for each directory entry.  I am looking at expanding this in the future to include the ability to export an individual entry to vCard.

= Can I disable the default styling/sizing of the profile thumbnail? = 

Yes. In the FSDirectory settings menu, change the “Apply CSS skin to thumbnails” setting to “No’. This is set to yes by default.

= How do I use the Faculty/Staff Widget? =

The widget allows you to feature a profile in a widget area by allowing you to supply the title for the widget, and the post ID of the profile that you want to feature.

To find your post ID, go to “Faculty and Staff Profiles” in the Wordpress admin, and highlight the title of the profile you want to feature.  You will see the post ID in the URL.  Enter that in the post ID field of the widget, and that profile will be featured in the sidebar.

The widget uses the name, title, thumbnail photo and whatever is included in the ‘Excerpt’ field for that user profile.

The excerpt field allows you to specify curated text for the featured bio widget.  This will generally be a better option that attempting to display the full profile due to limited space in widget areas.

= How do categories work? = 

Categories were introduced in version 1.5 to accommodate users who want to use the plugin for listing people who need to be grouped in to specific subgroups (like sales representatives that cover a state of set of states).  To display users by category, first make sure that you’ve created profile entries with categories assigned using the category meta box to the right of the main entry window to add the category you want the profile you’re adding to be associated with.

Once you’ve done that, make sure to choose ‘By Category’ as the display style in the FSDirectory settings menu.  This will output a list of all profiles separated by the categories you’ve created with a link back the original profile post.

= How do I get support or make a feature request? =

Feature requests, support, and questions can all be addressed to the public Faculty and Staff Directory Trello board at https://trello.com/b/6Dni5S3n   

== Screenshots ==

== Changelog ==

= 1.51 = 
* Bug fix: Profile name now correctly links to the custom post type entry content on all display templates.

= 1.50 =
* Filling Joe F’s Feature request: Profile name and photo now link back to the user profile page in the profile list.
* Filling LTCreative Solutions Feature request: Profiles now support optional category entry , listing profiles by category, and a field for company name in the profile info page.
* Other minor bug fixes.

= 1.42  =
Wordpress 4.0 compatibility release

= 1.41 =
Fixed a bug where title was placed after bio in single column layout.
Fixed a bug that was preventing phone number from appearing in the output.
Fixed a bug that was causing Twitter information to be saved as LinkedIn and Web.
After discussion with some users, removed required fields from post type.

= 1.4 =
Bug fixes.
Added custom formatting for single post custom display type from within plugin.

= 1.3 =

Fixed a bug that left sizing on images after no styling was selected.
Fixed a bug that was causing a jQuery undefined error on the three column template.
Added padding around profile images where default styling was removed.
Added support for rich text bio creation and display.
Added widget functionality, allowing you to feature a bio by post id.

= 1.2 = 

Added a new option in the settings menu that allows the user to disable thumbnail styling on profile pictures. 
Fixed a bug related to the fields of existing profiles clearing when mouse focus was placed in the field.

= 1.1 =

Major IE compatibility fixes. Auto-size divs for one, two and three column output.

= 1.0 =

Initial release