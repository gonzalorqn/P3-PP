<?php
class Ufologo
{
    private $pais;
    private $legajo;
    private $clave;

    public function __construct($p, $l, $c)
	{
		$this->pais = $p;
		$this->legajo = $l;
		$this->clave = $c;
    }
    
    public function ToJSON()
    {
        return '{ "pais": "' . $this->pais . '", "legajo": ' . $this->legajo . ' , "clave": "' . $this->clave . '" }';
        //return json_encode($this);
    }

    public function GuardarEnArchivo()
    {
        $path = "./archivos/ufologos.json";
        $retorno = new stdClass();
        $retorno->exito = false;
        if(file_exists($path))
        {
            $ufologos = Ufologo::TraerTodos();
            array_push($ufologos,$this);
            $retorno->mensaje = "Se agrego al archivo";
            $archivo = fopen($path,"a");
            $cadena = json_encode($ufologos);
            fwrite($archivo,$cadena);
            fclose($archivo);
            $retorno->exito = true;
        }
        else
        {
            $retorno->mensaje = "Se creo el archivo";
            $archivo = fopen($path,"a");
            fwrite($archivo,$this->ToJSON());
            fclose($archivo);
            $retorno->exito = true;
        }
        return $retorno;
    }

    public static function TraerTodos()
    {
        $path = "./archivos/ufologos.json";
        $archivo = fopen($path, "r");
        $cadena = fread($archivo,filesize($path));
        fclose($archivo);
        return json_decode($cadena,true);
    }

    public static function VerificarExistencia($ufologo)
    {
        $ufologos = Ufologo::TraerTodos();
        $retorno = new stdClass();
        $retorno->existe = false;
        $retorno->mensaje = "El ufologo no esta registrado";
        foreach($ufologos as $u)
        {
            if($u->legajo == $ufologo->legajo && $u->clave == $ufologo->clave)
            {
                $retorno->existe = true;
                $retorno->mensaje = "El ufologo esta registrado";
                break;
            }
        }
        return $retorno;
    }
}