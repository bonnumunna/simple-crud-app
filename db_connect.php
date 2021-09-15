<?php
    $conn = mysqli_connect('localhost', 'root', '', 'crud');

    if(mysqli_connect_errno()){
        die("Error Occured: ").mysqli_connect_error();
    }
?>