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
     * Restiuisce un singleton per creare Manga
     * @return \MangaFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new MangaFactory();
        }
        
        return self::$singleton;
    }
    
    /**
     * Restituisce un manga cercato in base all'id
     * @param type $mangaid
     * @return null se l'operazione non va a buon fine, il manga cercato altrimenti
     */
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
    
    /**
     * Restituisce un array contenente tutti i manga presenti nel sistema
     * @return array
     */
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
                join categoria on manga.categoria_fk = tipo
                order by manga.titolo, manga.n_volume";
        
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
    
    /**
     * Restituisce un array contenente tutti i manga scritti da un determinato autore
     * @param $autoreid id dell'autore
     * @return null se l'operazione non va a buon fine
     * un array di Manga altrimenti
     */
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
    
    
    /**
     * Salva i dati relativi ad un manga sul db
     * @param Manga $manga
     * @return il numero di righe modificate
     */
    public function salvaManga(Manga $manga) {
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaManga] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        
        $query = " update manga set 
                    titolo = ?,
                    titolo_orig = ?,
                    n_volume = ?,
                    autore_fk = ?,
                    casa_ed = ?,
                    anno_pub =?,
                    lingua = ?,
                    categoria_fk = ?,
                    genere = ?,
                    descrizione = ?,
                    prezzo = ?,
                    n_articoli = ?
                    
                    where manga.id = ?";
       
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaManga] impossibile inizializzare il prepared statement");
            return 0;
        }
        
        if (!$stmt->bind_param('ssiisisssssii', 
                $manga->getTitolo(), $manga->getTitoloOriginale(), $manga->getNumeroVolume(),
                $manga->getAutore(), $manga->getCasaEditrice(), $manga->getAnnoPubblicazione(),
                $manga->getLingua(), $manga->getCategoria(), $manga->getGenere(), 
                $manga->getDescrizione(), $manga->getPrezzo(), $manga->getNumeroArticoli(), 
                $manga->getId())) {
            error_log("[salvaManga] impossibile effettuare il binding in input");
            return 0;
        }
        
        if (!$stmt->execute()) {
            error_log("[salvaManga] impossibile eseguire lo statement");
            return 0;
        }

 
        $count = $stmt->affected_rows;
        $stmt->close();
        $mysqli->close();
        return $count;
    }
        
   
    /**
     * Crea un nuovo manga salvando i relativi dati sul db
     * @param Manga $manga
     * @return il numero di righe modificate
     */
    public function creaManga(Manga $manga, $venditore_id) {
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaManga] impossibile inizializzare il database");
            $mysqli->close();
            return false;
        }

        $stmt = $mysqli->stmt_init();
        $stmt2 = $mysqli->stmt_init();
        
        $create_manga = " insert into manga 
                    (id, titolo, titolo_orig, n_volume, autore_fk,
                    casa_ed, anno_pub, lingua, categoria_fk, 
                    genere, descrizione, prezzo, n_articoli) 
                    values
                    (default, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       
        $create_prodotto = "insert into venditore_manga (id, venditore_fk, manga_fk)
                values (default, ?, ?)";
        
        
        $stmt->prepare($create_manga);
        if (!$stmt) {
            error_log("[creaManga] impossibile inizializzare il prepared statement");
            return false;
        }
        $stmt2->prepare($create_prodotto);
        if (!$stmt2) {
            error_log("[creaManga] impossibile inizializzare il prepared statement");
            return false;
        }
        
        if (!$stmt->bind_param('ssiisisssssi', 
                $manga->getTitolo(), $manga->getTitoloOriginale(),
                $manga->getNumeroVolume(), $manga->getAutore(),
                $manga->getCasaEditrice(), $manga->getAnnoPubblicazione(),
                $manga->getLingua(), $manga->getCategoria(),
                $manga->getGenere(), $manga->getDescrizione(),
                $manga->getPrezzo(), $manga->getNumeroArticoli() )) {
            error_log("[creaManga] impossibile effettuare il binding in input");
            return false;
        }
        
        
        $mysqli->autocommit(false);
        if (!$stmt->execute()) {
            error_log("[creaManga] impossibile eseguire lo statement #1");
            $mysqli->rollback();
            $mysqli->close();
            return false;
        }
        $new_product_id = $stmt->insert_id;
        if (!$stmt2->bind_param('ii', $venditore_id, $new_product_id)) {
            error_log("[creaManga] impossibile effettuare il binding in input");
            $mysqli->rollback();
            $mysqli->close();
            return false;
        }
        
        if (!$stmt2->execute()) {
            error_log("[creaManga] impossibile eseguire lo statement #2");
            $mysqli->rollback();
            $mysqli->close();
            return false;
        }

        $mysqli->commit();
        $mysqli->autocommit(true);
        $mysqli->close();
        return true;
    }
    /**
     * Elimina i dati relativi ad un manga dal db
     * @param int $manga
     * @return il numero di righe modificate
     */
    public function eliminaManga( $manga) {
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaManga] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        
        $query = " DELETE FROM manga WHERE manga.id = ?";
        
       
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaManga] impossibile inizializzare il prepared statement");
            return 0;
        }
        
        if (!$stmt->bind_param('i', $manga)) {
            error_log("[salvaManga] impossibile effettuare il binding in input");
            return 0;
        }
        
        if (!$stmt->execute()) {
            error_log("[salvaManga] impossibile eseguire lo statement");
            return 0;
        }
