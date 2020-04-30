<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>afficher un rapport </title>
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
        <form class="form_ListeRaports m_b_26" method="post" action="">
            <div class="form_messages" id="js_form_messages">
            </div>
            <div class="wrap_input_CreationRap m_b_26">
                <?php
                $idRapportChoisi = $_SESSION['rapportChoisi'];
                require_once('FonctionsUtils.php');
                $conn = mysqlConnectDB();
                // get les infos du rapport choisie
                $SqlQueryRapport = "SELECT TitreRap,SyntheseRap,EtatRap FROM  rapport  WHERE  IdRap = " . $idRapportChoisi;
                $resultatQueryRapport = mysqli_query($conn, $SqlQueryRapport);
                if ($resultatQueryRapport != null) {
                    while ($ligne = mysqli_fetch_array($resultatQueryRapport)) {
                        $titreRapport = $ligne['TitreRap'];
                        $syntheseRapport = $ligne['SyntheseRap'];
                        $etatRaport = $ligne['EtatRap'];
                    }
                }
                echo '<p class="headerRapport"> ' . $titreRapport . '</p>';
                echo '<p class="headerRapport" >Etat rapport : <span style="color: #57b846">' . $etatRaport . '</span> </p>';
                //---get la liste des indicateurs avec leurs analyses pour le rapport choisi
                $datas = array();
                $SqlQueryComporter = "SELECT  i.IdInd as \"IdInd\", Analyse,LibelleInd FROM comporter c,indicateur i WHERE 
                                     c.IdInd=i.IdInd and IdRap=" . $idRapportChoisi;
                $resultatQueryComporter = mysqli_query($conn, $SqlQueryComporter);
                if ($resultatQueryComporter != null) {
                    while ($ligne = mysqli_fetch_assoc($resultatQueryComporter)) {
                        $datas[] = $ligne;
                    }
                }
                // Affichage des resultats des indicateurs avec les analyses
                echo '<ul>';
                foreach ($datas as $data) {
                    $idIndicateur = $data['IdInd'];
                    $analyseIndicateur = $data['Analyse'];
                    $LibelleInd = $data['LibelleInd'];
                    echo '<li class="li_indicateur">' . $LibelleInd . '</li>';
                    affichageResultatIndicateur($idIndicateur);
                    echo('<div class = "analyseIndicateur">' . $analyseIndicateur . '</div>');
                }
                echo '<span>Synthèse</span>';
                echo('<div class = "syntheseRapport">' . $syntheseRapport . '</div>');

                echo '<ul>';
                ?>
            </div>
            <div class="wrap_form_btn_DemmandeRap " style="margin-bottom: 60px">
                <p> Liste des commentaires</p>
                <?php
                $SqlQueryCommentaire = "SELECT DateCom,NomTypeUser,ContenuCom FROM commentaire c,user u , typeuser tu where c.IdUser=u.IdUser and
                                                u.IdTypeUser=tu.IdTypeUser and c.IdRap=" . $idRapportChoisi . " ORDER BY DateCom DESC";

                $ResultatQueryCommentaire = mysqli_query($conn, $SqlQueryCommentaire);
                echo("<table>");
                echo('<tr>');
                echo('<td class="t_head"> Heure </td>');
                echo('<td class="t_head"> Identifiant </td>');
                echo('<td class="t_head"> Message </td>');
                echo('<tr>');
                while ($ligne = mysqli_fetch_array($ResultatQueryCommentaire)) {
                    echo("<tr>");
                    echo('<td>' . $ligne['DateCom'] . "</td>");
                    echo("<td>" . $ligne["NomTypeUser"] . "</td>");
                    echo("<td>" . $ligne["ContenuCom"] . "</td>");
                    echo("</tr>");
                }
                echo("</table>");
                ?>

                <div>
                    <div class="wrap_form_btn_DemmandeRap" style="margin-bottom: 60px">
                        <button type="submit" class="form_btn m_l_26" name="submit" value="Retour">Retour</button>
                        <?php
                        // Ajouter des buttons  pour les rapport non cloturer
                        if ($etatRaport != 'cloturer') {

                            echo('<button type="submit" class="form_btn m_l_26" name="submit" value="Commenter">Commenter</button>');
                            if ($_SESSION['NomTypeUser'] == 'Directeur') {
                                echo('<button type="submit" class="form_btn m_l_26" name="submit" value="Cloturer">Cloturer</button>');
                            } elseif (($_SESSION['NomTypeUser'] == 'Directeur ventes')) {
                                echo('<button type="submit" class="form_btn m_l_26" name="submit" value="Ajouter Synthèse">Ajouter Synthèse</button>');
                            } else {
                                if ($etatRaport == 'ouvert')
                                    // soumettre pour le rapport ouvert et non cloturer
                                    echo('<button type="submit" class="form_btn m_l_26" name="submit" value="Soumettre">Soumettre</button>');
                            }

                        }

                        ?>
                    </div>
                    <?php //-------------submit-----------
                    if (isset($_POST['submit'])) {
                        switch ($_POST['submit']) {
                            // ---------retour vers la page ConsulterLesRapports---------
                            case "Retour":
                                header('location:ConsulterLesRapports.php');
                                break;
                            // ---------------Cloturer un rapport---------------
                            case  "Cloturer":
                                $sqlQueryUpdateRapport = "UPDATE rapport SET EtatRap = 'cloturer' WHERE IdRap =" . $idRapportChoisi;
                                // successfully
                                if (mysqli_query($conn, $sqlQueryUpdateRapport) == true) {
                                    echo '<script type="text/javascript">
                                    var div_message = document.getElementById(\'js_form_messages\');
                                    div_message.innerHTML += \'Votre rapport est cloturé \';
                                    div_message.style.backgroundColor=\'#57b846\';
                                    </script>';
                                    //Error
                                } else {
                                    //-afficher un message d'erreur
                                    echo '<script type="text/javascript">
                            var div_message = document.getElementById(\'js_form_messages\');
                            div_message.innerHTML += \'Oops ! erreur .Essayez plus tard \';
                            div_message.style.backgroundColor=\'rgba(209,46,46,0.8)\';
                            </script>';
                                }
                                break;
                            // ---------------Soumettre un rapport---------------
                            case  "Soumettre":
                                $sqlQueryUpdateRapport = "UPDATE rapport SET EtatRap = 'soumis' WHERE IdRap =" . $idRapportChoisi;
                                // successfully
                                if (mysqli_query($conn, $sqlQueryUpdateRapport) == true) {
                                    echo '<script type="text/javascript">
                                    var div_message = document.getElementById(\'js_form_messages\');
                                    div_message.innerHTML += \'Votre rapport est soumis \';
                                    div_message.style.backgroundColor=\'#57b846\';
                                    </script>';
                                    //Error
                                } else {
                                    //afficher un message d'erreur
                                    echo '<script type="text/javascript">
                                    var div_message = document.getElementById(\'js_form_messages\');
                                    div_message.innerHTML += \'Oops ! erreur .Essayez plus tard \';
                                    div_message.style.backgroundColor=\'rgba(209,46,46,0.8)\';
                                    </script>';
                                }
                                break;
                            // ---------------Commenter un rapport---------------
                            case "Commenter":
                                header('location:CommenterRapport.php');
                                break;
                            // ---------------Ajouter Synthèse---------------
                            case "Ajouter Synthèse":
                                header('location:AjouterSyntheseRapp.php');
                                break;
                        }

                    }
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

