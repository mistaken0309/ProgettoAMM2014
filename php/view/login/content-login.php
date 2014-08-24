<table border="0">
    <tr>
        <td>
            <div class="login" id="login">
                <h3>Accedi</h3>
                <form method="post" action="login">
                    <input type="hidden" name="cmd" value="login"/>
                    <label for="user">Username</label><br />
                    <input type="text" name="user" id="user"/>
                    <br>
                    <label for="password">Password</label><br/>
                    <input type="password" name="password" id="password"/> 
                    <br/>
                    <input type="submit" value="Login" id="button"/>
                </form>
            </div>
        </td>
        <td>
            <div class="login" id="signup">
                <h3>Registrati</h3>
                <form method="post" action="signup">
                    <input type="hidden" name="cmd" value="singup"/>
                    <label for="email">E-mail</label><br/>
                    <input type="email" name="email" id="email"/>
                    <br>
                    <label for="password">Password</label><br/>
                    <input type="password" name="password" id="password"/> 
                    <br/>
                    <input type="submit" value="Login" id="button"/>    
                </form>
            </div>
        </td>
    </tr>
    

