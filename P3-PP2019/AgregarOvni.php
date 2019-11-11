<?php
require_once './clases/Ovni.php';

$tipo=$_POST["tipo"];
$velocidad=$_POST["velocidad"];
$planeta=$_POST["planeta"];
//$foto=$_FILES["foto"]["name"];

$ovni=new Ovni($tipo,$velocidad,$planeta);

$imagen=$ovni->tipo.".".$ovni->planetaOrigen.".".date("His") . ".jpg";
$ovni->pathFoto=$imagen;

$listado=Ovni::Traer();
if($ovni->Existe($listado))
{
    echo '{"exito":FALSE,"mensaje":"El ovni ya existe en la base de datos"}';
}
else
{
    

    
    
    $destino="ovnis/imagenes/".$imagen;
    
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino))
    {
        $ovni->Agregar();
        header('Location:Listado.php');
    }
    else
    {
        echo '{"exito":FALSE,"mensaje":"No se pudo agregar la imagen"}';
    }

}
