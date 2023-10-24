<?php
session_start();
require_once "connection.php";

if ( !isset($_SESSION['id']) && !isset($_COOKIE['user'])){
    Header("Location:index.php");
}

if( $_SERVER['REQUEST_METHOD'] == "GET" ){
    $artiklId = $_GET['id'];
    $sql = "SELECT * FROM `products` WHERE `id` =  $artiklId ";
    $res = $conn -> query ($sql);
    if ( $res -> num_rows > 0 ){
        while ( $row = $res -> fetch_assoc()){
            $naziv = $row['title'];
            $opis = $row['description'];
            $cena = $row['price'];
            $fajl =$row['image'];
        }
    }
 }
 if( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $artiklId = $_POST['artikl_id'];
    echo $artiklId;
    $sql = "DELETE FROM `products` 
    WHERE `id` = $artiklId";
    if ( $conn ->query($sql) ){
        header ( "Location: admin_meni.php ");
    }else{
        echo $conn ->error;
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
<section class="bg-light py-3">
        <div class="container ">
                <div class="row justify-content-center ">
            
                    <div class="card col-md-4 m-1 ">
                        <img class="card-img-top p-3" src="<?php echo $fajl ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $naziv  ?></h5>
                            <p class="card-text">Cena <?php  echo $cena ?> RSD</p>
                            <p class="card-text"><?php  echo $opis; ?></p>
                            <form action="izbrisi_artikl.php" method="POST">
                                <p>Da li ste sigurni da želite da obrišete ovaj artikl?!</p>
                                <div class="form-group mt-2">
                                    <input type="hidden" name="artikl_id" value = "<?php echo $artiklId ?>">
                                    <button type="submit" class="btn btn-primary">Da</button>
                                    <a href="admin_meni.php" class="btn btn-secondary">Nazad</a>
                                </div>
                            </form>
                                       
                
                        </div>
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