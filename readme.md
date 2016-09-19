# The Social Links [![Build Status](https://travis-ci.org/DigitalLeap/the-social-links.svg?branch=master)](https://travis-ci.org/DigitalLeap/the-social-links)

The Social Links plugin adds a widget and shortcode to your WordPress website allowing you to display icons linking to your social profiles. The new version includes the following social networks:

* Google+
* Facebook
* Twitter
* Linkedin
* YouTube
* Instagram
* Pintrest

We've also added support for a **shortcode** (`[the-social-links]`) for use in WordPress posts and pages and a **custom template tag** (`<?php the_social_links();?>`) for use in template files.

**The Social Links is translation ready!**

It's important to note that we will only support the above social networks in the free version. Want extra social networks? You can purchase [The Social Links Pack](https://digitalleap.co.za/wordpress/plugins/social-links/the-social-links-pack/) for only $5 (unlimited commercial use) which gives you access to:

* Behance
* Bitcoin
* Delicious
* DeviantArt
* Digg
* Dribble
* Flickr
* Foursquare
* GitHub
* LastFM
* Medium
* Skype
* Soundcloud
* Spotify
* Tumblr
* Vine
* WordPress

**The reason we charge for extra social networks is to make sure we maintain a high level of support on this plugin. Our developers need to get paid even though they love contributing towards the community.**


## Installation

Installation via WordPress Dashboard:

1. Navigate to Plugins->Add New
2. Search for "The Social Links" and click "Install Now"
3. Click “Settings” or browse to the "The Social Links" once you have installed the plugin to configure your social network links.
4. Go to your widgets and add the "The Social Links" widget to your sidebar, add the shortcode (`[the-social-links]`) in your posts and pages or add the custom template tag (`<?php the_social_links();?><?php the_social_links();?>`) in your template files.

## Changelog

### 1.2.8
* Removed escaping of widget output

### 1.2.7
* Fixed a bug that prevent the widgets from loading.

### 1.2.6
* Fixed readme.txt

### 1.2.4
* Removed '_' when there shouldn't have been one.
* Notify users that support is now done on Github.

### 1.2.3
* Fixed static function error on shortcode

### 1.2
* Released quality code (according to WordPress Coding Standards)
* Added unit testing