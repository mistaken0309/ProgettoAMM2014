<?php


include_once 'Database.php';
include_once 'Prodotti.php';

/**
 * Description of ProdottiFactory
 *
 * @author Annalisa
 */
class ProdottiFactory {
    private static $singleton;
    
    private function __constructor(){
    
        
    }
    
    
    /**
     * Restiuisce un singleton per creare appelli
     * @return \ProdottiFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new ProdottiFactory();
        }
        
        return self::$singleton;
    }
    
    public function getProdottiPerId($prodottid){
        /*$query = "select 
                utente_manga.acquisto_id id,
                utente_manga.utente_fk u_id,
                utenti.username utente_username,
                utente_manga.prodotto prodotto_id,
                venditore_manga.venditore_fk v_id,
                venditore_manga.manga_fk manga_id,
                manga.titolo titolo,
                manga.n_volume n_volume,
                autore.autore autore,
                manga.prezzo prezzo,
                utente_manga.data data,
                utente_manga.quantita quantita
                
                from utente_manga
                join utenti on utente_manga.utente_fk = utenti.u_id
                join venditore_manga on utente_manga.prodotto = venditore_manga.id
                join venditori on venditore_manga.venditore_fk = venditori.v_id
                join manga on venditore_manga.manga_fk = manga.id
                join autore on manga.autore_fk = autore.id
                where utente_manga.acquisto_id = ?";*/
        $query = "select 
                venditore_manga.id id,
                venditore_manga.venditore_fk v_id,
                venditore_manga.manga_fk manga_id
                
                
                from venditore_manga
                join venditori on venditore_manga.venditore_fk = venditori.v_id
                join manga on venditore_manga.manga_fk = manga.id
                where venditore_manga.acquisto_id = ?";
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getProdottiPerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getProdottiPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('i', $acquistoid)) {
            error_log("[getProdottiPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        $toRet  = self::caricaProdottiDaStmt($stmt);
        $mysqli->close();
        return $toRet;    
    }
    
    public function getProdottiPerMangaId($mangaid){
        /*$query = "select 
                utente_manga.acquisto_id id,
                utente_manga.utente_fk u_id,
                utenti.username utente_username,
                utente_manga.prodotto prodotto_id,
                venditore_manga.venditore_fk v_id,
                venditore_manga.manga_fk manga_id,
                manga.titolo titolo,
                manga.n_volume n_volume,
                autore.autore autore,
                manga.prezzo prezzo,
                utente_manga.data data,
                utente_manga.quantita quantita
                
                from utente_manga
                join utenti on utente_manga.utente_fk = utenti.u_id
                join venditore_manga on utente_manga.prodotto = venditore_manga.id
                join venditori on venditore_manga.venditore_fk = venditori.v_id
                join manga on venditore_manga.manga_fk = manga.id
                join autore on manga.autore_fk = autore.id
                where utente_manga.acquisto_id = ?";*/
        $query = "select 
                venditore_manga.id id,
                venditore_manga.venditore_fk v_id,
                venditore_manga.manga_fk manga_id
                
                
                from venditore_manga
                join venditori on venditore_manga.venditore_fk = venditori.v_id
                join manga on venditore_manga.manga_fk = manga.id
                where manga.id = ?";
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getProdottiPerMangaId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getProdottiPerMangaId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('i', $mangaid)) {
            error_log("[getProdottiPerMangaId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        $toRet  = self::caricaProdottiDaStmt($stmt);
        $mysqli->close();
        return $toRet;    
    }
    
    private function caricaProdottiDaStmt(mysqli_stmt $stmt){
        if (!$stmt->execute()) {
            error_log("[caricaProdottiDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result($row['id'], $row['v_id'], $row['manga_id']);
        if (!$bind) {
            error_log("[caricaProdottiDaStmt] impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();
        
        $toRet = self::creaProdottiDaArray($row);  
        return $toRet;
    }
    
    private function creaProdottiDaArray($row){
        $prodotto = new Prodotti();
        $prodotto->setId($row['id']);
        $prodotto->setVenditore($row['v_id']); 
        $prodotto->setManga($row['manga_id']);

        return $prodotto;
    }
    
    public function &getListaProdotti(){
        $acquisti = array();
        $query = "select 
                utente_manga.acquisto_id id,
                utente_manga.utente_fk u_id,
                utente_manga.prodotto prodotto_id,
                venditore_manga.venditore_fk v_id,
                venditore_manga.manga_fk manga_id,
                utente_manga.data data,
                utente_manga.quantita quantita
                
                from utente_manga
                join utenti on utente_manga.utente_fk = utenti.u_id
                join venditore_manga on utente_manga.prodotto = venditore_manga.id
                join venditori on venditore_manga.venditore_fk = venditori.v_id
                join manga on venditore_manga.manga_fk = manga.id
                where utente_manga.acquisto_id = ?";
        
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaProdotti] impossibile inizializzare il database");
            $mysqli->close();
            return $acquisti;
            
        }
        
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaProdotti] impossibile eseguire la query");
            $mysqli->close();
            return $acquisti;
        }
        while ($row = $result->fetch_array()) {
            $acquisti[] = self::creaProdottiDaArray($row);
        }

        $mysqli->close();
        return $acquisti;  
    }

    public function &getListaProdottiPerAutore($autoreid){
        $acquisti = array();
        $query = $query = "select 
                utente_manga.acquisto_id id,
                utente_manga.utente_fk u_id,
                utente_manga.prodotto prodotto_id,
                venditore_manga.venditore_fk v_id,
                venditore_manga.manga_fk manga_id,
                utente_manga.data data,
                utente_manga.quantita quantita
                
                from utente_manga
                join utenti on utente_manga.utente_fk = utenti.u_id
                join venditore_manga on utente_manga.prodotto = venditore_manga.id
                join venditori on venditore_manga.venditore_fk = venditori.v_id
                join manga on venditore_manga.manga_fk = manga.id
                where utente_manga.acquisto_id = ?";
                
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[getListaProdottiPerAutore] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[getListaProdottiPerAutore] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->bind_param('i', $autoreid)) {
            error_log("[getListaProdottiPerAutore] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        
        $acquisti  = self::caricaProdottiDaStmt($stmt);
        $mysqli->close();
        return $acquisti; 
    }

}
