<?php

// Initialization of hooks_list array

$hooks_list = [];

// Adding items in the array for every hook used
// muplugins_loaded won't appear, as this is a standard plugin

function wpil_show_muplugins_loaded_hook() {
	$GLOBALS['hooks_list'][] = 'muplugins_loaded';
}
add_action( 'muplugins_loaded', 'wpil_show_muplugins_loaded_hook' );

function wpil_show_plugins_loaded_hook() {
	$GLOBALS['hooks_list'][] = 'plugins_loaded';
}
add_action( 'plugins_loaded', 'wpil_show_plugins_loaded_hook' );

function wpil_show_setup_theme_hook() {
	$GLOBALS['hooks_list'][] = 'setup_theme';
}
add_action( 'setup_theme', 'wpil_show_setup_theme_hook' );

function wpil_show_init_hook() {
	$GLOBALS['hooks_list'][] = 'init';
}
add_action( 'init', 'wpil_show_init_hook' );

function wpil_show_wp_loaded_hook() {
	$GLOBALS['hooks_list'][] = 'wp_loaded';
}
add_action( 'wp_loaded', 'wpil_show_wp_loaded_hook' );

function wpil_show_wp_hook() {
	$GLOBALS['hooks_list'][] = 'wp';
}
add_action( 'wp', 'wpil_show_wp_hook' );

function wpil_show_template_redirect_hook() {
	$GLOBALS['hooks_list'][] = 'template_redirect';
}
add_action( 'template_redirect', 'wpil_show_template_redirect_hook' );

function wpil_print_hook_list() {

	$hooks_list = $GLOBALS['hooks_list'];

	?>
		<div class="notice notice-success is-dismissible">
		<?php foreach( $hooks_list as $index => $item ) {
			echo '<p class="hook-list-item">' . $index + 1 . ' - ' . $item . '</p>';
		} ?>
		</div>
	<?php

}
add_action( 'admin_notices', 'wpil_print_hook_list' );

// Hook only available in front view (Located inside the theme)

function wpil_show_wp_footer_hook_20() {
	$GLOBALS['hooks_list'][] = 'wp_footer priority 20';
}
add_action( 'wp_footer', 'wpil_show_wp_footer_hook_20', 20 );

function wpil_show_wp_footer_hook_10() {
	$GLOBALS['hooks_list'][] = 'wp_footer priority 10';

	remove_action( 'wp_footer', 'wpil_show_wp_footer_hook_30', 30 );
}
add_action( 'wp_footer', 'wpil_show_wp_footer_hook_10', 10 );

function wpil_show_wp_footer_hook_30() {
	$GLOBALS['hooks_list'][] = 'wp_footer priority 30';
}
add_action( 'wp_footer', 'wpil_show_wp_footer_hook_30', 30 );

// the_title filter
// Filters need to return something, as it modifies a certain data at some point of the WordPress execution

add_filter( 'the_title', function($post_title) {
	return 'Title: ' . $post_title;
} );

add_filter( 'the_title', function($post_title) {
	return $post_title . ' (Thanks for reading!)';
}, 20 );