<h2 class="title">Elenco manga di <?= $autore ?></h2>
<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Volume</th>
            <th>Prezzo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mangas as $manga) { ?>
        <tr>
            <td><a href="home/manga?param=<?= $manga->getId()?>"><?= $manga->getTitolo() ?></a></td>
            <td><?= $manga->getNumeroVolume() ?></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>