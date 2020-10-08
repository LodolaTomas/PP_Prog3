<?php
require "./clases/Ciudadano.php";
$array = Ciudadano::traerTodos();
$json="";
$listajson=[];
foreach ($array as $value) {
    array_push($listajson,json_decode($value->toJSON()));
}
var_dump($listajson);