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
session_start();
if (isset($_SESSION['typeUser'])){
    if ($_SESSION['typeUser']=='D'){
        include 'NavDirecteur.php';
    }elseif (($_SESSION['typeUser']=='DV')){
        include 'NavDirecteurVentes.php';
    }else{
        include 'NavEmploye.php';
    }

}
?>
<div class="content">
    <h2> Demmander un rapport </h2>

    <form class="form_DemmandeRapport" method="post" action="">
        <div class="wrap_input_DemmandeRap m_b_26">
            <label for="MessageDemmande" class="label_input_DemRap">Message</label>
           <textarea class="textArea_DemRap m_l_26" id="MessageDemmande" ></textarea>

        </div>
        <div class="wrap_input_DemmandeRap m_b_26">
            <label for="service" class="label_input_DemRap">Service</label>
            <select id="service" name="service" class="select_DemRap m_l_26">
                <option selected value="marketing">Marketing</option>
                <option value="financier">Financier</option>

            </select>

        </div>
        <div class="wrap_form_btn_DemmandeRap">
            <button type="submit" class="form_btn m_l_26" name="submit">Envoyer</button>

        </div>
    </form>
</div>

<footer class="container_footer">
    <p>
        Copyright &copy; 2020 by LYFA , All rights reserved .
    </p>
</footer>

</body>
</html>
