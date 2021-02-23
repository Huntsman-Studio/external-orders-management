<?php

    // Includes
    include './DB/db_config.php';
    include './setters_getters.php';

    // Get Customer Details
    function customer($_id){

        // Connect to DB
        $conn = localCon();

        // Initialize SQL Query -> Get Customer Details
        $sql = 'SELECT * FROM wp_postmeta WHERE post_id = \''.$_id.'\'';

        // Get Result
        $result = $conn->query($sql);

        // Check Result
        if($result->num_rows > 0){

            /** WooCommerce order Details are stored as meta_key with meta_value */

            // Default Variable Values
            $_vat = NULL; $_bus_ad = NULL; $_bus_city = NULL; $_bus_name = NULL; $_bus_phone = NULL; $_bus_post = NULL;

            // Loop customer Details
            while($row = $result->fetch_assoc()){

                /** Check meta_key --> Get meta_value */
                switch($row['meta_key']){

                    // First Name
                    case '_billing_first_name':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        $_name = ucwords(strtolower($row['meta_value']));
                        break;
                    // Last Name
                    case '_billing_last_name':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        $_last_name = ucwords(strtolower($row['meta_value']));
                        break;
                    // Address
                    case '_billing_address_1':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        $_address = ucwords(strtolower($row['meta_value']));
                        break;
                    // City 
                    case '_billing_city':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        $_city = ucwords(strtolower($row['meta_value']));
                        break;
                    // Postcode
                    case '_billing_postcode':
                        // strtoupper() --> Make a string uppercase
                        $_post = strtoupper($row['meta_value']);
                        break;
                    // Country
                    case '_billing_country':
                        // meta_value --> New Encypted Country Code
                        $_code    = set_country_code($row['meta_value']);
                        // meta_value --> Full country name (ex: GR --> Greece)
                        $_country = get_billing_country($row['meta_value']);
                        break;
                    // Email
                    case '_billing_email':
                        $_email = $row['meta_value'];
                        break;
                    // Phone
                    case '_billing_phone':
                        $_phone = $row['meta_value'];
                        break;
                    // VAT
                    case 'VAT':
                        $_vat = $row['meta_value'];
                        break;
                    // Company Name
                    case 'Company name':
                        $_bus_name = $row['meta_value'];
                        break;
                    // Company Address
                    case 'Company address':
                        $_bus_ad = $row['meta_value'];
                        break;
                    // Business city
                    case '_business_city':
                        // ucwords()    --> Uppercase the first character of each word in a string
                        // strtolower() --> Make a string lowercase
                        $_bus_city = ucwords(strtolower($row['meta_value']));
                        break;
                    // Business Phone
                    case '_business_phone':
                        $_bus_phone = $row['meta_value'];
                    // Business Postcode
                    case '_business_post':
                        $_bus_post = $row['meta_value'];
                        break;
                    // Default 
                    default:
                    break;
                }
            }

            // Store Customer --> cheddar : customers
            store_customer($_email, $_name." ".$_last_name, $_phone, $_address, $_city, $_post, $_country, $_vat, $_bus_ad, $_bus_name, $_bus_city, $_bus_post, $_bus_phone);
            
            // Disconnect from DB
            closeCon($conn);
        }
    }


    // Get order details
    function order($_id){

        // Connect to DB
        $conn = localCon();

        // Initialize SQL Query --> Get Order Details
        $sql = 'SELECT * FROM wp_posts
        JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
        WHERE wp_posts.ID = \''.$_id.'\'';

        // Get result
        $result = $conn->query($sql);

        // Check result
        if($result->num_rows > 0){

            // Loop Result
            while($row = $result->fetch_assoc()){
                
                switch($row['meta_key']){

                    // Payment Method
                    case '_payment_method':
                        // Meta_Value --> New String
                        $_payment_method = set_payment_method($row['meta_value']);
                        break;
                    // Transaction ID
                    case '_transaction_id':
                        $_trans_id = $row['meta_value'];
                        break;
                    // Country
                    case '_billing_country':
                        // meta_value --> New Encypted Country Code
                        $_code    = set_country_code($row['meta_value']);
                        // meta_value --> Full country name (ex: GR --> Greece)
                        $_country = get_billing_country($row['meta_value']);
                        break;
                    // Email
                    case '_billing_email':
                        $_email = $row['meta_value'];
                        break;
                     // PayPal Fee
                     case '_paypal_transaction_fee':
                        $_paypal_fee = $row['meta_value'];
                        break;
                    // PayPal Fee -- PayPal Checkout Plug-in
                    case 'PayPal Transaction Fee':
                        $_paypal_fee = $row['meta_value'];
                        break;
                    // Stripe Fee
                    case '_stripe_fee':
                        $_stripe_fee = $row['meta_value'];
                        break;
                    // Stripe Payment
                    case '_stripe_net':
                        $_stripe_payment = $row['meta_value'];
                        break;
                    // Default
                    default:
                        break;
                }
            }

            // Store order tp Database
            store_order($_code."/".$row['ID'], $row['post_date'], set_order_status($row['post_status']), $_payment_method, $row['post_excert'], $_stripe_fee, $_stripe_payment, $_paypal_fee, $_email, $_trans_id);
        }
    }


    // Order Items
    function order_items($_id){

    } 
?>