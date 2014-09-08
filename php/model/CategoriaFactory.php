<?php

include_once 'Database.php';
include_once 'Categoria.php';



/**
 * Description of CategoriaFactory
 *
 * @author Annalisa
 */
class CategoriaFactory {
    private static $singleton;
    
    private function __constructor(){
    }
    
    
    /**
     * Restiuisce un singleton per creare Categoria
     * @return \CategoriaFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new CategoriaFactory();
        }
        
        return self::$singleton;
    }
    
    
    /**
     * Cerca una categoria in base al valore di $tipo
     * @param $tipo
     * @return null se l'operazione non va a buon fine
     * @return la categoria cercata altrimenti
     */
    public function &getCategoriaPerTipo($tipo) {
        $query = "select *
                from categoria where tipo = ?";
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCategoriaPerTipo] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCategoriaPerTipo] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        
        if (!$stmt->bind_param('i', $tipo)) {
            error_log("[getCategoriaPerTipo] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $toRet = self::caricaCategoriaDaStmt($stmt);
       
        $mysqli->close();
        return $toRet;
    }
    
    private function caricaCategoriaDaStmt(mysqli_stmt $stmt){
        if (!$stmt->execute()) {
            error_log("[caricaCategoriaDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result($row['tipo']);
        if (!$bind) {
            error_log("[caricaCategoriaDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();
        
        
        $toRet = self::creaCategoriaDaArray($row);
        return $toRet;
    }
    
    private function creaCategoriaDaArray($row){
        $categoria = new Categoria();
        $categoria->setTipo($row['tipo']);
        return $categoria;
        
    }
    
    /**
     * Restituisce un array contenente tutte le categorie presenti nel sistema
     * @return array di categorie
     */
    public function &getListaCategorie(){
        $categorie = array();
        $query = "select tipo from categoria;";
        
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaCategorie] impossibile inizializzare il database");
            $mysqli->close();
            return $categorie;
            
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaCategorie] impossibile eseguire la query");
            $mysqli->close();
            return $categorie;
        }
        while ($row = $result->fetch_array()) {
            $categorie[] = self::creaCategoriaDaArray($row);
        }

        $mysqli->close();
        return $categorie;
        
    }
    
}
