<?php
session_start();
include_once("connection.php");
include_once("validation.php");


if ( !isset($_SESSION['id']) && !isset( $_COOKIE['user'])){
    Header("Location: admin.php");

} 
$pErr = "";
$dateErr = "";
$successMsg = "";
$errMsg ="";
$k = $r = $c = $d = $idInput = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $k = $conn-> real_escape_string( $_POST["k"]);
    $r = $conn-> real_escape_string( $_POST["r"]);
    $c = $conn-> real_escape_string( $_POST["c"]);
    $d = $conn-> real_escape_string( $_POST["d"]);
    $dateSelect = $conn-> real_escape_string( $_POST["date_select"]);
    $dateManualy = $conn-> real_escape_string( $_POST["date_manualy"]);

    if ( !isset($dateSelect) || $dateSelect == "Izaberi ili ručno unesi datum" ){
        if ( !isset( $dateManualy) || $dateManualy == "" ){
            $dateErr = "Morate izabrati datum";
        }else{
            $date = $dateManualy;
        }
    }else{
        If ( $dateSelect == "today" ){
            $date = date( "Y-m-d D" );
        }elseif( $dateSelect == "yesterday"){
            $date = date("Y-m-d D", time() - 60 * 60 * 24);
        }
    }

    if ( !is_numeric($k) || !is_numeric($r) || !is_numeric($c) || !is_numeric($d)){
        $pErr = "Polja prihvataju samo cele brojeve";
    }
    if ( $pErr == "" && $dateErr == "" ){

        $ukupno = $k + $r + $c - ( $d * 0.3 );
        $createdAt = date ( "H-i-s d-m-Y" );
        $upit = "INSERT INTO `earnings` (`k`, `r`, `c`, `d`,`date`, `created_at`, `ukupno`)
        VALUES(
            $k,
            $r,
            $c,
            $d,
            '".$date."',
            '".$createdAt."',
            $ukupno
        )
        ";
        if ( $conn -> query($upit)){
            $successMsg = "Uspešno dodato";
            header( "Location: bookkeeping.php#e_table");

        }else{
            $errMsg = "Greska prilikom dodavanja novog artikla " .$conn->error;
            }
    }  
}   



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjigovodjstvo</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-xxl">
            <h3 class="fw-bold text-secondary">
                Dobrodošao admine
            </h3> 

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto just">
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="index.php">Naslovna </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="bookkeeping.php">Knjigovodjstvo </a>
                    </li>
                
                    <li class="nav-item active">
                        <a class="nav-link fw-bold" href="dodaj_artikl.php">Dodaj artikl</a>
                    </li>
                    <li class="nav-item active nav-dropdown ">
                        <div class="nav-link fw-bold nav-dropdown" href="">Izmeni artikl</div>
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
    <section id="bookkeping_form">
        <div class="container-xxl">
            <div class="row text-center my-3">
                <h6>Unesi odgovarajuće parametre</h6>
            </div>
            <div class="text-success ms-3">
                <?php echo $successMsg; ?>
            </div>
            <div class="text-danger ms-3">
                <?php echo $errMsg; ?>
            </div>
            <form action="bookkeeping.php" method="POST" class="border border-primary-subtle py-4 mx-md-3">
                <div class="mb-3 row justify-content-center">
                    <input type="hidden" name="id_input" value="<?php $idInput; ?>">
                    <input placeholder="K" class="col-md-2 col-10 m-2" type="number" min="0" max="150000" name="k" id="k" value="<?php echo $k ?>">
                    <input placeholder="R" class="col-md-2 col-10 m-2" type="number" min="0" max="150000" name="r" id="r" value="<?php echo $r ?>">
                    <input placeholder="C" class="col-md-2 col-10 m-2" type="number" min="0" max="150000" name="c" id="c" value="<?php echo $c ?>">
                    <input placeholder="D" class="col-md-2 col-10 m-2" type="number" min="0" max="150000" name="d" id="d" value="<?php echo $d ?>">
                    <div class="text-danger col-8">
                        <?php echo $pErr ?>
                    </div>
                </div>
               
                <div class="mb-3 row justify-content-center">
                    <div class="col-md-4 m-2">
                        <select name="date_select" class="form-select" aria-label="Default select example">
                            <option selected>Izaberi ili ručno unesi datum</option>
                            <option value="today">Danas</option>
                            <option value="yesterday">Juče</option>
                            <option value="day_before_yesterday">Prekjuče</option>   
                        </select>
                    </div>  
                    <div class="col-md-4 m-2">
                        <input type="date" name="date_manualy" id="date_manualy" class="form-control">
                    </div>
                    <div class="text-danger col-8">
                        <?php echo $dateErr ?>
                    </div>
                </div>
                
                
                <div class="mb-3 row justify-content-center">
                    <button type="submit" class="btn btn-primary col-md-3 col-10 m-2">Pošalji</button>
                    <button type="reset" class="btn btn-danger col-md-3 col-10 m-2">Resetuj</button>
                </div>
            </form>
            
        </div>
    </section>
    <?php
        $upit = "SELECT * FROM `earnings` ORDER BY `date` DESC";
        $res = $conn -> query ( $upit );
        
        $sumUpit ="SELECT SUM(`ukupno`) as `ukupno_total`
        FROM `earnings`";
        $resSum = $conn -> query ( $sumUpit );
        
        if ( $resSum -> num_rows > 0){
            $r =  $resSum -> fetch_all(MYSQLI_ASSOC); 
        }
        
    ?>
    <section id="e_table">
        <div class="container-lg">
            <div class="row">
                <table class="table col-12 table-success">
                    <thead>
                        <tr>
                            <th scope="col-md-2">#</th>
                            <th scope="col-md-2">K</th>
                            <th scope="col-md-2">R</th>
                            <th scope="col-md-2">C</th>
                            <th scope="col-md-2">D</th>
                            <th scope="col-md-2">Ukupno</th>
                            <th scope="col-md-2"></th>
                            <th scope="col-md-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ( $res -> num_rows > 0){
                        while ( $row = $res -> fetch_assoc()){
                    ?>
                        <tr>
                            <td scope=""><?php echo $row['date'] ?></td>
                            <td scope=""><?php echo $row['k'] ?></td>
                            <td scope=""><?php echo $row['r'] ?></td>
                            <td scope=""><?php echo $row['c'] ?></td>
                            <td scope=""><?php echo $row['d'] ?></td>
                            <td scope=""><?php echo $row['ukupno'] ?></td>
                            <td scope=""><a href="bookkeeping_update.php?id=<?php echo $row['id'];?>&action=izmeni" class="btn btn-success">Izmeni</a></td>
                            <td scope=""><a href="bookkeeping_delete.php?id=<?php echo $row['id'];?>&action=izbrisi" class="btn btn-danger">Izbrisi</a></td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                        <tr>
                            <td scope="col-md-2"></td>
                            <td scope="col-md-2"></td>
                            <td scope="col-md-2"></td>
                            <td scope="col-md-2"></td>
                            <td scope="col-md-2"></td>
                            <td scope="col-md-2"><?php echo $r[0]['ukupno_total']?></td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<body>
    
</body>
</html>