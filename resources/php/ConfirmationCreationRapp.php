<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title>Récapitulatif rapport </title>
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
    <div class="content">
        <h2> Récapitulatif rapport </h2>
        <form class="form_ConfCreationRapport" method="post" action="">
            <div class="form_messages" id="js_form_messages"></div>
            <div class="wrap_input_Indicateurs m_b_26">
                <?php
                require_once('FonctionsUtils.php');
                $conn = mysqlConnectDB();
                if (isset($_SESSION['indicateurs'])) {
                    echo '<p class="headerRapport"> Titre rapport : ' . $_SESSION['titreRapport'] . '</p>';
                    echo '<p class="headerRapport"> Type rapport : ' . $_SESSION['typeRapport'] . '</p>';
                    // ----------get LibelleInd pour chaque indicateur choisi   --------------
                    echo '<ul style="margin-top: 20px;">';
                    foreach ($_SESSION['indicateurs'] as $key => $indicateur) {
                        $sqlQueryIndicateur = 'SELECT LibelleInd FROM  indicateur  WHERE IdInd= ' . $indicateur;
                        $QueryResultat = mysqli_query($conn, $sqlQueryIndicateur);
                        if ($QueryResultat != null) {
                            $ligne = mysqli_fetch_array($QueryResultat);
                            $LibelleInd = $ligne['LibelleInd'];
                        }
                        echo '<li class="li_indicateur">' . $LibelleInd . '</li>';
                        echo '<div class="wrap_input_CreationRap m_b_26">';
                        // affichage des résultats des indicateurs
                        affichageResultatIndicateur($indicateur);
                        echo '<textarea class="textArea_AnalyseInd m_l_26" name="Analyses[]" required placeholder="Analyse"></textarea>';
                        echo '</div>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <div class="wrap_form_btn_DemmandeRap">
                <button type="submit" class="form_btn m_l_26" name="submit">Valider</button>

            </div>
            <?php
            //-------------submit-----------
            // insertion dans la base
            if (isset($_POST['submit'])) {
                if (!empty($_POST['Analyses'])) {
                    // recuperer  IdType pour l'insertion
                    $sqlQueryTypeRapp = "SELECT  IdType FROM type WHERE LCASE(NomType) ='" . $_SESSION['typeRapport'] . "'";
                    $resultatQueryTypeRapp = mysqli_query($conn, $sqlQueryTypeRapp);
                    if ($resultatQueryTypeRapp != null) {
                        $ligne = mysqli_fetch_array($resultatQueryTypeRapp);
                        $idTypeRapp = $ligne['IdType'];
                    }
                    //  préparetion et insertion dans la table rapport
                    $titreRapport = mysqli_real_escape_string($conn, $_SESSION['titreRapport']);
                    $dateCreation = date('Y-m-d');
                    $etatRapport = mysqli_real_escape_string($conn, 'ouvert');

                    // La synthèse est vide car c'est au directeur des ventes de la rajouter plus tard
                    $sqlQueryInsertRapport = "INSERT INTO rapport(TitreRap, DateCreation, EtatRap, SyntheseRap, IdType) VALUES 
                                                                ('$titreRapport','$dateCreation','$etatRapport',' ','$idTypeRapp')";
                    // check and save rapport
                    if (mysqli_query($conn, $sqlQueryInsertRapport) == True) {
                        // successfully
                        $idRapport = mysqli_insert_id($conn);
                    } else {
                        //Error query rapport
                        echo "Error: " . $sqlQueryInsertRapport . "<br>" . mysqli_error($conn);
                    }
                    //  Préparetion et insertion dans la table comporter
                    $Analyses = $_POST['Analyses'];
                    foreach ($_SESSION['indicateurs'] as $key => $indicateur) {
                        $analyseIndicateur = mysqli_escape_string($conn, $Analyses[$key]);
                        $sqlQueryComporter = "INSERT INTO comporter(IdRap, IdInd, Analyse)
                                                VALUES ('$idRapport','$indicateur','$analyseIndicateur')";
                        // successfully
                        if (mysqli_query($conn, $sqlQueryComporter) == true) {
                             echo '<script type="text/javascript">
                             var div_message = document.getElementById(\'js_form_messages\');
                             div_message.innerHTML += \'Votre rapport est bien créé\';
                             div_message.style.backgroundColor=\'#57b846\';
                             </script>
                            ';
                            //Error
                        } else {
                            // supprimer les infos insérées dans la table rapport car pas de rapport sans indicateurs
                            mysqli_query($conn, "DELETE FROM rapport  WHERE IdRap =" . $idRapport);
                            //afficher un message d'erreur
                            echo '<script type="text/javascript">
                            var div_message = document.getElementById(\'js_form_messages\');
                            div_message.innerHTML += \'Oops ! erreur .Essayez plus tard \';
                            div_message.style.backgroundColor=\'rgba(209,46,46,0.8)\';
                            </script>';
                        }

                    }
                }
            }
            // Close connection
            mysqli_close($conn);
            ?>
        </form>
    </div>
</div>
<footer class="container_footer">
    <p>
        Copyright &copy; 2020 by LYFA , All rights reserved .
    </p>
</footer>

</body>
</html>

