<?php

    include_once 'Controller.php';
    include_once basename(__DIR__) . '/../model/MangaFactory.php';
    include_once basename(__DIR__) . '/../model/AutoreFactory.php';
    include_once basename(__DIR__) . '/../model/UtenteFactory.php';
    include_once basename(__DIR__) . '/../model/AcquistiFactory.php';

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
                    
                    case 'manga':
                        $mangaid = (int)($request['param']);
                        $manga = MangaFactory::instance()->getMangaPerId((int) $mangaid);
                        $vista->setSottoPagina('manga');
                    break;
                
                    case 'lista':
                        $autori = AutoreFactory::instance()->getListaAutori();
                        $mangas = MangaFactory::instance()->getListaManga();
                        $vista->setSottoPagina('lista');
                        break;
                
                    case 'lista_per_autore':
                        $autori = AutoreFactory::instance()->getListaAutori();
                        $mangas = MangaFactory::instance()->getListaMangaPerAutore($request['param']);
                        $vista->setSottoPagina('lista_per_autore');
                        break;
                    case 'acquisti':
                        $utente = UtenteFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                        $acquisti = AcquistiFactory::instance()->getListaAcquistiAcquirente($utente);
                        $vista->setSottoPagina('acquisti');
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

                    // salvataggio permanente dell'acquisto
                    case 'r_salva_elenco':
                        if (isset($acquisto)) {
                            //if (count($_SESSION[self::elenco][$elenco_id]->getEsami()) > 0) {
                                if (!AcquistiFactory::instance()->salvaAcquisto($_SESSION[self::acquisto][$acquisto])) {
                                    $msg[] = '<li> Impossibile salvare l\'acquisto</li>';
                                } else {
                                    unset($_SESSION[self::elenco][$elenco_id]);
                                    $elenchi_attivi = $_SESSION[self::elenco];
                                    $vd->setPagina("reg_esami");
                                    $vd->setSottoPagina('reg_esami');
                                }
                            } else {
                                $msg[] = '<li> &Egrave; necessario inserire almeno un esame</li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Esami registrati correttamente");
                        //}
                        $this->showHomeUtente($vd);
                        break;
                    
                    
                    case 'e_cerca':
                        $msg = array();
                        $this->creaFeedbackUtente($msg, $vista, "Lo implementiamo con il db, fai conto che abbia funzionato ;)");
                        $this->showHomeUtente($vista);
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
