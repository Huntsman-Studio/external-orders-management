<?php

    // Store Order Details
    function order_details($order_id, $type, $value){

        // Connect to DB
        $conn = openCon();

        // Real Escape Values (May Contain " OR ')
        $_value = $conn -> real_escape_string( $value );
        
        // Initialize SQL Query --> Insert Into order_details
        $sql = 'INSERT INTO order_details(order_id, type, value) 
                VALUES("' . $order_id . '", "' . $type . '", "' . $_value . '")';
        
        // Check Query
        if ( $conn -> query( $sql ) == TRUE ){   
            // Console LOG
            // console_log( $order_id . " Created \n" . $type . " Added \n" . $value . " Updated \n");
        } else {
            // Console LOG
            console_log( "An error occured \n" . $conn -> error );
        }

        // Disconnect from DB
        $conn->close();
    }

?>