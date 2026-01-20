<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: ");
}
?>