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
     * Restiuisce un singleton per creare appelli
     * @return \MangaFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new AutoreFactory();
        }
        
        return self::$singleton;
    }
    
    
    /**
     * Restiuisce la lista di CorsiDiLaurea per un Dipartimento
     * @param Dipartimento $dip il Dipartimento in questione
     * @return array|\CorsoDiLaurea
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

        
        if (!$stmt->bind_param('i', $autore->getId())) {
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
        
        return self::creaAutoreDaArray($row);
    }
    
    private function creaAutoreDaArray($row){
        $autore = new Autore();
        $autore->setId($row['id']);
        $autore->setAutore($row['autore']);
        return $autore;
        
    }
    
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
    public function &getListaMangaPerAutore($autoreid){
        $mangas = array();
        $query = "select 
                manga.id id,
                manga.titolo titolo,
                manga.titolo_orig titolo_orig,
                manga.n_volume n_volume,
                autore.id id,
                autore.autore autore,
                manga.casa_ed casa_ed,
                manga.anno_pub anno_pub,
                manga.lingua lingua,
                categoria.tipo tipo,
                manga.genere genere,
                manga.descrizione descrizione,
                manga.prezzo prezzo,
                manga.n_articoli n_articoli
                
                from autore
                join autore on manga.autore_fk = autore.id
                join categoria on manga.categoria_fk = tipo
                where autore.id = ?";
                
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[ListaMangaPerAutore] impossibile inizializzare il database");
            $mysqli->close();
            return $mangas;
            
        }
         
        /*
        
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaManga] impossibile eseguire la query");
            $mysqli->close();
            return $mangas;
        }
        while ($row = $result->fetch_array()) {
            $mangas[] = self::creaMangaDaArray($row);
        }

        $mysqli->close();
        return $mangas; 
        
        */
        
        
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[ListaMangaPerAutore] impossibile inizializzare il prepared statement");
            $mysqli->close();
            return $mangas;
        }
        
        if (!$stmt->bind_param('i', $autoreid)) {
            error_log("[ListaMangaPerAutore] impossibile effettuare il binding in input");
            $mysqli->close();
            return $mangas;
        }

        
        $mangas = self::creaMangaDaStmt($stmt);
                
        $mysqli->close();
        return $mangas;
        
    }
    
}

