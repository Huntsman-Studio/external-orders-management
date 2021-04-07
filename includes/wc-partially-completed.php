<?php

    /**
     * Override WooCommerce Order Statuses
     */

    // REGISTER STATUS Partially Completed
    function wpblog_wc_register_post_statuses() {
        register_post_status( 'wc-partially', array(
            'label' => _x( 'Partially Completed', 'WooCommerce Order status', 'text_domain' ),
            'public' => true,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop( 'Partially Completed (%s)', 'Partially Completed (%s)', 'text_domain' )
        ) );
    }
    add_filter( 'init', 'wpblog_wc_register_post_statuses' );

    // ADD STATUS CHANGE
    function wpblog_wc_add_order_statuses( $order_statuses ) {
        $order_statuses['wc-partially'] = _x( 'Partially Completed', 'WooCommerce Order status', 'text_domain' );
        return $order_statuses;
    }
    add_filter( 'wc_order_statuses', 'wpblog_wc_add_order_statuses' );
    
?>