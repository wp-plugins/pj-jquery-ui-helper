=== PJ jQuery UI Helper ===
Contributors: pjokumsen
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=T4KCYGJYRJHS4
Tags: jquery ui, dialog, tabs
Requires at least: 3.8.1
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin to incorporate jQuery UI in posts and pages using shortcodes.

== Description ==

This plugin allows you to use jQuery UI's widgets with a simple to advanced shortcode in your pages or posts.

Here is a list of the current widgets and their corresponding shortcodes:

* Dialog - Used with \[pjjuh-dialog\]*contents*\[/pjjuh-tab\] to create a button where the shortcode is inserted that will open a dialog with the contents of the tag (or you can set an attribute of page to a title of one of the pages on your site to load the contents of that page into the dialog that is opened from pressing the button). For more information on how to use this please visit [my site](http://pjokumsen.co.za/wordpress/plugins/pj-jquery-ui-helper/).
* Tabs - Used with \[pjjuh-tab-group\] and then \[pjjuh-tab title="tab-title"\]*contents*\[/pjjuh-tab\] to create a tab with the title "tab-title" that contains the contents specified. For more information on how to use this please visit [my site](http://pjokumsen.co.za/wordpress/plugins/pj-jquery-ui-helper/). 
* Accordion - Used with \[pjjuh-accordion\] and then \[pjjuh-acc-section title="section-title"\]*contents*\[/pjjuh-acc-section\] to create a section with the title "section-title" that contains the contents specified. For more information on how to use this please visit [my site](http://pjokumsen.co.za/wordpress/plugins/pj-jquery-ui-helper/).

Widgets I hope to add in the near future are:

* Tooltips

I also hope to allow more variations for the widgets in the near future.

== Installation ==

1. Upload files to the `/wp-content/plugins/` directory, in their own directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add shortcodes to your pages/posts as you like

== Frequently Asked Questions ==

= How can I create a dialog? =

Find where you would like to place the button, in that location (In Page/Post edit) insert \[pjjuh-dialog\]\{contents\}\[/pjjuh-dialog\] where \{contents\} is the contents you would like to have inside of your dialog.

= How can I create tabs? =

Find where you would like to place your tabs section, in that location (In Page/Post edit) insert \[pjjuh-tab-group\]\[pjjuh-tab title='\{tab-title\}'\]\{contents\}\[/pjjuh-tab\]\[/pjjuh-tab-group\] where \{contents\} is the contents you would like inside of that tab and \{tab-title\} is the text that will show in the tab's button. Take a look at screenshots for an example.

= Are there more attributes I can use in the shortcodes? =

Yes! There is a list of accepted attributes here: [Plugin Website](http://pjokumsen.co.za/wordpress/plugins/pj-jquery-ui-helper/).

= Are there themes that I can choose from? =

Yes! There are currently 3 supported themes, check out the screenshots page to see how they look. The themes can be selected in the Plugin Options menu (PJ jQuery UI Helper, on the side of your admin page).

== Screenshots ==

1. An example of a dialog using the shortcode \[pjjuh-dialog\].
2. An example of tabs using the shortcode \[pjjuh-tab-group\] and \[pjjuh-tab\].
3. An example of an accordion using the shortcode \[pjjuh-accordion\] and \[pjjuh-acc-section\].

Examples of themes

4. blue theme
5. base theme
6. flick theme
7. trontastic theme

== Changelog ==

= 1.0.8 =
* Updated themes to 1.11.4

= 1.0.7 =
* Implemented heightStyle option for Accordions as height_style parameter in \[pjjuh-accordion\] shortcode. Defaults to "auto" if not used.

= 1.0.6 =
* Applied font sizing to Tabs section

= 1.0.5 =
* Included accordion functionality

= 1.0.4 =
* Added 'trontastic' theme for darker websites

= 1.0.3 =
* Used WordPress jQuery UI scripts
* Updated to allow for multiple dialogs on a page/post

= 1.0.2 =
* Added settings for user to set default width and height for dialogs.

= 1.0.1 =
* Included tabs functionality.
* Allow for user to choose themes, more themes to be added.

= 1.0.0 =
* Created plugin with dialog functionality.

== Upgrade Notice ==

= 1.0.5 =
Accordion widget now available

= 1.0.4 =
New theme available

= 1.0.3 = 
Use WordPress scripts

= 1.0.2 =
Tab widget added.