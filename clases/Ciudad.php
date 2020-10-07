<?php
require './clases/IParte1.php';
require './clases/IParte2.php';
require './clases/IParte3.php';
class Ciudad implements IParte1, IParte2, IParte3
{

    public $id;
    public $nombre;
    public $poblacion;
    public $pais;
    public $pathFoto;

    public function __construct($_id = "", $_nombre, $_poblacion, $_pais, $_pathFoto = "")
    {
        $this->id = $_id;
        $this->nombre = $_nombre;
        $this->poblacion = $_poblacion;
        $this->pais = $_pais;
        $this->pathFoto = $_pathFoto;
    }

    public function ToJSON()
    {
        $p = new stdClass();
        $p->id = $this->id;
        $p->nombre = $this->nombre;
        $p->poblacion = $this->poblacion;
        $p->pais = $this->pais;
        $p->pathFoto = $this->pathFoto;
        return json_encode($p);
    }

    public function Agregar()
    {
        try {
            $user = "root";
            $pass = "";
            $obj = new PDO("mysql:host=localhost;dbname=ciudades_bd;charset=utf8", $user, $pass);
            $consulta = $obj->prepare("INSERT INTO ciudades ( nombre, poblacion, pais, path_foto)VALUES(?,?,?,?)");
            return $consulta->execute(array($this->nombre, $this->poblacion, $this->pais, $this->pathFoto));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function Traer()
    {
        try {
            $listaCiudades = array();
            $user = "root";
            $pass = "";
            $db = new PDO("mysql:host=localhost;dbname=ciudades_bd;charset=utf8", $user, $pass);
            $sql = $db->query("SELECT * FROM ciudades");

            while ($fila = $sql->fetch()) {
                $ciudad = new Ciudad($fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
                array_push($listaCiudades, $ciudad);
            }
            return $listaCiudades;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function Existe($arrayCiudad)
    {
        $flag = false;
        foreach ($arrayCiudad as $key) {
            if ($this->nombre == $key->nombre && $this->pais == $key->pais) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }

    function Modificar()
    {
        try {
            $user = "root";
            $pass = "";

            $obj = new PDO("mysql:host=localhost;dbname=ciudades_bd;charset=utf8", $user, $pass);
            $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $obj->prepare("UPDATE ciudades SET nombre= ?, poblacion= ?,pais= ?,path_foto= ? WHERE id=?");
            return $consulta->execute([$this->nombre, $this->poblacion, $this->pais, $this->pathFoto, $this->id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function Eliminar()
    {
        try {
            $user = "root";
            $pass = "";

            $obj = new PDO("mysql:host=localhost;dbname=ciudades_bd;charset=utf8", $user, $pass);
            $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $obj->prepare("DELETE FROM ciudades WHERE nombre=? AND pais=?");
            return $consulta->execute([$this->nombre, $this->pais]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function GuardarEnArchivo()
    {
        $nombreArchivo = "./ciudades_borradas.txt";
        $archivo = fopen($nombreArchivo, "a+");
        if ($archivo) {
            $pathFoto = $this->pathFoto;
            $fechaActual = date("h:i:s");
            $fechaActual = str_replace(":", "", $fechaActual);
            $pathviejoM="ciudadesModificadas/" . $pathFoto;
            $pathviejoI="ciudades/imagenes/" . $pathFoto;
            $imagenTipo = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
            if (file_exists("./ciudadesModificadas/" . $pathFoto)) {
                rename(chop($pathviejoM), chop("./ciudadesBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
            }
            if (file_exists("./ciudades/imagenes/" . $pathFoto)) {
                rename(chop($pathviejoI), chop("./ciudadesBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
            }
            $this->pathFoto= $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo;
            fwrite($archivo, $this->id . "-" . $this->nombre . "-" . $this->poblacion . "-" . $this->pais . "-" . chop($this->pathFoto) . "\r\n");
            fclose($archivo);
        }
    }
    static function MostrarBorrados()
    {
        $archivo = fopen('./ciudades_borradas.txt', "r");
        $datos = array();
        $listaBorrados = array();
        if ($archivo) {
            $archivito = filesize('./ciudades_borradas.txt');
            if ($archivito != 0) {
                while (!feof($archivo)) {
                    $cadena = fgets($archivo);
                    $datos = explode('-', $cadena);
                    if (count($datos) > 2) {
                        $CiudadBorrada = new Ciudad($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
                        array_push($listaBorrados, $CiudadBorrada);
                    }
                }
            }
            fclose($archivo);
        }
        return $listaBorrados;
    }
}
