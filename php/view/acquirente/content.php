<?php
switch ($vista->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;
    case 'lista':
        include_once 'lista.php';
        break;
    case 'manga':
        include_once 'manga.php';
        break;
    case 'lista_per_autore':
        include_once 'lista_per_autore.php';
        break;
    case 'compra':
    case 'acquisti':
        include_once 'acquisti.php';
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
            <li><a href="acquirente/anagrafica">Impostazioni Account</a></li>
            <li><a href="acquirente/lista">Sfoglia i Manga</a></li>
            <li><a href="acquirente/acquisti">Storico Acquisti</a></li>
        </ul>
<?php
    break;
}
?>

