
    <h2>Modifica Prodotto</h2>
    <hr class="division">
<div class="input-anagrafica">

    <form method="post" action="venditore/modifica">
        <input type="hidden" name="manga_id" value="<?= $manga->getId()?>">
        <label class="label_manga" for="titolo">Titolo</label>
        <input type="text" name="titolo" id="titolo" value="<?= $manga->getTitolo() ?>"/>
        <br/>
        <label for="titolo_originale">Titolo Originale</label>
        <input type="text" name="titolo_originale" id="titolo_originale" value="<?= $manga->getTitoloOriginale() ?>"/>
        <br/>
        <label for="n_volume">Numero Volume</label>
        <input type="text" name="n_volume" id="n_volume" value="<?= $manga->getNumeroVolume() ?>"/>
        <br/>
        <label for="autore">Autore</label>
        <select name="autore" id="autore">
            
            <?php
                foreach($autori as $autore){
                    if( $autore->getId() ==  $manga->getId()){
            ?>
            <option selected="selected" value="<?= $autore->getId() ?>"><?= $autore->getAutore()?></option>
            <?php
                    }else {
                        
            ?>
            <option value="<?= $autore->getId() ?>"><?= $autore->getAutore()?></option>
            <?php
                    }
            }
            ?>
            
        </select>
        <br/>
        <label for="casa_ed">CasaEditrice</label>
        <input type="text" name="casa_ed" id="casa_ed" value="<?= $manga->getCasaEditrice() ?>"/>
        <br/>
        <label for="pubblicazione">AnnoPubblicazione</label>
        <input type="text" name="pubblicazione" id="pubblicazione" value="<?= $manga->getAnnoPubblicazione() ?>"/>
        <br/>
        <label for="lingua">Lingua</label>
        <input type="text" name="lingua" id="lingua" value="<?= $manga->getLingua() ?>"/>
        <br/>
        <label for="categoria">Categoria</label>
        
        <select name="categoria" id="categoria">
            
            <?php
                foreach($categorie as $categoria){
                    if( $categoria->getTipo() ==  $manga->getCategoria()){
            ?>
            <option selected="selected" value="<?= $categoria->getTipo()?>"><?= $categoria->getTipo()?></option>
            <?php
                    }else {
                        
            ?>
            <option value="<?= $categoria->getTipo() ?>"><?= $categoria->getTipo()?></option>
            <?php
                    }
            }
            ?>
            
        </select>
        <br/>
        <label for="genere">Genere</label>
        <input type="text" name="genere" id="genere" value="<?= $manga->getGenere() ?>"/>
        <br/>
        <label for="descrizione">Descrizione</label>
        <input type="text" name="descrizione" id="descrizione" value="<?= $manga->getDescrizione() ?>"/>
        <br/>
        <label for="prezzo">Prezzo</label>
        <input type="text" name="prezzo" id="prezzo" value="<?= $manga->getPrezzo() ?>"/>
        <br/>
        <label for="n_articoli">NumeroArticoli</label>
        <input type="text" name="n_articoli" id="n_articoli" value="<?= $manga->getNumeroArticoli() ?>"/>
        <br/>
        <input type="hidden" name="cmd" value="modifica">
        <input type="submit" class="button" value="Salva"/>
    </form>
</div>

