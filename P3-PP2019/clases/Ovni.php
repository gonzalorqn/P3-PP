<?php
/*Ovni.php. Crear, en ./clases, la clase Ovni con atributos públicos (tipo, velocidad, planetaOrigen y pathFoto),
constructor (con todos sus parámetros opcionales), un método de instancia ToJSON(), que retornará los datos de
la instancia (en una cadena con formato JSON).*/
require "IParte2.php";
require_once 'AccesoDatos.php';
class Ovni{
    public $tipo;
    public $velocidad;
    public $planetaOrigen;
    public $pathFoto;

    public function __construct($tipo=NULL, $velocidad=NULL, $planetaOrigen=NULL,$pathFoto=NULL)
	{
        if($tipo!=NULL)
            $this->tipo = $tipo;
        if($velocidad!=NULL)
            $this->velocidad = $velocidad;
        if($planetaOrigen!=NULL)
            $this->planetaOrigen=$planetaOrigen;
        if($pathFoto!=NULL)
            $this->pathFoto = $pathFoto;
    }
    
    public function ToJSON()
    {
        return '{"tipo":"'.$this->tipo.'","velocidad":"'.$this->velocidad.'","planetaOrigen":"'.$this->planeta.'","pathFoto":"'.$this->foto.'"}';
    }

    public function Agregar()
    {
        $retorno=FALSE;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO ovnis ( tipo, velocidad, planeta,
                                                        foto)
                                                    VALUES( :tipo, :velocidad, :planeta, :foto)");
        
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_STR);
        $consulta->bindValue(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
        
        $consulta->execute();   
        if($consulta->rowCount()>0) //SI EXISTE EL CORREO EN LA BASE DE DATOS, DEVUELVE 1 FILA
         $retorno=TRUE;                  // POR LO QUE ROWCOUNT SERA 1, INGRESANDO AL IF

        return $retorno;
    }

    public static function Traer()
    {
        $retorno=FALSE;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM ovnis");
        $consulta->execute();
        
        if($consulta->rowCount()>0)
           $retorno=$consulta->fetchAll(PDO::FETCH_CLASS,'Ovni');
                                                        
        else
        return "No hay ovnis cargados o se ha producido un error";
        
        return $retorno; 
    }

    public function ActivarVelocidadWarp()
    {
        return $this->velocidad*(10.45);
    }

    public function Existe($ovnis)
    {
        $retorno=FALSE;
        
        for ($i=0; $i <count($ovnis) ; $i++) { 
            // if($ovnis[$i]->tipo==$this->tipo && 
            //     $ovnis[$i]->velocidad==$this->velocidad 
            //     && $ovnis[$i]->planeta==$this->planetaOrigen)
            //     {
            //         $retorno=TRUE;
            //     }
            if($ovnis[$i]->foto==$this->pathFoto)
            $retorno=TRUE;

        }
        return $retorno;
    }

    public function Modificar($id)
    {
        $retorno=FALSE;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $tipo=$this->tipo;  $velocidad=$this->velocidad;    $planeta=$this->planetaOrigen;
        $foto=$this->pathFoto;
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `ovnis` SET `tipo`='$tipo', 
                                                            `velocidad`='$velocidad', 
                                                            `planeta`='$planeta',
                                                            `foto`='$foto' WHERE `id`=$id");
        $consulta->execute();
        
        if($consulta->rowCount()>0)
            $retorno=TRUE;
        
        
        return $retorno;
    }

    public function Eliminar()
    {
        $retorno=FALSE;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $foto=$this->pathFoto;
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM ovnis WHERE foto='$foto'");
        $consulta->execute();
        if($consulta->rowCount()>0)
            $retorno=TRUE;
        return $retorno;
    }

    public function GuardarEnArchivo($id)
    {
        $ar = fopen("ovnis_borrados.txt", "a");
        
        $imagen=$id.".".$this->tipo.".borrado.".date("His") . ".jpg";
        $destino="ovnisBorrados/".$imagen;
        $texto=$this->tipo." - ".$this->velocidad." - ".$this->planetaOrigen." - ".$imagen."\n";
        $cant = fwrite($ar,$texto );
        rename("ovnis/imagenes/".$this->pathFoto,$destino);
        fclose($ar);
    }

    public static function MostrarBorrados()
    {
        $archivo=fopen("ovnis_borrados.txt", "r");
        $retorno=fread($archivo,filesize("ovnis_borrados.txt"));
        return $retorno;
    }
}

?>