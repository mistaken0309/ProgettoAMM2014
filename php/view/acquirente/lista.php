<h2>Elenco manga</h2>
<?php
    include_once 'filtro.php';
?>


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
            <td><a href="acquirente/manga?param=<?= "$mangaid" ?>"><?= $manga->getTitolo() ?></a></td>
            <td><a href="acquirente/lista_per_autore?param=<?= $manga->getAutore()?>"><?= AutoreFactory::getAutorePerId($manga->getAutore())->getAutore() ?></a></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>