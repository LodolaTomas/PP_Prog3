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
        $nombreArchivo = "./archivos/cuidadano.json";
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Guardado Cuidadano Fallo";
        $archivo = fopen($nombreArchivo, "a+");
        if ($archivo) {
            fwrite($archivo, $this->ToJSON() . "\r\n");
            $retorno->exito = true;
            $retorno->mensaje = "Guardado Cuidadano Agregado";
            fclose($archivo);
        }
        return $retorno;
    }

    static function TraerTodos()
    {
        $nombreArchivo = "./archivos/cuidadano.json";
        $archivo = fopen($nombreArchivo, "r");
        rewind($archivo);
        $ciudadano = array();
        if ($archivo) {
            while (!feof($archivo)) {
                $cadena = trim(fgets($archivo));
                $datos = json_decode($cadena, true);
                if ($datos != false) {
                    $newCiudadano = new Ciudadano($datos->ciudad, $datos->clave, $datos->email);
                    array_push($ciudadano, $newCiudadano);
                }
            }
            fclose($archivo);
        }
        return $ciudadano;
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
