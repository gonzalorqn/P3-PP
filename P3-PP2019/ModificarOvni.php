<?php
require_once 'clases/Ovni.php';

$id=$_POST["id"];
$tipo=$_POST["tipo"];
$velocidad=$_POST["velocidad"];
$planeta=$_POST["planeta"];
$foto=$_FILES["foto"]["name"];

$ovni=new Ovni($tipo,$velocidad,$planeta,$foto);

$imagen=$ovni->tipo.".".$ovni->planetaOrigen.".modificado.".date("His") . ".jpg";

$ovni->pathFoto=$imagen;
$destino="ovnismodificados/".$imagen;

if($ovni->Modificar($id))
{  
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino))
    {
        header('Location:ListadoUfologos.php');
    }
    else
    echo '{"exito":FALSE,"mensaje":"No se pudo modificar"}';
}
else
echo '{"exito":FALSE,"mensaje":"No se pudo modificar"}';