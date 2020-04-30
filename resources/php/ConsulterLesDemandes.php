<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title> Consulter les demandes </title>
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
        <h2> Liste des demandes  </h2>
        <form class="form_ListeRaports m_b_26" method="post" action="">
            <div class="wrap_input_CreationRap m_b_26">
                <?php
                require_once('FonctionsUtils.php');
                $conn = mysqlConnectDB();
                //  Chaque employé aura accès aux demandes destinées à son service
                if ($_SESSION['NomTypeUser'] == 'Employé finance'){
                    $SqlQueryDemande="SELECT IdDem,ContenuDem, EtatDem , NomTypeUser from demanderapport d,user u,typeuser t WHERE  
                    d.IdUser=u.IdUser and u.IdTypeUser=t.IdTypeUser and LCASE (d.DestinationDem )=\"Service Financier\" ";
                }else{
                    $SqlQueryDemande="SELECT IdDem,ContenuDem, EtatDem , NomTypeUser from demanderapport d,user u,typeuser t WHERE  
                    d.IdUser=u.IdUser and u.IdTypeUser=t.IdTypeUser and LCASE (d.DestinationDem )=\"Service Marketing\"  ";
                }
                $ResultatQueryDemande = mysqli_query($conn,$SqlQueryDemande);
                if ($ResultatQueryDemande!=null){
                    echo("<table>");
                    echo ('<tr>');
                    echo('<td class="t_head"> Contenu Demande</td>');
                    echo('<td class="t_head"> Etat demande </td>');
                    echo('<td class="t_head"> Demandeur  </td>');

                    echo('<tr>');
                    while($ligne=mysqli_fetch_array($ResultatQueryDemande)){
                        echo("<tr>");
                        $ContenuDem= $ligne['ContenuDem'];
                        $IdDem = $ligne['IdDem'];
                        // ajouter un boutton radio pour les demandes non traitées afin de changer leur état
                        if ($ligne["EtatDem"] == 'en cours'){
                            echo("<td><input type='radio' name= \"demandeChoisie\"  value='$IdDem' 
                        style='margin-right: 10px;width: 15px;height: 13px'>" . $ContenuDem . "</td>");
                        }else{
                            echo("<td>".$ContenuDem."</td>");
                        }
                        echo("<td>".$ligne["EtatDem"]."</td>");
                        echo("<td>".$ligne["NomTypeUser"]."</td>");
                        echo("</tr>");
                    }
                    echo("</table>");

                }

                ?>
            </div>
            <div class="wrap_form_btn_DemmandeRap">
                <button type="submit" class="form_btn m_l_26" name="submit">Traitée</button>

            </div>
            <?php
            //-------------submit-----------
            if (isset($_POST['submit'])) {
                if ( !empty($_POST['demandeChoisie'])) {
                    //mettre a jour l'etat de la demande
                    $SqlQueryUpadateDemande= "UPDATE demanderapport SET EtatDem='traitée' WHERE IdDem =".$_POST['demandeChoisie'];
                    $ResultatQueryUpadatDemande = mysqli_query($conn,$SqlQueryUpadateDemande);
                    if ($ResultatQueryUpadatDemande==false){
                        echo "Erreur dans la mise a jour : " . mysqli_error($conn);
                    }
                    // Rederiction vers la page création rapport pour le traitement de la demande
                    header("location:CreationRapport.php");
                } else {
                    echo "<div style=\" padding: 10px ;margin-top: 10px;font-size:90%;font-weight: 300;color: #ff4558\">
                        Veuillez sélectionner une demande !!</div>";
                }
            }
            // Close connection
            mysqli_close($conn);
            ?>
        </form>

        <footer class="container_footer">
            <p>
                Copyright &copy; 2020 by LYFA , All rights reserved .
            </p>
        </footer>

</body>
</html>

