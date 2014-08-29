<?php

include_once 'Controller.php';

/**
 * Description of AcquirenteController
 *
 * @author Annalisa
 */
class AcquirenteController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handleInput(&$request) {
        $vista = new ViewDescriptor();
        
        $vista->setPagina($request['page']);
        
        if(!$this->loggedIn()){
            $this->showLoginPage($vista);
        } else {
                       // utente autenticato
            /*$user = UserFactory::instance()->cercaUtentePerId(
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);*/
            if(isset($request["subpage"])){
                switch ($request["subpage"]){
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
                                //$user = UserFactory::instance()->cercaUtentePerId(
                        //$_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vista);
            }
        }
        
    }
}
