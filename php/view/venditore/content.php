<?php
switch ($vista->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;
    case 'lista':
        include_once 'lista.php';
        break;
    case 'aggiungi-manga':
        include_once 'aggiungi_manga.php';
        break;
    case 'manga':
        include_once 'manga.php';
        break;
    case 'modifica':
        include_once 'modifica_manga.php';
        break;
    case 'lista_per_autore':
        include_once 'lista_per_autore.php';
        break;
    case 'vendite':
        include_once 'vendite.php';
        break;
    default:
        
?>
        <p>
            Benvenuto, <?= $user->getUsername() ?>!
        </p>
        <p>
            Puoi Scegliere tra le seguenti sezioni:
        </p>
        <ul>
            <li><a href="venditore/anagrafica">Impostazioni Account</a></li>
            <li><a href="venditore/lista">Elenco prodotti</a></li>
            <li><a href="venditore/aggiungi-manga">Aggiungi un nuovo prodotto</a></li>
            <li><a href="venditore/vendite">Storico vendite</a></li>
        </ul>
<?php
    break;
}
?>

