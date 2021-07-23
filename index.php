<?php
 /**
 * Plugin Name: meta field for products currency
 */


add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
function woo_add_custom_general_fields() {
    echo '<div class="options_group">';

    woocommerce_wp_select( array(
        'id'      => 'c_select',
        'label'   => __( 'Currency', 'c_selector' ),
        'options' => array(
	      'INR' => __( 'Indian rupee', 'INR' ),
	      'USD' => __( 'US Dollar', 'USD' ),
	      'EUR' => __( 'European euro', 'EUR' )
	    ),
    ) );

    echo '</div>';
}

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );
function woo_add_custom_general_fields_save( $post_id ){

// Select
    $woocommerce_select = $_POST['c_select'];
    if( !empty( $woocommerce_select ) )
        update_post_meta( $post_id, 'c_select', esc_attr( $woocommerce_select ) );
    else {
        update_post_meta( $post_id, 'c_select',  '' );
    }
}

//register meta field in rest API
add_action( 'rest_api_init', 'register_posts_meta_field' ); 
function register_posts_meta_field() {   
  register_meta('post','c_select',
            [
                'show_in_rest' => true,
                'single' => true,
                'type' => 'string',
            ]
        );
}