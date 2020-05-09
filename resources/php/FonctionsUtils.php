<?php

//Données de la connection a la BD
define('host', 'localhost');
define('login', 'root');
define('password', '');
define('dbName', 'db_lagardere');
// Fonction pour la connexion a la BD de l'application
function mysqlConnectDB()
    {
    // Connexion à la base de donnée
        $connDB = mysqli_connect(host, login, password, dbName);
    // Check connection
        if ($connDB === false) {
            die("ERROR: Could not connect DB. " . mysqli_connect_error());
        } else {
            return $connDB;
        }
    }

//Fonction pour la connexion a l'entrepôt de données sous sql server
function sqlServerConnectDB()
{
    $serverName = "DESKTOP-C8RQSP8";
    $connectionInfo = array("Database" => "ED_Lagardere", "CharacterSet" => "UTF-8");
// Vu que userName et password ne sont pas spécifiés dans le tableau $connectionInfo,
// la connexion va tenter d'utiliser l'authentification Windows.Pour spécifié UserName et password
// $connectionInfo = array( "Database"=>"dbName", "UID"=>"userName", "PWD"=>"password") Pour spécifié UserName et password;
    $connED = sqlsrv_connect($serverName, $connectionInfo);

    if ($connED) {
        //echo "Connexion établie.<br />";
        return $connED;
    } else {
        //echo "La connexion n'a pu être établie.<br />";
        die("ERROR: Could not connect EB. " . sqlsrv_errors());
    }
}

