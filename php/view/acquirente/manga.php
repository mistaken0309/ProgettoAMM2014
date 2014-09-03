<h3><?= $manga->getTitolo() ?></h3>
<div class="manga"><h4>Titolo Originale</h4>: <?= $manga->getTitoloOriginale() ?></div>
<div class="manga"><h4># volume</h4>: <?= $manga->getNumeroVolume() ?></div>
<div class="manga"><h4>Autore</h4>: <a href="acquirente/lista_per_autore?param=<?= $manga->getAutore()?>"><?= AutoreFactory::instance()->getAutorePerId($manga->getAutore())->getAutore() ?></a></div>
<div class="manga"><h4>Casa editrice</h4>: <?= $manga->getCasaEditrice() ?></div>
<div class="manga"><h4>Anno di pubblicazione</h4>: <?= $manga->getAnnoPubblicazione() ?></div>
<div class="manga"><h4>Lingua</h4>: <?= $manga->getLingua() ?></div>
<div class="manga"><h4>Categoria</h4>: <?= $manga->getCategoria() ?></div>
<div class="manga"><h4>Genere</h4>: <?= $manga->getGenere() ?></div>
<div class="manga"><h4>Descrizione</h4>: <?= $manga->getDescrizione() ?></div>
<div class="manga"><h4>Prezzo</h4>: <?= $manga->getPrezzo() ?></div>
<div class="manga"><h4>Disponibilità</h4>: <?= $manga->getNumeroArticoli() ?></div>



