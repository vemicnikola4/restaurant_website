<?php
    mysqli_report(MYSQLI_REPORT_OFF);
    $server = "localhost";
    $database = "giros_kod_talicnog_tome";
    $username = "girosuser";
    $password = "Cocacola@148";

    $conn = new mysqli ( $server,$username,$password,$database );
    if ( $conn -> connect_error ){
        // header("Location: error.php?m=".$conn->connect_error);
        die( "Neuspela konekcija: " . $conn -> connect_error);
    }else{
        $conn->set_charset("utf8");
    }


?>