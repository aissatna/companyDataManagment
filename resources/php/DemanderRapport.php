<!doctype html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" type="text/css" href="../css/style.css">
            <title>Demander un rapport</title>
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
                    if (isset($_SESSION['NomTypeUser'])){
                        if ($_SESSION['NomTypeUser']=='Directeur'){
                            include 'MenuDirecteur.html';
                        }elseif (($_SESSION['NomTypeUser']=='Directeur ventes')){
                            include 'MenuDirecteurVentes.html';
                        }else{
                            include 'MenuEmployé.html';
                        }

                    }
                    ?>
                     <div class="content">
                        <h2> Demander un rapport </h2>
                        <form class="form_DemmandeRapport" method="post" action="">
                        <div class="form_messages" id="js_form_messages"></div>
                        <div class="wrap_input_DemandeRap m_b_26">
                                <label for="contenuDemande" class="label_input_DemRap">Message</label>
                                <textarea class="textArea_DemRap m_l_26" id="contenuDemande" name="contenuDemande"  required></textarea>
                        </div>
                        <div class="wrap_input_DemandeRap m_b_26">
                            <label for="service" class="label_input_DemRap">Service</label>
                            <select id="service" name="service" class="selectService m_l_26" required>
                                <option selected value="service marketing">Marketing</option>
                                <option value="service financier">Financier</option>
                            </select>
                        </div>
                        <div class="wrap_form_btn_DemmandeRap">
                            <button type="submit" class="form_btn m_l_26" name="submit">Envoyer</button>
                        </div>
                    </form>
                        <?php
                    require_once('FonctionsUtils.php');
                    if (isset($_POST['submit'])){
                        if (!empty($_POST['contenuDemande']) && !empty($_POST['service'])){
                            $conn = mysqlConnectDB();
                            // Get entered data and create a legal SQL string that can be used in an SQL statement
                            $ContenuDemande = mysqli_real_escape_string($conn,$_POST['contenuDemande']);
                            $DestinationDem = mysqli_real_escape_string($conn,$_POST['service']);
                            $IdUser =mysqli_real_escape_string($conn,$_SESSION['IdUser']);
                            $sqlQueryInsert = "INSERT INTO demanderapport(ContenuDem,DestinationDem, EtatDem, IdUser) VALUES ('$ContenuDemande','$DestinationDem','en cours',$IdUser)";
                            $resultInsert = mysqli_query($conn,"$sqlQueryInsert");
                            if($resultInsert)
                            //Success
                            {
                                echo '<script type="text/javascript">
                                var div_message = document.getElementById(\'js_form_messages\');
                                div_message.innerHTML += \'Votre demande est envoyée \';
                                div_message.style.backgroundColor=\'#57b846\';
                                </script>';


                            }
                            else
                             //Error
                            {
                                echo '<script type="text/javascript">
                                var div_message = document.getElementById(\'js_form_messages\');
                                div_message.innerHTML += \'Oops ! erreur  .Essayez plus tard \';
                                div_message.style.backgroundColor=\'rgba(209,46,46,0.8)\';
                                </script>';


                            }
                            // Close connection
                            mysqli_close($conn);
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
