<?php
$email = $_GET["email"]??NULL;
$ciudad=$_GET["ciudad"]??NULL;
$email=str_replace(".","_",$email);
$cookienombre = $email . "_" . $_GET['ciudad'];

$obj = new stdClass();
$existCookie = false;
$valueCookie;

if(isset($_COOKIE[$cookienombre])){
    $obj->exito=true;
    $obj->mensaje=$_COOKIE[$cookienombre];
}else{
    $obj->exito=false;
    $obj->mensaje="No se ah encontrado ninguna Cookie con ese Nombre!<br>";
}

echo json_encode($obj);