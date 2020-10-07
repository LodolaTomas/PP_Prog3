<?php
require "./clases/Ciudad.php";
$nombre = $_POST["nombre"] ?? NULL;
$poblacion = $_POST["poblacion"] ?? NULL;
$pais = $_POST["pais"] ?? NULL;

$ciudadFake = new Ciudad("", $nombre, "", $pais, "");
$arrayCiudades = $ciudadFake->Traer();

$json= new stdClass();
if ($ciudadFake->Existe($arrayCiudades)) {
    $json->exito=false;
    $json->mensaje= "La Ciudad ya Existe en la Base de Datos!";
} else {
    $pathFoto = "./ciudades/imagenes/" . $_FILES["foto"]["name"];
    $imagenTipo = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
    $fechaActual = date("h:i:s");
    $fechaActual = str_replace(":", "", $fechaActual);
    $_FILES["foto"]["name"] = $nombre . "." . $pais . "." . $fechaActual . "." . $imagenTipo;
    $pathFoto = "./ciudades/imagenes/" . $_FILES["foto"]["name"];
    move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto);
    $newCiudad = new Ciudad("",$nombre,$poblacion,$pais,$_FILES["foto"]["name"]);
    $json->exito=$newCiudad->Agregar();
    $json->mensaje="La Ciudad a sido Agregada!";
}

echo json_encode($json);