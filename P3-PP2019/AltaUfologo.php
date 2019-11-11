<?php

require_once "./clases/ufologo.php";
/*AltaUfologo.php: Se recibe por POST el país, el legajo y la clave. Invocar al método GuardarEnArchivo.*/

$pais=$_POST["pais"];
$legajo=$_POST["legajo"];
$clave=$_POST["clave"];

$ufologo=new ufoLogo($pais,$legajo,$clave);
$retorno=$ufologo->GuardarEnArchivo();
echo $retorno;
?>