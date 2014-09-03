<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acquisti
 *
 * @author Annalisa
 */
class Acquisti {
    private $id;
    private $utente_id;
    private $prodotto_id;
    private $venditore_id;
    private $data;
    private $quantita;
    
    
    public function __construct() {
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getUtenteId(){
        return $this->utente_id;
    }
    public function setUtenteId($utente){
        $this->utente_id = $utente;
    }
    
    public function getProdottoId(){
        return $this->prodotto_id;
    }
    public function setProdottoId($prodotto){
        $this->prodotto_id = $prodotto;
    }
    
    
    public function getVenditoreId(){
        return $this->venditore_id;
    }
    public function setVenditoreId($venditore){
        $this->venditore_id = $venditore;
    }
    public function getMangaId(){
        return $this->manga_id;
    }
    public function setMangaId($manga){
        $this->manga_id = $manga;
    }
    
    public function getData(){
        return $this->data;
    }
    public function setData($data){
        $this->data = $data;
    }
    
    
    public function getQuantita(){
        return $this->quantita;
    }
    public function setQuantita($quantita){
        $this->quantita = $quantita;
    }
    
}
