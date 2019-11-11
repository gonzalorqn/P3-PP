<?php
require_once 'clases/Ovni.php';
require_once 'clases/AccesoDatos.php';

if(isset($_GET["id"]))
{
    $id=$_GET["id"];
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM ovnis WHERE id=$id");
        $consulta->execute();
        
        if($consulta->rowCount()>0)
        echo "El ovni existe en la base de datos";
        else
        echo "El ovni No Existe";
}
else
{
    $listado = array();
	$archivo=fopen("ovnis_borrados.txt", "r");
		
		while(!feof($archivo))
		{
			$archAux = fgets($archivo);
			$alien = explode(" - ", $archAux);
			$alien[0] = trim($alien[0]);
			if($alien[0] != ""){
				$listado[] = new Ovni($alien[0], $alien[1],$alien[2],$alien[3]);
			}
		}
		fclose($archivo);
        
        $tabla="<h1>OVNIS BORRADOS</h1><table border='5'><tr><td>TIPO</td><td>VELOCIDAD</td><td>PLANETA</td><td>FOTO</td></tr>";
        for($i=0;$i<count($listado);$i++)
        {
            $tabla.="<tr><td>".$listado[$i]->tipo."</td><td>".$listado[$i]->velocidad."</td>
                        <td>".$listado[$i]->planetaOrigen."</td><td><img src='ovnisBorrados/".$listado[$i]->pathFoto."' height='100px' width='100px'></td>
                        </tr>";
        }
        $tabla.="</table>";
        echo $tabla;
}

if(isset($_POST["accion"])=="borrar")
{
    $id=$_POST["id"];
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM ovnis WHERE id=$id");
        $consulta->execute();
        if($consulta->rowCount()>0)
        {
            $ovniBD=$consulta->fetchAll(PDO::FETCH_CLASS,'Ovni');
            
            $ovni=new Ovni($ovniBD[0]->tipo,$ovniBD[0]->velocidad,$ovniBD[0]->planeta,$ovniBD[0]->foto);
            
            if($ovni->Eliminar())
            {
                $ovni->GuardarEnArchivo($id);
                header('Location: Listado.php');
            }
            else
                echo '{"exito":FALSE,"mensaje":"No se pudo borrar"}';
        }
        else
            echo '{"exito":FALSE,"mensaje":"El ovni no existe o ha sido borrado"}';
}

