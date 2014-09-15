<h2 class="title">Elenco manga</h2>
<p class="italic">Clicca sul titolo del manga per acquistarlo o vedere i dettagli.</p>
<?php
    include_once 'filtro.php';
?>
<div id="table_manga">
<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Volume</th>
            <th>Autore</th>
            <th>Prezzo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mangas as $manga) { ?>
        <tr>
            <td><a href="acquirente/manga?param=<?= $manga->getId() ?>"><?= $manga->getTitolo() ?></a></td>
            <td><?= $manga->getNumeroVolume() ?></td>
            <td><a href="acquirente/lista_per_autore?param=<?= $manga->getAutore()?>"><?= AutoreFactory::getAutorePerId($manga->getAutore())->getAutore() ?></a></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<p id="nessuno">Non ci sono ancora manga in vendita.</p>

