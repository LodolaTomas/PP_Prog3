<?php
require "./clases/Ciudad.php";
$arrayTelevisores = array();
$CiudadRandom = new Ciudad("", "", "", "");
$arrayCiudades = $CiudadRandom->Traer();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {

            padding: 20px;
            margin: 0 auto;
            width: 900px;
            text-align: center;
        }

        .trpapa {
            height: 100px;
        }
    </style>
    <title>Listado Ciudades</title>
</head>

<body>
    <th>
        <h4>Listado Ciudades</h4>
    </th>
    <table>
        <tr>
            <td colspan="4">
                <hr />
            </td>
        </tr>
        <tr>
            <th>Nombre</th>
            <th>Poblacion</th>
            <th>Pais</th>
            <th>Foto</th>
        </tr>
        <?php foreach ($arrayCiudades as $key) { ?>
            <tr class="trpapa">
                <td><?php echo $key->nombre ?></td>
                <td><?php echo $key->poblacion ?></td>
                <td><?php echo $key->pais ?></td>
                <?php
                $flag = false;
                if ($key->pathFoto == "") {
                    echo '<td>SinFoto</td';
                } else {
                    if (file_exists("./ciudades\imagenes/" . $key->pathFoto)) {
                        echo "<td><img src=./ciudades\imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                        $flag = true;
                    }
                    if (file_exists("./ciudadesModificadas/" . $key->pathFoto)) {
                        echo "<td><img src=./ciudadesModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                        $flag = true;
                    }
                    if ($flag == false)
                        echo '<td>SinFoto</td';
                }
                ?>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="4">
                <hr />
            </td>
        </tr>
    </table>
</body>

</html>