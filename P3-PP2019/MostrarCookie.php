<?php
/*MostrarCookie.php: Se recibe por GET un JSON (con el legajo del ufólogo) y se verificará si existe una cookie con
el mismo nombre, de ser así, retornará un JSON que contendrá: éxito(bool) y mensaje(string), dónde se mostrará
el contenido de la cookie. Caso contrario, false y el mensaje indicando lo acontecido.*/
$legajo=$_GET["legajo"];
date_default_timezone_set('America/Argentina/Buenos_Aires');

if(isset($_COOKIE[$legajo]))
{
    echo '{"exito":true,"mensaje":"'.$_COOKIE[$legajo].'"}';
}
else
{
    echo '{"exito":false,"mensaje":"La cookie no existe"}';
}

?>