<?php

/**
 * Description of Acquirente
 *
 * classe che rappresenta un acquirente
 * @author Annalisa Congiu
 */
class Acquirente extends UtenteBase{
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(UtenteBase::Acquirente);      
    }
}
