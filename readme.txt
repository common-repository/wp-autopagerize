=== Plugin Name ===
Contributors: 5509-1,rewish
Tags: post, autopagerize, pager, plugin
Requires at least: 2.8.1
Tested up to: 2.9.2
Stable tag: 1.0.2.5.3

This plugin adds pager and autopagerize function to your blog.

== Description ==

Version 1.0.2.4: <strong>Some bugs fixed.</strong>

A few notes about the sections above:

* This plugin contains pager func that will work WordPress 2.7 or higher
* You can use 'AutoPagerize' or 'ButtonPagerize'

== Installation ==
How to install the plugin and get it working.

1. Upload `wp-autopagerize` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php if(function_exists('wp_autopagerize')) { wp_autopagerize(); } ?>` after `<?php endwhile; ?>` in your templates
4. You can change settings in your WordPress admin menu 'Settings'