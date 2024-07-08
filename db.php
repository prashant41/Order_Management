<?php

$servername="localhost";
$username="root";
$password="root";
$database="saiprasad";

$dsm="mysql:host=$servername;dbname=$database";

$options=[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES=>false,
];

try{
    $pdo=new PDO($dsm,$username,$password,$options);
    echo " ";
}catch(PDOException $e){
    die("Connection failed!!!".$e->getMessage());
}

?>