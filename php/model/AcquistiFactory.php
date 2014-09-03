<?php


include_once 'Database.php';
include_once 'Acquisti.php';

/**
 * Description of AcquistiFactory
 *
 * @author Annalisa
 */
class AcquistiFactory {
    private static $singleton;
    
    private function __constructor(){
    
        
    }
    
    
    /**
     * Restiuisce un singleton per creare appelli
     * @return \AcquistiFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new AcquistiFactory();
        }
        
        return self::$singleton;
    }
    
    public function getAcquistiPerId($acquistoid){
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
            error_log("[getAcquistiPerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getAcquistiPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('i', $acquistoid)) {
            error_log("[getAcquistiPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        $toRet  = self::caricaAcquistoDaStmt($stmt);
        $mysqli->close();
        return $toRet;    
    }
    
    
    public function &caricaAcquistiDaStmt(mysqli_stmt $stmt) {
        $acquisti = array();
        if (!$stmt->execute()) {
            error_log("[caricaAcquistiDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        
        
        $row = array();
        $bind = $stmt->bind_result(
                $row['id'], $row['u_id'],
                $row['prodotto_id'], $row['v_id'], $row['manga_id'],
                $row['data'] , $row['quantita']);
        if (!$bind) {
            error_log("[caricaAcquistiDaStmt] impossibile effettuare il binding in output");
            return null;
        }

        while ($stmt->fetch()) {
            $acquisti[] = self::creaAcquistiDaArray($row);
        }

        $stmt->close();

        return $acquisti;
    }
    
    private function caricaAcquistoDaStmt(mysqli_stmt $stmt){
        if (!$stmt->execute()) {
            error_log("[caricaAcquistiDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['id'], $row['u_id'],
                $row['prodotto_id'], $row['v_id'], $row['manga_id'],
                $row['data'] , $row['quantita']);
        if (!$bind) {
            error_log("[caricaAcquistiDaStmt] impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();
        
        $toRet = self::creaAcquistiDaArray($row);  
        return $toRet;
    }
    
    private function creaAcquistiDaArray($row){
        $acquisto = new Acquisti();
        $acquisto->setId($row['id']);
        $acquisto->setUtenteId($row['u_id']);
        $acquisto->setProdottoId($row['prodotto_id']);
        $acquisto->setVenditoreId($row['v_id']); 
        $acquisto->setMangaId($row['manga_id']);
        $acquisto->setData($row['data'] );
        $acquisto->setQuantita($row['quantita']);

        return $acquisto;
    }
    
    public function &getListaAcquistiAcquirente($user){
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
                where utenti.u_id = ?";
        
        $mysqli = Database::getInstance()->connectDb();
        if(!isset($mysqli)){
            error_log("[ListaAcquisti] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[ListaAcquisti] impossibile inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('i', $user)) {
            error_log("[ListaAcquisti] impossibile effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $acquisti = self::caricaAcquistiDaStmt($stmt);
        
            $mysqli->close();
            return $acquisti;
    }
    
    public function &getListaAcquistiPerAutore($autoreid){
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
            error_log("[getListaAcquistiPerAutore] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[getListaAcquistiPerAutore] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->bind_param('i', $autoreid)) {
            error_log("[getListaAcquistiPerAutore] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }   
        
        $acquisti  = self::caricaAcquistiDaStmt($stmt);
        $mysqli->close();
        return $acquisti; 
    }

}
