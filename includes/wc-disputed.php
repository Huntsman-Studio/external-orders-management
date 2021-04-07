<?php
    // REGISTER STATUS Disputed
    function wpblog_wc_register_post_statuses_disputed() {
        register_post_status( 'wc-disputed', array(
            'label' => _x( 'Disputed', 'WooCommerce Order status', 'text_domain' ),
            'public' => true,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop( 'Disputed (%s)', 'Disputed (%s)', 'text_domain' )
        ) );
    }
    add_filter( 'init', 'wpblog_wc_register_post_statuses_disputed' );

    // ADD STATUS CHANGE
    function wpblog_wc_add_order_statuses_disputed( $order_statuses ) {
        $order_statuses['wc-disputed'] = _x( 'Disputed', 'WooCommerce Order status', 'text_domain' );
        return $order_statuses;
    }
    add_filter( 'wc_order_statuses', 'wpblog_wc_add_order_statuses_disputed' );
?>