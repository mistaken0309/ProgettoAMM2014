
<div class="input-anagrafica">
    
    <h2>Dati personali</h2>
    
    <p><strong>Username:</strong> <?= $user->getUsername() ?></p>
        
    <form method="post" action="studente/anagrafica">
        <input type="hidden" name="cmd" value="indirizzo"/>
        <label for="nome">Nome</label>
        <input type="text" name="via" id="via" value="<?= $user->getNome() ?>"/>
        <br>
        <label for="cognome">Cognome</label>
        <input type="text" name="civico" id="civico" value="<?= $user->getCognome() ?>"/>
        <br/>
        <input type="submit" value="Salva"/>
    </form>
    
</div>
<hr style="solid" width="100%" size="1px" color="gainsboro"/>

<div class="input-anagrafica">
    <h3>Indirizzo</h3>

    <form method="post" action="studente/anagrafica">
        <input type="hidden" name="cmd" value="indirizzo"/>

        
        <table>
            <tr><td><label for="via">Via o Piazza</label></td>
                <td><input type="text" name="via" id="via" value="<?= $user->getVia() ?>"/></td></tr>
        </table>
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
        <input type="submit" value="Salva"/>
    </form>
</div>

<hr style="solid" width="100%" size="1px" color="gainsboro"/>

<div class="input-anagrafica">
    <h3>Email</h3>

    <form method="post" action="studente/anagrafica">
        <input type="hidden" name="cmd" value="email"/>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= $user->getEmail() ?>"/>
        <br/>
        <input type="submit" value="Salva"/>
    </form>
</div>

<hr style="solid" width="100%" size="1px" color="gainsboro"/>

<div class="input-anagrafica">
    <h3>Password</h3>
    <form method="post" action="studente/anagrafica">
        <input type="hidden" name="cmd" value="password"/>
        <label for="pass1">Nuova Password:</label>
        <input type="password" name="pass1" id="pass1"/>
        <br/>
        <label for="pass2">Conferma:</label>
        <input type="password" name="pass2" id="pass2"/>
        <br/>
        <input type="submit" value="Cambia"/>
    </form>
</div>