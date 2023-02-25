<?php
include_once '../global/ConfigServer.php';
$myServer = "mysql:dbname=" . DB . ";host=" . SERVER;
try {
    $pdo = new PDO(
        $myServer,
        USER,
        PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",)
    );
} catch (PDOException $e) {
    echo "<script> alert('Error!')</script>";
}
