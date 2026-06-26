<?php 

function wpil_enqueue_scripts () {
    wp_enqueue_script(
        'wpil-rest-api-script',
        plugin_dir_url( __DIR__ ). 'src/02-rest-api.js',
        array(),
        '1.0'
    );
    echo "test";
}

add_action('wp_enqueue_scripts', 'wpil_enqueue_scripts');
add_action('admin_enqueue_scripts', 'wpil_enqueue_scripts');

