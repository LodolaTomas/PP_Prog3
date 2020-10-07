<?php
require "./clases/Ciudadano.php";
$array = Ciudadano::traerTodos();
$json="";
foreach ($array as $value) {
    $json .= $value->toJSON()."<br>";
}
echo $json;