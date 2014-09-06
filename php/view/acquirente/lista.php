<h2>Elenco manga</h2>
<?php
    include_once 'filtro.php';
?>
<p>Cliccare sul titolo del manga per acquistarlo o vedere i dettagli.</p>
<?php
if( count($mangas) > 0){
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
            <td><a href="acquirente/manga?param=<?= $manga->getId() ?>"><?= $manga->getTitolo() ?></a></td>
            <td><a href="acquirente/lista_per_autore?param=<?= $manga->getAutore()?>"><?= AutoreFactory::getAutorePerId($manga->getAutore())->getAutore() ?></a></td>
            <td><?= $manga->getPrezzo() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
} else {
?>
<p>Non ci sono ancora manga in vendita.</p>
<?php } ?>
