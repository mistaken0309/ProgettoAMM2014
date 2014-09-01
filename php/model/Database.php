<?php
    include_once basename(__DIR__) . '/../Settings.php';
/**
 * Description of Database
 * 
 * @author Annalisa Congiu
 */
class Database {
    
    public function __construct() {
        
    }
    
    private static $singleton;
    /**
     *  Restituisce un singleton per la connessione al Db
     *  per garantire che si acceda al database da un unico
     *  punto
     * 
     * @return \Database
     */
    public static function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new Database();
        }
        
        return self::$singleton;
    }
    
    /**
     * Restituisce una connessione funzionante al db
     * @return \mysqli una connessione funzionante al db dell'applicazione,
     * null in caso di errore
     */
    public function connectDb(){
        // creo l'istanza della classe mysqli
        $mysqli= new mysqli();

        // connessione al database
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_password, Settings::$db_name);
        
        // controllo errori
        if($mysqli->errno != 0){
            return null;
        }else{
            return $mysqli;
        }
    }
}
