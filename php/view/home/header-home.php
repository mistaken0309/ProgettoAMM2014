<div>
    <nav id="topbar">
        <div>
            
            <form method="post" action="home/login" >
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
<div class="clear"></div>
<div id="title"><div>Manga Mania</div></div>