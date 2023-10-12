<?php

if ( isset ( $_POST['submit'])){

    $file = $_FILES['fotografija_artikla'];

    $fileName = $_FILES['fotografija_artikla']['name'];
    $fileTmpName = $_FILES['fotografija_artikla']['tmp_name'];//privremena lokacija filea
    $fileSize= $_FILES['fotografija_artikla']['size'];
    $fileError = $_FILES['fotografija_artikla']['error'];
    $fileType = $_FILES['fotografija_artikla']['type'];

    $fileExt = explode( '.', $fileName );
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array ('jpg','jpeg','png');

    if ( in_array ( $fileActualExt, $allowed )){
        if ( $fileError === 0 ){
            if( $fileSize < 500000 ){
                $fileNameNew = uniqueid('',true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            }else{
                echo "Prevelik file";
            }
        }else{
            echo "Greska pri uploudovanju fotografije ";
        }
    }else{
        echo "jpg jpeg png fajlovi dozvoljeni";
    }
}


?>