<?php


// create a custom end point in the My Accunt Page

function custom_wc_end_point() {
	if(class_exists('WooCommerce')){
    add_rewrite_endpoint( 'videos', EP_ROOT | EP_PAGES );
}
}

add_action( 'init', 'custom_wc_end_point' );


function custom_endpoint_query_vars( $vars ) {
    $vars[] = 'videos';
    return $vars;
}
add_filter( 'query_vars', 'custom_endpoint_query_vars', 0 );



function ac_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'ac_custom_flush_rewrite_rules' );

// add the custom endpoint in the my account nav items

function custom_endpoint_acct_menu_item( $items ) {
   
    $logout = $items['customer-logout'];
    unset( $items['customer-logout'] );
	$items['videos'] = __( 'Videos', 'woocommerce' ); // replace videos with your endpoint name
	$items['customer-logout'] = $logout;

    return $items;
}

add_filter( 'woocommerce_account_menu_items', 'custom_endpoint_acct_menu_item' );

// fetch content from your source page (in this case video page)
function fetch_content_custom_endpoint() {
	
	global $post;
    $id = "987453291"; // your video page id
    ob_start();
    $output = apply_filters('the_content', get_post_field('post_content', $id));
    $output .= ob_get_contents();
    ob_end_clean();
    echo $output;
 
}

add_action( 'woocommerce_account_videos_endpoint', 'fetch_content_custom_endpoint' );
