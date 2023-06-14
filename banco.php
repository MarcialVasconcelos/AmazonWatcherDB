<?php

$env = parse_ini_file('.env');

class Banco {
	// private static $dbNome =    getenv('DB_DATABASE');
    // private static $dbHost =    getenv('DB_HOST');
    // private static $dbUsuario = getenv('DB_USERNAME');
    // private static $dbSenha =   getenv('DB_PASSWORD');

    private static $dbNome =    'amazonwatcher';
    private static $dbHost =    '127.0.0.1';
    private static $dbUsuario = 'root';
    private static $dbSenha =   '';
    
    private static $cont = null;
    
    public function __construct() {
        die('A função Init nao é permitido!');
    }
    
    public static function conectar() {
        if(null == self::$cont) {
            try {
                self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbNome, self::$dbUsuario, self::$dbSenha); 
            }
            catch(PDOException $exception) {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function desconectar() {
        self::$cont = null;
    }
}

?>