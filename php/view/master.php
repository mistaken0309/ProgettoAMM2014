<?php
    include_once 'ViewDescriptor.php';
    include_once basename(__DIR__) . '/../Settings.php';    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <!--<base href="http://spano.sc.unica.it/amm2014/congiuAnnalisa/">-->
        <title><?= $vista->getTitle()?></title>
        <base href="<?= Settings::getApplicationPath() ?>php/"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="buy manga, manga shop, manga">
        <meta name="description" content="manga shop">
        <meta name="author" content="Annalisa Congiu">
        <link rel="shortcut icon" type="image/x-icon" href="<?=basename(__DIR__)?>/../../img/icona.png" />
        <!--Ricaricare la pagina ogni 30 secondi-->
        <!--<meta http-equiv="refresh" content="30">-->
        <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
        <link href="http://roboto-webfont.googlecode.com/svn/trunk/roboto.all.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/mainstylesheet.css">
        <!--<script type="text/javascript"></script>-->
        
    </head>
    <body>
        
        <div id="page">
        
        <header>
            <?php
                $header = $vista->getHeader();
                require "$header";
            ?>
        </header>
        
        <div id="sidebar1">
            <?php
                $leftbar = $vista->getLeftbar();
                require "$leftbar";
            ?>
        </div>

        <div class="middle">
            <?php
                    if ($vista->getMessaggioErrore() != null) {
                        ?>
                        <div class="error">
                            <div>
                                <?=
                                $vista->getMessaggioErrore();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($vista->getMessaggioConferma() != null) {
                        ?>
                        <div class="confirm">
                            <div>
                                <?=
                                $vista->getMessaggioConferma();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
            <?php
                $content = $vista->getContent();
                require "$content";
            ?>
        </div>
        
        <div class="clear"></div>
        
        
        <footer>
            <div>
                Progetto di Amministrazione di Sistema 2014 di Annalisa Congiu
                
                <div class="validator">
                    
                        <a href="http://validator.w3.org/check/referer">
                            <img style="border:0;"
                                src="../img/html-valid-icon.png"
                                alt="HTML Valido!" />
                            HTML Valido
                        </a>
                        
                        
                        <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img style="border:0;"
                            src="../img/css-valid-icon.png"
                            alt="CSS Valido!" />
                            CSS Valido!
                        </a>
                        
                    
                </div>
            </div>
        </footer>
        </div>
        
    </body>
</html>
