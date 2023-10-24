<?php
session_start();
require_once "connection.php";
require_once "validation.php";

if ( !isset ( $_SESSION['id']) && !isset($_COOKIE['user'])){
    header ( "Location: index.php ");
}

$nazivErr = $opisErr = $cenaErr = $fajlErr = $kategorijaErr = "";
$akcija = $preporuka = 0;
$successMsg = "";
$errMessage = "";
if ( $_SERVER["REQUEST_METHOD"] == "GET" && isset ( $_GET['id'])){
    $artiklId = $_GET['id'];
    
    $sql = "SELECT * FROM `products` WHERE `id` =  $artiklId ";
    $res = $conn -> query ($sql);
    if ( $res -> num_rows > 0 ){
        while ( $row = $res -> fetch_assoc()){
            $naziv = $row['title'];
            $opis = $row['description'];
            $cena = $row['price'];
            $fajl =$row['image'];
            $akcija = $row['action'];
            $preporuka = $row['best_seler'];
        }
    }
}
if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $naziv = $conn-> real_escape_string( $_POST["naziv_artikla"]);
    $cena = $conn-> real_escape_string( $_POST["cena_artikla"]);
    $opis = $conn-> real_escape_string( $_POST["opis_artikla"]);
    $kategorija = $conn-> real_escape_string( $_POST["kategorija"]);
    $artiklId = $conn-> real_escape_string( $_POST["artikl_id"]);

    if ( isset ($_POST["akcija"]) ){
        $akcija = 1;
    }
    if ( isset ($_POST['preporuka'])){
        $preporuka = 1;
    }
    
    $updatedAt = date("Y-m-d H:i:s");

    
    // var_dump($fotografija);
    // var_dump($akcija);


    $nazivErr = textValidation($naziv);

    if (!empty( $cena )){
        if ( !is_numeric ( $cena )){
            $cenaErr = "Polje prihvata samo brojeve";
        }
    }else{
        $cenaErr = "Obavezno polje";
    }
    
    

    $opisErr =  textValidation($opis);
    if( $kategorija == "Izaberite kategoriju artikla"){
        $kategorijaErr = "Morate izabrati kategoriju";
    }

    if(  $nazivErr == "" && $opisErr == "" && $cenaErr == "" && $kategorijaErr == "" ){
        $upit = "UPDATE `products` SET 
                `title` = '".$naziv."',
                `description` = '".$opis."',
                `price` = '".$cena."',
                `updated_at` = '".$updatedAt."',
                `category` = '".$kategorija."',
                `action` = $akcija,
                `best_seler` = $preporuka
                WHERE `id` = $artiklId
            ";
            if ( $conn -> query($upit)){
                $successMsg = "Uspešno izmenjeno";
            }else{
                $errMessage = "Greska prilikom izmene artikla " .$conn->error;
            }
        }
    }
        // if ( $_FILES['fotografija_artikla']['size'] !== 0 ){
        //     $file = $_FILES['fotografija_artikla'];
    
    
        //     $fileName = $_FILES['fotografija_artikla']['name'];
        //     $fileTmpName = $_FILES['fotografija_artikla']['tmp_name'];//privremena lokacija filea
        //     $fileSize= $_FILES['fotografija_artikla']['size'];
        //     $fajlErr = $_FILES['fotografija_artikla']['error'];
        //     $fileType = $_FILES['fotografija_artikla']['type'];
        
        //     $fileExt = explode( '.', $fileName );
        //     $fileActualExt = strtolower(end($fileExt));
        
        //     $allowed = array ('jpg','jpeg','png');
        
        //     if ( in_array ( $fileActualExt, $allowed )){
        //         if ( $fajlErr === 0 ){
        //             if( $fileSize < 1000000 ){
        //                 $fileNameNew = $fileName;
        //                 $fileDestination = 'uploads/'.$fileNameNew;
        //                 move_uploaded_file($fileTmpName, $fileDestination);
        //             }else{
        //                 $fajlErr = "Prevelik file";
        //             }
        //         }else{
        //             $fajlErr = "Greska pri uploudovanju fotografije ";
        //         }
        //     }else{
        //         $fajlErr = "jpg jpeg png fajlovi dozvoljeni";
        //     }
        
        // }else{
        //     $fajlErr = "Morate izabrati fotografiju!";
        // }
    //     if ($fajlErr == 0){
    //         $upit = "UPDATE `products` SET 
    //             `title` = '".$naziv."',
    //             `description` = '".$opis."',
    //             `price` = '".$cena."',
    //             `image` = '".$fileDestination."',
    //             `updated_at` = '".$updatedAt."',
    //             `category` = '".$kategorija."',
    //             `action` = $akcija,
    //             `best_seler` = $preporuka
    //             WHERE `id` = $artiklId
    //         ";
    //         if ( $conn -> query($upit)){
    //             $successMsg = "Uspešno izmenjeno";
    //         }else{
    //             $errMessage = "Greska prilikom izmene artikla " .$conn->error;
    //         }
    //         }
    // }
    // }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni Artikl</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body>
