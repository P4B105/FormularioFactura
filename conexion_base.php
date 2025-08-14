<?php 

$host = "localhost";
$usuario = "root";
$password = "";
$nombredb = "base_formulario";
$conexion = new mysqli($host, $usuario, $password, $nombredb);//CONEXION

if($conexion->connect_error){//Si hay un error en la conexion, entonces imprimara que no se pudo conectar a la base de datos e imprimira el error
    die("No se ha podido conectar con la base de datos" . $conexion->connect_error); //die() funcion que imprime un mensaje y sale del script actual. Esta funcion es la salida () a la funcion de alias
}
?>