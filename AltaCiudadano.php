<?php
require "./clases/Ciudadano.php";

$ciudad=$_POST["ciudad"]??NULL;
$email=$_POST["email"]??NULL;
$clave=$_POST["clave"]??NULL;

$ciudadano= new Ciudadano($ciudad,$email,$clave);
$json= new stdClass();
$json=$ciudadano->GuardarEnArchivo();
echo ($json->exito==true)?json_encode($json) :"No se pudo guardar en Archivo";
