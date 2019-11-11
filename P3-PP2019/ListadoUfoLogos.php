<?php
/*ListadoUfologos.php: (GET) Se mostrará el listado de todos los ufólogos en formato de array de JSON.*/
require_once "./clases/ufologo.php";

$traigoTodos=Ufologo::TraerTodos();
echo json_encode($traigoTodos);

?>