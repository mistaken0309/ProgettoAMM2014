<?php
switch ($vista->getSottoPagina()) {
    case 'lista':
        include_once 'lista.php';
        break;
    case 'lista_per_autore':
        include_once 'lista_per_autore.php';
        break;
    case 'manga':
        include_once 'manga.php';
        break;
    case 'login':
        include_once 'content-login.php';
        break;
    default:
        
?>
<h2>Elenco manga</h2>


<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Autore</th>
            <th>Prezzo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mangas as $manga) { ?>
        <tr>
            <?php
            $mangaid = $manga->getId();
            ?>
            <td><a href="home/manga?param=<?= "$mangaid" ?>"><?= $manga->getTitolo() ?></a></td>
            <td><a href="home/lista_per_autore?param=<?= $manga->getAutore()?>"><?= AutoreFactory::getAutorePerId($manga->getAutore())->getAutore() ?></a></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
    break;
}
?>

