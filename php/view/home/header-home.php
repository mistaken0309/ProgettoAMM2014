<div>
    <p id="title"><a>Manga Mania</a>
    <nav id="topbar">
        <div>
            <form method="post" action="login" >
            <input type="hidden" name="cmd" value="login"/>
            <label for="user">Username</label>
            <input type="text" name="user" id="user"/>
            <label for="password">Password</label>
            <input type="password" name="password" id="password"/>                 
            <input type="submit" value="Login" id="button"/>
            </form>
            <p><a href="<?= basename(__DIR__) . '/../home'?>">Home</a></p>
        </div>
    </nav>
</div>