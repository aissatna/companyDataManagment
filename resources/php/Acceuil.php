<!doctype html>
    <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <link rel="stylesheet" type="text/css" href="../css/style.css">
                <title>Acceuil</title>
            </head>
            <body>
                    <header class="container_header">
                        <img src="../img/logo_1.png" alt="logo">
                        <h1>
                            Société Lagardère Active
                        </h1>
                    </header>
                    <div class="container_content">
                        <?php
                        // Affichage de menu selon le type de l'utilisateur
                        session_start();
                        if (isset($_SESSION['NomTypeUser'])) {
                            if ($_SESSION['NomTypeUser'] == 'Directeur') {
                                include 'MenuDirecteur.html';
                            } elseif (($_SESSION['NomTypeUser'] == 'Directeur ventes')) {
                                include 'MenuDirecteurVentes.html';
                            } else {
                                include 'MenuEmployé.html';
                            }

                        }
                        ?>
                    </div>
                    <footer class="container_footer">
                        <p>
                            Copyright &copy; 2020 by LYFA , All rights reserved .
                        </p>
                    </footer>
            </body>
    </html>