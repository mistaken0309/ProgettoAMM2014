<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prodotti
 *
 * @author Annalisa
 */
class Prodotti {
    private $id;
    private $venditore;
    private $manga;
    
    public function __construct() {
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getVenditore(){
        return $this->venditore;
    }
    public function setVenditore($venditore){
        $this->venditore = $venditore;
    }
    
    public function getManga(){
        return $this->manga;
    }
    public function setManga($manga){
        $this->manga = $manga;
    }
    
    
}
