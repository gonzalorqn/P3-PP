<?php
require_once './clases/Ovni.php';



        $listado=(Ovni::Traer());
        
        $tabla="<table border='5'><tr><td>TIPO</td><td>VELOCIDAD</td><td>PLANETA</td><td>FOTO</td>
                    <td>VEL WARP</td></tr>";
        for($i=0;$i<count($listado);$i++)
        {
            $tabla.="<tr><td>".$listado[$i]->tipo."</td><td>".$listado[$i]->velocidad."</td>
                        <td>".$listado[$i]->planeta."</td><td><img src='ovnis/imagenes/".$listado[$i]->foto."' height='100px' width='100px'></td>
                        <td>".$listado[$i]->ActivarVelocidadWarp()."</td></tr>";
        }
        $tabla.="</table>";
        echo $tabla;
