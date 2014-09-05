<?php

/**
 * Description of Venditore
 *
 * classe che rappresenta un venditore
 * @author Annalisa Congiu
 */
class Venditore extends UtenteBase{
    /*
     * 
     */
    private $descrizione;
    
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(UtenteBase::Venditore);      
    }
    
    public function setDescrizione($descrizione){
        $this->descrizione = $descrizione;
        return true;
    }
    public function getDescrizione(){
        return $this->descrizione;
    }
}
