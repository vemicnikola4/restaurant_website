<?php
session_start();

require_once "connection.php";
require_once "header.php";
if ( !isset( $_SESSION['id'])){
    if(!isset( $_COOKIE['user'])){
        header( "Location: admin.php");
    }
}
$fajlErr = "";
if ( $_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kategorija']) && isset($_GET['naslov'])){
    $kategorija = $_GET['kategorija'];
    $naslov = $_GET['naslov'];
    $sql = "SELECT * FROM `products` WHERE `category` = '".$kategorija."'";

    $res = $conn -> query($sql);

}else{
    $naslov = "Svi artikli";
    $sql = "SELECT * FROM `products`";

    $res = $conn -> query($sql);
}
if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
    // $fajl = $conn-> real_escape_string( $_POST["fotografija_artikla"]);

    $updatedAt = date("Y-m-d H:i:s");
    $artiklId = $conn-> real_escape_string( $_POST["artikl_id"]);
    if ( $_FILES['fotografija_artikla']['size'] !== 0 ){
            $file = $_FILES['fotografija_artikla'];
    
            var_dump($file);
            $fileName = $_FILES['fotografija_artikla']['name'];
            $fileTmpName = $_FILES['fotografija_artikla']['tmp_name'];//privremena lokacija filea
            $fileSize= $_FILES['fotografija_artikla']['size'];
            $fajlErr = $_FILES['fotografija_artikla']['error'];
            $fileType = $_FILES['fotografija_artikla']['type'];
        
            $fileExt = explode( '.', $fileName );
            $fileActualExt = strtolower(end($fileExt));
        
            $allowed = array ('jpg','jpeg','png');
        
            if ( in_array ( $fileActualExt, $allowed )){
                if ( $fajlErr === 0 ){
                    if( $fileSize < 1000000 ){
                        $fileNameNew = $fileName;
                        $fileDestination = 'uploads/'.$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                    }else{
                        $fajlErr = "Prevelik file";
                    }
                }else{
                    $fajlErr = "Greska pri uploudovanju fotografije ";
                }
            }else{
                $fajlErr = "jpg jpeg png fajlovi dozvoljeni";
            }
        
        }else{
            $fajlErr = "Morate izabrati fotografiju!";
        }
        if ($fajlErr == 0){
            $upit = "UPDATE `products` SET 
                `image` = '".$fileDestination."',
                `updated_at` = '".$updatedAt."'
                WHERE `id` = $artiklId
            ";
            if ( $conn -> query($upit)){
                $successMsg = "Uspešno izmenjeno";
                header ( "Location: admin_meni.php");
            }else{
                $errMessage = "Greska prilikom izmene artikla " .$conn->error;
                }
            }
    }
    
    



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-xxl">
            <h3 class="fw-bold text-secondary">
                Dobrodošao admine
            </h3> 
            <?php


            ?>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto just">
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="index.php">Naslovna </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="index.php#akcije">Akcije </a>
                    </li>
                
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="dodaj_artikl.php">Dodaj artikl</a>
                    </li>
                    <li class="nav-item active nav-dropdown ">
                        <a class="nav-link fw-bold nav-dropdown" href="">Izmeni artikl</a>
                        <div class="div-dropdown list">
                            <a class="d-block" href="admin_meni.php?kategorija=Sve">Svi artikli</a>
                            <a class="d-block" href="admin_meni.php?kategorija=giros&naslov=Giros">Giros</a>
                            <a class="d-block" href="admin_meni.php?kategorija=sendvic&naslov=Senviči">Sendviči</a>
                            <a class="d-block" href="admin_meni.php?kategorija=salata&naslov=Salate">Salate</a>
                            <a class="d-block" href="admin_meni.php?kategorija=desert&naslov=Desert">Desert</a>
                            <a class="d-block" href="admin_meni.php?kategorija=akcija&naslov=Kombo&akcija">Kombo akcija</a>
                            <a class="d-block" href="admin_meni.php?kategorija=pice&naslov=Piće">Piće</a>
                            <a class="d-block" href="admin_meni.php?kategorija=drugo&naslov=Drugo">Drugo</a>   
                        </div>        
                    </li>
                    <li class="nav-item active">
                        <a  class="nav-link fw-bold" href="logout.php">Izloguj se</a>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>
    <?php

    // $kategorije = ["giros","sendvic","salata","desert","akcija","pice","drugo"];
    // $naslovi = ["Girosi","Sendviči","Salate","Deserti","Kombo akcija","Pice","Drugo"];
    ?>

    <div class="container-large p-4 bg-light">
        <div class="row text-center">
            <div class="col-12">
                <h6>Na ovoj stranici možeš dodavati i menjati artikle. Menjanje slike artikla vrši se klikom na sliku ako si u mobilmom režimu, te odabirom novog fajla i klikom na dugme izmeni.</h6>
                <h6>Ako si za računarom dovoljno je da predješ mišem preko slike i forma za izmenu fotografije će se automatki prikazati.</h6>
            </div>
        </div>
    </div>
    <section class="bg-white" id="meni">
        <div class="container-fluid ps-lg-5">
            <div class="row justify-content-center">
                <div class="col-12 intro-text">
                    <h1 class="">Meni</h1>
                </div>
                <div class="row m-2">
                    <?php
                        if ($res -> num_rows > 0){
                    echo "<h3 class='my-3 text-dark text-center'> $naslov </h3>";
                            while ( $row = $res -> fetch_assoc()){
                    ?>
                    <div class="card col-lg-2 col-sm-5 m-md-3 m-sm-2 p-0 border-0 bg-light">
                        <div class="m-0 w-100 slika-admin-meni">
                            <img class="card-img-top " src="<?php echo $row['image'] ?>" alt="Card image cap">
                        </div>
                        <div class="promeni-sliku-link ">
                            <form method="Post" action="admin_meni.php" enctype= "multipart/form-data" class="mt-2 text-center">
                                <div class="form-group">
                                    <input type="hidden" name="artikl_id" value="<?php echo $row['id']; ?>">
                                    <div class="text-danger">
                                    <?php if ( $fajlErr !== 0 ) {echo $fajlErr ;}?>
                                    </div>
                                    <label for="exampleFormControlFile1" class="fw-bold">Izmeni fotografiju</label>
                                    <input type="file" class="form-control-file m-2"  name="fotografija_artikla" >   
                                </div>
                                <button type="submit" class="btn btn-primary">Izmeni</button>
                            </form>
                        </div>
                        <div class="card-body ">
                            <h5 class="card-title fw-bold my-2"><?php echo $row['title']  ?></h5>
                            <p class="card-text fw-bold">Cena <?php  echo $row['price'] ?> RSD</p>
                            <p class="card-text "><?php  echo $row['description'] ?></p>
                            <?php if ( $row['action'] == 1 ){ ?>
                            <a href="index.php#akcija" class="kombo_link m-1">Vidi kombo ponudu</a>
                            <?php }; ?>
                            <a href="izmeni_artikl.php?id=<?php echo $row['id']?>" class="btn btn-success m-1">Izmeni artikal</a>
                            <a href="izbrisi_artikl.php?id=<?php echo $row['id']?>" class="btn btn-danger m-1">Izbriši artikal</a>
                        </div>
                    </div>
                    <?php
                            }
                        }else{

                        }
                    
                    ?>
                </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    

</body>

</html>