
<h3 class="manga-title"><?= $manga->getTitolo() ?></h3>
<div class="manga"><h4>Titolo Originale</h4>: <?= $manga->getTitoloOriginale() ?></div>
<div class="manga"><h4># volume</h4>: <?= $manga->getNumeroVolume() ?></div>
<div class="manga"><h4>Autore</h4>: <?= AutoreFactory::instance()->getAutorePerId($manga->getAutore())->getAutore() ?></div>
<div class="manga"><h4>Casa editrice</h4>: <?= $manga->getCasaEditrice() ?></div>
<div class="manga"><h4>Anno di pubblicazione</h4>: <?= $manga->getAnnoPubblicazione() ?></div>
<div class="manga"><h4>Lingua</h4>: <?= $manga->getLingua() ?></div>
<div class="manga"><h4>Categoria</h4>: <?= $manga->getCategoria() ?></div>
<div class="manga"><h4>Genere</h4>: <?= $manga->getGenere() ?></div>
<div class="manga"><h4>Descrizione</h4>: <?= $manga->getDescrizione() ?></div>
<div class="manga"><h4>Prezzo</h4>: <?= $manga->getPrezzo() ?></div>
<div class="manga"><h4>Disponibilit&agrave;</h4>: 
        <?php 
        $articoli = $manga->getNumeroArticoli();
            if($articoli>0){
                echo "$articoli"; 
            } else{
                echo 'Questo articolo non &egrave; disponibile';
            }
            
        ?>
</div>
<div class="manga">
    <form method="post" action="venditore/modifica" class="inline">
        <input type="hidden" name="manga_id" value="<?= $manga->getId()?>">
        <button type="submit" class="button"> Modifica</button>
    </form>
    <a href="venditore/lista"><button type="submit" class="button">Torna all'elenco</button></a>
    
</div>