function affichageResultatIndicateur($IdIndicateur)
    {
        // connexion l'entrepôt de données
        $connED = sqlServerConnectDB();
        switch ($IdIndicateur) {
            //---------------indicateur nombre d'abonnements par année----------
            case 1:
                $SqlQuery = 'SELECT year(DateDeb) as "Année", count(CodeC) as "Nombre_abonnés" FROM Abonner GROUP BY year(DateDeb)';
                $ResultatQuery = sqlsrv_query($connED, $SqlQuery);
                $Année = '';
                $Nombre_abonnés = '';
                while ($ligne = sqlsrv_fetch_array($ResultatQuery)) {
                    $Année .= '<td>' . $ligne['Année'] . '</td>';
                    $Nombre_abonnés .= '<td>' . $ligne["Nombre_abonnés"] . '</td>';
                }
                echo '
                <table>     
                 <tr>
                    <td class="t_head">Année</td>' . $Année . '
                   </tr>
                 <tr>
                    <td class="t_head">Nombre abonnés</td>' . $Nombre_abonnés . '
                 </tr>
                </table> 
                ';
                break;
            // ------------indicateur nombre d'abonnements par type de publication-----------
            case 2:
                $SqlQuery = 'SELECT tp.NomTY as "Type_pub", count(a.CodeC) as "Nombre_abonnés" FROM TypePU tp, Publication p
                            , Abonner a WHERE tp.CodeTY = p.CodeTY AND p.CodePU = a.CodePU GROUP BY tp.CodeTY, tp.NomTY';
                $ResultatQuery = sqlsrv_query($connED, $SqlQuery);
                echo("<table>");
                echo('<tr>');
                echo('<td class="t_head"> Type de publication </td>');
                echo('<td class="t_head"> Nombre abonnés </td>');
                echo('<tr>');
                while ($ligne = sqlsrv_fetch_array($ResultatQuery)) {
                    echo("<tr>");
                    echo('<td>' . $ligne['Type_pub'] . "</td>");
                    echo("<td>" . $ligne["Nombre_abonnés"] . "</td>");
                    echo("</tr>");
                }
                echo("</table>");
                break;
            //-------- Indicateur nombre de pays diffusant chaque publication--------------
            case 3:
                $SqlQuery = 'SELECT P.NomPU as "pub", count(pa.CodeP) as "nb_pays" 
                FROM publication p, payer pa WHERE p.CodePU = pa.CodePU GROUP BY p.CodePU, p.NomPU';
                $ResultatQuery = sqlsrv_query($connED, $SqlQuery);
                echo("<table>");
                echo('<tr>');
                echo('<td class="t_head"> Publication </td>');
                echo('<td class="t_head"> Nombre de pays </td>');
                echo('<tr>');
                while ($ligne = sqlsrv_fetch_array($ResultatQuery)) {
                    echo("<tr>");
                    echo('<td>' . $ligne['pub'] . "</td>");
                    echo("<td>" . $ligne["nb_pays"] . "</td>");
                    echo("</tr>");
                }
                echo("</table>");
                break;
             //----------Prix maximum et prix minimum de vente par publication---------------------
            case 4:
                // Il faut utiliser FORMAT(max(pa.PrixNumPublic), 'C', 'de-de') pour formater l'affichage des prix
                // sous sqlServe le type money return 4 digits aprés la virgule :18,0000
                $SqlQuery ='SELECT P.NomPU as "pub", FORMAT(max(pa.PrixNumPublic), \'C\', \'de-de\') as "Prix_max",
                            FORMAT(min(pa.PrixNumPublic), \'C\', \'de-de\') as "Prix_min"
                            FROM publication p, payer pa WHERE p.CodePU = pa.CodePU GROUP BY p.CodePU, p.NomPU';
                $ResultatQuery= sqlsrv_query($connED,$SqlQuery);
                echo("<table border=1>");
                echo ('<tr>');
                echo('<td class="t_head"> Publication </td>');
                echo('<td class="t_head"> Prix maximum </td>');
                echo('<td class="t_head"> Prix minimum </td>');
                echo('<tr>');
                while($ligne=sqlsrv_fetch_array($ResultatQuery)){
                    echo("<tr>");
                    echo('<td>'.$ligne['pub']."</td>");
                    echo("<td>".$ligne["Prix_max"]." </td>");
                    echo("<td>".$ligne["Prix_min"]." </td>");
                    echo("</tr>");
                }
                echo("</table>");
            break;
            //-----------------Montant des abonnements par type de publication----------------------
            case 5:
                $SqlQuery='SELECT tp.NomTY as "Type_pub", FORMAT(sum(a.PrixNumAb*a.Nbnum), \'C\', \'de-de\') as "montant_abo" FROM TypePU tp, Publication p, Abonner a 
                        WHERE tp.CodeTY = p.CodeTY AND p.CodePU = a.CodePU GROUP BY tp.CodeTY, tp.NomTY';
                $ResultatQuery= sqlsrv_query($connED,$SqlQuery);
                echo("<table>");
                echo ('<tr>');
                echo('<td class="t_head"> Type de publication </td>');
                echo('<td class="t_head"> Montant abonnements </td>');
                echo('<tr>');
                while($ligne=sqlsrv_fetch_array($ResultatQuery)){
                    echo("<tr>");
                    echo('<td>'.$ligne['Type_pub']."</td>");
                    echo("<td>".$ligne["montant_abo"]."</td>");
                    echo("</tr>");
                }
                echo("</table>");
                break;
            //--------Montant dépensé par publication------------------------------------
            case 6:
                $SqlQuery='SELECT p.NomPU as "pub",FORMAT( sum(ca.ForfaitArt * NbArt+t.PrixCar * ea.Nbcar), \'C\', \'de-de\')
                as "Dépenses" FROM TypeJour t, Journaliste j, EcrireArticle ea, Numero n, Publication p, CoutArticle ca WHERE 
                t.CodeTYJ = j.CodeTYJ AND j.CodeJ = ea.CodeJ AND ea.CodeRU = ca.CodeRU AND ea.CodeNO = n.CodeNO AND 
                n.CodePU = p.CodePU AND p.CodePU = ca.CodePU AND ca.CodeJ = j.CodeJ GROUP BY p.CodePU, p.NomPU';
                $ResultatQuery= sqlsrv_query($connED,$SqlQuery);
                echo("<table>");
                echo ('<tr>');
                echo('<td class="t_head"> Publication </td>');
                echo('<td class="t_head"> Montant dépensé </td>');
                echo('<tr>');
                while($ligne=sqlsrv_fetch_array($ResultatQuery)){
                    echo("<tr>");
                    echo('<td>'.$ligne['pub']."</td>");
                    echo("<td>".$ligne["Dépenses"]."</td>");
                    echo("</tr>");
                }
                echo("</table>");
                break;

        }
        sqlsrv_close($connED);
    }

?>

