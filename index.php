<!doctype html>
    <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <!-- stylesheet link -->
                <link rel="stylesheet" type="text/css" href="resources/css/style.css">
                <title>Connexion</title>

            </head>
            <body>
                <div class="limiter_login">
                    <div class="container_login">
                        <div class="wrap_login">
                            <div class="login_title">
                        <span class="login_title_text">
                            Sign In
                        </span>
                            </div>
                            <form class="login_form" method="post" action="">
                                <div class="wrap_input m_b_26">
                                    <label for="userName" class="label_input">Username</label>
                                    <input type="text" id="userName" name="userName" class="input_field"  placeholder="Enter username" required>
                                    <span class="focus_input"></span>
                                </div>
                                <div class="wrap_input m_b_18">
                                    <label for="passWord" class="label_input">Password</label>
                                    <input type="password" id="passWord" name="passWord" class="input_field"  placeholder="Enter password" required>
                                    <span class="focus_input"></span>
                                </div>
                                <div class="wrap_form_btn">
                                    <button type="submit" class="form_btn" name="submit"> Login</button>
                                </div>
                                <!-- div pour afficher un message en cas d'erreur-->
                                <div id="js_error" style=" padding: 10px ;margin-top: 10px;font-size:90%;font-weight: 300;color: #ff4558">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <?php
                require_once('resources/php/FonctionsUtils.php');
                if (isset($_POST['submit'])) {
                    if (!empty($_POST['userName'])&& !empty($_POST['passWord'])) {
                        session_start();
                        $conn= mysqlConnectDB();
                        // Check si le pseudo et le mot de passe sont corrects
                        $sqlQueryUser = "select IdUser from user where PseudoUser='".$_POST['userName']."'and PwdUser = '".$_POST['passWord']."'";
                        $resultQueryUser = mysqli_query($conn,$sqlQueryUser);
                        if (mysqli_num_rows($resultQueryUser) == 1 && $resultQueryUser!=null){
                            $row = mysqli_fetch_array($resultQueryUser);
                            $_SESSION['IdUser']= $row['IdUser'];
                            // get type of user pour afficher le menu lui correspond
                            $sqlQueryTypeUser="select NomTypeUser from user u ,typeuser t where u.IdTypeUser=t.IdTypeUser and u.IdTypeUser = ". $_SESSION['IdUser'];
                            $resultQueryTypeUser = mysqli_query($conn,$sqlQueryTypeUser);
                            $row=mysqli_fetch_array($resultQueryTypeUser);
                            $_SESSION['NomTypeUser'] = $row['NomTypeUser'];
                            header('location:resources/php/Acceuil.php');
                        }else{
                            // erreur dans les identifiants
                            echo '<script type="text/javascript">
                            var div_erreur = document.getElementById(\'js_error\');
                            div_erreur.innerHTML += \'Oops ! username or password incorrect \';
                            </script>';
                        }
                    }
                }
                // Close connection
                mysqli_close($conn);
                ?>
            </body>
    </html>