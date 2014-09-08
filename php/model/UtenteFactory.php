<?php

include_once 'UtenteBase.php';
include_once 'Acquirente.php';
include_once 'Venditore.php';
include_once 'Database.php';

/**
 * Classe per la creazione degli utenti del sistema
 *
 * @author Annalisa Congiu
 */
class UtenteFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare utenti
     * @return \UtenteFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UtenteFactory();
        }

        return self::$singleton;
    }

    /**
     * Carica un utente tramite username e password
     * @param string $username
     * @param string $password
     * @return \UtenteBase|\Venditore|\Acquirente
     */
    
    public function caricaUtente($username, $password) {


        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[loadUtente] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        // cerco prima nella tabella degli acquirenti
        $query = "select
            utenti.u_id u_id,
            utenti.username username,
            utenti.password password,
            utenti.email email,
            utenti.nome nome,
            utenti.cognome cognome,
            utenti.via via,
            utenti.civico civico,
            utenti.citta citta,
            utenti.provincia provincia,
            utenti.cap cap

            from utenti
            where utenti.username = ? and utenti.password = ?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUtente] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUtente] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $acquirente = self::caricaAcquirenteDaStmt($stmt);
        if (isset($acquirente)) {
            // ho trovato uno acquirente
            $mysqli->close();
            return $acquirente;
        }

        // ora cerco un venditore
        $query = "select 
            venditori.v_id v_id,
            venditori.azienda azienda,
            venditori.password password,
            venditori.nome_tit nome,
            venditori.cognome_tit cognome,
            venditori.email email,
            venditori.via via,
            venditori.civico civico,
            venditori.citta citta,
            venditori.provincia provincia,
            venditori.cap cap,
            venditori.descrizione descrizione

            from venditori 
            where venditori.azienda = ? and venditori.password = ?";

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUtente] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUtente] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $venditore = self::caricaVenditoreDaStmt($stmt);
        if (isset($venditore)) {
            // ho trovato un venditore
            $mysqli->close();
            return $venditore;
        }
    }

    /**
     * Restituisce un array con i Venditori presenti nel sistema
     * @return array
     */
    public function &getListaVenditori() {
        $venditori = array(); 
        $query = "select * from venditori";

        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaVenditori] impossibile inizializzare il database");
            $mysqli->close();
            return $venditori;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaVenditori] impossibile eseguire la query");
            $mysqli->close();
            return $venditori;
        }

        while ($row = $result->fetch_array()) {
            $venditori[] = self::creaVenditoreDaArray($row);
        }

        $mysqli->close();
        return $venditori;
    }

    /**
     * Restituisce la lista dei acquirenti presenti nel sistema
     * @return array
     */
    public function &getListaCompratori() {
        $acquirenti = array();
        $query = "select * from utenti";
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaAcquirenti] impossibile inizializzare il database");
            $mysqli->close();
            return $acquirenti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaAcquirenti] impossibile eseguire la query");
            $mysqli->close();
            return $acquirenti;
        }

        while ($row = $result->fetch_array()) {
            $acquirenti[] = self::creaAcquirenteDaArray($row);
        }

        return $acquirenti;
    }


    /**
     * Cerca uno acquirente per id
     * @param int $id
     * @return Acquirente un oggetto Acquirente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function cercaUtentePerId($id, $role) {
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        switch ($role) {
            case UtenteBase::Acquirente:
                $query = "select
                    utenti.u_id u_id,
                    utenti.username username,
                    utenti.password password,
                    utenti.email email,
                    utenti.nome nome,
                    utenti.cognome cognome,
                    utenti.via via,
                    utenti.civico civico,
                    utenti.citta citta,
                    utenti.provincia provincia,
                    utenti.cap cap

                    from utenti
                    where utenti.u_id = ?";
                    
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }
                
                $toRet = self::caricaAcquirenteDaStmt($stmt);
                return $toRet;
                
                break;

            case UtenteBase::Venditore:
                $query = "select 
                    venditori.v_id v_id,
                    venditori.azienda azienda,
                    venditori.password password,
                    venditori.nome_tit nome,
                    venditori.cognome_tit cognome,
                    venditori.email email,
                    venditori.via via,
                    venditori.civico civico,
                    venditori.citta citta,
                    venditori.provincia provincia,
                    venditori.cap cap,
                    venditori.descrizione descrizione

                    from venditori 
                    where venditori.v_id = ?";

                

                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[loadUtente] impossibile effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet =  self::caricaVenditoreDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;

            default: return null;
        }
    }

    /**
     * Crea uno acquirente da una riga del db
     * @param type $row
     * @return \Acquirente
     */
    public function creaAcquirenteDaArray($row) {
        $acquirente = new Acquirente();
        $acquirente->setId($row['u_id']);
        $acquirente->setUsername($row['username']);
        $acquirente->setPassword($row['password']);
        $acquirente->setEmail($row['email']);
        $acquirente->setNome($row['nome']);
        $acquirente->setCognome($row['cognome']);
        $acquirente->setVia($row['via']);
        $acquirente->setNumeroCivico($row['civico']);
        $acquirente->setCitta($row['citta']);
        $acquirente->setProvincia($row['provincia']);
        $acquirente->setCap($row['cap']);
        $acquirente->setRuolo(UtenteBase::Acquirente);

        return $acquirente;
    }

    /**
     * Crea un venditore da una riga del db
     * @param type $row
     * @return \Venditore
     */
    public function creaVenditoreDaArray($row) {
        $venditore = new Venditore();
        $venditore->setId($row['v_id']);
        $venditore->setUsername($row['azienda']);
        $venditore->setPassword($row['password']);
        $venditore->setNome($row['nome']);
        $venditore->setCognome($row['cognome']);
        $venditore->setEmail($row['email']);
        $venditore->setVia($row['via']);
        $venditore->setNumeroCivico($row['civico']);
        $venditore->setCitta($row['citta']);
        $venditore->setProvincia($row['provincia']);
        $venditore->setCap($row['cap']);
        $venditore->setDescrizione($row['descrizione']);
        $venditore->setRuolo(UtenteBase::Venditore);
        
        return $venditore;
    }

    /**
     * Salva i dati relativi ad un utente sul db
     * @param UtenteBase $utente
     * @return il numero di righe modificate
     */
    public function salva(UtenteBase $utente) {
        $mysqli = Database::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($utente->getRuolo()) {
            case UtenteBase::Acquirente:
                $count = $this->salvaAcquirente($utente, $stmt);
                break;
            case UtenteBase::Venditore:
                $count = $this->salvaVenditore($utente, $stmt);
        }

        $stmt->close();
        $mysqli->close();
        return $count;
    }

    /**
     * Rende persistenti le modifiche all'anagrafica di uno acquirente sul db
     * @param Acquirente $b lo acquirente considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaAcquirente(Acquirente $b, mysqli_stmt $stmt) {
        $query = " update utenti set 
                    password = ?,
                    email = ?,
                    nome = ?,
                    cognome = ?,
                    via = ?,
                    civico = ?,
                    citta = ?,
                    provincia = ?,
                    cap = ?
                    
                    where utenti.u_id = ?";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaAcquirente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        
        if (!$stmt->bind_param('sssssisssi', 
                $b->getPassword(), $b->getEmail(), $b->getNome(), $b->getCognome(), 
                $b->getVia(), $b->getNumeroCivico(), $b->getCitta(), $b->getProvincia(), 
                 $b->getCap(), $b->getId()
                )) {
            error_log("[salvaAcquirente] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }
        
        if (!$stmt->execute()) {
            error_log("[caricaIscritti] impossibile" .
                    " eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }
    
    /**
     * Rende persistenti le modifiche all'anagrafica di un venditore sul db
     * @param Venditore $s il venditore considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaVenditore(Venditore $s, mysqli_stmt $stmt) {
        $query = " update venditori set 
                    password = ?,
                    nome_tit = ?,
                    cognome_tit = ?,
                    email = ?,
                    via = ?,
                    civico = ?,
                    citta = ?,
                    provincia = ?,
                    cap = ?,
                    descrizione = ?
                    where venditori.v_id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaAcquirente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        
        if (!$stmt->bind_param('sssssissisi', 
                $s->getPassword(), $s->getNome(), $s->getCognome(), $s->getEmail(), 
                $s->getVia(), $s->getNumeroCivico(), $s->getCitta(), $s->getProvincia(),
                $s->getCap(),  $s->getDescrizione(), $s->getId())) {
            error_log("[salvaAcquirente] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[caricaIscritti] impossibile" .
                    " eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    /**
     * Carica un venditore eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaVenditoreDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaVenditoreDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['v_id'],
                $row['azienda'],
                $row['password'],
                $row['nome'], 
                $row['cognome'], 
                $row['email'], 
                $row['via'],
                $row['civico'],
                $row['citta'],
                $row['provincia'],
                $row['cap'],
                $row['descrizione']);
        if (!$bind) {
            error_log("[caricaVenditoreDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        $toRet = self::creaVenditoreDaArray($row);
        return $toRet;
    }

    /**
     * Carica uno acquirente eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaAcquirenteDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaAcquirenteDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['u_id'], 
                $row['username'], 
                $row['password'],
                $row['email'],
                $row['nome'], 
                $row['cognome'], 
                $row['via'], 
                $row['civico'], 
                $row['citta'], 
                $row['provincia'],
                $row['cap']);
        if (!$bind) {
            error_log("[caricaAcquirenteDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        $toRet = self::creaAcquirenteDaArray($row);
        return $toRet;
    }

}

