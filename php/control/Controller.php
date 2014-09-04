<?php
    include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
    include_once basename(__DIR__) . '/../model/UtenteBase.php';
    include_once basename(__DIR__) . '/../model/Venditore.php';
    include_once basename(__DIR__) . '/../model/Acquirente.php';
    include_once basename(__DIR__) . '/../model/UtenteFactory.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Annalisa
 */
class Controller {
    const user = 'user';
    const role = 'role';
    
    public function __construct() {
        
    }
    
    
    public function handle_input(&$request){
        $vista = new ViewDescriptor();


        // imposto la pagina
        $vista->setPagina($request['page']);

        
        if(isset($request["subpage"])){
            switch ($request["subpage"]){
                
                case 'manga':
                    $mangaid = (int)($request['param']);
                    $manga = MangaFactory::instance()->getMangaPerId((int) $mangaid);
                    $vista->setSottoPagina('manga');
                break;
            
                case 'lista_per_autore':
                    $autori = AutoreFactory::instance()->getListaAutori();
                    $mangas = MangaFactory::instance()->getListaMangaPerAutore($request['param']);
                    $vista->setSottoPagina('lista_per_autore');
                    break;
                    
                
                default:
                    $autori = AutoreFactory::instance()->getListaAutori();
                    $mangas = MangaFactory::instance()->getListaManga();
                    $vista->setSottoPagina('lista');
                    break;
            }
        
        }
        // gestion dei comandi
        // tutte le variabili che vengono create senza essere utilizzate 
        // direttamente in questo switch, sono quelle che vengono poi lette
        // dalla vista, ed utilizzano le classi del modello

        if (isset($request["cmd"])) {
            // abbiamo ricevuto un comando
            switch ($request["cmd"]) {
                case 'login':
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                    $this->login($vista, $username, $password);
                    
                    // questa variabile viene poi utilizzata dalla vista
                    if ($this->loggedIn()){
                        $user = UtenteFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                    }
                    break;
                case 'logout':
                    $this->logout($vista);
                    break;
                default : 
                    $this->showLoginPage($vista);
                    break;
            }
        } else {
            if($this->loggedIn()){
                $user = UtenteFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                $this->showHomeUtente($vista);
            } else {
                    $this->showHome($vista);
            }
        }
        
        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
        
    }
    
    protected function showLoginPage($vista){
        $vista->setTitle("Login");
        $vista->setContent(basename(__DIR__) . '/../view/login/content-login.php');
        $vista->setHeader(basename(__DIR__) . '/../view/login/header-login.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/login/leftbar-login.php');
    }
    
    protected function showHomeAcquirente($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/acquirente/content.php');
        $vista->setHeader(basename(__DIR__) . '/../view/acquirente/header.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/acquirente/leftbar.php');
    }
    
    protected function showHomeVenditore($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/venditore/content-user.php');
        $vista->setHeader(basename(__DIR__) . '/../view/venditore/header-user.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/venditore/leftbar-user.php');
    }
    
    protected function showHomeUtente($vista){
        $user = UtenteFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
        
        switch ($user->getRuolo()) {
            case UtenteBase::Acquirente:
                $this->showHomeAcquirente($vista);
                break;

            case UtenteBase::Venditore:
                $this->showHomeVenditore($vista);
                break;

        }
    }
    
    protected function showHome($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/home/home-content.php');
        $vista->setHeader(basename(__DIR__) . '/../view/home/header-home.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/home/leftbar-home.php');
    }
    
    
    protected function login($vista, $username, $password){
        //carico i dati dell'utente dal database
        $user = UtenteFactory::instance()->caricaUtente($username, $password);
        if (isset($user) && $user->esiste()) {
            // utente autenticato
            $_SESSION[self::user] = $user->getId();
            $_SESSION[self::role] = $user->getRuolo();
            $this->showHomeUtente($vista);
        } else {
            $vista->setMessaggioErrore("Utente sconosciuto o password errata");
            $this->showLoginPage($vista);
        }
    }
    
    
    
