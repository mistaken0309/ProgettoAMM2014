<h2 class="title">Elenco manga di <?= $manga->getAutore()->getAutore()?></h2>
<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Prezzo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mangas as $manga) { ?>
        <tr>
            <td><a href="acquirente/manga?param=<?= $manga->getId()?>"><?= $manga->getTitolo() ?></a></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>