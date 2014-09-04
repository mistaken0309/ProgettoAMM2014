<h2>Elenco manga</h2>
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
            <td><a href="home/manga?param=<?= $manga->getId()?>"><?= $manga->getTitolo() ?></a></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>