<?php
    include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
    include_once basename(__DIR__) . '/../model/UtenteBase.php';
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
                    if ($this->loggedIn())
                        $user = UtenteFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
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
            ///$vista->setMessaggioErrore("Utente sconosciuto o password errata");
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
}
