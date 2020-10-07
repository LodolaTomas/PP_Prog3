<?php
require "./clases/Ciudadano.php";

$email = $_POST["email"] ?? NULL;
$clave = $_POST["clave"] ?? NULL;
$ciudadano = new Ciudadano("", $email, $clave);
$validar = Ciudadano::verificarExistencia($ciudadano);
$resp = new stdClass();
if ($validar->exito) {
    $rep->exito = true;
    $cookieNombre = $ciudadano->_getEmail() . "_" . $ciudadano->_getCiudad();
    $cookieValor = date("H:i:s") . $validar->mensaje;
    setcookie($cookieNombre, $cookieValor,);
    $rep->mensaje = "Ciudadano encontrado\n" . $validar->mensaje;
} else {

    $resp->exito = false;
    $resp->mensaje = "No se encontro al Ciudadano\n" . $validar->mensaje;
}
echo json_encode($resp);
