<?php
session_start();
require_once ("connection.php");
$usernameError = "";
$passwordError = "";
$poruka = "";
$username = "";
if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['id'])){
    Header( "Location: admin_meni.php");
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
                $passwordError = "Wrong password try again!";
            }else{
                //dobr i username i password
                //memorija zajednicka za sve php stranice izgleda kao assocniz
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
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
                            <button type="submit" class="btn btn-primary">Uloguje se</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/
GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</html>






















?>