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
        <?php foreach ($acquisti as $acquisto) { ?>
        <tr>
            <td>
                <a href="venditore/manga?param=<?= $acquisto->getMangaId()?>">
                <?= MangaFactory::instance()->getMangaPerId($acquisto->getMangaId())->getTitolo() ?></a>
            </td>
            <td>
                <?= MangaFactory::instance()->getMangaPerId($acquisto->getMangaId())->getPrezzo() ?>
            </td>
            <td>
                <?= $acquisto->getData() ?>
            </td>
            <td>
                <?= UtenteFactory::instance()->cercaUtentePerId($acquisto->getUtenteId(),2)->getUsername() ?>
            </td>
            <td>
                <?= $acquisto->getQuantita() ?>
            </td>
            
            
        </tr>
        <?php } ?>
    </tbody>
</table>
