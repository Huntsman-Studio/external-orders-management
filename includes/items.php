<?php

    // Store Order Items
    function items($id, $order_id, $name, $qty, $total, $discount, $sku, $type){
    
        // Connect to DB
        $conn = openCon();

        // Real Escape Values (May Contain " OR ')
        $_name = $conn -> real_escape_string( $name );
        
        // Initialize SQL Query --> Insert items
        $sql = 'INSERT INTO items(id, order_id, name, qty, total, discount, sku, type)
                VALUES("' . $id . '", "' . $order_id . '", "' . $_name . '", ' . $qty . ', 
                        ' . $total . ', ' . $discount . ', "' . $sku . '", "' . $type . '")';
        
        // Check Query
        if ( $conn -> query( $sql ) == TRUE )
        {   
            // Console LOG
            // console_log( "Item" . $id . " Added \n" );
        } else {
            // Console LOG
            console_log( "An error occured \n" . $conn -> error );
        }

        // Disconnect from DB
        $conn->close();
    } 
?>