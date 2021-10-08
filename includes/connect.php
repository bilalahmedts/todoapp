<?php

    $host = "localhost";
    $userName = "root";
    $password = "";
    $database = "todoapp";

    /** establishing the connection with the database */

    $con = mysqli_connect($host,$userName,$password,$database);

    /** checking the connection */

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
 


