<head>
    <title>Mega Ultra Quiz De La Mort Qui Tue</title>
    <link href="style/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<header>
    <?php 
        require_once 'autoloader.php';
        spl_autoload_register();

        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        
        session_start();
        if (isset($_SESSION['Nom'])) {
            echo "<a class='btn btn-danger' href='Deconnexion.php'>Se Deconnecter</a>";
        } else {
            echo "<a class='btn btn-success' href='Connexion.php'>Se Connecter</a>";
        }
        echo "<a class='btn btn-warning' href='ImportJson.php'>Importer un Quizz</a>";
    ?>
</header>
