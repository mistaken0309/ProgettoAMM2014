<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Prezzo</th>
            <th>Data</th>
            <th>Acquirente</th>
            <th>Quantit&agrave</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vendite as $vendita) { ?>
        <tr>
            <td>
                <a href="venditore/manga?param=<?= $vendita->getMangaId()?>">
                <?= MangaFactory::instance()->getMangaPerId($vendita->getMangaId())->getTitolo() ?></a>
            </td>
            <td>
                <?= MangaFactory::instance()->getMangaPerId($vendita->getMangaId())->getPrezzo() ?>
            </td>
            <td>
                <?= $vendita->getData() ?>
            </td>
            <td>
                <?= UtenteFactory::instance()->cercaUtentePerId($vendita->getUtenteId(),2)->getUsername() ?>
            </td>
            <td>
                <?= $vendita->getQuantita() ?>
            </td>
            
            
        </tr>
        <?php } ?>
    </tbody>
</table>
