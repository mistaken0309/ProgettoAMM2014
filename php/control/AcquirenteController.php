<?php

include_once 'Controller.php';
include_once basename(__DIR__) . '/../model/UtenteFactory.php';

/**
 * Description of AcquirenteController
 *
 * @author Annalisa
 */
class AcquirenteController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle_input(&$request) {
        $vista = new ViewDescriptor();
        
        $vista->setPagina($request['page']);
        
        if(!$this->loggedIn()){
            $this->showLoginPage($vista);
        } else {
            // utente autenticato
            $user = UtenteFactory::instance()->cercaUtentePerId(
                    $_SESSION[Controller::user], $_SESSION[Controller::role]);
            if(isset($request["subpage"])){
                switch ($request["subpage"]){
                    case 'anagrafica':
                        $vista->setSottoPagina('anagrafica');
                        break;
                    default:
                        $vista->setSottoPagina('home');
                        break;
                }
            }
            if(isset($request["cmd"])){
                switch ($request["cmd"]) {
                    case 'logout':
                        $this->logout($vista);
                        break;
                    default:
                        $this->showHomeUtente($vista);
                }
            } else{
                $user = UtenteFactory::instance()->cercaUtentePerId(
                        $_SESSION[Controller::user], $_SESSION[Controller::role]);
                $this->showHomeUtente($vista);
            }
        }
        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
}
