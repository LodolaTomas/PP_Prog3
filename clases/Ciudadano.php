<?php

class Ciudadano
{
    private $ciudad;
    private $email;
    private $clave;

    function __construct($_ciudad, $_email, $_clave)
    {
        $this->ciudad = $_ciudad;
        $this->email = $_email;
        $this->clave = $_clave;
    }

    public function ToJSON()
    {
        $p = new stdClass();
        $p->ciudad = $this->ciudad;
        $p->email = $this->email;
        $p->clave = $this->clave;
        return json_encode($p);
    }

    public function _getCiudad()
    {
        return $this->ciudad;
    }
    public function _getEmail()
    {
        return $this->email;
    }

    public function _getClave()
    {
        return $this->clave;
    }

    function GuardarEnArchivo()
    {
        $arrayJson = array();
        $path = "./archivos/ciudadano.json";
        $obj= new stdClass();
        $obj->exito=false;
        $obj->mensaje="No se pudo Agregar el Ciudadano";
        if (file_exists("./archivos/ciudadano.json")) {// verifico si el archivo ya fue creado o no
            $arc = fopen($path, "r+");
            $leo = fread($arc, filesize($path));//si fue creado lo leo
            fclose($arc);
            $arrayJson = json_decode($leo);//guardo lo leio en un arrayJson
            array_push($arrayJson, json_decode($this->ToJSON()));//guardo en ese array mi nuevo Ciudadano 
            $arc = fopen($path, "w+");//abro el archivo nuevamente y sobreescribo
            $cant = fwrite($arc, json_encode($arrayJson));//termino guardando el nuevo Ciudadano agegado al .json
            if ($cant > 0) {
                $obj->exito=true;
                $obj->mensaje="Ciudadano Agregado Correctamente";
            }
            fclose($arc);
        } else {// si el archivo no existe lo creo 
            $arc = fopen("./archivos/ciudadano.json", "w+");
            array_push($arrayJson, json_decode($this->ToJSON()));
            $cant = fwrite($arc, json_encode($arrayJson));//guardo en el archivo nuevo mi arrayjson
            if ($cant > 0) {
                $obj->exito=true;
                $obj->mensaje="Ciudadano Agregado Correctamente";
            }
            fclose($arc);
        }
        return $obj;
    }

    static function TraerTodos()
    {
        $traigoTodos=array();
        $nombreArchivo = "./archivos/ciudadano.json";
        $archivo = fopen($nombreArchivo, "r");
        $archAux = fread($archivo,filesize($nombreArchivo));
        $traigoTodos=json_decode($archAux,true,512,JSON_OBJECT_AS_ARRAY);//traigo los arrays de json
        fclose($archivo);
        $cantidad= count($traigoTodos);
        $arrayCiudadano=[];
        for ($i=0; $i < $cantidad; $i++) { 
            $ciudadano= new Ciudadano($traigoTodos[$i]["ciudad"],$traigoTodos[$i]["email"],$traigoTodos[$i]["clave"]);
            array_push($arrayCiudadano,$ciudadano);
        }
        return $arrayCiudadano;
    }

    public static function verificarExistencia($ciudadano)
    {
        $ciudadanos = Ciudadano::traerTodos();
        $obj = new stdClass();
        $obj->cont = 0;
        $flag = 0;
        foreach ($ciudadanos as $value) {
            if ($value->_getEmail() == $ciudadano->_getEmail()  && $value->_getClave() == $ciudadano->_getClave()) {
                $obj->existe = true;
                $flag = 1;
                foreach ($ciudadanos as $valor) {
                    if ($valor->_getCiudad() == $ciudadano->_getCiudad()) {
                        $obj->cont++;
                    }
                }
                $obj->mensaje = "Ciudadanos en la misma ciudad:" . $obj->cont;
                break;
            }
        }
        if ($flag == 0) {
            $obj->existe = false;
            $obj->mensaje = "No se encontro Ciudadano";
            $obj->popular = "HACERRR";
        }
        return $obj;
    }


    public static function ciudadesMasPopulares()
    {
        $ciudadanos = Ciudadano::TraerTodos();
        foreach ($ciudadanos as $key) {
        }
    }
}
