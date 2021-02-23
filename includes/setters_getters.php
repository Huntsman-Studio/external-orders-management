<?php
    // Includes
    include './DB/db_config.php';

    /**
     * @title   Set Payment Method
     * @param   String $postmeta['meta_value']
     * @return  New String $_payment_method 
     */
    function set_payment_method($payment){

        switch($payment){
            case 'bacs':
                // $payment = 'Bank Transfer';
                return 'Bank Transfer';
                break;
            case 'cod':
                // $payment = 'Cash on Delivery';
                return 'Cash on Delivery';
                break;
            case 'stripe':
                // $payment = 'Stripe';
                return 'Stripe';
                break;
            case 'paypal':
                // $payment = 'PayPal';
                return 'PayPal';
                break;
                case 'ppec_paypal':
                    // $payment = 'PayPal';
                    return 'PayPal';
                    break;
            default:
                // $payment = 'Payment error-->'.$payment;
                return 'Payment error-->'.$payment;
                break;
        }

        // return $payment;
    }

    /**
     * @title   Get country Code & return full country name (ex: GR --> Greece)
     * @param   String $postmeta['meta_value']
     * @return  New String $_country
     */
    function get_billing_country($_country){
        
        switch($_country){
            case 'AL':
                return 'Albania';
                break;
            case 'AT':
                return 'Austria';
                break;
            case 'BE':
                return 'Belgium';
                break;
            case 'BA':
                return 'Bosnia & Hezegovina';
                break;
            case 'BG':
                return 'Bulgaria';
                break;
            case 'HR':
                return 'Croatia';
                break;
            case 'CY':
                return 'Cyprus';
                break;
            case 'CZ':
                return 'Czech Republic';
                break;
            case 'DK':
                return 'Denmark';
                break;
            case 'EE':
                return 'Estonia';
                break;
            case 'FI':
                return 'Finland';
                break;
            case 'FR':
                return 'France';
                break;
            case 'DE':
                return 'Germany';
                break;
            case 'GR':
                return 'Greece';
                break;
            case 'HU':
                return 'Hungary';
                break;
            case 'IE':
                return 'Ireland';
                break;
            case 'IT':
                return 'Italy';
                break;
            case 'LV':
                return 'Latvia';
                break;
            case 'LI':
                return 'Liechtenstein';
                break;
            case 'LT':
                return 'Lithuania';
                break;
            case 'LU':
                return 'Luxembourg';
                break;
            case 'MT':
                return 'Malta';
                break;
            case 'MD':
                return 'Moldova';
                break;
            case 'MC':
                return 'Monaco';
                break;
            case 'ME':
                return 'Montenegro';
                break;
            case 'NL':
                return 'Netherlands';
                break;
            case 'MK':
                return 'North Macedonia';
                break;
            case 'NO':
                return 'Norway';
                break;
            case 'PL':
                return 'Poland';
                break;
            case 'PT':
                return 'Portugal';
                break;
            case 'RO':
                return 'Romania';
                break;
            case 'RU':
                return 'Russia';
                break;
            case 'RS':
                return 'Serbia';
                break;
            case 'SK':
                return 'Slovakia';
                break;
            case 'SI':
                return 'Slovenia';
                break;
            case 'ES':
                return 'Spain';
                break;
            case 'SE':
                return 'Sweden';
                break;
            case 'CH':
                return 'Switzerland';
                break;
            case 'TR':
                return 'Turkey';
                break;
            case 'UA':
                return 'Ukraine';
                break;
            case 'GB':
                return 'United Kingdom';
                break;
        }

        // return $_country;
    }

    /**
     * @title   Convert country code to encrypted country code (ex: GR --> I4)
     * @param   String $postmeta['meta_value']
     * @return  New String $_code
     */
    function set_country_code($_country){

        // SET country code

        switch($_country){

            case 'AT':
                return 'C2';
                break;
            case 'BE':
                return 'B4';
                break;
            case 'BG':
                return 'I3';
                break;
            case 'HR':
                return 'F4';
                break;
            case 'CY':
                return 'I5';
                break;
            case 'CZ':
                return 'F1';
                break;
            case 'DK':
                return 'A4';
                break;
            case 'EE':
                return 'D1';
                break;
            case 'FI':
                return 'A1';
                break;
            case 'FR':
                return 'E1';
                break;
            case 'DE':
                return 'C1';
                break;
            case 'GR':
                return 'I4';
                break;
            case 'HU':
                return 'F3';
                break;
            case 'IE':
                return 'B2';
                break;
            case 'IT':
                return 'G1';
                break;
            case 'LV':
                return 'D2';
                break;
            case 'LI':
                return 'C4';
                break;
            case 'LT':
                return 'D3';
                break;
            case 'LU':
                return 'E2';
                break;
            case 'MT':
                return 'G3';
                break;
            case 'MD':
                return 'I1';
                break;
            case 'MC':
                return 'E3';
                break;
            case 'ME':
                return 'F5';
                break;
            case 'NL':
                return 'B3';
                break;
            case 'NO':
                return 'A3';
                break;
            case 'PL':
                return 'D4';
                break;
            case 'PT':
                return 'H2';
                break;
            case 'RO':
                return 'I2';
                break;
            case 'SK':
                return 'F2';
                break;
            case 'SI':
                return 'G2';
                break;
            case 'ES':
                return 'H1';
                break;
            case 'SE':
                return 'A2';
                break;
            case 'CH':
                return 'C3';
                break;
            case 'GB':
                return 'B1';
                break;
        }
        // return $_country;
    }

    /**
     * @title   Convert Order Status String (ex: wc-pending --> Pending)
     * @param   String $post['meta_value']
     * @return  New String $status
     */
    function set_order_status($_status){

        switch($_status){
            case 'wc-pending':
                $_status = 'Pending Payment';
                break;
            case 'wc-on-hold':
                $_status = 'On Hold';
                break;
            case 'wc-completed':
                $_status = 'Completed';
                break;
            case 'wc-cancelled':
                $_status = 'Cancelled';
                break;
            case 'wc-refunded':
                $_status = 'Refund';
                break;
            case 'wc-failed':
                $_status = 'Failed';
                break;
            case 'wc-processing':
                $_status = 'Processing';
                break;
            default:
                $_status .= ' | Check status error';
                break;
        }

        return $_status;

    }

    /**
     * @title   Store customer to the DB
     * @param   $_name, $_address, $_post, $_country, $_email, $_phone, $_vat, 
     *          $_bus_name, $_bus_ad, $_bus_city, $_bus_post, $_bus_phone
     */
    function store_customer($_email, $_name, $_phone, $_address, $_city, $_post, $_country, $_vat, 
                            $_bus_ad, $_bus_name, $_bus_city, $_bus_post, $_bus_phone){
        
        // Connect to DB
        $conn = openCon();
        
        // Initialize SQL Query --> Insert into Customers
        $sql = 'INSERT INTO customers (email, name, phone, address, city, post, country, vat, bus_ad, bus_name, bus_city, bus_post, bus_phone)
                VALUES ("'.$_email.'","'.$_name.'","'.$_phone.'","'.$_address.'","'.$_city.'","'.$_post.'","'.$_country.'","'.$_vat.'","'.$_bus_ad.'","'.$_bus_name.'","'.$_bus_city.'","'.$_bus_post.'","'.$_bus_phone.'")';

        // Run Query
        if ($conn->query($sql) === TRUE){
            // echo "BOOOOOOOOOOOOOOOOOM -> CUSTOMER<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br/>";
        }

        // Disconnect from DB
        closeCon($conn);
    }

    /**
     * @title   Store orders to the DB
     * @param   $_order_id, $_order_date, $_order_status, $_payment_method, $_order_notes,
     *          $_stripe_fee, $_stripe_payment, $_paypal_fee, $_email, $_trans_id 
     */ 
    function store_order($_order_id, $_order_date, $_order_status, $_payment_method, $_order_notes,
                        $_stripe_fee, $_stripe_payment, $_paypal_fee, $_email, $_trans_id){
        
        // Connect to DB 
        $conn = openCon();
        
        // Initialize SQL Query --> Insert into Orders
        $sql = 'INSERT INTO orders (id, date, status, payment, notes, stripe_fee, stripe_payment, paypal_fee, email, trans_id) 
                VALUES ("'.$_order_id.'","'.$_order_date.'","'.$_order_status.'","'.$_payment_method.'","'.$_order_notes.'",'.$_stripe_fee.',
                '.$_stripe_payment.','.$_paypal_fee.',"'.$_email.'","'.$_trans_id.'")';

        // Run Query
        if ($conn->query($sql) === TRUE){
            // echo "BOOOOOOOOOOOOOOOOOM -> ORDER<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br/>";
        }

        // Disconnect from DB
        closeCon($conn);
    }

    /**
     * @title   Store order items to DB
     * @param   $_id, $_order_id, $_name, $_qty, $_total, $_discount, $_sku, $_type 
     */
    function store_items($_id, $_order_id, $_name, $_qty, $_total, $_discount, $_sku, $_type){

        // Connect to DB
        $conn = openCon();

        // Initialize SQL Query --> Insert into items
        $sql = 'INSERT INTO items (id, order_id, name, qty, total, discount, sku, type) 
                VALUES ("'.$_id.'","'.$_order_id.'","'.$_name.'","'.$_qty.'","'.$_total.'","'.$_discount.'","'.$_sku.'","'.$_type.'")';

        // Run Query
        if ($conn->query($sql) === TRUE){
            // echo "BOOOOOOOOOOOOOOOOOM -> ITEMS<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br/>";
        }

        // Disconnect from DB
        closeCon($conn);
    }
?>