<?php

function usernameValidation($u, $conn){
    
    $query = "SELECT * FROM `coments` WHERE `email` = '$u' ";
    $result = $conn->query($query);
    if ( empty( $u )){
        return "Username ne sme biti prazan!";
    }elseif ( filter_var($u, FILTER_VALIDATE_EMAIL) === false ){
        return "Format nije validan!";
    }elseif(preg_match('/\s/',$u)){ //regularni izrazi. NA pocetku i na kraju su delimiteri. prvi parametar je neki sablon
        return "Email ne sme sadržati razmak!";
    }elseif(strlen($u) < 5 || strlen( $u ) > 25 ){
        return "Email mora imati izmedju 5 i 25 karaktera!";
    }elseif($result->num_rows > 0){
        return "Email već postoji izaberite drugi username";
    }else{
        return "";
    }
}

function passwordValidation($password){
    if ( empty( $password )){
        return "Password ne sme biti prazan";
    }elseif(preg_match('/\s/',$password)){ 
        return "Password ne sme sadržati razmake!";
    }elseif(strlen($password) < 5 || strlen( $password ) > 50 ){
        return "Password mora imati izmedju 5 i 25 karaktera!";
    }else{
        return "";
    }
}

function textValidation($text){
    if ( empty ( $text )){
        return "Obavezno polje!";
    }elseif( !preg_match('/^[a-zA-ZČčćĆšŠđĐžŽ\s0-9+,.]+$/', $text)){//uzima string i pretrazuje ga da li sadrzi odredjeni sadrzaj
        return "POlje ne sme da sadrzi specijalne karaktere!";
    }elseif ( strlen( $text ) <  2  ){
        return "Polje mora da sadrži najmanje 2 znaka!";
    }else{
        return "";
    }
}














































































































?>