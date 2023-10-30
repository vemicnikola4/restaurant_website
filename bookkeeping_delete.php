<?php
session_start();
include_once("connection.php");
include_once("validation.php");


if ( !isset($_SESSION['id']) && !isset( $_COOKIE['user'])){
    Header("Location: admin.php");

} 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset( $_GET['id']) && isset( $_GET['action']) && $_GET['action'] == "izbrisi" ){
    $id = $_GET['id'];
    $upit = "DELETE FROM `earnings` WHERE `id` = $id";

    if ( $conn -> query($upit)){
        header( "Location: bookkeeping.php#e_table");
    }else{
        $errMsg = "Greska prilikom dodavanja novog artikla " .$conn->error;
        }
}

?>