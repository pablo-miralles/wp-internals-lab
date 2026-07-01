<?php 

// Adding JS and CSS files for the REST API query form

function wpil_enqueue_scripts() {
    wp_enqueue_script(
        'wpil-rest-api-script',
        WPIL_PLUGIN_URL . 'src/02-rest-api.js',
        array(),
        '1.0',
        true
    );

    wp_add_inline_script(
        'wpil-rest-api-script',
        'const wpilPhpVariables = {
            restUrl: "' . rest_url('wp/v2/') . '"
        };',
        "before"
    );

    wp_enqueue_style(
        'wpil-rest-api-style',
        WPIL_PLUGIN_URL . 'src/02-rest-api.css',
        array(),
        '1.0'
    );
}

add_action('wp_enqueue_scripts', 'wpil_enqueue_scripts');

// Adding the REST API query form using wp_body_open hook
// (just for quick testing purposes)

function wpil_use_custom_template( $template ) {

    include_once WPIL_PLUGIN_PATH . '/includes/02-rest-api/template.php';

}

add_action( 'wp_body_open', 'wpil_use_custom_template' );

// Adding custom endpoint

add_action('rest_api_init', function() {
    register_rest_route(
        'pablo-lab/v1',
        '/summary',
        array(
            'methods' => 'GET',
            'callback' => 'wpil_print_custom_endpoint_request'
        )
    );
});

function wpil_print_custom_endpoint_request (WP_REST_Request $request) {

    $result = array();
    $number = absint($request['number']);
    $text = sanitize_text_field($request['text']);

    switch (true) {
        case ($number && $text):
            $result[] = $number;
            $result[] = $text;
            break;
        case ($number):
            $result[] = $number;
            $result[] = "Use the param 'text' to sanitize the text";
            break;
        case ($text):
            $result[] = "Use the param 'number' and add a number to convert it to its absolute integer.";
            $result[] = $text;
            break;
        default:
            $result[] = "Use the param 'number' and add a number to convert it to its absolute integer.";
            $result[] = "Use the param 'text' to sanitize the text";   
            break;
    }

    return $result;
}
