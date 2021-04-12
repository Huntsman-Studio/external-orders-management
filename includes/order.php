<?php

    // Store Order   
    function order($order_id, $date, $status, $payment, $notes, $stripe_fee, $paypal_fee, $stripe_payment, $email, $trans_id, $time, $invoice){

        // Connect to DB
        $conn = openCon();

        // Initialize SQL Query --> Insert order
        $sql = 'INSERT INTO orders(id, date, status, payment, notes, stripe_fee, paypal_fee, stripe_payment, email, trans_id, time, invoice) 
        VALUES ("' . $order_id . '", "' . $date . '", "' . $status . '", "' . $payment . '", "' . $notes . '", ' . $stripe_fee . ',
                 ' . $paypal_fee . ', ' . $stripe_payment . ', "' . $email . '", "' . $trans_id . '", "'. $time.'", ' . $invoice. ')';

        // Check Query
        if ( $conn -> query( $sql ) == TRUE ){   
            // Console LOG
            // console_log( $order_id . " Created \n");
        } else {
            // Console LOG
            console_log( "An error occured " . $conn -> error );
        }

        // Disconnect from DB
        $conn -> close();
    }
?>