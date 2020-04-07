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
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])){
if(!empty($_POST['userName'])) {
    session_start();
    $_SESSION['typeUser'] = $_POST['userName'];
    header('location:resources/php/Acceuil.php');
}
}


?>
</body>
</html>