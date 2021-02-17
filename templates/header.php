<?php
include_once('bd/funcion.php');
session_start();

if ($_SESSION['s_usuario'] === null) {
  header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TECNIEM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="css/adminlte.css">
  <link rel="stylesheet" href="css/estilo.css">


  <link rel="apple-touch-icon" sizes="57x57" href="img/iconos/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="img/iconos/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="img/iconos/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="img/iconos/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="img/iconos/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="img/iconos/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="img/iconos/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="img/iconos/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="img/iconos/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="img/iconos/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/iconos/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="img/iconos/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/iconos/favicon-16x16.png">
  <link rel="manifest" href="img/iconos/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>