    protected function logout($vista){
        // reset array $_SESSION
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            // imposto il termine di validita' al mese scorso
            setcookie(session_name(), '', time() - 2592000, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        $this->showLoginPage($vista);
        
    }
    /**
     * Verifica se l'utente sia correttamente autenticato
     * @return boolean true se l'utente era gia' autenticato, false altrimenti
     */
    protected function loggedIn() {
        return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
    }
    
        /**
     * Crea un messaggio di feedback per l'utente 
     * @param array $msg lista di messaggi di errore
     * @param ViewDescriptor $vd il descrittore della pagina
     * @param string $okMsg il messaggio da mostrare nel caso non ci siano errori
     */
    protected function creaFeedbackUtente(&$msg, $vista, $okMsg) {
        if (count($msg) > 0) {
            // ci sono messaggi di errore nell'array,
            // qualcosa e' andato storto...
            $error = "Si sono verificati i seguenti errori \n<ul>\n";
            foreach ($msg as $m) {
                $error = $error . $m . "\n";
            }
            // imposto il messaggio di errore
            $vista->setMessaggioErrore($error);
        } else {
            // non ci sono messaggi di errore, la procedura e' andata
            // quindi a buon fine, mostro un messaggio di conferma
            $vista->setMessaggioConferma($okMsg);
        }
    }
    
    
    /**
     * Aggiorno l'indirizzo di un utente (comune a Venditore e Acquirente)
     * @param UtenteBase $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali messaggi d'errore
     */
    protected function aggiornaImpostazioni($user, &$request, &$msg) {

        if (isset($request['nome'])) {
            if (!$user->setNome($request['nome'])) {
                $msg[] = '<li>Il nome specificato non &egrave; corretto</li>';
            }
        }
        if (isset($request['cognome'])) {
            if (!$user->setCognome($request['cognome'])) {
                $msg[] = '<li>Il cognome specificato non &egrave; corretto</li>';
            }
        }
        

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UtenteFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    
    /**
     * Aggiorno l'indirizzo di un utente (comune a Venditore e Acquirente)
     * @param UtenteBase $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali messaggi d'errore
     */
    protected function aggiornaEmail($user, &$request, &$msg) {

        if (isset($request['email'])) {
            if (!$user->setEmail($request['email'])) {
                $msg[] = '<li>La e-mail specificata non &egrave; corretta</li>';
            }
        }
        

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UtenteFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    /**
     * Aggiorno la password di un utente (comune a Studente e Docente)
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali
     * messaggi d'errore
     */
    protected function aggiornaPassword($user, &$request, &$msg) {
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$user->setPassword($request['pass1'])) {
                    $msg[] = '<li>Il formato della password non &egrave; corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
        
        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UtenteFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    
    /**
     * Aggiorno l'indirizzo di un utente (comune a Venditore e Acquirente)
     * @param UtenteBase $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali messaggi d'errore
     */
    protected function aggiornaIndirizzo($user, &$request, &$msg) {

        if (isset($request['via'])) {
            if (!$user->setVia($request['via'])) {
                $msg[] = '<li>La via specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['civico'])) {
            if (!$user->setNumeroCivico($request['civico'])) {
                $msg[] = '<li>Il formato del numero civico non &egrave; corretto</li>';
            }
        }
        if (isset($request['citta'])) {
            if (!$user->setCitta($request['citta'])) {
                $msg[] = '<li>La citt&agrave; specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['provincia'])) {
            if (!$user->setProvincia($request['provincia'])) {
                $msg[] = '<li>La provincia specificata &egrave; corretta</li>';
            }
        }
        if (isset($request['cap'])) {
            if (!$user->setCap($request['cap'])) {
                $msg[] = '<li>Il CAP specificato non &egrave; corretto</li>';
            }
        }

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UtenteFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
}
