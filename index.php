<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Zdeněk Němec">
    <title>Vyhledávací systém pro ARES</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
</head>

<body>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=lookup">Vyhledávání podle IČO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=results">Výsledky vyhledávání</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <?php
    if (isset($_GET['page']))
        $page = $_GET['page'];
    else
        $page = 'lookup';
    if (preg_match('/^[a-z0-9]+$/', $page)) {
        $vlozeno = include($page . '.php');
        if (!$vlozeno)
            echo ('Podstránka nenalezena');
    } else
        echo ('Neplatný parametr.');
    ?>

    <footer class="footer">
        <div class="footer-copyright text-center py-3">© <?php echo date("Y"); ?> Copyright:
            <a href="mailto:zdenek@nemec.pro"> Zdeněk Němec</a>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="js/vendor/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/myjs.js"></script>
</body>

</html>