<?php
    include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
    include_once basename(__DIR__) . '/../model/UtenteBase.php';
    include_once basename(__DIR__) . '/../model/Venditore.php';
    include_once basename(__DIR__) . '/../model/Acquirente.php';
    include_once basename(__DIR__) . '/../model/UtenteFactory.php';
    include_once basename(__DIR__) . '/../model/ProdottiFactory.php';
    include_once basename(__DIR__) . '/../model/AutoreFactory.php';

/**
 * Controller che gestisce gli utenti non autenticati, 
 * fornendo le funzionalita' comuni anche agli altri controller
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
                case 'login':
                    $vista->setSottoPagina('login');
                    break;
            
                case 'lista_per_autore':
                    $autore = AutoreFactory::instance()->getAutorePerId($request['param'])->getAutore();
                    $mangas = MangaFactory::instance()->getListaMangaPerAutore($request['param']);
                    $vista->setSottoPagina('lista_per_autore');
                    break;
                    
                
                default:
                    $autori = AutoreFactory::instance()->getListaAutori();
                    $mangas = MangaFactory::instance()->getListaManga();
                    $vista->setSottoPagina('home');
                    break;
            }
        
        }
        // gestione dei comandi
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
                    $vista->setSottoPagina('login');
                    $this->logout($vista);
                    break;
                default : 
                    $this->showHome($vista);
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
    
    protected function showHomeAcquirente($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/acquirente/content.php');
        $vista->setHeader(basename(__DIR__) . '/../view/acquirente/header.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/acquirente/leftbar.php');
    }
    
    protected function showHomeVenditore($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/venditore/content.php');
        $vista->setHeader(basename(__DIR__) . '/../view/venditore/header.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/venditore/leftbar.php');
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
    //imposta la pagina per gli utenti non autenticati
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
            $this->showHome($vista);
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
        $this->showHome($vista);
        
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
     * Crea un nuovo manga
     * @param Manga $manga oggetto Manga
     * @param int $venditore_id id del venditore che sta inserendo il nuovo manga
     * @param array $request
     * @param array $msg
     */
    protected function creaManga($manga, $venditore_id, &$request, &$msg) {
            
        if (isset($request['titolo'])){
            if(!$manga->setTitolo($request['titolo'])){
                $msg[] = '<li>Il titolo specificato non &egrave; corretto</li>';
            }
        
        }
        
        if (isset($request['titolo_originale'])){
            if(!$manga->setTitoloOriginale($request['titolo_originale'])){
                $msg[] = '<li>Il titolo specificato non &egrave; corretto</li>';
                }
        }
        
        if (isset($request['n_volume'])){
            if(!$manga->setNumeroVolume($request['n_volume'])){
                $msg[] = '<li>Il numero del volume specificato non &egrave; corretto</li>';
            }
                
        }
        
        if (isset($request['autore']) && $request['autore']){
            if(!$manga->setAutore($request['autore'])){
                $msg[] = '<li>L\'autore specificato non &egrave; corretto</li>';   
            }    
        } 
        if(isset($request['nuovo_autore']) && $request['nuovo_autore']){
            $autore_id = AutoreFactory::instance()->creaNuovoAutore($request['nuovo_autore']);
            if(!$autore_id){
                $msg[] = '<li>Ci sono stati dei problemi con il salvataggio del nuovo autore</li>';
            } else if(!$manga->setAutore($autore_id)){
                $msg[] = '<li>Il nuovo autore non &egrave; corretto</li>';   
            } 
        }
        
        if (isset($request['casa_ed'])){
            if(!$manga->setCasaEditrice($request['casa_ed'])){
                $msg[] = '<li>La case editrice specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['pubblicazione'])){
            if(!$manga->setAnnoPubblicazione($request['pubblicazione'])){
                $msg[] = '<li>L\'anno di pubblicazione specificato non &egrave; corretto</li>'; 
            }
        }
        if (isset($request['lingua'])){
            if(!$manga->setLingua($request['lingua'])){
                $msg[] = '<li>La lingua specificata non &egrave; corretta</li>';   
            }   
        }
        if (isset($request['categoria'])){
            if(!$manga->setCategoria($request['categoria'])){
                $msg[] = '<li>La categoria specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['genere'])){
            if(!$manga->setGenere($request['genere'])){
                $msg[] = '<li>Il genere specificato non &egrave; corretto</li>';
            }
        }
        if (isset($request['descrizione'])){
            if(!$manga->setDescrizione($request['descrizione'])){
                $msg[] = '<li>La descrizione specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['prezzo'])){
            if(!$manga->setPrezzo($request['prezzo'])){
                $msg[] = '<li>Il prezzo specificato non &egrave; corretto</li>';
            }
        }
        if (isset($request['n_articoli'])){
            if(!$manga->setNumeroArticoli($request['n_articoli'])){
                $msg[] = '<li>Il numero di articoli specificato non &egrave; corretto</li>';
            }
        }
        

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (MangaFactory::instance()->creaManga($manga, $venditore_id) != true) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    /**
     * Aggiorno un manga già esistente
     * @param Manga $manga il manga da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali messaggi d'errore
     */
    protected function aggiornaManga($manga, &$request, &$msg) {
            
        if (isset($request['titolo'])){
            if(!$manga->setTitolo($request['titolo'])){
                $msg[] = '<li>Il titolo specificato non &egrave; corretto</li>';
            }
        
        }
        
        if (isset($request['titolo_originale'])){
            if(!$manga->setTitoloOriginale($request['titolo_originale'])){
                $msg[] = '<li>Il titolo specificato non &egrave; corretto</li>';
                }
        }
        
        if (isset($request['n_volume'])){
            if(!$manga->setNumeroVolume($request['n_volume'])){
                $msg[] = '<li>Il numero del volume specificato non &egrave; corretto</li>';
            }
                
        }
        
        if (isset($request['autore'])){            
            if(!$manga->setAutore($request['autore'])){
                $msg[] = '<li>L\'autore specificato non &egrave; corretto</li>';   
            }    
        }
        
        if (isset($request['casa_ed'])){
            if(!$manga->setCasaEditrice($request['casa_ed'])){
                $msg[] = '<li>La case editrice specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['pubblicazione'])){
            if(!$manga->setAnnoPubblicazione($request['pubblicazione'])){
                $msg[] = '<li>L\'anno di pubblicazione specificato non &egrave; corretto</li>'; 
            }
        }
        if (isset($request['lingua'])){
            if(!$manga->setLingua($request['lingua'])){
                $msg[] = '<li>La lingua specificata non &egrave; corretta</li>';   
            }   
        }
        if (isset($request['categoria'])){
            if(!$manga->setCategoria($request['categoria'])){
                $msg[] = '<li>La categoria specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['genere'])){
            if(!$manga->setGenere($request['genere'])){
                $msg[] = '<li>Il genere specificato non &egrave; corretto</li>';
            }
        }
        if (isset($request['descrizione'])){
            if(!$manga->setDescrizione($request['descrizione'])){
                $msg[] = '<li>La descrizione specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['prezzo'])){
            if(!$manga->setPrezzo($request['prezzo'])){
                $msg[] = '<li>Il prezzo specificato non &egrave; corretto</li>';
            }
        }
        if (isset($request['n_articoli'])){
            if(!$manga->setNumeroArticoli($request['n_articoli'])){
                $msg[] = '<li>Il numero di articoli specificato non &egrave; corretto</li>';
            }
        }
        

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (MangaFactory::instance()->salvaManga($manga) != 1) {
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
     * Aggiorno la descrizione di un acquirente 
     * @param Venditore $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali messaggi d'errore
     */
    protected function aggiornaDescrizione($user, &$request, &$msg) {

        if (isset($request['descrizione'])) {
            if (!$user->setDescrizione($request['descrizione'])) {
                $msg[] = '<li>La descrizione specificata non &egrave; corretta</li>';
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
     * Aggiorno la email di un utente (comune a Venditore e Acquirente)
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
     * Aggiorno la password di un utente (comune a Venditore e Acquirente)
     * @param UtenteBase $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali messaggi d'errore
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
