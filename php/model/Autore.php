<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Autore
 *
 * @author Annalisa
 */
class Autore {
    private $id;
    private $autore;
    
    public function __construct() {
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getAutore(){
        return $this->autore;
    }
    public function setAutore($autore){
        $this->autore = $autore;
    }
}
