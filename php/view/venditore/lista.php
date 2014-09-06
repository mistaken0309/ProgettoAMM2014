<h2 class="title">Elenco prodotti</h2>
<p class="italic">Cliccare sul titolo del manga per modificarne le relative informazioni</p>
<?php
if(count($prodotti) >0){
?>
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
            <td><?= $manga->getNumeroVolume() ?></td>
            <td><?= AutoreFactory::getAutorePerId($manga->getAutore())->getAutore() ?></td>
            <td><?= $manga->getPrezzo() ?></td>
            <td></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
} else {?>
<p>Non sono ancora stati aggiunti dei prodotti</p>
<p><a href="venditore/aggiungi-manga">Aggiungi un prodotto</a></p>
<?php } ?>
