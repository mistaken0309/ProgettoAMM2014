
    <h2>Aggiungi un nuovo prodotto</h2>

<div class="input-anagrafica">

    <form method="post" action="venditore/aggiungi-manga">
        <label class="label_manga" for="titolo">Titolo</label>
        <input type="text" name="titolo" id="titolo" value=""/>
        <br/>
        <label for="titolo_originale">Titolo Originale</label>
        <input type="text" name="titolo_originale" id="titolo_originale" value=""/>
        <br/>
        <label for="n_volume">Numero Volume</label>
        <input type="text" name="n_volume" id="n_volume" value=""/>
        <br/>
        <label for="autore">Autore</label>
        <select name="autore" id="autore">
            
            <?php
                foreach($autori as $autore){           
            ?>
            <option value="<?= $autore->getId() ?>"><?= $autore->getAutore()?></option>
            <?php
            }
            ?>
            
        </select>
        <br/>
        <label for="casa_ed">CasaEditrice</label>
        <input type="text" name="casa_ed" id="casa_ed" value=""/>
        <br/>
        <label for="pubblicazione">AnnoPubblicazione</label>
        <input type="text" name="pubblicazione" id="pubblicazione" value=""/>
        <br/>
        <label for="lingua">Lingua</label>
        <input type="text" name="lingua" id="lingua" value=""/>
        <br/>
        <label for="categoria">Categoria</label>
        
        <select name="categoria" id="categoria">
            
            <?php
                foreach($categorie as $categoria){          
            ?>
            <option value="<?= $categoria->getTipo() ?>"><?= $categoria->getTipo()?></option>
            <?php
            }
            ?>
            
        </select>
        <br/>
        <label for="genere">Genere</label>
        <input type="text" name="genere" id="genere" value=""/>
        <br/>
        <label for="descrizione">Descrizione</label>
        <input type="text" name="descrizione" id="descrizione" value=""/>
        <br/>
        <label for="prezzo">Prezzo</label>
        <input type="text" name="prezzo" id="prezzo" value=""/>
        <br/>
        <label for="n_articoli">NumeroArticoli</label>
        <input type="text" name="n_articoli" id="n_articoli" value=""/>
        <br/>
        <input type="hidden" name="cmd" value="aggiungi">
        <input type="submit" class="button" value="Salva"/>
    </form>
</div>

