<?php
include_once 'Settings.php';
 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <base href="<?= Settings::getApplicationPath() ?>"/>
        <link rel="stylesheet" type="text/css" href="<?=basename(__DIR__)?>/../css/mainstylesheet.css">
        <title>Errore</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=basename(__DIR__)?>/../img/error-icon.png" />
        
    </head>
    <body>
        <div id="error">
        <h1><?= $titolo ?></h1>
        <p>
            <?=
            $messaggio
            ?>
        </p>
        <?php if (isset($login)) { ?>
            <p>Puoi autenticarti alla pagina di <a href="php/home/login">login</a></p>
        <?php } ?>
        </div>
    </body>
</html>
