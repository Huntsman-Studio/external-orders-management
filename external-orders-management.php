<?php
    /**
     * Plugin Name: External Orders Management System
     * Plugin URI:  https://huntsmanstudio.gr/external-orders-management/
     * Description: This plug-in is used for sending orders data to an external orders management system when an order id created and the customer is navigates to thank you page
     * Version:     1.0
     * Author:      Developers Huntsman Studio
     * Author URI:  https://huntsmanstudio.gr/
    */

    // Includes
    include './includes/functions.php';

    // Add Action
    add_action('woocommerce_new_order', 'order');

    function order( $order_id ){

        // Store Customer
        customer($order_id);

        // Store Order
        order($order_id);

        // Order items
        

    }
?>