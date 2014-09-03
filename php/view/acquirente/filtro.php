<div class="input-anagrafica">
    <h3>Filtro</h3>
    <form method="post" action="acquirente/lista_per_autore?param=">
        <label for="autore">Autore</label>
        <select name="autore" id="autore">
            <option value="qualsiasi">Qualsiasi</option>
            <?php foreach ($autori as $autore) { ?>
                <option value="<?= $autore->getId() ?>" ><?= $autore->getAutore() ?></option>
            <?php } ?>
        </select>
        <button class="button" type="submit" name="cmd" value="e_cerca">Cerca</button>
    </form>
</div>
