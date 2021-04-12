<?php

    // Store Customer
    function customer($email){

        // Connect to DB
        $conn = openCon();

        // Initialize SQL Query -->  Store Customer
        $sql = 'INSERT INTO customers(email) VALUES ("' . $email . '")';

        // Check Query
        if ( $conn -> query( $sql ) == TRUE )
        {   
            // Console LOG
            // console_log( $email . " Added \n" );
        } else {
            // Console LOG
            console_log( "An error occured \n" . $conn -> error );
        }

        // Disconnect From DB
        $conn -> close();
    }
?>