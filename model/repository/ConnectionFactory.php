<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ConnectionFactory
 *
 * @author wadmin
 */
class ConnectionFactory {

    private static ?MyMySqli $connection = null;
    private static $ruta_fichero;

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    public static function getConnection() {

        if (is_null(self::$connection)) {
            self::$ruta_fichero = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . DATABASE_INI_FILE;

            if (!$settings = parse_ini_file(self::$ruta_fichero, TRUE)) {
                throw new Exception('Unable to open ' . self::$ruta_fichero . '.');
            }

            self::$connection = new MyMySqli( 
                    $settings['database']['host'],                    
                    $settings['database']['username'],
                    $settings['database']['password'], 
                    $settings['database']['schema']);

        }
            return self::$connection;
        
    }
}
    