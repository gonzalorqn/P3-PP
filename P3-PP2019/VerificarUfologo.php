<?php
/*VerificarUfologo.php: Se recibe por POST el legajo y la clave, si coinciden con algún registro del archivo JSON
(VerificarExistencia), crear una COOKIE nombrada con el legajo del ufólogo, que guardará la fecha actual (con
horas, minutos y segundos) más el retorno del mensaje del método VerificarExistencia. Luego ir a
ListadoUfologos.php.
Caso contrario, retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido (agregar el
mensaje obtenido del método de clase).*/
require_once "./clases/ufologo.php";

$legajo=$_POST["legajo"];
$clave=$_POST["clave"];

$ufoLogo=new StdClass();
$ufoLogo->legajo=$legajo;
$ufoLogo->clave=$clave;

$obj=ufoLogo::VerificarExistencia($ufoLogo);
$obj=json_decode($obj);
if($obj->existe==true)
{
    setcookie($ufoLogo->legajo,date('d/m/y h:i:s')."--".$obj->mensaje);
    header("Location:ListadoUfoLogos.php");
}
else
{
    echo '{"exito":false,"mensaje":"El ufologo no existe"}';
}


?>