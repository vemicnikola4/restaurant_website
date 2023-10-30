<?php
require_once "connection.php";

$sql = "CREATE TABLE IF NOT EXISTS `users`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR (255) NOT NULL UNIQUE  ,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id`)
    )ENGINE = InnoDB;
";

$sql .= "CREATE TABLE IF NOT EXISTS `products`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL UNIQUE,
    `description` TEXT ,
    `price` INT ,
    `image` VARCHAR (255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY(`id`)
    )ENGINE = InnoDB;
 ";

$sql .= "CREATE TABLE IF NOT EXISTS `db_update`
    (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `upit` TEXT,
        `opis`  VARCHAR (255),
        PRIMARY KEY (`id`)
        )ENGINE=InnoDB;
";

$sql .= "CREATE TABLE IF NOT EXISTS `coments` 
    (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR (100),
    `name` VARCHAR(100),
    `coment` TEXT,
    PRIMARY KEY (`id`)
    )ENGINE=INnoDB;
    ";

$sql .= "CREATE TABLE IF NOT EXISTS `earnings` 
    (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `k` INT DEFAULT 0,
    `r` INT DEFAULT 0,
    `c` INT DEFAULT 0,
    `d` INT DEFAULT 0,
    `date` DATE,
    `created_at` DATE,
    `updated_at` DATE,
    PRIMARY KEY (`id`)
    )ENGINE=InnoDB;
"; 

if($conn->multi_query($sql)){
    echo "<p>Tables created successfully</p>";
}else{
    header("Location: error.php?m=".$conn->error);
}
?>