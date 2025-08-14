<?php
//Iniciamos la sesion:
session_start();
//El strtolower() convierte los datos recibidos en minusculas para realizar mejor la comparacion en el if 
$usuario = strtolower($_POST['usuario']); 
$contraseña = strtolower($_POST['contraseña']);

//ASIGNO VALORES A LA SESION
$_SESSION['usuario'] = $usuario;

if($_SESSION['usuario'] == 'admin' && $contraseña == 'admin'){
    header("location: formulario.php");//Usado para redirigir a otra pagina
    exit();
}else{
    header("location: index.html");
    exit();
}
?>