<?php

    // $db['db_host'] = "localhost";
    // $db['db_user'] = "root";
    // $db['db_pass'] = "";
    // $db['db_name'] = "cms";
    
    // foreach($db as $key => $value){
    //     define(strtoupper($key), $value); 
    //     //define constant meaning it cannot be changed after it is set
    // }
    $connection = mysqli_connect("localhost", "root", "", "cms"); //server, username, password, database name
    // if($connection){
    //     echo "Connected";
    // }

?>