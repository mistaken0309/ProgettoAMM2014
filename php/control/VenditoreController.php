<?php

    include_once 'Controller.php';
    include_once basename(__DIR__) . '/../model/MangaFactory.php';
    include_once basename(__DIR__) . '/../model/AutoreFactory.php';
    include_once basename(__DIR__) . '/../model/UtenteFactory.php';
    include_once basename(__DIR__) . '/../model/AcquistiFactory.php';
    include_once basename(__DIR__) . '/../model/ProdottiFactory.php';
    include_once basename(__DIR__) . '/../model/CategoriaFactory.php';

/**
 * Description of VenditoreController
 *
 * @author Annalisa
 */
class VenditoreController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle_input(&$request) {
        $vista = new ViewDescriptor();
        
        $vista->setPagina($request['page']);
        
        if(!$this->loggedIn()){
            $vista->setSottoPagina('login');
            $this->showHome($vista);
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
                
                    case 'modifica':
                        $mangaid = $request['manga_id'];
                        $manga = MangaFactory::instance()->getMangaPerId($mangaid);
                        $autori = AutoreFactory::instance()->getListaAutori();
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vista->setSottoPagina('modifica');
                        break;
                    
                    case 'aggiungi-manga':
                        $autori = AutoreFactory::instance()->getListaAutori();
                        $categorie = CategoriaFactory::instance()->getListaCategorie();
                        $vista->setSottoPagina('aggiungi-manga');
                        break;

                
                    case 'lista':
                        $autori = AutoreFactory::instance()->getListaAutori();
                        $venditore_id = $user->getId();
                        $prodotti = ProdottiFactory::instance()->getListaProdottiPerVenditore($venditore_id);
                        $vista->setSottoPagina('lista');
                        break;
                    
                    case 'vendite':
                        $vendite = AcquistiFactory::instance()->getListaAcquistiVenditore($user);
                        $vista->setSottoPagina('vendite');
                        break;
                    case 'compra':
                        
                        $acquisto = new Acquisti();
                        $acquisto->setUtenteId($user);
                        $prodotto_id = ProdottiFactory::instance()->getProdottiPerMangaId($request['manga_id']);
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
                        $vista->setSottoPagina('login');
                        $this->logout($vista);
                        break;
                    
                                        
                    case 'modifica':
                        $msg = array();
                        $this->aggiornaManga($manga, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Informazioni sul manga aggiornate");
                        $this->showHomeUtente($vista);
                        break;
                    
                                        
                    case 'aggiungi':
                        $msg = array();
                        $manga = new Manga();
                        $venditoreid = $user->getId();
                        $this->creaManga($manga, $venditoreid, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Manga aggiunto");
                        $this->showHomeUtente($vista);
                        break;
                    
                    case 'impostazioni':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaImpostazioni($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Impostazioni aggiornate");
                        $this->showHomeUtente($vista);
                        break;
                    
                    case 'descrizione':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaDescrizione($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vista, "Descrizione aggiornata");
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
                                $vista->setPagina("venditore");
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
