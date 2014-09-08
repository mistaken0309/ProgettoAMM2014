<?php
switch ($vista->getSottoPagina()) {
    case 'lista_per_autore':
        include_once 'lista_per_autore.php';
        break;
    case 'manga':
        include_once 'manga.php';
        break;
    case 'login':
        include_once 'content-login.php';
        break;
    case 'lista':
    default:
        include_once 'lista.php';
        break;
}
?>

