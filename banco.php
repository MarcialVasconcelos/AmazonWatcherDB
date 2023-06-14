<?php

$env = parse_ini_file('.env');

class Banco
{
    	
	private static $dbNome =    $env['DB_DATABASE'];
    private static $dbHost =    getenv('DB_HOST');
    private static $dbUsuario = getenv('DB_USERNAME');
    private static $dbSenha =   getenv('DB_PASSWORD');
    
    private static $cont = null;
    
    public function __construct() 
    {
        die('A função Init nao é permitido!');
    }
    
    public static function conectar()
    {
        if(null == self::$cont)
        {
            try
            {
                self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbNome, self::$dbUsuario, self::$dbSenha); 
            }
            catch(PDOException $exception)
            {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function desconectar()
    {
        self::$cont = null;
    }
}

?>