<?php
    include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
    include_once basename(__DIR__) . '/../model/UtenteBase.php';
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
    const impersonato = '_imp';
    private $logged = 0;
    
    public function __construct() {
        
    }
    
    
    public function handle_input(&$request){
        $vista = new ViewDescriptor();


        // imposto la pagina
        $vista->setPagina($request['page']);
        
        // imposto il token per impersonare un utente (nel lo stia facendo)
        //$this->setImpToken($vista, $request);

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
                    /*
                    // questa variabile viene poi utilizzata dalla vista
                    if ($this->loggedIn())
                        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);*/
                    break;
                      
                case 'home':
                    $this->showHome($vista);
                break;    
                default : 
                    $this->showLoginPage();
                break;
            }
        } else if (isset($request["subpage"])) {
            switch ($request["subpage"]) {
                //$vista->setSottoPagina($sottopagina);
                /*case "login":
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                    $this->login($vista, $username, $password);
                    /*
                    // questa variabile viene poi utilizzata dalla vista
                    if ($this->loggedIn())
                        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                break;*/
                case 'home':
                    $vista->setSottoPagina('home');
                    if($this->loggedIn()){
                        $this->showHomeUtente($vista);
                    } else {$this->showHome($vista);}
                break;    
                case 'login': 
                    $vista->setSottoPagina('login');
                    $this->showLoginPage($vista);
                break;
                default : 
                    $vista->setSottoPagina('login');
                    $this->showLoginPage($vista);
                break;
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
    
    protected function showHomeUtente($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/homeUtente/content-user.php');
        $vista->setHeader(basename(__DIR__) . '/../view/homeUtente/header-user.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/homeUtente/leftbar-user.php');
    }
    
    protected function showHome($vista){
        $vista->setTitle("MangaMania - MM");
        $vista->setContent(basename(__DIR__) . '/../view/home/home-content.php');
        $vista->setHeader(basename(__DIR__) . '/../view/home/header-home.php');
        $vista->setLeftbar(basename(__DIR__) . '/../view/home/leftbar-home.php');
    }
    
    
    protected function login($vista, $user, $password){
        if (isset($user) && $user == "davide" && $password == "spano") {
            // utente autenticato
            //$_SESSION[self::user] = $user->getId();
            //$_SESSION[self::role] = $user->getRuolo();
            $this->logged = 1;
            $this->showHomeUtente($vista);
        } else {
            ///$vd->setMessaggioErrore("Utente sconosciuto o password errata");
            $this->showLoginPage($vista);
        }
    }
    protected function logout($vista){
        $this->logged = 0;
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
        if($this->logged == 1){
            return true;
        }
        return false;
    }
}
