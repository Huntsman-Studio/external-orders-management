<?php

    // Connect to DB
    function openCon(){

        $host   = '';
        $uname  = '';
        $passwd = '';
        $db     = '';
        
        $conn = new mysqli($host, $uname, $passwd, $db);

        if( $conn->connect_error ){
            die('Connection failed: ' . $conn->connect_error);
        }

        return $conn;
    }

    // Connect to local Database
    function localCon(){

        $host   = '';
        $uname  = '';
        $passwd = '';
        $db     = '';
        
        $conn = new mysqli($host, $uname, $passwd, $db);

        if( $conn->connect_error ){
            die('Connection failed: ' . $conn->connect_error);
        }

        return $conn;
    }

    // Disconnect from DB
    function closeCon($conn){
        $conn->close();
    }
?>