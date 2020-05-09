## Projet Societe Lagardere Active
Développement d'un site web dynamique intranet permettant l’édition et la validation des rapports d’analyses marketing et financiers.


![demo_lagardere](https://user-images.githubusercontent.com/37422000/81479280-94ba4480-9222-11ea-8110-649dfec69273.gif)
### Avant de lancer le site vous devez :

**1.** Créer l’entrepôt de données sous SQL server en utilisant le fichier
« ED Lagardere.bacpac » pour cela suivez les étapes expliqué dans cette vidéo : https://www.youtube.com/watch?v=QdKOqlD_3jw
       
**2.** Télécharger le pilote Php SQL Server disponible sur ce lien
 https://docs.microsoft.com/fr-fr/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver15
 
**3.** Suivez les étapes dans cette vidéo pour la configuration du pilote : https://www.youtube.com/watch?v=gyFVT72t55c

**4.** Créer la base de données sous MySQL en utilisant le scripte « db_lagardere.sql » qui se trouve dans "/resources/sql"

**5.** Changer les paramètres de la connexion (Nom de serveur, mot de passe, utilisateur, nom de la base) des serveur (MySQL et SQL server) 
dans la page « ressources /PHP /FonctionsUtils.php »

**6.** Lancer le site sur la page « index.html »

### Les identifiants des utilisateurs :

| Poste            | Username | Password |
| -------------    |:--------:| --------:|
|Directeur         |D         |  000     |
| Directeur ventes |DV        |  123     |
|Employé finance   | EF       | 456      |
|Employé marketing | EM       | 789      |



