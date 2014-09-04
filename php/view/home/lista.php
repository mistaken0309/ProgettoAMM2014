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