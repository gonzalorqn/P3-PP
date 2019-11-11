<?php

class Ufologo{

    private $_pais;
    private $_legajo;
    private $_clave;

    public function __construct($pais,$legajo,$clave)
    {
        $this->_pais=$pais;
        $this->_legajo=$legajo;
        $this->_clave=$clave;
    }

    public function GetPais(){return $this->_pais;}
    public function GetLegajo(){return $this->_legajo;}
    public function GetClave(){return $this->_clave;}

    public function ToJSON()
    {
        return '{"pais":"'.$this->GetPais().'","legajo":"'.$this->GetLegajo().'","clave":"'.
                      $this->GetClave().'"}';
    }

    public function GuardarEnArchivo()
    {
        $arrayUFO=array();
        $path="./archivos/ufologos.json";

        if(file_exists("./archivos/ufologos.json"))
        {
        $resultado=FALSE;
        $arc=fopen( $path,"r+");
        $leo=fread($arc,100000000);
        fclose($arc);
        
        $arrayUFO=json_decode($leo);
        array_push($arrayUFO,json_decode($this->ToJSON()));
        $arc=fopen( $path,"w+");
        $cant=fwrite($arc,json_encode($arrayUFO));
        
        if($cant > 0)
		{
			$resultado = TRUE;			
		}
        fclose($arc);
        return '{"exito":"'.$resultado.'","mensaje":"Se ha guardado correctamente"}';
        }
        else
        {
            $resultado=FALSE;
            $arc=fopen( "./archivos/ufologos.json","w+");
            array_push($arrayUFO,json_decode($this->ToJSON()));
            $cant=fwrite($arc,json_encode($arrayUFO));
            if($cant > 0)
            {
                $resultado = TRUE;			
            }
            fclose($arc);
            return '{"exito":"'.$resultado.'","mensaje":"Se ha guardado correctamente"}';
        }
    }

    public static function TraerTodos()
    {
        $traigoTodos=array();
        $archivo=fopen("./archivos/ufologos.json", "r");
		
        $archAux = fread($archivo,filesize("./archivos/ufologos.json"));
		$traigoTodos=json_decode($archAux);
		fclose($archivo);
		
		return $traigoTodos;
    }

    /*Método de clase VerificarExistencia($ufologo), que recorrerá el array (invocar a TraerTodos) 
    y retornará un JSON que contendrá: existe(bool) y mensaje(string).*/

    public static function VerificarExistencia($ufologo)
    {
        $ufoArray=ufoLogo::TraerTodos();
        $retorno="";
        foreach ($ufoArray as $ufo) 
        {
            if($ufo->clave==$ufologo->clave && $ufo->legajo==$ufologo->legajo)
            {
                $retorno= '{"existe":true,"mensaje":"El ufologo existe"}';
                break;
            }
            else
            {
                $retorno='{"existe":false,"mensaje":"El ufologo no existe"}';
            }
        }
        return $retorno;
    }


}
?>