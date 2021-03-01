<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$proyecto = (isset($_POST['proyecto'])) ? $_POST['proyecto'] : '';



$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_bitacora(id_proyecto,fecha_bit,tipo_bit,titulo_bit,descripcion_bit) VALUES('$proyecto','$fecha','$tipo','$titulo','$descripcion') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM w_bitacora ORDER BY id_bit DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE w_bitacora SET titulo_bit='$titulo',tipo='$tipo',fecha_bit='$fecha',descripcion_bit='$descripcion' WHERE id_bit='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM w_bitacora WHERE id_bit='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE w_bitacora SET estado_bit=0 WHERE id_bit='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
