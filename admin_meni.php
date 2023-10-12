<?php
session_start();

require_once "connection.php";
require_once "header.php";

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
            <a class="navbar-brand" href="index.php">
                <span class="fw-bold text-secondary">
                    Giros kod Taličnog Tome
                </span> 
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto just">
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="meni.php">Meni </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="index.php#akcije">Akcije </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="knjiga_utisaka.php">Knjiga utisaka </a>
                    </li>
                    <?php
                    if ( isset($_SESSION['id'])){
                        ?>
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="dodaj_artikl.php">Dodaj artikl</a>
                    </li>
                    
                        <?php
                    }

                    ?>
                </ul>
            </div>
        </div>
    
    </nav>
    <?php

    $kategorije = ["giros","sendvic","salata","desert","akcija","pice","drugo"];
    $naslovi = ["Girosi","Sendviči","Salate","Deserti","Kombo akcija","Pice","Drugo"];
    ?>

    <section class="bg-light" id="meni">
        <div class="container-fluid">
            <div class="row my-2 justify-content-center">
                <div class="col-12 intro-text my-3">
                    <h1 class="my-3">Pogledaj naš meni</h1>
                    
                    <p class="fw-bold">Giros  Sendviči  Salate  Palačinke</p>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light py-3">
        <div class="container-fluid ">
                <div class="row justify-content-center ">
                    <?php
                    for ( $i = 0 ; $i < count( $kategorije ); $i++ ){
                        $sql = "SELECT * FROM `products` WHERE `category` = '".$kategorije[$i]."'";
                        $res = $conn->query($sql);
                        ?>
                        <div class="text-center my-3 text-secondary">
                            <h3 class=""><?php echo $naslovi[$i] ?></h3>
                        </div>
                        <?php
                        if ( $res -> num_rows > 0){
                            while ( $row = $res -> fetch_assoc()){
                                ?>
                                <div class="card col-md-3 m-1 ">
                                    <img class="card-img-top p-3" src="<?php echo $row['image'] ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold"><?php echo $row['title']  ?></h5>
                                        <p class="card-text">Cena <?php  echo $row['price'] ?> RSD</p>
                                        <p class="card-text"><?php  echo $row['description'] ?></p>
                                        <?php if ( $row['action'] == 1 ){
                                        ?>
                                        <a href="index.php#akcija" class="kombo_link">Vidi akciju sa ovim artiklom</a>
                                        <?php
                                        }
                                        if ( isset( $_SESSION['id'])){
                                            ?>
                                            <a href="izmeni_artikl.php?id=<?php echo $row['id']?>" class="kombo_link">Izmeni artikal</a>
                                            <a href="izbrisi_artikl.php?id=<?php echo $row['id']?>" class="kombo_link">Izbriši artikal</a>
                                            <?php

                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                        
                        
                        ?>
                        <!--   -->
                        <?php
                            
                
                        ?>
                    </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    

</body>

</html>