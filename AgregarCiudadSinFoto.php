<?php
require "./clases/Ciudad.php";

$nombre=$_POST["nombre"]??NULL;
$poblacion=$_POST["poblacion"]??NULL;
$pais=$_POST["pais"]??NULL;

$CiudadSinFoto= new Ciudad("",$nombre,$poblacion,$pais);

$p = new stdClass();

if($CiudadSinFoto->Agregar()){
        $p->exito = true;
        $p->mensaje = "Ciudad Agregada Correctamente";
}else{
        $p->exito = false;
        $p->mensaje = "Ciudad NO Agregada";
}
echo json_encode($p);