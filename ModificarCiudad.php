<?php
require "./clases/Ciudad.php";

$ciudad=json_decode($_POST["ciudad_json"]);
$pathFoto="./ciudadesModificadas/".$_FILES["foto"]["name"];
$fechaActual= date("h:i:s");
$fechaActual=str_replace(":","",$fechaActual);
$imagenTipo= strtolower(pathinfo($pathFoto,PATHINFO_EXTENSION));
$p = new stdClass();
if (file_exists("./ciudadesModificadas/" . $ciudad->foto)) {
    unlink("./ciudadesModificadas/".$ciudad->foto);
}
if (file_exists("./ciudades/imagenes/" . $ciudad->foto)) {
    unlink("./ciudades/imagenes/" . $ciudad->foto);
}
$ciudad->foto=$ciudad->nombre.".".$ciudad->pais."."."modificado".".".$fechaActual.".".$imagenTipo;
$ciudadnueva=new Ciudad($ciudad->id,$ciudad->nombre,$ciudad->poblacion,$ciudad->pais,$ciudad->foto);
if($ciudadnueva->Modificar()){
    $_FILES["foto"]["name"]="./ciudadesModificadas/".$ciudadnueva->nombre.".".$ciudadnueva->pais."."."modificado".".".$fechaActual.".".$imagenTipo;
    move_uploaded_file($_FILES["foto"]["tmp_name"], $_FILES["foto"]["name"]);
    $p->exito=true;
    $p->mensaje="Ciudad Modificada con Exito!";
}else{
    $p->exito=false;
    $p->mensaje="La Ciudad No pudo ser Modificada";
}

echo json_encode($p);
