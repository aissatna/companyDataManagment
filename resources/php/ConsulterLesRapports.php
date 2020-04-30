<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title> Consulter les rapports </title>
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
        <h2> Liste des rapports  </h2>
        <form class="form_ListeRaports m_b_26" method="post" action="">
            <div class="wrap_input_CreationRap m_b_26">
                <?php
                require_once('FonctionsUtils.php');
                $conn = mysqlConnectDB();
                // Les directeurs auront accès à tous les rapports
                if ($_SESSION['NomTypeUser'] == 'Directeur' or $_SESSION['NomTypeUser'] == 'Directeur ventes') {
                    $SqlQueryRapport="SELECT IdRap,TitreRap, DateCreation, EtatRap ,NomType  FROM rapport R, type T WHERE r.IdType=T.IdType";
                 // Chaque employé aura accè aux rapports de son service
                }elseif ($_SESSION['NomTypeUser'] == 'Employé finance'){
                    $SqlQueryRapport="SELECT IdRap,TitreRap, DateCreation, EtatRap ,NomType  FROM rapport R, type T WHERE 
                                        r.IdType=T.IdType and LCASE(T.NomType)= 'Financier'";
                }else{
                    $SqlQueryRapport="SELECT IdRap,TitreRap, DateCreation, EtatRap ,NomType  FROM rapport R, type T WHERE 
                                        r.IdType=T.IdType and LCASE(T.NomType)= 'Marketing'";
                }
                $ResultatQueryRapport = mysqli_query($conn,$SqlQueryRapport);
                if ($ResultatQueryRapport!=null){
                    echo("<table>");
                    echo ('<tr>');
                    echo('<td class="t_head"> Titre rapport </td>');
                    echo('<td class="t_head"> Type </td>');
                    echo('<td class="t_head"> Date création  </td>');
                    echo('<td class="t_head"> Etat </td>');
                    echo('<tr>');
                    while($ligne=mysqli_fetch_array($ResultatQueryRapport)){
                        echo("<tr>");
                        $titreRapport = $ligne['TitreRap'];
                        $idRapport = $ligne['IdRap'];
                        echo("<td> <input type='radio'value='$idRapport' name='idRapp'>" . $titreRapport . "</td>");
                        echo("<td>".$ligne["NomType"]."</td>");
                        echo("<td>".$ligne["DateCreation"]."</td>");
                        echo("<td>".$ligne["EtatRap"]."</td>");
                        echo("</tr>");
                    }
                    echo("</table>");
                }
                ?>
            </div>
            <div class="wrap_form_btn_DemmandeRap">
                <button type="submit" class="form_btn m_l_26" name="submit">Consulter</button>

            </div>
            <?php
            //-------------submit-----------
            if (isset($_POST['submit'])) {
                if ( !empty($_POST['idRapp'])) {
                    //Enregistrer l'id du rapport choisi dans la variable session
                    $_SESSION['rapportChoisi'] = $_POST['idRapp'];
                    header("location: AfficherRapport.php");
                } else {
                    echo "<div style=\" padding: 10px ;margin-top: 10px;font-size:90%;font-weight: 300;color: #ff4558\">Veuillez sélectionner un rapport !!</div>";
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

