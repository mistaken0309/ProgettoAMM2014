<?php

include_once 'Database.php';
include_once 'Autore.php';

/**
 * Description of AutoreFactory
 *
 * @author Annalisa
 */
class AutoreFactory {
    private static $singleton;
    
    private function __constructor(){
    
        
    }
    
    
    /**
     * Restiuisce un singleton per creare autori
     * @return \MangaFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new AutoreFactory();
        }
        
        return self::$singleton;
    }
    
    
    /**
     * Restituisce un Autore in base all'id
     * @param $id id dell'autore ricercato
     * @return \Autore
     */
    public function &getAutorePerId($id) {
        $query = "select *
                from autore where id = ?";
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getAutorePerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getAutorePerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        
        if (!$stmt->bind_param('i', $id)) {
            error_log("[getAutorePerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $toRet = self::caricaAutoreDaStmt($stmt);
       
        $mysqli->close();
        return $toRet;
    }
    
    /**
     * Restituisce un Autore in base al nome
     * @param $nome nome dell'autore ricercato
     * @return \Autore
     */
    public function &getAutorePerNome($autore) {
        $query = "select *
                from autore where autore = ?";
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getAutorePerNome] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getAutorePerNome] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        
        if (!$stmt->bind_param('s', $autore)) {
            error_log("[getAutorePerNome] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $toRet = self::caricaAutoreDaStmt($stmt);
       
        $mysqli->close();
        return $toRet;
    }
    
    private function &caricaAutoreDaStmt(mysqli_stmt $stmt){
        if (!$stmt->execute()) {
            error_log("[caricaAutoreDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result($row['id'], $row['autore']);
        if (!$bind) {
            error_log("[caricaAutoreDaStmt] impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();
        $toRet = self::creaAutoreDaArray($row);
        return $toRet;
    }
    
    private function creaAutoreDaArray($row){
        $autore = new Autore();
        $autore->setId($row['id']);
        $autore->setAutore($row['autore']);
        return $autore;
        
    }
    
    /**
     * Restituisce un array contenente tutti gli autori presenti nel sistema
     * @return array di Autori
     */
    public function &getListaAutori(){
        $autori = array();
        $query = "select * from autore;";
        
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaAutori] impossibile inizializzare il database");
            $mysqli->close();
            return $autori;
            
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaAutori] impossibile eseguire la query");
            $mysqli->close();
            return $autori;
        }
        while ($row = $result->fetch_array()) {
            $autori[] = self::creaAutoreDaArray($row);
        }

        $mysqli->close();
        return $autori;
        
    }
    
    /**
     * Crea un nuovo autore 
     * @param $nome nome dell'autore da creare
     * @return boolean false se l'operazione non va a buon fine o l'id dell'autore creato
     */
    public function &creaNuovoAutore($nome){
        $query = "insert into autore(id, autore)
                 values (default, ?)";
        
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[creaNuovoAutore] impossibile inizializzare il database");
            $mysqli->close();
            return false;   
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[creaNuovoAutore] impossibile inizializzare il prepared statement");
            return false;
        }
        
        if (!$stmt->bind_param('s', $nome)) {
            error_log("[creaNuovoAutore] impossibile effettuare il binding in input");
            return false;
        }
        
        
        if (!$stmt->execute()) {
            error_log("[creaNuovoAutore] impossibile eseguire lo statement #1");
            $mysqli->rollback();
            $mysqli->close();
            return false;
        }
        $new_autore_id = $stmt->insert_id;

        $mysqli->close();
        return $new_autore_id;
        
    }
    
}

