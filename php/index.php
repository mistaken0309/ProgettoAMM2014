<?php
    include_once 'control/Controller.php';
    //$content = "view/home-content.php";
    //include 'view/master.php';
    include_once 'control/AcquirenteController.php';
    FrontController::dispatch($_REQUEST);
    
class FrontController{
    
    public static function dispatch($request){
        
        session_start();
        if(isset($request["page"])){
            switch($request["page"]){
                
                case "login":
                    $controller = new Controller();
                    $controller->handle_input($request);
                break;
                case "home":
                    $controller = new Controller();
                    $controller->handle_input($request);
                break;
                
                case 'acquirente':
                    $controller = new AcquirenteController();
                    $controller->handle_input($request);
                break;
                /*case 'venditore':
                    $controller = new VenditoreController();
                    $controller->handle_input($request);
                    break;
                 */
                default:
                    self::write404();
                    break;

            }   
        }
    }

    /**
     * Crea una pagina di errore quando il path specificato non esiste
     */
    public static function write404() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('error.php');
        exit();
    }

    /**
     * Crea una pagina di errore quando l'utente non ha i privilegi 
     * per accedere alla pagina
     */
    public static function write403() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('error.php');
        exit();
    }
}    
?>
