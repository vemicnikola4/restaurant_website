<?php
require_once ( "connection.php ");

$upiti[] = [
    'id' => 1,
    'upit' => "ALTER TABLE `products` ADD  `category` VARCHAR(255)",
    'opis' => "Dodavanje kolone category u products"
];

$upiti[] = [
    'id' => 2,
    'upit' => "ALTER TABLE `products`
    MODIFY COLUMN `title` VARCHAR(255)",
    'opis' => "Manjanje kolone title u not unique"
];
$upiti[] =[
    'id'=> 3,
    'upit' =>"ALTER TABLE `products` ADD `best_seler` BOOLEAN",
    'opis'=> "dodavanje kolone best_seler u tabelu `products`"
];
$upiti[]=[
    'id'=> 4,
    'upit'=>"ALTER TABLE `coments` ADD `grade` INT NOT NULL",
    'opis'=> "dodavanje kolone grade u tabelu coments"
];
$upiti[]=[
    'id'=> 5,
    'upit'=> "ALTER TABLE `earnings` ADD `ukupno` INT DEFAULT 0",
    'opis'=> "Dodavanje kolone ukupno u tabelu earnings"
];

$sql = "SELECT `id` FROM `db_update`";


$res = $conn -> query($sql);

if ($res -> num_rows == 0 ){
    echo "db_update is empty"; 
    foreach ( $upiti as $upit ){
        if ( !$conn -> query ($upit['upit'])){
            echo "<p>Error query ".$upit['opis'] 
            ." ".$conn->error."</p>";
        }else{
            $q = "INSERT INTO `db_update` (`id`,`upit`,`opis`)
            VALUES
            (".$upit['id'].",'".$upit['upit']."','".$upit['opis']."')
            ";
            echo "<p>Upit ".$upit['opis']." uspesan!</p>";
        
            if( $conn->query($q)){
                echo "<p>Uspesno!!</p>";
            }
        }
    }
}else{
    $allQArr =$res->fetch_all(MYSQLI_ASSOC);
    $ids =[];
        foreach ($allQArr as $querry ){
            $ids[] = $querry['id'];
        }
    if ( count( $upiti ) == count( $ids )){
        echo "Svi upiti su izvrseni!";
    }else{
        $allQArr =$res->fetch_all(MYSQLI_ASSOC);
        
        foreach ( $upiti as $upit ){
            if ( !in_array ( $upit['id'], $ids )){
                if ( $conn -> query($upit['upit'])){
                    $q = "INSERT INTO `db_update` (`id`,`upit`,`opis`)
                    VALUES
                    (".$upit['id'].",'".$upit['upit']."','".$upit['opis']."')
                    ";
                    echo "<p>Upit ".$upit['opis']." uspesan!</p>";
        
                    if( $conn->query($q)){
                        echo "<p>Uspesno dodat upit u db_update!!</p>";
                    } 
                }else{
                    echo "<p>Neuspesan upit ".$upit['opis']. " " .$conn->error. "</p>";
                }
            }
        }
    }
}

?>