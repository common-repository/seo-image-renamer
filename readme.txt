=== SEO Image Renamer ===
Contributors: WordpressAlpar, AKM3
Tags: seo, images
Requires at least: 3.0
Tested up to: 3.3.2
Stable tag: 1.2.1
Donate link: http://www.akm3.de/

SEO-IMR scans all the images which are attached to posts or pages on your blog and remove EXIF-Data and rename them according to SEO-Guidelines.

== Description ==

The SEO-IMR Plugin is a small plugin that scans all the images which are attached to posts or pages on your blog. 

In a small form it displays the current image name and the attached EXIF data. 
 
The whole purpose of the plugin is to rename images AFTER they have been uploaded to the Media-Library and eventually added into a post.

The plugin can rename these images and also rename all the generated thumbnails. 

Additionally to that, the plugin removes any EXIF-Data such as "Adbobe Photoshop CS 5" or "Copyright MR. A" etc. 

If you buy a lot of photos on the internet and you are looking for a convenient way to rename these, this is the plugin for you.

Please read the INSTALLTION tab. You need to have ImageMagick installed, otherwise the plugin will trigger a "Fatal Error"


This plugin is Multi-Site compatible!

== Installation ==


1. Make sure you have ImageMagick WORKING. Otherwise the plugin will not work and trigger a fatal error.
2. Upload `seo-image-renamer/` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
 

== Frequently Asked Questions ==

= Why does the Plugin say: Plugin could not be activated because it triggered a fatal error. =

Because you need to install ImageMagick

= Can the plugin also rename alt-Tags and title-attributes? =

Since 1.2 it can, yes.

= Can the plugin used in Multi-Site installs? =

Since it does not use own tables, yes it is.


== Screenshots ==

1. Working Screenshot with critical EXIF-Data


== Changelog ==


= 1.2.1 =
* Fixed a bug where an image would be replaced wrong if it had the same name as another one

= 1.2 =
* Changed the location of the plugin to be shown under "Settings", cause non-admin users can't see the plugin tab in multi-site installations.
* Added options to delete image from filesystem and to replace ALT and TITLE tags
* Added small preview of image on the left
* Added notifier that png and gif do not support EXIF data and there do not need EXIF removal
* Added warning if one tries to rename image to already exisitng name
Ã* Multiple Bugfixes

= 1.1 =
* Just changed plugin author, to give credits to developer

= 1.0 =
* Working version

== Upgrade Notice ==

= 1.2.1 =
No actions needed

= 1.2 =
No actions needed

= 1.1 =

No actions needed

= 1.0 =
First version. No Upgrade notes