/*
 * "Cannot delete or update a parent row: a foreign key constraint fails (`amm14_congiuannalisa`.`venditore_manga`, 
 * CONSTRAINT `venditore_manga_ibfk_2` FOREIGN KEY (`manga_fk`) REFERENCES `manga` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE)"
 */
 
        $count = $stmt->affected_rows;
        $stmt->close();
        $mysqli->close();
        return $count;
    }
    
    
    /**
     * 
     * @param Docente $user
     * @param type $insegnamento
     * @param type $matricola
     * @param type $nome
     * @param type $cognome
     * @return array
     */
    public function &filtraManga(/*Docente $user, $insegnamento, $matricola, $nome, $cognome*/
            $autore) {
        $mangas = array();
        
        // costruisco la where "a pezzi" a seconda di quante 
        // variabili sono definite
        $where=" ";
        $par = array();
        //$par[] = $user->getId();
        /*
        if(isset($insegnamento)){
            $where .= " and insegnamenti.id = ? ";
            $bind .="i";
            $par[] = $insegnamento;
        }
        
        if(isset($matricola)){
            $where .= " and studenti.matricola = ? ";
            $bind .="s";
            $par[] = $matricola;
        }
        
        if(isset($nome)){
            $where .= " and lower(studenti.nome) like lower(?) ";
            $bind .="s";
            $par[] = "%".$nome."%";
        }
        
        if(isset($cognome)){
            $where .= " and lower(studenti.cognome) like lower(?) ";
            $bind .="s";
            $par[] = "%".$cognome."%";
        }
         *
         */
        if(isset($autore)){
            $bind = "i";
            $where = " where manga.autore_fk = ? ";
            $par[] = $autore;
        }
         
        
        
        
        
        
        
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
                  ".$where;
        
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[filtraManga] impossibile inizializzare il database");
            $mysqli->close();
            return $mangas;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[filtraManga] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $mangas;
        }

        switch (count($par)) {
            case 1:
                if (!$stmt->bind_param($bind, $par[0])) {
                    error_log("[filtraManga] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $mangas;
                }
                break;
            case 2:
                if (!$stmt->bind_param($bind, $par[0], $par[1])) {
                    error_log("[filtraManga] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $mangas;
                }
                break;

            case 3:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2])) {
                    error_log("[filtraManga] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $mangas;
                }
                break;

            case 4:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2], $par[3])) {
                    error_log("[filtraManga] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $mangas;
                }
                break;

            case 5:
                if (!$stmt->bind_param($bind, $par[0], $par[1], $par[2], $par[3], $par[4])) {
                    error_log("[filtraManga] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return $mangas;
                }
                break;

           
        }

        $mangas = self::caricaMangasDaStmt($stmt);
        $mysqli->close();
        return $mangas;
    }

}
?>
