<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$fin = (isset($_POST['fin'])) ? $_POST['fin'] : '';
$cliente = (isset($_POST['cliente'])) ? $_POST['cliente'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO ticket (cliente_ti,apertura_ti,clausura_ti,usuario_ti,descripcion_ti,costo_ti) VALUES('$cliente','$inicio','$fin','$usuario','$descripcion','$costo')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM ticket ORDER BY folio_ti DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        
        break;        
    case 3://baja
                            
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
