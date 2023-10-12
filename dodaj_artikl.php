<?php
session_start();
if ( !isset($_SESSION['id'])){
    Header ("Location: index.php");
}

require_once "connection.php";
require_once "validation.php";
require_once "header.php";

$naziv = $cena = $opis = "";
$nazivError = $cenaError = $opisError = $fileError = $kategorijaErr = "";
$akcija = $preporuka = 0;
$errMessage = "";
$successMsg = "";
if ( $_SERVER["REQUEST_METHOD"] == "POST"){
    $naziv = $conn-> real_escape_string( $_POST["naziv_artikla"]);
    $cena = $conn-> real_escape_string( $_POST["cena_artikla"]);
    $opis = $conn-> real_escape_string( $_POST["opis_artikla"]);
    $kategorija = $conn-> real_escape_string( $_POST["kategorija"]);

    if ( isset ($_POST['akcija'])){
        $akcija = 1;
    }
    if ( isset ($_POST['preporuka'])){
        $preporuka = 1;
    }
    

    $createdAt = date("Y-m-d H:i:s");

    
    // var_dump($fotografija);
    // var_dump($akcija);

    $sql = " SELECT * FROM `products` WHERE `title` = '".$naziv."'";
    $res =  $conn -> query ( $sql );
    if ( $res -> num_rows > 0 ){
        $nazivError = "Postoji artikl sa ovim nazivom!";
    }else{
        $nazivError = textValidation($naziv);
    }

    if (!empty( $cena )){
        if ( !is_numeric ( $cena )){
            $cenaError = "Polje prihvata samo brojeve";
        }
    }else{
        $cenaError = "Obavezno polje";
    }
    
    

    $opisError =  textValidation($opis);

    if( $kategorija == "Izaberite kategoriju artikla"){
        $kategorijaErr = "Morate izabrati kategoriju";
    }

    if ( $nazivError == "" && $opisError == "" && $cenaError == "" &&  $kategorijaErr == "" ){
    if ( $_FILES['fotografija_artikla']['size'] !== 0 ){
        $file = $_FILES['fotografija_artikla'];


        $fileName = $_FILES['fotografija_artikla']['name'];
        $fileTmpName = $_FILES['fotografija_artikla']['tmp_name'];//privremena lokacija filea
        $fileSize= $_FILES['fotografija_artikla']['size'];
        $fileError = $_FILES['fotografija_artikla']['error'];
        $fileType = $_FILES['fotografija_artikla']['type'];
    
        $fileExt = explode( '.', $fileName );
        $fileActualExt = strtolower(end($fileExt));
    
        $allowed = array ('jpg','jpeg','png','webp');
    
        if ( in_array ( $fileActualExt, $allowed )){
            if ( $fileError === 0 ){
                if( $fileSize < 1000000 ){
                    $fileNameNew = $fileName;
                    $fileDestination = 'uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                }else{
                    $fileError = "Prevelik file";
                }
            }else{
                $fileError = "Greska pri uploudovanju fotografije ";
            }
        }else{
            $fileErroe = "jpg jpeg png fajlovi dozvoljeni";
        }
    
    }else{
        $fileError = "Morate izabrati fotografiju!";
    }
   

    
    if ( $fileError == 0){
    
        $upit = "INSERT INTO `products` (`title`, `description`, `price`, `image`, `created_at`, `category`,`action`,`best_seler`)
        VALUES(
            '".$naziv."',
            '".$opis."',
            $cena,
            '".$fileDestination."',
            '".$createdAt."',
            '".$kategorija."',
            $akcija,
            $preporuka
        )
        ";
        if ( $conn -> query($upit)){
            $successMsg = "Uspešno dodato";
        }else{
            $errMessage = "Greska prilikom dodavanja novog artikla " .$conn->error;
            }
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
    <nav class="navbar navbar-expand-lg bg-white shadow py-3 sticky-top">
        <div class="container">
        <a class="navbar-brand" href="index.php">
            <!-- <img src="uploads/viber_slika_2023-09-11_19-45-13-507.png" alt="logo"> -->
            <h1 class="text-secondary fw-bold">Giros kod Taličnog Tome</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Naslovna strana</a>
                </li>
                <li class="nav-item">
                    <a href="admin_meni.php" class="display-block nav-link">
                    Meni
                    </a>                    
                </li>
                <li class="nav-item">
                    <a href="dodaj_artikl.php" class="display-block nav-link">
                    Dodaj artikl
                    </a>                    
                </li>
            </ul>
        </div>
        </div>
    </nav>
        <div class="container mt-5">
        <div class="row justify-content-center ">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body"> 
                        <h4 class="mb-2">Dodajte artikal:</h4>
                        <?php 
                        if ( $successMsg !== ""){
                        ?>
                        <div class="text-success m-3">
                            <?php echo $successMsg; ?>
                        </div>
                        <?php
                        }elseif($errMessage !== ""){
                           
                            ?>
                        <div class="text-danger m-3">
                            <?php echo $errMessage; ?>
                        </div>
                        <?php
                        }
                    ?>
                        <form method="Post" action="dodaj_artikl.php" enctype= "multipart/form-data" >
                            <div class="form-group">
                                <label for="naziv_artikla m-3">Naziv Artikla</label>
                                <input type="text" class="form-control mt-3" name="naziv_artikla" id="naziv_artikla"placeholder="Unesite naziv artikla" value="<?php echo $naziv ;?>">
                                <div class="text-danger">
                                    <?php echo $nazivError ?>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label for="cena_artikla">Cena</label>
                                <input type="text" class="form-control mt-3" id="cena_artikla" name="cena_artikla"placeholder="Unesite cenu artikla" value="<?php echo $cena ;?>">
                                <div class="text-danger">
                                    <?php echo $cenaError ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Fotografija</label>
                                <input type="file" class="form-control-file mt-3" id="fotografija_artikla" name="fotografija_artikla" >
                                <div class="text-danger">
                                    <?php if ( $fileError !== 0 ) {echo $fileError ;}?>
                                </div>
                            </div>
                            <div class="form-group  mt-3">
                                <label for="opis_artikla">Unesite opis artikla</label>
                                <textarea class="form-control mt-3" rows="5" id="opis_artikla" name="opis_artikla" ><?php echo $opis ;?></textarea>
                                <div class="text-danger">
                                    <?php echo $opisError ?>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="akcija" type="checkbox" value="1" id="flexCheckDefault"  <?php if( $akcija == 1 ){echo 'checked';};?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Akcija
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" name="preporuka" type="checkbox" value="1" id="flexCheckChecked" <?php if( $preporuka == 1 ){echo 'checked';};?>>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Preporuka
                                </label>
                            </div>
                            <div class="form-group my-2">
                                <div class="text-danger">
                                    <?php echo $kategorijaErr; ?>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="kategorija">
                                    <option selected>Izaberite kategoriju artikla</option>
                                    <option value="giros">Giros</option>
                                    <option value="sendvic">Sendviči</option>
                                    <option value="salata">Salate</option>
                                    <option value="desert">Deserti</option>
                                    <option value="akcija">Kombo akcija</option>
                                    <option value="pice">Piće</option>
                                    <option value="drugo">Drugo</option>
                                </select>
                            </div>
                            <div class="form-group my-2">

                                <button type="submit" class="btn btn-primary">Dodaj artikal</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php


?>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    

</body>


</html>