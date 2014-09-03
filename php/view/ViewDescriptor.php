<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewDescriptor
 *
 * @author Annalisa
 */
class ViewDescriptor {
    const get = 'get';
    const post = 'post';
    private $title;
    private $content;
    private $header;
    private $leftbar;
    private $pagina;
    private $sottopagina;
    private $messaggioErrore;
    private $messaggioConferma;
    
    public function __construct() {
        
    }
    
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
    }


    public function getContent(){
        return $this->content;
    }
    
    public function setContent($content){
        $this->content = $content;
    }
    
    public function getHeader(){
        return $this->header;
    }
    public function setHeader($header){
        $this->header = $header;
    }
    
    public function getLeftbar(){
        return $this->leftbar;
    }
    public function setLeftbar($leftbar){
        $this->leftbar = $leftbar;
    }
    
    public function getPagina(){
        return $this->pagina;
    }
    public function setPagina($page){
        $this->pagina = $page;
    }
    
    public function getSottoPagina(){
        return $this->sottopagina;
    }
    public function setSottoPagina($sottopagina){
        $this->sottopagina = $sottopagina;
    }
    
    /**
     * Restituisce il testo del messaggio di errore
     * @return string
     */
    public function getMessaggioErrore() {
        return $this->messaggioErrore;
    }

      /**
     * Imposta un messaggio di errore
     * @return string
     */
    public function setMessaggioErrore($msg) {
        $this->messaggioErrore = $msg;
    }
    
    /**
     * Restituisce il contenuto del messaggio di conferma
     * @return string
     */
    public function getMessaggioConferma() {
        return $this->messaggioConferma;
    }

    /**
     * Imposta il contenuto del messaggio di conferma
     * @param string $msg
     */
    public function setMessaggioConferma($msg) {
        $this->messaggioConferma = $msg;
    }
    
}
