<h2>Elenco prodotti</h2>
<p>Cliccare sul titolo del manga per modificarne le relative informazioni</p>
<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Autore</th>
            <th>Prezzo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prodotti as $prodotto) { ?>
        <tr>
            <?php
            
               $manga = MangaFactory::instance()->getMangaPerId($prodotto->getManga());
               
            ?>
            <td><a href="venditore/manga?param=<?= $prodotto->getManga() ?>"><?= $manga->getTitolo() ?> vol. <?= $manga->getNumeroVolume() ?></a></td>
            <td><?= AutoreFactory::getAutorePerId($manga->getAutore())->getAutore() ?></td>
            <td><?= $manga->getPrezzo() ?></td>
            <td></td>
        </tr>
        <?php } ?>
    </tbody>
</table>