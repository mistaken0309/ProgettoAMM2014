<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Descrizione</title>
        <meta name="author" content="Annalisa Congiu">
        <link rel="shortcut icon" type="image/x-icon" href="/img/apple-touch-icon.png" />
        <meta http-equiv="refresh" content="30">
        <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
        <link href="http://roboto-webfont.googlecode.com/svn/trunk/roboto.all.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/mainstylesheet.css">
    </head>
    <body>
    <div id="description-page">
        <h1>Accesso all'applicazione del progetto</h1>
        <h2>Accesso al progetto</h2>
        <p>
            La homepage del progetto si trova sulla URL <a href="php/home">http://spano.sc.unica.it/amm2014/congiuAnnalisa/php/home</a>
        </p>
        <h2>Credenziali di accesso</h2>
        
        <h3>Ruolo venditore</h3>
            <ul>
                <li>username: venditore1</li>
                <li>password: venditore1</li>
            </ul>
            <ul>
                <li>username: venditore2</li>
                <li>password: venditore2</li>
            </ul>
        
        <h3>Ruolo utente (compratore)</h3>
            <ul>
                <li>username: utente1</li>
                <li>password: utente1</li>
            </ul>
            <ul>
                <li>username: utente2</li>
                <li>password: utente2</li>
            </ul>
        <h2> Descrizione dell'applicazione </h2>
        <p>
            L'applicazione gestisce la compravendita di manga.
        </p>
        <p>
            Ci sono due ruoli: venditore e utente.
        </p>
        <p>Il venditore può:</p>
        <ul>
            <li>Aggiungere un nuovo manga</li>
            <li>Modificare un manga già esistente</li>
            <li>Eliminare un manga dal catalogo</li>
            <li>Visualizzare la lista dei prodotti da lui messi in vendita</li>
            <li>Visualizzare la lista dei prodotti venduti</li>
            <li>Gestire i propri dati anagrafici</li>   
        </ul>
        
        <p>L'utente può:</p>
        <ul>
            <li>Visualizzare l'elenco dei manga disponibili</li>
            <li>Visualizzare l'elenco dei manga disponibili in base all'autore</li>
            <li>Visualizzare i dati realativi a un determinato manga</li>
            <li>Acquistare un manga</li>
            <li>Visualizzare la lista degli acquisti</li>
            <li>Gestire i propri dati anagrafici</li>
        </ul>
        

        <h2> Requisiti del progetto rispettati</h2>
        <ul>
            <li>Utilizzo di HTML e CSS</li>
            <li>Utilizzo di PHP e MySQL</li>
            <li>Utilizzo del pattern MVC </li>
            <li>Due ruoli (venditore e utente)</li>
            <li>Transazione per la registrazione di un acquisto (metodo salvaAcquisto della classe AcquistiFactory.php)</li>
            <li>Transazione per la registrazione di un nuovo manga (metodo creaManga della classe MangaFactory.php)</li>
            <li>Caricamento ajax dei risultati della ricerca dei manga (ruolo acquirente)</li>
        </ul>
    </div>
</body>
</html>
