<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MangaFactory
 *
 * @author Annalisa Congiu
 */
class MangaFactory {
    private static $singleton;
    
    private function __constructor(){
    }
    
    
    /**
     * Restiuisce un singleton per creare appelli
     * @return \AppelloFactory
     */
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new AppelloFactory();
        }
        
        return self::$singleton;
    }
}
