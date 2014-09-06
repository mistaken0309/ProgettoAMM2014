
<h2>Dati Personali</h2>

<div class="input-anagrafica">
    <h3>Impostazioni Account</h3>

    <form method="post" action="acquirente/anagrafica">
        <input type="hidden" name="cmd" value="impostazioni"/>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= $user->getNome() ?>"/>
        <br/>
        <label for="cognome">Cognome</label>
        <input type="text" name="cognome" id="cognome" value="<?= $user->getCognome() ?>"/>
        <br/>
        <input type="submit" class="button" value="Salva"/>
    </form>
    <p> </p>
    <form method="post" action="acquirente/anagrafica">
        <input type="hidden" name="cmd" value="email"/>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= $user->getEmail() ?>"/>
        <input type="submit" class="button" value="Salva"/>
    </form>
    <p> </p>
    <form method="post" action="acquirente/anagrafica">
        <input type="hidden" name="cmd" value="password"/>
        <label for="pass1">Nuova Password:</label>
        <input type="password" name="pass1" id="pass1"/>
        <br/>
        <label for="pass2">Conferma:</label>
        <input type="password" name="pass2" id="pass2"/>
        <br/>
        <input type="submit" class="button" value="Cambia"/>
    </form>
</div>
<hr class="division">
<div class="input-anagrafica">
    
    <h3>Indirizzo</h3>

    <form method="post" action="acquirente/anagrafica">
        <input type="hidden" name="cmd" value="indirizzo"/>
        <label for="via">Via o Piazza</label><input type="text" name="via" id="via" value="<?= $user->getVia() ?>"/>
        <br>
        <label for="civico">Numero Civico</label>
        <input type="text" name="civico" id="civico" value="<?= $user->getNumeroCivico() ?>"/>
        <br/>
        <label for="citta">Citt&agrave;</label>
        <input type="text" name="citta" id="citta" value="<?= $user->getCitta() ?>"/>
        <br/>
        <label for="provincia">Provincia</label>
        <input type="text" name="provincia" id="provincia" value="<?= $user->getProvincia() ?>"/>
        <br/>
        <label for="cap">CAP</label>
        <input type="text" name="cap" id="cap" value="<?= $user->getCap() ?>"/>
        <br/>
        <input type="submit" class="button" value="Salva"/>
    </form>
</div>

