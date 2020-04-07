<?php
//Données de la connection
define('host','localhost');
define('login','root');
define('password','');
define('dbName','db_lagardere');

function mysql_connect(){
    // Connexion à la base de donnée
    $connexion = mysqli_connect(host,login,password);
    if ($connexion==null){
        echo '<p> Echec de connection</p>>';
    }else{
        // Sélection de la base de donnée
        if (mysqli_select_db($connexion,dbName)==true){
             echo("Connection réussie");
        }else{
            echo("Cette base n'existe pas");
        }
    }
    return $connexion;
}
?>