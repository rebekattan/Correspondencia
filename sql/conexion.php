<?php

error_reporting(E_ERROR); 

<<<<<<< HEAD
    $host="localhost";
=======
    $host="localhost:3306";
>>>>>>> 278bfd9499dbd37b229dc65db8da662022f67dc1
    $user="root";
    $password="";
    $bd="correspondencia";

    $conn=mysqli_connect($host,$user,$password,$bd);

    if (!$conn) {
        $response=array('success'=>false, 'error'=>"No hay conexión a la base de datos");

        echo json_encode($response);
        exit();
    }else{
        $response=array();
        mysqli_set_charset($conn, 'utf8');
    }
?>