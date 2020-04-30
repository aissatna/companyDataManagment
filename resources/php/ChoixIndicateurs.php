<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Choix indicateurs </title>
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
        <h2> Choix indicateurs  </h2>
        <form class="form_ChoixIndicateurs" method="post" action="">
            <div class="wrap_input_Indicateurs m_b_26">
                <?php
                require_once ('FonctionsUtils.php');
                if (isset($_SESSION['titreRapport']) && isset($_SESSION['typeRapport'] )) {
                    $connDB=mysqlConnectDB();
                    // ----------La liste des indicateurs  correspondant au type rapport  --------------
                    $sqlQueryIndicateurs="SELECT I.IdInd as 'idInd',I.LibelleInd as 'LibelleInd'FROM indicateur I,type T WHERE I.IdType = T.IdType AND LCASE(T.NomType) = '".$_SESSION['typeRapport']."'";
                    $resultIndicateurs = mysqli_query($connDB,$sqlQueryIndicateurs);
                    if ($resultIndicateurs!= null){
                        while ($ligne= mysqli_fetch_array($resultIndicateurs)){
                            $idIndicateur = $ligne['idInd'];
                            $libelleIndicateur= $ligne['LibelleInd'];
                            echo "<div class='m_b_18'><input type='checkbox' style='margin-right: 10px ;height: 13px ;width: 15px' name= \"indicateurs[]\"value=$idIndicateur>
                        <label class='libelleIndicateur'>$libelleIndicateur</label></div>";
                        }
                    }
                }
                // Close connection
                mysqli_close($connDB);
                ?>
            </div>
            <div class="wrap_form_btn_DemmandeRap">
                <button type="submit" class="form_btn m_l_26" name="submit">Suivant</button>

            </div>
            <?php
            //-------------submit-----------
            if (isset($_POST['submit'])) {
                if ( !empty($_POST['indicateurs'])) {
                    $_SESSION['indicateurs'] = $_POST['indicateurs'];
                    header("location:ConfirmationCreationRapp.php");


                } else {
                    echo "<div style=\" padding: 10px ;margin-top: 10px;font-size:90%;font-weight: 300;color: #ff4558\">
                        Veuillez sélectionner au moins un indicateur !!</div>";
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

