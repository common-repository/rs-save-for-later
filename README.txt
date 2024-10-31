=== Simplicity Save for Later ===
Contributors: ratkosolaja, simplicitywp
Tags: save for later, bookmark, pocket, logged out, wishlist
Requires at least: 3.0
Tested up to: 4.8
Stable tag: 1.0.8
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Save content for later.

== Description ==

**Simplicity Save for Later** will add a button to your posts/pages/custom post types so users who aren't logged in as well as ones who are, can save that content so they can access it later. This plugin uses cookies to make this possible. This plugin is light, fast (ajax powered) and coded with best practice.

Upon activation this plugin will create a page called "Saved for Later", and when a user access it, it will show him his saved content. When you deactivate this plugin, that page will be deleted as well.

**NOTE:** Since the plugin name has changed, so did the shortcodes. Make sure you change "rs" prefix to "simplicity":
**NOTE 2:** In the next version I will implement some additional features as well as change how cookies are being saved. This is going to be a pretty big update. :)

1. In Saved for Later page, use [simplicity-saved-for-later] instead of [rs-saved-for-later]
2. If you have included [rs-save-for-later] shortcode anywhere, change it to [simplicity-save-for-later]

**Features:**

* You can choose whether you want this plugin to add a save for later button to the end of your content.
* You can pick on which post types you want to show save for later button.
* You can choose whether you want to use our minimal styling or not.
* Included Shortcode
* You can enable this plugin to be visible only for logged in users.
* Users can clear all of their saved items with one click.

**Live demo can be found over [here](http://ratkosolaja.info/plugins/2016/07/10/possimus-quisquam-animi-omnis-laboriosam/).**

== Installation ==

They are two ways we can go about this: **Using the WordPress Plugin Search** or **Using the WordPress Admin Plugin Upload**.

Using the WordPress Plugin Search:

1. Go to WordPress admin area.
2. Click on Plugins > Add New.
3. In the Search box, type in **Simplicity Save for Later** and hit enter.
4. Next to the **Simplicity Save for Later** click on the Install Now button.
5. Click on Activate Plugin.

Using the WordPress Admin Plugin Upload:

1. Download the plugin here from our plugin page.
2. Go to WordPress admin area.
3. Click on Plugins > Add New > Upload Plugin.
4. Click on Choose File and select **rs-save-for-later.zip**
5. Click on Install Now button.
6. Click on Activate Plugin.

== Frequently Asked Questions ==

**Why did the plugin name change?**
This plugin has been bought by a company that I work for, because of that, plugin name changes from RS Save for Later to Simplicity Save for Later.

**Will you still support the plugin?**
Yes, I will still support and be in charge of the plugin. Basically, nothing changes except the name.

**Caching Plugins**: When using them, please disable caching for the "Saved for Later" page, if you don't it won't show "Saved for Later" content properly. Also, make sure you exclude "wp-content/plugins/rs-saved-for-later/public/js/rs-saved-for-later-public.js" file from minification.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png

== Changelog ==

= 1.0.8 =
* Fix a bug where JS wouldn't load on archive pages.

= 1.0.7 =
* Load button directly.

= 1.0.6 =
* Fixed a bug where on some server specific settings when user is logged in, saving item wouldn't work.
* When user isn't logged in, set and get cookies via JS rather than PHP.

= 1.0.5 =
* Fixed a bug when user changed "See Saved" text, it wouldn't apply on the front end.
* Fixed a bug with a footer counter.

= 1.0.4 =
* Cookie saving mechanism has been completely rewritten, now, we use less requests which will improve plugin performance.
* Plugin has been renamed to Simplicity Save for Later.

= 1.0.3 =
* Now you can easily clear all of your saved items with one button.
* Added a function to prevent W3TC from caching this plugin. NOTE: I have tested this, it seems to be working well, however, I would like for you to test it even more and tell me if everything seems to be working properly.

= 1.0.2 =
* Added support for WordPress 4.6.1
* Now you can enable Save for Later for Logged in Users only
* When user is logged in, the data will be saved to the database rather via a cookie

= 1.0.1 =
* Added support for WordPress 4.6

= 1.0.0 =
* Initial Release July 20th, 2016