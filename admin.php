<?php
session_start();
require_once ("connection.php");
$usernameError = "";
$passwordError = "";
$poruka = "";
$username = "";
if ( $_SERVER['REQUEST_METHOD'] == 'GET'){

    if ( isset($_COOKIE['user']) || isset($_SESSION['id'])){

        
        // Header( "Location: admin_meni.php");

    }
}
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $username = $conn-> real_escape_string( $_POST["username"]);
    $password = $conn-> real_escape_string( $_POST["password"]);

    If( empty($username) ){
        $usernameError = " Morate uneti username! ";
    }

    if ( empty ( $password )){
        $passwordError = " Morate uneti password! ";
    }

    if ( $usernameError == "" && $passwordError == "" ){
        $q = "SELECT * FROM `users` WHERE `username` = '".$username."'" ;
        $result = $conn -> query ($q);

        if ( $result -> num_rows == 0){
            $usernameError = "Pogrešan username!";

        }else{
            $row = $result->fetch_assoc();
            $dbPassword = $row['password'];
            if(!password_verify( $password, $dbPassword)){
                //poklopili su se username ali lozinka nije dobra
                //Ovde moze da se broji br neuspelih logovanja
                $passwordError = "Pogrečna lozinka!";
            }else{
                //dobr i username i password
                //memorija zajednicka za sve php stranice izgleda kao assocniz
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                if ( isset($_POST['kolacic'])  ){
                    setcookie("user", "tomasef", time()+60*60*24*30 , "/");


                }
                header("Location: admin_meni.php");
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
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
    <div class="container mt-5 login-container h-100 align-items-center">
        <div class="row justify-content-center login-container">
            <div class="col-md-6  login-form">
                <div class="card">
                    <div class="card-body">
                        <form action="admin.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Korisničko ime</label>
                                <input type="email" name="username" class="form-control" id="username" aria-describedby="emailHelp" value="<?php echo $username  ?>">
                                <div class="text-danger">
                                    <?php echo $usernameError ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Lozinka</label>
                                <input type="password" name="password" class="form-control" id="password">
                                <div class="text-danger">
                                    <?php echo $passwordError ?>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="kolacic" type="checkbox" value="1" id="flexCheckDefault" checked >
                                <label class="form-check-label" for="flexCheckDefault" >
                                    Zapamti me naovom uredjaju
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Uloguj se</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</html>






















