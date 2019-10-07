<?php
if(isset($_POST["legajo"]) && isset($_POST["clave"]))
{
    $ufologo = new Ufologo("", $_POST["legajo"], $_POST["clave"]);
    $verificar = Ufologo::VerificarExistencia($ufologo);
    if($verificar->existe)
    {
        $strCookie = date("d-m-y h:i:s") . " - " . $verificar->mensaje;
        setcookie($_POST["legajo"], $strCookie);
    }
}