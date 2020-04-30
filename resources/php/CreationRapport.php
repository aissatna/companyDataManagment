<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Créer rapport</title>
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
        <h2> Création rapport </h2>
        <form class="form_CreationRapport" method="post" action="">
            <div class="wrap_input_CreationRap m_b_26">
                <label for="titreRapp" class="label_input_titreRap">Titre</label>
                <input type="text" id="titreRapp" class="input_titreRap m_l_26" name="titreRapp" required>
            </div>
            <div class="wrap_input_CreationRap m_b_26">
                <label for="typeRapp" class="label_input_TypeRapp">Type</label>
                <?php
                // Les directeurs pourront créer tous type de rapport
                if ($_SESSION['NomTypeUser'] == 'Directeur' or $_SESSION['NomTypeUser'] == 'Directeur ventes'){
                    echo '
                <select id="typeRapp" name="typeRapp" class="selectTypeRapp m_l_26" required>
                    <option selected value="Marketing">Marketing</option>
                    <option value="Financier">Financier</option>
                </select>
                ';
                    //chaque employé poura créér un type particulier de rapport
                }elseif ($_SESSION['NomTypeUser'] == 'Employé finance'){
                    echo '
                    <input id ="typeRapp"type="text" disabled="disabled" value="Financier" name="typeRapp" class="selectTypeRapp m_l_26"/>
                    ';
                }else{
                    echo '
                    <input id ="typeRapp"type="text" disabled="disabled" value="Marketing" name="typeRapp" class="selectTypeRapp m_l_26"/>
                    ';
                }

                ?>

            </div>
            <div class="wrap_form_btn_DemmandeRap">
                <button type="submit" class="form_btn m_l_26" name="submit">Suivant</button>

            </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $_SESSION['titreRapport'] = $_POST['titreRapp'];

        if ($_SESSION['NomTypeUser'] == 'Directeur' or $_SESSION['NomTypeUser'] == 'Directeur ventes'){
                $_SESSION['typeRapport'] = $_POST['typeRapp'];
                header('location:ChoixIndicateurs.php');
        }elseif ($_SESSION['NomTypeUser'] == 'Employé finance'){
            $_SESSION['typeRapport'] = "Financier";
            header('location:ChoixIndicateurs.php');
        }else{
            $_SESSION['typeRapport'] = "Marketing";
            header('location:ChoixIndicateurs.php');
        }
        }
        ?>
    </div>
</div>
        <footer class="container_footer">
            <p>
                Copyright &copy; 2020 by LYFA , All rights reserved .
            </p>
        </footer>

</body>
</html>
