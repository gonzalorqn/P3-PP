<?php
require_once ("./clases/ufologo.php");

if(isset($_POST["pais"]) && isset($_POST["legajo"]) && isset($_POST["clave"]))
{
    $ufologo = new Ufologo($_POST["pais"],$_POST["legajo"],$_POST["clave"]);
    var_dump($ufologo->GuardarEnArchivo());
}