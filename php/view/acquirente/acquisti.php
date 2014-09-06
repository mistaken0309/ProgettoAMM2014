<h2>Prodotti acquistati</h2>
<?php
if(count($acquisti) > 0){
?>

<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Prezzo</th>
            <th>Data</th>
            <th>Venditore</th>
            <th>Quantit&agrave</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($acquisti as $acquisto) { ?>
        <tr>
            <td>
                <a href="acquirente/manga?param=<?= $acquisto->getMangaId()?>">
                <?= MangaFactory::instance()->getMangaPerId($acquisto->getMangaId())->getTitolo() ?></a>
            </td>
            <td>
                <?= MangaFactory::instance()->getMangaPerId($acquisto->getMangaId())->getPrezzo() ?>
            </td>
            <td>
                <?= $acquisto->getData() ?>
            </td>
            <td>
                <?= UtenteFactory::instance()->cercaUtentePerId($acquisto->getVenditoreId(),1)->getUsername() ?>
            </td>
            <td>
                <?= $acquisto->getQuantita() ?>
            </td>
            
            
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
} else {?>
<p>Non hai ancora effettuato nessun acquisto.</p>
<?php } ?>
