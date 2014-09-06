
<h2>Vendite</h2>
<?php
if (count($vendite) > 0){
?>
<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Prezzo</th>
            <th>Data</th>
            <th>Acquirente</th>
            <th>Quantit&agrave;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vendite as $vendita) { 
            $manga = MangaFactory::instance()->getMangaPerId($vendita->getMangaId());
            $utente = UtenteFactory::instance()->cercaUtentePerId($vendita->getUtenteId(),2);
            ?>
        <tr>
            <td>
                <a href="venditore/manga?param=<?= $vendita->getMangaId()?>">
                <?= $manga->getTitolo() ?> vol. <?= $manga->getNumeroVolume() ?>
                </a>
            </td>

            <td>
                <?= $manga->getPrezzo() ?>
            </td>
            <td>
                <?= $vendita->getData() ?>
            </td>
            <td>
                <?= $utente->getUsername() ?>
            </td>
            <td>
                <?= $vendita->getQuantita() ?>
            </td>
            
            
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
} else {?>
<p>Nessun prodotto &egrave; stato venduto.</p>
<?php } ?>

