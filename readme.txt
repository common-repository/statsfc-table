=== StatsFC Table ===
Contributors: willjw
Donate link:
Tags: widget, football, soccer, premier league, uefa, champions league, europa league
Requires at least: 3.3
Tested up to: 6.2.2
Stable tag: 2.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This widget will place a football league table on your website.

== Description ==

Add a football league table to your WordPress website. To request a key sign up for your free trial at [statsfc.com](https://statsfc.com).

For a demo, check out [wp.statsfc.com/league-table](https://wp.statsfc.com/league-table/).

= Translations =
* Bahasa Indonesia
* Dansk
* Deutsch
* Eesti
* Español
* Français
* Hrvatski Jezik
* Italiano
* Magyar
* Norsk bokmål
* Slovenčina
* Slovenski Jezik
* Suomi
* Svenska
* Türkçe

If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com) or on Twitter [@StatsFC](https://twitter.com/StatsFC).

== Installation ==

1. Upload the `statsfc-table` folder and all files to the `/wp-content/plugins/` directory
2. Activate the widget through the 'Plugins' menu in WordPress
3. Drag the widget to the relevant sidebar on the 'Widgets' page in WordPress
4. Set the StatsFC key and any other options. If you don't have a key, sign up for free at [statsfc.com](https://statsfc.com)

You can also use the `[statsfc-table]` shortcode, with the following options:

* `key` (required): Your StatsFC key
* `competition` (required): Competition key, e.g., `EPL`
* `group` (optional): Competition group, e.g., `A`, `B`
* `season` (optional): Season to show league table for, e.g., `2016/2017`
* `type` (optional): Type of league table, `full` or `mini`
* `highlight` (optional): Name of the team you want to highlight, e.g., `Liverpool`
* `rows` (optional, *used in conjunction with `highlight`*): Number of rows you want to show, e.g., `3`, `5`
* `date` (optional): For a back-dated league table, e.g., `2013-12-31`
* `show_badges` (optional): Display team badges, `true` or `false`
* `show_form` (optional): Show form of last 6 matches, `true` or `false`
* `show_status` (optional): Show league position movement arrows, `true` or `false`
* `default_css` (optional): Use the default widget styles, `true` or `false`
* `omit_errors` (optional): Omit error messages, `true` or `false`

== Frequently asked questions ==



== Screenshots ==



== Changelog ==

= 2.2.1 =
* Hotfix: Make the plugin more efficient by only loading the form when it's required

= 2.2.0 =
* Feature: Split tables by competition group

= 2.1.0 =
* Feature: Allow league position movement arrows to be displayed (up, same, down) with the `show_status` option

= 2.0.0 =
* Refactor: Update plugin for new API

= 1.28.1 =
* Hotfix: Possible issue loading language/CSS files

= 1.28.0 =
* Feature: Allow a league table to be shown for a specific season via the new `season` parameter

= 1.27.5 =
* Hotfix: Check options exist before using them

= 1.27.4 =
* Hotfix: Check highlight value against short and full team names

= 1.27.3 =
* Hotfix: Check the before/after widget/title bits exist before using them

= 1.27.2 =
* Hotfix: Load relevant language file based on the default language for the site

= 1.27.1 =
* Hotfix: Fixed missing team badges

= 1.27.0 =
* Feature: Added multi-language support. If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com)

= 1.26.2 =
* Hotfix: Added a responsive horizontal scroll if the widget is too wide for mobile

= 1.26.1 =
* Hotfix: Fixed possible `Undefined index: omit_errors` error

= 1.26.0 =
* Feature: Put CSS/JS files back into the local repo
* Feature: Enqueue style/script directly instead of registering first

= 1.25.0 =
* Feature: Added `omit_errors` parameter
* Feature: Load CSS/JS remotely

= 1.24.3 =
* Hotfix: Fixed "Invalid domain" bug caused by referal domain

= 1.24.2 =
* Hotfix: Fixed bug saving 'Show badges' option

= 1.24.1 =
* Hotfix: Fixed bug with boolean options

= 1.24.0 =
* Feature: Added `show_badges` parameter

= 1.23.0 =
* Feature: Allow more discrete ads for ad-supported accounts

= 1.22.0 =
* Feature: Enabled ad-support

= 1.21.0 =
* Feature: Added `group` parameter

= 1.20.0 =
* Feature: Use built-in WordPress HTTP API functions

= 1.19.0 =
* Feature: Added badge class for each team

= 1.18.0 =
* Feature: Default `default_css` parameter to `true`

= 1.17.0 =
* Feature: Updated team badges.

= 1.16.0 =
* Feature: Added a `rows` parameter, which will work in association with `highlight`.

= 1.15.1 =
* Hotfix: Fixed shortcode bug.

= 1.15.0 =
* Feature: Added `[statsfc-table]` shortcode.

= 1.14.0 =
* Feature: Added a `date` parameter.

= 1.13.0 =
* Feature: Added an option to show team form.

= 1.12.0 =
* Feature: Use API to get competition list dynamically.

= 1.11.0 =
* Feature: Updated to use the new API.
* Feature: Removed support for European competition groups for now.

= 1.10.0 =
* Feature: Tweaked error message.

= 1.9.0 =
* Feature: Opened up to UEFA Champions League and UEFA Europa League group stages groups.

= 1.8.0 =
* Feature: Added timestamp for debugging.

= 1.7.0 =
* Feature: More reliable team icons.

= 1.6.0 =
* Feature: Added fopen fallback if cURL request fails.

= 1.5.1 =
* Hotfix: Fixed possible cURL bug.

= 1.5.0 =
* Feature: Use cURL to fetch API data if possible.

= 1.4.0 =
* Feature: Updated team badges for 2013/14.

= 1.3.0 =
* Feature: Load images from CDN.

= 1.2.0 =
* Feature: Changed 'Highlight' option from a textbox to a dropdown.

= 1.1.1 =
* Hotfix: Fixed possible CSS overlaps.

= 1.1.0 =
* Feature: Swapped club crests for shirts.

== Upgrade notice ==

