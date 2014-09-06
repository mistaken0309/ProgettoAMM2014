<?php

    include_once 'Controller.php';
    include_once basename(__DIR__) . '/../model/MangaFactory.php';
    include_once basename(__DIR__) . '/../model/AutoreFactory.php';
    include_once basename(__DIR__) . '/../model/UtenteFactory.php';
    include_once basename(__DIR__) . '/../model/AcquistiFactory.php';
    include_once basename(__DIR__) . '/../model/ProdottiFactory.php';

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
                        $autore = $request['param'];
                        $mangas = MangaFactory::instance()->getListaMangaPerAutore($autore);
                        $vista->setSottoPagina('lista_per_autore');
                        break;
                    case 'acquisti':
                        $acquisti = AcquistiFactory::instance()->getListaAcquistiAcquirente($user);
                        $vista->setSottoPagina('acquisti');
                        break;
                    
                    case 'compra':
                        $acquisto = new Acquisti();
                        $acquisto->setUtenteId($user->getId());
                        $prodotto_id = ProdottiFactory::instance()->getProdottiPerMangaId($request['manga_id'])->getId();
                        $acquisto->setProdottoId($prodotto_id);
                        $acquisto->setQuantita($request['quantita']);
                        $acquisto->setMangaId($request['manga_id']);
                        
                        $vista->setSottoPagina('compra');
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
                    
                        
                    case 'impostazioni':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaImpostazioni($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Impostazioni aggiornate");
                        $this->showHomeUtente($vista);
                        break;
                    
                    case 'email':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Impostazioni aggiornate");
                        $this->showHomeUtente($vista);
                        break;
                    
                    
                    case 'password':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Password aggiornata");
                        $this->showHomeUtente($vista);
                        break;
                    
                    case 'indirizzo':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Indirizzo aggiornato");
                        $this->showHomeUtente($vista);
                        break;
                    
                    // salvataggio permanente dell'acquisto
                    case 'fai_acquisto':
                        if (isset($acquisto)) {                            
                            if (!AcquistiFactory::instance()->salvaAcquisto($acquisto)) {
                                $msg[] = '<li> Impossibile salvare l\'acquisto</li>';
                            } else {
                                $vista->setPagina("acquirente");
                                $vista->setSottoPagina('compra');
                            }
                            $this->creaFeedbackUtente($msg, $vista, "Acquisto andato a buon fine");
                        }
                        $this->showHomeUtente($vista);
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
