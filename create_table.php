<?php
    include_once('db_connect.php');

    $sql = "CREATE TABLE IF NOT EXISTS crud(
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `firstname` VARCHAR(255) NOT NULL,
        `lastname` VARCHAR(255) NOT NULL,
        `gender` ENUM('male', 'female') DEFAULT 'male',
        `country` VARCHAR(255) NOT NULL,
        PRIMARY KEY(id)
    )";
    $query = mysqli_query($connection, $sql);
    if($query == true){
        echo "Table created";
    }
?>