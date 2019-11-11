<?php

require_once './clases/Ovni.php';

$obj_json=$_POST["obj_json"];
$obj_ovni=json_decode($obj_json);

$listado=Ovni::Traer();
//var_dump($listado);die();
$retorno="No se encontraron coincidencias";
for ($i=0; $i <count($listado) ; $i++) { 
    if($listado[$i]->tipo==$obj_ovni->tipo && $listado[$i]->velocidad==$obj_ovni->velocidad && $listado[$i]->planeta==$obj_ovni->planetaOrigen)
    {
        $retorno=$listado[$i]->ToJSON();
    }
}
echo $retorno;