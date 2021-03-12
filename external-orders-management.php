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
    include 'includes/functions.php';
    include 'includes/DB/db_config.php';
    include 'includes/setters_getters.php';
    include 'includes/wc-partially-completed.php';

    // Add Action
    add_action('woocommerce_thankyou', 'order');

    function order( $order_id ){

        // Connect to DB
        $conn = localCon();
        $_paypal_fee=$_stripe_payment=$_stripe_fee=0;

        $sql = 'SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id ='.$order_id.'';

        $res = $conn->query($sql);

        if($res->num_rows > 0){
            while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){

                // if($row['meta_key'] === 'VAT'){
                //     $_vat = $row['meta_value'];
                // }
                
                switch($row['meta_key']){
                    // First Name
                    case '_billing_first_name':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        // (string)     --> Convert valkue to String
                        $_name = (string)ucwords(strtolower($row['meta_value']));
                        break;
                    // Last Name
                    case '_billing_last_name':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        // (string)     --> Convert valkue to String
                        $_last = (string)ucwords(strtolower($row['meta_value']));
                        break;
                    // Phone
                    case '_billing_phone':
                        // (string)     --> Convert valkue to String
                        $_phone = (string)$row['meta_value'];
                        break;
                    // Address
                    
                    case '_billing_address_1':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        // (string)     --> Convert valkue to String
                        $_address = (string)ucwords(strtolower($row['meta_value']));
                        break;
                    // City
                    case '_billing_city':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        // (string)     --> Convert valkue to String
                        $_city = (string)ucwords(strtolower($row['meta_value']));
                        break;
                    // Postcode
                    case '_billing_postcode':
                        // strtoupper() --> Make a string uppercase
                        // (string)     --> Convert valkue to String
                        $_post = (string)strtoupper($row['meta_value']);
                        break;
                    // Country
                    case '_billing_country':
                        // meta_value --> New Encypted Country Code
                        $_code = (string)set_country_code($row['meta_value']);
                        // meta_value --> Full country name (ex: GR --> Greece)
                        $_country = (string)get_billing_country($row['meta_value']);
                        break;
                    // VAT
                    case 'VAT':
                        $_vat = (string)$row['meta_value'];
                        break;
                    // Business Address
                    case 'Company address':
                        $_bus_ad = (string)$row['meta_value'];
                        break;
                    // Business Name
                    case 'Company name':
                        $_bus_name = (string)$row['meta_value'];
                        break;
                    // Business City
                    case '_business_city':
                        $_bus_city = (string)$row['meta_value'];
                        break;
                    // Business Post
                    case '_business_post':
                        $_bus_post = (string)$row['meta_value'];
                        break;
                    // Business Phone
                    case '_business_phone':
                        $_bus_phone = (string)$row['meta_value'];
                        break;
                    // Email
                    case '_billing_email':
                        $_email = (string)$row['meta_value'];
                        break;
                    // Payment method
                    case '_payment_method':
                        // Meta_Value --> New String
                        $_payment_method = (string)set_payment_method($row['meta_value']);
                        break;
                    // Stripe fee
                    case '_stripe_fee':
                        $_stripe_fee = $row['meta_value'];
                        break;
                    // Stripe Payment
                    case '_stripe_net':
                        $_stripe_payment = $row['meta_value'];
                        break;
                    // Transaction ID
                    case '_transaction_id':
                        $_trans_id = (string)$row['meta_value'];
                        break;
                    // PayPal Fee
                    case '_paypal_transaction_fee':
                        $_paypal_fee = $row['meta_value'];
                        break;
                    // PayPal Fee -- PayPal Checkout Plug-in
                    case 'PayPal Transaction Fee':
                        $_paypal_fee = $row['meta_value'];
                        break;
                    // Default
                    default:
                        break;
                }
            }
        }

        // Initialize SQL Query --> Get order data
        $sql_order = 'SELECT * FROM wp_posts WHERE ID = '.$order_id;

        // Get result
        $result = $conn->query($sql_order);
    
        // Check result
        if($result->num_rows > 0){

            // Loop Result
            while($row = $result->fetch_assoc()){
                $_date      = $row['post_date'];
                $_status    = set_order_status($row['post_status']);
                $_notes     = $row['post_excert'];
            }
        }
        //C2/15934/2021-02-25 11:30:29/On Hold/Bank Transfer//////ofwurttrrtrtligmr@icare.eu/

        // Disconnect from Local
        $conn->close();

        // Connect to external
        $conn = openCon();

        // Store customers
        $sqlCust = 'INSERT INTO customers(name, phone, address, city, post, country, vat, bus_ad, bus_name, bus_city, bus_post, bus_phone, email) 
            VALUES ("'.$_name.' '.$_last.'","'.$_phone.'","'.$_address.'","'.$_city.'","'.$_post.'","'.$_country.'","'.$_vat.'","'.$_bus_ad.'","'.$_bus_name.'",
            "'.$_bus_city.'","'.$_bus_post.'","'.$_bus_phone.'","'.$_email.'")';

        // Check if Stored
        if($conn->query($sqlCust) === TRUE){
            $test = 'OK Customers | ';
        } else {
            $test = $conn->error;
        }


        // Store orders
        // $code=$_code.'/'.$order_id;
        $sqlOrder = 'INSERT INTO orders (id, date, status, payment, notes, stripe_fee, paypal_fee, stripe_payment, email, trans_id) 
        VALUES ("'.$_code.'/'.$order_id.'", "'.$_date.'", "'.$_status.'", "'.$_payment_method.'", "'.$_notes.'", '.$_stripe_fee.' ,'.$_paypal_fee.', '.$_stripe_payment.', "'.$_email.'", "'.$_trans_id.'")';


        // Check if Sotored
        if($conn->query($sqlOrder) === TRUE){
            $test .= 'OK Order | ';
        } else {
            $test = $conn->error;
        }

        // Dsiconnect From External
        $conn->close();

        // Connect to local
        $conn = localCon();

        // Store order Items 
        $sqlItem = 'SELECT * FROM wp_woocommerce_order_items WHERE order_id = '.$order_id;

        // Get result
        $resItem = $conn->query($sqlItem);

        // Check result
        if($resItem->num_rows > 0){

            // Loop result
            while($rowItem = $resItem->fetch_assoc()){

                // DEF VALUES
                $sku = '';
                $qty = 1;
                $regular_price = 0;
                $sale_price = 0;
                $discount = 0;
                $product_id = 0;
                $variation_id = 0;

                // Item Name
                $item_name = $rowItem['order_item_name'];

                // Item ID
                $itemID = $rowItem['order_item_id'];

                if($rowItem['order_item_type'] == 'line_item'){
                    
                    // Set type
                    $type = 'item';

                    // Initialize SQL Query --> wp_woocommerce_order_itemmeta
                    $sqlItemMeta = 'SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '.$itemID.'';

                    // Get Result
                    $resItemMeta = $conn->query($sqlItemMeta);

                    // Check result
                    if($resItemMeta->num_rows > 0){

                        // Loop Result
                        while($rowItemMeta = $resItemMeta->fetch_assoc()){

                            // Check meta_key
                            switch($rowItemMeta['meta_key']){
                                // Product ID
                                case '_product_id':
                                    $product_id = $rowItemMeta['meta_value'];
                                    break;
                                // Variation ID
                                case '_variation_id':
                                    $variation_id = $rowItemMeta['meta_value'];
                                    break;
                                // QTY
                                case '_qty':
                                    $qty = $rowItemMeta['meta_value'];
                                    break;
                                // Default
                                default:
                                    break;
                            }

                        } // wp_woocommerce_order_itemmeta

                        // Initialize SQL Query --> wp_postmeta || VARIABLE <> SIMPLE
                        if($variation_id == 0){
                            $sqlItemPost = 'SELECT * FROM wp_postmeta WHERE post_id = '.$product_id.'';
                        } else {
                            $sqlItemPost = 'SELECT * FROM wp_postmeta WHERE post_id = '.$variation_id.'';
                        }

                        // Get result
                        $resItemPost = $conn->query($sqlItemPost);

                        // Check Result
                        if($resItemPost->num_rows > 0){

                            // Loop Result
                            while($rowItemPost = $resItemPost->fetch_assoc()){

                                // Check meta_key
                                switch($rowItemPost['meta_key']){
                                    // Regular Price
                                    case '_regular_price':
                                        $regular_price = $rowItemPost['meta_value'];
                                        break;
                                    // Sale Price
                                    case '_sale_price':
                                        $sale_price = $rowItemPost['meta_value'];
                                        break;
                                    // SKU
                                    case '_sku':
                                        $sku = (string)strtoupper($rowItemPost['meta_value']);
                                        break;
                                    // Default
                                    default:
                                        break;
                                }
                            } // wp_postmeta
                        }

                        // Check disc
                        if($sale_price != 0){
                            $discount = $regular_price - $sale_price;
                        }
                        
                    }

                } elseif($rowItem['order_item_type'] == 'shipping'){

                    // Set type 
                    $type ='ship';

                    // Initialize SQL Query --> wp_woocommerce_order_itemmeta
                    $sqlShipMeta = 'SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '.$itemID.'';

                    // Get Result
                    $resShipMeta = $conn->query($sqlShipMeta);

                    // Check result
                    if($resShipMeta->num_rows > 0){
                        
                        // Loop Result
                        while($rowShipMeta = $resShipMeta->fetch_assoc()){

                            // Check meta_key
                            switch($rowShipMeta['meta_key']){
                                // Cost
                                case 'cost':
                                    $regular_price = $rowShipMeta['meta_value'];
                                    break;
                                // Default
                                default:
                                    break;
                            }
                        } // wp_woocommerce_order_itemmeta
                    }
                }

                $string = 'INSERT INTO items(id, order_id, name, qty, total, discount, sku, type)
                            VALUES("'.$_code.'/'.$itemID.'","'.$_code.'/'.$order_id.'","'.$item_name.'",'.$qty.','.$regular_price.','.$discount.',"'.$sku.'","'.$type.'")';

                store_item($string);

            } // wp_woocommerce_order_items
        }

        
        $conn->close();
        
        ///////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////  

        // Connect to external
        $connEx = openCon();

        // Debug INSERT result
        // $sql1 = 'INSERT INTO test(id) VALUES ("'.$test.'")';

        // if($connEx->query($sql1)){

        // }
        // ///////////////////////////////////////////////////////////
        // ///////////////////////////////////////////////////////////

        // // Disconnect from DB 
        $connEx->close();
    }

    function store_item($value){

        $conn = openCon();

        if($conn->query($value)){

        }

        $conn->close();
    }
?>