<div class="container mt-5">
        <div class="row justify-content-center ">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body"> 
                        <h4 class="mb-2">Izmenite artikal:</h4>
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
                        <form method="Post" action="izmeni_artikl.php" enctype= "multipart/form-data" >
                            <div class="form-group">
                                <input type="hidden" name="artikl_id" value ="<?php echo $artiklId ?>">
                                <label for="naziv_artikla">Naziv Artikla</label>
                                <input type="text" class="form-control my-3" name="naziv_artikla" id="naziv_artikla"placeholder="Unesite naziv artikla" value="<?php echo $naziv ;?>">
                                <div class="text-danger">
                                    <?php echo $nazivErr ?>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label for="cena_artikla">Cena</label>
                                <input type="text" class="form-control my-3" id="cena_artikla" name="cena_artikla"placeholder="Unesite cenu artikla" value=<?php echo $cena ;?>>
                                <div class="text-danger">
                                    <?php echo $cenaErr ?>
                                </div>
                            </div>
                            <?php
                            if ( isset( $_GET['action']) && $_GET['action'] == 'izmeni_sliku'){
                            ?>
                            <div class="form-group">
                                <div class="text-danger">
                                    <?php if ( $fajlErr !== 0 ) {echo $fajlErr ;}?>
                                </div>
                                <label for="exampleFormControlFile1">Fotografija</label>
                                <input type="file" class="form-control-file my-3" id="fotografija_artikla" name="fotografija_artikla" >   
                            </div>
                            <?php
                            }
                            ?>
                            <div class="form-group">
                                <label for="opis_artikla">Unesite opis artikla</label>
                                <textarea class="form-control my-3" rows="5" id="opis_artikla" name="opis_artikla" ><?php echo $opis ;?></textarea>
                                <div class="text-danger">
                                    <?php echo $opisErr ?>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="akcija" type="checkbox" value="1" id="flexCheckDefault" <?php if( $akcija == 1 ){echo 'checked';};?>>
                                <label class="form-check-label" for="flexCheckDefault" >
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
                                <select class="custom-select p-1" id="inputGroupSelect01" name="kategorija">
                                    <option selected>Izaberite kategoriju artikla</option>
                                    <option value="giros">Giros</option>
                                    <option value="sendvic">Sendviči</option>
                                    <option value="palacinke">Palačinke</option>
                                    <option value="desert">Deserti</option>
                                    <option value="akcija">Kombo akcija</option>
                                    <option value="pice">Piće</option>
                                    <option value="other">Drugo</option>
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <button type="submit" class="btn btn-primary">Izmeni artikal</button>
                                <button type="reset" class="btn btn-danger"><a href="admin_meni.php" class="text-decoration-none text-white">Nazad</a></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    

</body>
</html>