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

    // Add Action
    add_action('woocommerce_thankyou', 'order');

    function order( $order_id ){

        // Connect to DB
        $conn = localCon();

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
                        $_country = (string)set_country_code($row['meta_value']);
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
                    // Default

                    default:
                        break;
                }
            }
        } else {
            $res = 'Boom';
        }

        // Disconnect from Local
        $conn->close();

        // Connect to External
        $conn = openCon();

        // Store customers
        $sql = 'INSERT INTO customers(name, phone, address, city, post, country, vat, bus_ad, bus_name, bus_city, bus_post, bus_phone, email) 
                VALUES ("'.$_name.' '.$_last.'","'.$_phone.'","'.$_address.'","'.$_city.'","'.$_post.'","'.$_country.'","'.$_vat.'","'.$_bus_ad.'","'.$_bus_name.'",
                "'.$_bus_city.'","'.$_bus_post.'","'.$_bus_phone.'","'.$_email.'")';

        // Check if Sotored
        if($conn->query($sql) === TRUE){
            $test = 'OK';
        } else {
            $test = $conn->error;
        }

        ///////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////  
        // Debug INSERT result
        $sql1 = 'INSERT INTO test(id) VALUES ("'.$test.'")';

        if($conn->query($sql1)){

        }
        ///////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////

        // Disconnect from DB 
        $conn->close();
    }
?>