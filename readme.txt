=== CleanCodeNZ Favorite Posts Plugin  ===
Contributors: cleancodenz
Donate link: http://www.cleancode.co.nz/
Tags: google,analytics,favorite,posts,wordpress,plugin
Requires at least: 2.0.2
Tested up to: 3.0
Stable tag: trunk

This plugin uses Google Analytics API to get the stats of favorite posts of your wordpress blogs and list them in a table

== Description ==
If your wordpress site is tracked by Google Analytics, then you can get access to all those stats about your site like visitors, keywords and pageviews.
But it is not easy to present some of those stats on your wordpress site if you want to, like which posts are visitor's favorite posts? because data in Google Analytics 
about the sites you are tracking are private to the account holder, not to the general public.

This plugin uses Google Analytics API to get the stats of favorite posts of your wordpress blogs and list them in a table

To use this plugin, you need a Google Analytics Account and a profile which is your wordpress install, your Google Analytics information are encrypted and saved in options.

Any issues: [contact me](http://www.cleancode.co.nz/contact).

== Installation ==

1. Ensure that extension php_curl is enabled for your php server
2. Upload this directory to your plugins directory. It will create a 'wp-content/plugins/cleancodenzfavposts/' directory
3. WordPress users should go to their Plugins page and activate "CleanCode NZ Favorite Posts Plugin".
4. Now go to Settings->CleanCodeNZFP, type in your google analytics account and profile id
5. Place `<!-- cleancodenzfavoritepostsgen -->` in your pages or posts, or place `<?php cleancodenz_create_favposts(); ?>` in your template.

== Frequently Asked Questions ==

= Where can I find help for this plugin =

You can find more information of this plugin from [CleanCodeNz Favorite Posts Plugin](http://www.cleancode.co.nz/cleancodenz-favorite-posts-wordpress-plugin "Favorite Posts List From Google Analytics!")

== Screenshots ==

Screenshots at: [CleanCodeNz Favorite Posts Plugin](http://www.cleancode.co.nz/cleancodenz-favorite-posts-wordpress-plugin "Favorite Posts List From Google Analytics!")

== Changelog ==

= 1.0.1 =
* Start date of report period added to option .

== Upgrade Notice ==

None
