<?php

class Banco {
    private static $cont = null;
    
    public function __construct() {
        die('A função Init nao é permitido!');
    }
    
    public static function conectar() {
        $whitelist = array(
            '127.0.0.1',
            '::1',
            'localhost'
        );
        
        if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            $dbNome =    getenv('DB_DATABASE');
            $dbHost =    getenv('DB_HOST');
            $dbUsuario = getenv('DB_USERNAME');
            $dbSenha =   getenv('DB_PASSWORD');
        }else{
            $dbNome =    'amazondb';
            $dbHost =    '127.0.0.1';
            $dbUsuario = 'root';
            $dbSenha =   '';
        }
        if(null == self::$cont) {
            try {
                self::$cont =  new PDO( "mysql:host=".$dbHost.";"."dbname=".$dbNome, $dbUsuario, $dbSenha); 
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