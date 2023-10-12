<?php
session_start();
if ( isset($_SESSION['id']) ){
    header( "Location: index.php ");
}
require_once ("connection.php");
    if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $rePassword = $_POST["re_password"];

        // var_dump($username);
        // var_dump($password);
        // var_dump($rePassword);
        
        
    }

    $upit = "SELECT * FROM `users` WHERE `username` = 'tomasef123'";
    $admin = $conn -> query ( $upit );

    if ( $admin -> num_rows == 0 ){
    $adminUser = "girosuser";
    $adminPass = "tomasef123";
    $hash = password_hash ($adminPass, PASSWORD_DEFAULT);

    $query = "INSERT INTO `users` (`username`,`password`)
    VALUES 
        ('$adminUser','$hash'); 
    ";
    
    $conn -> query($query) ;
    }

    //1. Val za username
    //2.validacija za password
    //3.Validacija za rePassword
    //4.Insertovati new user 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register user</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
    </head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center ">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header bg-light py-2 pb-1">
                    <h4>Novi zaposleni</h4>
                </div>
                <div class="card-body">
                    <form action="register_user.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Korisničko ime</label>
                            <input type="email" name="username" class="form-control" id="username" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Lozinka</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="re_password" class="form-label">Ponovi Lozinku</label>
                            <input type="password" name="re_password" class="form-control" id="re_password">
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>


</html>