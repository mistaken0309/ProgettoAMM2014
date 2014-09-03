<?php

include_once 'Database.php';
include_once 'Manga.php';



/**
 * Description of MangaFactory
 *
 * @author Annalisa Congiu
 */
class MangaFactory {
    private static $singleton;
    
    private function __constructor(){
    
        
    }
    
    
    /**
     * Restiuisce un singleton per creare appelli
     * @return \MangaFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new MangaFactory();
        }
        
        return self::$singleton;
    }
    
    
    public function &getMangaPerId($mangaid){
        $query = "select 
                manga.id id,
              
manga.titolo titolo,
                manga.titolo_orig titolo_orig,
                manga.n_volume n_volume,
                manga.autore_fk a_id,
                autore.autore autore,
                manga.casa_ed casa_ed,
                manga.anno_pub anno_pub,
                manga.lingua lingua,
                categoria.tipo tipo,
                manga.genere genere,
                manga.descrizione descrizione,
                manga.prezzo prezzo,
                manga.n_articoli n_articoli
                
                from manga
                join autore on manga.autore_fk = autore.id
                join categoria on manga.categoria_fk = tipo
                where manga.id = ?";
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getMangaPerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getMangaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('i', $mangaid)) {
            error_log("[getMangaPerId] impossibile effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        $toRet  = self::caricaMangaDaStmt($stmt);
        $mysqli->close();
        return $toRet;    
    }
    private function &caricaMangaDaStmt(mysqli_stmt $stmt){
        if (!$stmt->execute()) {
            error_log("[caricaMangaDaStmt] impossibile eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['id'], $row['titolo'], $row['titolo_orig'],
                $row['n_volume'], $row['a_id'], $row['autore'],
                $row['casa_ed'], $row['anno_pub'], $row['lingua'],
                $row['tipo'], $row['genere'], $row['descrizione'], 
                $row['prezzo'], $row['n_articoli']);
        
        if (!$bind) {
            error_log("[caricaMangaDaStmt] impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();
        
        $toRet = self::creaMangaDaArray($row);  
        return $toRet;
    }
    
    private function creaMangaDaArray($row){
        $manga = new Manga();
        $manga->setId($row['id']);
        $manga->setTitolo($row['titolo']);
        $manga->setTitoloOriginale($row['titolo_orig']);
        $manga->setNumeroVolume($row['n_volume']);
        $manga->setAutore($row['a_id']);
        $manga->setCasaEditrice($row['casa_ed']);
        $manga->setAnnoPubblicazione($row['anno_pub']);
        $manga->setLingua($row['lingua']);
        $manga->setCategoria($row['tipo']);
        $manga->setGenere($row['genere']);
        $manga->setDescrizione($row['descrizione']);
        $manga->setPrezzo($row['prezzo']);
        $manga->setNumeroArticoli($row['n_articoli']);
        return $manga;
    }
    
    public function &getListaManga(){
        $mangas = array();
        $query = "select 
                manga.id id,
                manga.titolo titolo,
                manga.titolo_orig titolo_orig,
                manga.n_volume n_volume,
                autore.id a_id,
                autore.autore autore,
                manga.casa_ed casa_ed,
                manga.anno_pub anno_pub,
                manga.lingua lingua,
                categoria.tipo tipo,
                manga.genere genere,
                manga.descrizione descrizione,
                manga.prezzo prezzo,
                manga.n_articoli n_articoli
                
                from manga
                join autore on manga.autore_fk = autore.id
                join categoria on manga.categoria_fk = tipo";
        
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaManga] impossibile inizializzare il database");
            $mysqli->close();
            return $mangas;
            
        }
        
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
    }
    public function &getListaMangaPerAutore($autoreid){
        $mangas = array();
        $query = "select 
                manga.id id,
                manga.titolo titolo,
                manga.titolo_orig titolo_orig,
                manga.n_volume n_volume,
                autore.id a_id,
                autore.autore autore,
                manga.casa_ed casa_ed,
                manga.anno_pub anno_pub,
                manga.lingua lingua,
                categoria.tipo tipo,
                manga.genere genere,
                manga.descrizione descrizione,
                manga.prezzo prezzo,
                manga.n_articoli n_articoli
                
                from manga
                join autore on manga.autore_fk = autore.id
                join categoria on manga.categoria_fk = tipo
                where autore.id = ?";
                
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaMangaPerAutore] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[getListaMangaPerAutore] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->bind_param('i', $autoreid)) {
            error_log("[getListaMangaPerAutore] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        
        $mangas  = self::caricaMangasDaStmt($stmt);
        $mysqli->close();
        return $mangas; 
    }
    
    public function &caricaMangasDaStmt(mysqli_stmt $stmt) {
        $mangas = array();
        if (!$stmt->execute()) {
            error_log("[caricaMangasDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        
        
        $row = array();
        $bind = $stmt->bind_result(
                $row['id'], $row['titolo'], $row['titolo_orig'],
                $row['n_volume'], $row['a_id'], $row['autore'],
                $row['casa_ed'], $row['anno_pub'], $row['lingua'],
                $row['tipo'], $row['genere'], $row['descrizione'], 
                $row['prezzo'], $row['n_articoli']);
        if (!$bind) {
            error_log("[caricaMangasDaStmt] impossibile effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $mangas[] = self::creaMangaDaArray($row);
        }

        $stmt->close();

        return $mangas;
    }
    

}
?>
