<?php
require_once './clases/Ovni.php';

$json_recibido=$_POST["obj_json"];
//echo $json_recibido;die();
$obj_Ovni=json_decode($json_recibido);
//echo $obj_Ovni->tipo;die();
$miOvni=new Ovni($obj_Ovni->tipo,$obj_Ovni->velocidad,$obj_Ovni->planetaOrigen);

$obj_retorno=new StdClass();
$obj_retorno->exito=FALSE;
$obj_retorno->mensaje="No se pudo agregar";
if($miOvni->Agregar())
{
    $obj_retorno->exito=TRUE;
    $obj_retorno->mensaje="Se agrego correctamente";
}
echo json_encode($obj_retorno);