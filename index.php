<?php
require_once "connection.php";
  if( $_SERVER['REQUEST_METHOD'] == "GET" && isset( $_GET['kategorija']) && isset( $_GET['naslov'])){
    $kategorija = $_GET['kategorija'];
    if ( $kategorija == 'best_seler' ){
      $sql = "SELECT * FROM `products` WHERE `best_seler` = 1";

    }else{
      $sql = "SELECT * FROM `products` WHERE `category` = '".$kategorija."'";
    }
    $res = $conn -> query ($sql);
    $naslov = $_GET['naslov'];
  }else{
    $kategorija = "best_seler";
    $sql = "SELECT * FROM `products` WHERE `best_seler` = 1";
    $res = $conn -> query ($sql);
    $naslov = "Giros";
  }
  $drinksSql = "SELECT * FROM `products` WHERE `category` = 'drink'";
  $resDrinks = $conn -> query ($drinksSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naslovna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <h1 class="text-secondary fw-bold">Giros kod Taličnog Tome</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php#meni">Meni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#akcija">Akcija</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-dropdown" href="https://www.google.com/maps/place/Giros+Kod+Talicnog+Tome/@44.77343,20.4715083,17.52z/data=!4m8!3m7!1s0x475a7105733d1609:0x3fa6b4613d2882db!8m2!3d44.7733561!4d20.4750713!9m1!1b1!16s%2Fg%2F11t2_qt1_s?entry=ttu">Kako do nas</a>
                        <div class="div-dropdown">
                            <a href="https://www.google.com/maps/place/Giros+Kod+Talicnog+Tome/@44.77343,20.4715083,17.52z/data=!4m8!3m7!1s0x475a7105733d1609:0x3fa6b4613d2882db!8m2!3d44.7733561!4d20.4750713!9m1!1b1!16s%2Fg%2F11t2_qt1_s?entry=ttu" class="display-block nav-link">
                                Jove Ilića 150 Voždovac
                            </a>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link" href="ostavi_komentar.php">Ostavi komentar</a>
                    </li>
                </ul>
                <a href="tel: +381 0616493939" class="btn btn-brand">Naruči odmah</a>
            </div>
        </div>
    </nav>

    <!-- carousel -->
    <div id="hero-slider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators mt-4">
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item text-center bg-cover vh-100 active slide-1" id="hero_slide_1">
                <div class="container h-100 d-flex align-items-center justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h6 class="text-white">Dobrodošli</h6>
                            <h1 class="display-1 text-white fw-bold">Najbolji Giros na Voždovcu</h1>
                            <h3><a  class= "text-white py-3" href="https://www.google.com/maps/place/Giros+Kod+Talicnog+Tome/@44.7733645,20.4736967,18.04z/data=!4m6!3m5!1s0x475a7105733d1609:0x3fa6b4613d2882db!8m2!3d44.7733561!4d20.4750713!16s%2Fg%2F11t2_qt1_s?entry=ttu">Jove Ilića 150</a></h3>
                            <a href="tel: +381 0616493939" class="btn btn-brand">POZOVI</a>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="carousel-item text-center bg-cover vh-100 slide-2" id="hero_slide_2">
                <div class="container h-100 d-flex align-items-center justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h6 class="text-white">Dobrodošli</h6>
                            <h1 class="display-1 text-white fw-bold">Pileći Giros bez konkurencije</h1>
                            <a href="tel: +381 0616493939" class="btn btn-brand">POZOVI</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#hero-slider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden ">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-slider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- o nama -->
    <section id="o_nama">
        <div class="container">
            <div class="row gy-4 align-items-center justify-content-center">
                <div class="col-lg-5 o_nama_slika">
                    <img src="uploads/viber_slika_2022-08-31_15-26-18-918.jpg" alt="" class="h-100 w-100">
                </div>
                <div class="col-lg-5">
                    <h1>O nama</h1>
                    <div class="divider my-4"></div>
                    <p>Giros Kod Taličnog Tome je počeo sa radom jula 2022. Težimo da svaki naš obrok bude spremljen kao da ga pravimo za sebe. Od nas možete očekivati samo ljubaznost i profesionalizam. </p>
                    <p>Nalazimo se neposredno pored FONa i preko puta FPNa na adresi:</p>
                    <p>Jove Ilića 150</p>
                    <a href="#meni" class="btn btn-brand">Vidi Meni</a>
                </div>

            </div>
        </div>
    </section>

    <!-- meni -->
    <section class="bg-light" id="meni">
        <div class="container-fluid">
            <div class="row my-2 justify-content-center">
                <div class="col-12 intro-text my-3">
                    <h1 class="my-3">Pogledaj naš meni</h1>
                    <p class="fw-bold">Giros  Sendviči  Salate  Palačinke</p>
                </div>
                <div class="col-12 my-2">
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=best_seler&naslov=Najprodavaniji_artikli#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "best_seler"){ echo 'nav-link-active';} ?>">Naša preporuka</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=giros&naslov=Giros#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "giros"){ echo 'nav-link-active';} ?>">Giros</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=sendvic&naslov=Sendviči#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "sendvic"){ echo 'nav-link-active';} ?>">Sendviči</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=salata&naslov=Salate#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "salata"){ echo 'nav-link-active';} ?>">Salate</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=desert&naslov=Desert#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "desert"){ echo 'nav-link-active';} ?>">Desert</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=drugo&naslov=Drugo#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "drugo"){ echo 'nav-link-active';} ?>">Drugo</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="index.php?kategorija=pice&naslov=Piće#meni" class="btn btn-primary nav-link <?php if ( $kategorija == "pice"){ echo 'nav-link-active';} ?>">Piće</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 text-center my-3">
                    <h4><?php echo str_replace("_"," ", $naslov) ?></h4>
                    
                </div>
                <?php
                        if ( $naslov == "Desert"){
                ?>
                <div class="col-12 justify-content-start mb-3">
                    <div id="prilozi" class="text-center fw-bold">
                        <h5 class ="">Prilozi</h5>
                        <div  id="">
                            <span>Nutela <span>100</span> RSD |</span>
                            <span>Eurokrem <span>90</span> RSD |</span>
                            <span>Kitket namaz <span>150</span> RSD |</span>
                            <span>Džem <span>60</span> RSD |</span>
                            <span>Plazma <span>50</span> RSD |</span>
                            <span>Kokos <span>50</span> RSD</span>
                        </div>
                    </div>
                </div>
                <?php
                    }elseif ( $naslov == "Giros" || $naslov == "Najprodavaniji_artikli" ){
                ?>
                <div class="col-12 justify-content-start mb-3">
                    <div id="prilozi" class="text-center">
                        <div id="prilozi" class="text-center">
                            <h5 class ="">Prilozi</h5>
                            <div  id="" class="m-0 fw-bold">
                                <span>Zelena salata |</span>
                                <span>Kečap  |</span>
                                <span>Majonez |</span>
                                <span>Senf |</span>
                                <span>Čili|</span>
                                <span>Tucana paprika |</span>
                                <span>Čedar sir <span>60</span> RSD |</span>
                                <span>BBQ <span>50</span> RSD </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>    
            </div>
            <div class="row m-2">
                <?php
                if ( $res -> num_rows > 0){
                    while ( $row = $res -> fetch_assoc()){
                ?>
                <div class="card col-lg-2 col-sm-5 m-md-2 m-sm-2 p-0 border-0 bg-light">
                    <div class="m-0 w-100">
                        <img class="card-img-top " src="<?php echo $row['image'] ?>" alt="Card image cap">
                    </div>
                    <div class="card-body ">
                        <h5 class="card-title fw-bold my-2"><?php echo $row['title']  ?></h5>
                        <p class="card-text fw-bold">Cena <?php  echo $row['price'] ?> RSD</p>
                        <p class="card-text "><?php  echo $row['description'] ?></p>
                        <?php if ( $row['action'] == 1 ){ ?>
                        <a href="index.php#akcija" class="kombo_link">Vidi kombo ponudu</a>
                        <?php }; ?>
                    </div>
                </div>
                <?php 
                    }
                }
                ?>
            </div>
            <!-- <div class="row m-2">
                <?php
                if ( $resDrinks -> num_rows > 0){
                    while ( $row = $resDrinks -> fetch_assoc()){
                ?>
                <div class="card col-lg-2 col-md-3 m-md-2 p-0 border-0 bg-light">
                    <div class="m-0 w-100">
                        <img class="card-img-top w-100 h-100 " src="<?php echo $row['image'] ?>" alt="Card image cap">
                    </div>
                    <div class="card-body ">
                        <h5 class="card-title fw-bold my-2"><?php echo $row['title']  ?></h5>
                        <p class="card-text fw-bold">Cena <?php  echo $row['price'] ?> RSD</p>
                        <p class="card-text "><?php  echo $row['description'] ?></p>
                        <?php if ( $row['action'] == 1 ){ ?>
                        <a href="index.php#akcija" class="kombo_link">Vidi kombo ponudu</a>
                        <?php }; ?>
                    </div>
                </div>
                <?php 
                    }
                }
                ?>
            </div>     -->
        </div>
    </section>

    <!-- akcija -->
    <section id="akcija">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 my-2 text-center">
                    <h1>Akcija</h1>
                    <p class="my-3 fw-bold">Trudimo se da redovno obradujemo svoje mušterije različitim kombo ponudama</p>
                </div>
                <div class="col-lg-10">
                    <div class="container">
                        <div class="row justify-content-center my-3">
                            <?php
                            $sql = "SELECT * FROM `products` WHERE `category` = 'akcija'";
                            $res = $conn -> query ( $sql );
                            if ( $res -> num_rows > 0){
                            while ( $row = $res -> fetch_assoc()){
                            ?>
                            <div class="card col-lg-4 col-sm-5 m-1 m-md-2 p-0 border-0 bg-white">
                                <div class="m-0 w-100">
                                    <img class="card-img-top w-100 h-100 " src="<?php echo $row['image'] ?>" alt="Card image cap">
                                </div>
                                <div class="card-body ">
                                    <h5 class="card-title fw-bold my-3"><?php echo $row['title']  ?></h5>
                                    <p class="card-text fw-bold">Cena <?php  echo $row['price'] ?> RSD</p>
                                    <p class="card-text "><?php  echo $row['description'] ?></p>
                                </div>
                            </div>    
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- komentari logika -->
    <?php
    $avgSql = "SELECT AVG(`grade`)
    FROM `coments`";
    $resAvg = $conn -> query ( $avgSql );
    $r =  $resAvg -> fetch_all(MYSQLI_ASSOC);
    $rAvg = number_format($r[0]["AVG(`grade`)"],1);

    if ( isset( $_GET['komentar']) && $_GET['komentar'] == "najbolje_ocenjeni"){
      $sql = "SELECT * FROM `coments` ORDER BY `grade` DESC LIMIT 3";
    }elseif( isset($_GET['komentar']) && $_GET['komentar'] == "najlosije_ocenjeni" ){
      $sql = "SELECT * FROM `coments` ORDER BY `grade` ASC  LIMIT 3";
    }else{
      $sql = "SELECT * FROM `coments`
      ORDER BY RAND()
      LIMIT 3";
    }
    
    $comments =[];
    $res = $conn -> query ( $sql );
    if ( $res -> num_rows > 0){
      while ( $row = $res -> fetch_assoc()){
        $comments[]= $row;
      }
    }
    ?>
    <!-- komentari -->
    <section id="komentari" class="bg-cover">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="text-white">Utisci naših gostiju <?php  echo  "<span class='quote-icon'>".$rAvg ."</span>"; ?></h1>
                    <h5 class="text-white my-3">
                        Šta drugi misle o našoj hrani
                    </h5>
                </div>
            </div>
            <!-- carousel -->
            <div id="komentari_slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators mt-4">
                    <button type="button" data-bs-target="#komentari_slider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#komentari_slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#komentari_slider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="review bg-white p-5 text-center">
                                <!-- <p class="quote-icon fw-bold"></p> -->
                                    <i class="ri-double-quotes-r quote-icon"></i>
                                    <p class="my-3"><span><?php echo $comments[0]["name"] ."<span class='quote-icon ms-2'>". number_format($comments[0]["grade"],1);".'</span>'." ?></span></p>
                                    <p><?php echo $comments[0]["coment"]  ?></p>
                                    <p>
                                        <a href="index.php?komentar=najbolje_ocenjeni#komentari"  class="kombo_link m-3">Najbolja ocena</a>
                                        <a href="index.php?komentar=najlosije_ocenjeni#komentari"  class="kombo_link m-3">Najlošija ocena</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="review bg-white p-5 text-center">
                                <!-- <p class="quote-icon fw-bold"></p> -->
                                    <i class="ri-double-quotes-r quote-icon"></i>
                                    <p class="my-3"><?php echo $comments[1]["name"] ."<span class='quote-icon ms-2'>". number_format($comments[1]["grade"],1);".'</span>'." ?></p>
                                    <p><?php echo $comments[1]["coment"]  ?></p>
                                    <p>
                                        <a href="index.php?komentar=najbolje_ocenjeni#komentari" class="kombo_link m-3">Najbolja ocena   </a>
                                        <a href="index.php?komentar=najlosije_ocenjeni#komentari"  class="kombo_link m-3">Najlošija ocena</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="review bg-white p-5 text-center">
                                <!-- <p class="quote-icon fw-bold"></p> -->
                                    <i class="ri-double-quotes-r quote-icon"></i>
                                    <p class="my-3"><?php echo $comments[2]["name"] ."<span class='quote-icon ms-2'>". number_format($comments[2]["grade"],1);".'</span>'." ?></p>
                                    <p><?php echo $comments[2]["coment"]  ?></p>
                                    <p>
                                        <a href="index.php?komentar=najbolje_ocenjeni#komentari" class="kombo_link m-3">Najbolja ocena   </a>
                                        <a href="index.php?komentar=najlosije_ocenjeni#komentari"  class="kombo_link m-3">Najlošija ocena</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#komentari_slider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden ">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#komentari_slider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>