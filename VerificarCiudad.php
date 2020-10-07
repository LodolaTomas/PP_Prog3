<?php
require "./clases/Ciudad.php";
$ciudad = $_POST["ciudad"] ?? NULL;
if ($ciudad != NULL) {
    $ciudad = json_decode($_POST["ciudad"]);

    $aux = new Ciudad("", $ciudad->nombre, "", $ciudad->pais);
    $arrayCiudades = $aux->Traer();
    if ($aux->Existe($arrayCiudades)) {
        echo $aux->ToJSON();
    } else {
        $respuesta="No coinciden en Ambos";
        foreach ($arrayCiudadaes as $key) {
            if($key->nombre==$aux->nombre){
                $respuesta="No coinciden en Pais";
            }
            if($key->pais==$aux->pais){
                $respuesta="No coinciden en Nombre";
            }
        }
        echo $respuesta;
    }
}
