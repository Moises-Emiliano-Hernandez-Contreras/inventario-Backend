<?php

include_once "cabeceras.php";
include_once "conection.php";

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        getAll($mysql);
        break;
    case 'POST':
        create($mysql, $_POST);
        break;
    case 'PUT':
        update($mysql, $_GET);
        break;
    case 'DELETE':
        delete($mysql, $_GET);
        break;
    default:
        # code...
        break;
}
function getAll($conexion)
{
    $query = "SELECT * FROM empleado";
    $resultado = $conexion->query($query);
    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
    }
    echo json_encode($datos);
}
function create($conexion, $param)
{    
    $nombre = $param["nombre"];
    $oficio = $param["oficio"];
    $salario = $param["salario"];
    $area = $param["area"];
    $estado = $param["estado"];
    
    $resultado = $conexion->prepare("INSERT INTO empleado VALUES (NULL,?,?,?,?,?)");         
    $resultado->bind_param("ssssd", $nombre, $oficio, $salario, $area, $estado);    
    $resultado->execute();
    if($resultado->affected_rows){
        echo json_encode(["resultado"=>"OK"]);
    }else{
        echo json_encode(["resultado"=>"BAD"]);
    }
}
function update($conexion,$id){
    $param=json_decode(file_get_contents('php://input'),true);
    $nombre = $param["nombre"];
    $oficio = $param["oficio"];
    $salario = $param["salario"];
    $area = $param["area"];
    $estado = $param["estado"];   
    $uid=$id["id"]; 
    $query = "UPDATE empleado SET nombre='$nombre', oficio=$oficio, salario=$salario, area=$area, estado=$estado WHERE id=$uid";
    $resultado = $conexion->query($query);
    if($resultado){
        echo json_encode(["resultado"=>"OK"]);
    }else{
        echo json_encode(["resultado"=>"BAD"]);
    }                
}
function delete($conexion, $id){
    $uid=$id["id"];
    $resultado = $conexion->prepare("DELETE FROM empleado WHERE id = ?");         
    $resultado->bind_param("d",$uid);    
    $resultado->execute();
    if($resultado->affected_rows){
        echo json_encode(["resultado"=>"OK"]);
    }else{
        echo json_encode(["resultado"=>"BAD"]);
    }    
}
?>