<!DOCTYPE html>
<?php
include_once '../global/ConfigServer.php';
include_once '../global/connection_DB.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Panel de control</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" >
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" >
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" >
    <!-- Custom Styles-->
    <link href="../Inventario/assets/css/custom-styles.css" rel="stylesheet" >
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' >
    <!--Datatables -->
    <!-- <link rel="stylesheet" type="text/css" href="../Inventario/assets/DataTables/datatables.min.css"> -->
    <link rel="stylesheet" type="text/css" href="../Inventario/assets/DataTables/DataTables-1.11.3/css/jquery.dataTables.css"> 


    
    <style>
        .no-boder {
    border:0px solid #f3f3f3;
    box-shadow: 2px 2px 10px  #2221216b;
    }
    .panel{
        -webkit-box-shadow: 1px 1px 7px 1px rgb(221 221 221);
        box-shadow: 1px 1px 7px 1px rgb(221 221 221);
    }
    .pagination > li > a,
    .pagination > li > span {
        border-radius: 4px;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        box-shadow: 2px 2px 3px red;
    }
    </style>
</head>
</html>