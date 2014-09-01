<?php

/**
 * Description of Manga
 *
 * @author Annalisa
 */
class Manga {
    private $id;
    private $titolo;
    private $titoloOriginale;
    private $volumi;
    private $autore;
    private $casaEditrice;
    private $annoPubblicazione;
    private $lingua;
    private $categoria;
    private $genere;
    private $descrizione;
    private $prezzo;
    private $numeroArticoli;
    
    public function __construct() {
        
    }
    
    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    
    public function getTitolo(){
        return $this->titolo;
    }
    public function setTitolo($titolo){
        $this->titolo = $titolo;
    }
    
    public function getTitoloOriginale(){
        return $this->titoloOriginale;
    }
    public function setTitoloOriginale($titoloOriginale){
        $this->titoloOriginale = $titoloOriginale;
    }
    
    public function getNumeroVolume(){
        return $this->volumi;
    }
    public function setNumeroVolume($volumi){
        $this->volumi = $volumi;
    }
    
    public function getAutore(){
        return $this->autore;
    }
    public function setAutore($autore){
        $this->autore = $autore;
    }
    
    public function getCasaEditrice(){
        return $this->casaEditrice;
    }
    public function setCasaEditrice($casaEditrice){
        $this->casaEditrice = $casaEditrice;
    }
    
    public function getAnnoPubblicazione(){
        return $this->annoPubblicazione;
    }
    public function setAnnoPubblicazione($annoPubblicazione){
        $this->annoPubblicazione = $annoPubblicazione;
    }
    
    public function getLingua(){
        return $this->lingua;
    }
    public function setLingua($lingua){
        $this->lingua = $lingua;
    }
    
    public function getCategoria(){
        return $this->categoria;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }
    
    public function getGenere(){
        return $this->genere;
    }
    public function setGenere($genere){
        $this->genere = $genere;
    }
    
    public function getDescrizione(){
        return $this->descrizione;
    }
    public function setDescrizione($descrizione){
        $this->descrizione = $descrizione;
    }
    
    public function getPrezzo(){
        return $this->prezzo;
    }
    public function setPrezzo($prezzo){
        $this->prezzo = $prezzo;
    }
    
    public function getNumeroArticoli(){
        return $this->numeroArticoli;
    }
    public function setNumeroArticoli($numeroArticoli){
        $this->numeroArticoli = $numeroArticoli;
    }
}
