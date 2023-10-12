<?php
require_once "connection.php";
require_once "validation.php";
$emailErr = $imeErr = $komentarErr = "";
$emailKomentar = $imeKomentar = $komentar = "";
$succssesMsg = $errorMsg ="";
if ( $_SERVER["REQUEST_METHOD"] == "POST"){
    $emailKomentar = $conn-> real_escape_string( $_POST["email_komentar"]);
    $imeKomentar = $conn ->real_escape_string( $_POST["ime_komentar"]);
    $komentar = $conn -> real_escape_string( $_POST["komentar_text"]);
    $ocena = $conn -> real_escape_string( $_POST["ocena"]);

    $emailErr = usernameValidation($emailKomentar, $conn);
    if ( empty( $imeKomentar )){
        $imeErr = " Polje ne sme biti prazno!";
    }elseif( strlen( $imeKomentar ) <= 3 ){
        $imeErr = " Polje mora sadržati više od 3 znaka!";
    }elseif( !preg_match('/^[a-zA-ZČčćĆšŠđĐžŽ\s]+$/', $imeKomentar)){
        $imeErr = "Polje ne sme sadržati specijalne karaktere";
    }else{
        $imeErr = "";
    }

    $komentarErr = textValidation($komentar);

if ( $emailErr == ""  && $imeErr == "" && $komentarErr == ""){
    $sql = "INSERT INTO `coments` (`email`,`name`,`coment`,`grade`)
    VALUES (
        '".$emailKomentar."',
        '".$imeKomentar."',
        '".$komentar."',
        $ocena
        )
    ";
    if ( $conn -> query ( $sql )){
        $succssesMsg = " Cenimo vaše sugestije hvala na izdvojenom vremenu.";
    }else{
        $errorMsg = "Grešk aprilikom slanja komentara ".$conn -> error;
    }
}
   
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    <title>Hello, world!</title>
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
          <li class="nav-item">
            <a class="nav-link" href="">Postovi</a>
          </li>
        </ul>
        <a href="tel: +381 0616493939" class="btn btn-brand">Naruči odmah</a>
      </div>
    </div>
  </nav>
  <section id="komentar_form" class="bg-cover">
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-lg-6  ">
                <div class="card p-1">
                    <div class="card-body">
                        <form action="ostavi_komentar.php" method="POST">
                            <div class="border-1 border-success  text-success p-2">
                                <?php echo  $succssesMsg; ?>
                            </div>
                            <div class="mb-3">
                                <label for="email_komentar" class="form-label" >Email</label>
                                <input type="email" class="form-control" id="email_komentar" name="email_komentar" placeholder="Unesite svoj email" value= "<?php echo $emailKomentar;  ?>">
                                <div class="text-danger">
                                    <?php echo $emailErr; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ime_komentar" class="form-label">Ime i Prezime</label>
                                <input type="text" class="form-control" id="ime_komentar" placeholder="Unesite svoje ime" name="ime_komentar" value= "<?php echo $imeKomentar;  ?>">
                                <div class="text-danger">
                                    <?php echo $imeErr; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="komentar_text" class="form-label">Ostavi svoj komentar</label>
                                <textarea class="form-control" id="komentar_text" rows="3" name="komentar_text" > <?php echo $komentar;  ?></textarea>
                                <div class="text-danger">
                                    <?php echo $komentarErr; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p>Ocena</p>
                            </div>
                            <div class="radio-buttons mb-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="3">
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="4">
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="5">
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="6">
                                    <label class="form-check-label" for="inlineRadio6">6</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="7">
                                    <label class="form-check-label" for="inlineRadio7">7</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="8">
                                    <label class="form-check-label" for="inlineRadio8">8</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="9">
                                    <label class="form-check-label" for="inlineRadio9">9</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ocena" id="inlineRadio2" value="10" checked>
                                    <label class="form-check-label" for="inlineRadio10" >10</label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-brand">Pošalji</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                        <a href="index.php" class="ps-2 kombo_link">Nazad</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  
  </body>
</html>