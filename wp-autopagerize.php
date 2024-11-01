<?php
/*
Plugin Name: WP-AutoPagerize
Plugin URI: http://5509.me/log/wpautopagerize
Description: Activate AutoPagerize in your WordPress
Author: nori
Version: 1.0.2.5.3
Author URI: http://5509.me/

$LastChangedDate: 2010-06-02 21:45:02 -0500 (Wed, 02 Jun 2010) $
*/

/*  Copyright 2010 nori  (email : norimania@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_action('admin_menu', 'wpPageRize_admin');
function wpPageRize_admin() {
	add_submenu_page('options-general.php', 'WP-AutoPagerize', 'WP-AutoPagerize', 8, __FILE__, 'wpPageRize_admin_fn');
}

function wpPageRize_get_option() {
	$option = get_option('wp-autopagerize');
	if (!is_array($option)) {
		$option = array();
	}
	return array_merge(array(
		'loadingMethod' => 0,
		'defaultCondition' => 0,
		'className' => 'div.post',
		'customInsertPos' => '',
		'pageNumber' => 0,
		'prev' => 'Prev',
		'next' => 'Next',
		'buttonValue' => 'Loading next',
		'beforeCall' => '',
		'callback' => ''
	), $option);
}

function wpPageRize_admin_fn() {
	extract(wpPageRize_get_option(), EXTR_SKIP);
	require dirname(__FILE__) . '/view/admin.php';
}

add_action('wp_head','wpPageRize_add_style');
function wpPageRize_add_style() {
	echo '<link type="text/css" rel="stylesheet" href="'. plugin_dir_url(__FILE__) .'wp-autopagerize.css" />'. PHP_EOL;
}

function wp_autopagerize() {
	global $wp_rewrite, $wp_query, $paged;

	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}

	$paginate_base = get_pagenum_link(1);
	if ( strpos($paginate_base, '?') !== false || !$wp_rewrite->using_permalinks() ) {
		$paginate_format = '';
		$paginate_base = add_query_arg('paged', '%#%');
	} else {
		$paginate_format = (substr($paginate_base, -1 , 1) == '/' ? '' : '/')
		                 . user_trailingslashit('page/%#%/', 'paged');
		$paginate_base .= '%_%';
	}

	$o = wpPageRize_get_option();

	$result = paginate_links( array(
		'base' => $paginate_base,
		'format' => $paginate_format,
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'current' => ($paged ? $paged : 1),
		'prev_text' => $o['prev'],
		'next_text' => $o['next'],
	));

	echo '<div class="wpPageRize"><span>' . PHP_EOL . $result . PHP_EOL . '</span></div>';
}

add_action('wp_footer','wpPageRize_add_JSfunc');
function wpPageRize_add_JSfunc() {
	$pluginFullPath = plugin_dir_url(__FILE__);
	extract(wpPageRize_get_option(), EXTR_SKIP);
	require dirname(__FILE__) . '/view/add_jsfunc.php';
}
