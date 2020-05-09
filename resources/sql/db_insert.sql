------------------- TABLE TypeUser -------------------------
insert into TypeUser (IdTypeUser, NomTypeUser)
values (1, 'Directeur'),(2, 'Directeur ventes'),(3, 'Employé finance'),(4, 'Employé marketing');

------------------- TABLE User -------------------------
insert into User (IdUser, IdTypeUser, PseudoUser, PwdUser)
values (1, 1, 'D', '000'),(2, 2, 'DV', '123'),(3, 3, 'EF', '456'),(4, 4, 'EM', '789');

------------------- TABLE DemandeRapport -------------------------
insert into DemandeRapport (IdDem,IdUser, ContenuDem, DestinationDem, EtatDem)
values (1,1, 'Analyse du marché en 2019', 'service marketing', 'en cours'),
(2,2, 'Analyse du marché en 2018', 'service marketing','traitée'),
(3,1, 'Analyse financière en 2019', 'service financier','en cours');

------------------- TABLE Type -------------------------
insert into Type (IdType, NomType) values (1, 'Marketing'),(2, 'Financier');

------------------- TABLE Indicateur -------------------------
insert into Indicateur (IdInd, IType, LibelleInd, RequeteInd)
values (1, 1, 'IndicateurM_1', 'Requete1'),(2, 1, 'IndicateurM_2', 'Requete2'),(3, 1, 'IndicateurM_3', 'Requete3');
,(4, 2, 'IndicateurF_1', 'Requete4'),(5, 2, 'IndicateurF_2', 'Requete5'),(6, 2, 'IndicateurF_3', 'Requete6');

------------------- TABLE Rapport ------------------------- 
insert into Rapport (IdRap, IdType, DateCreation, EtatRap, SyntheseRap, TitreRap)
values (1, 1, '2020/03/01', 'ouvert', 'Synthese1', 'Rapport_Analyse Maketing en 2019'),
 (2, 1, '2019/03/31', 'cloturer', 'Synthese2', 'Rapport_Analyse Maketing en 2018'),
 (3, 2, '2020/03/03', 'soumis', 'Synthese3', 'Rapport_Analyse financière en 2019');;

------------------- TABLE Comporter -------------------------
insert into Comporter (IdRap, IdInd, Analyse)
values (1, 1, 'Analyse1'),(1, 2, 'Analyse2'),(2, 3, 'Analyse3'),(3, 4, 'Analyse4')
,(3, 5, 'Analyse5'),(3, 6, 'Analyse6');

------------------- TABLE Bilan -------------------------
insert into Bilan (IdBilan, TitreBilan, DescriptionBil)
values (1, 'Bilan Marketing 2018', 'Bilan Marketing 2018'),
(2, 'Bilan Marketing 2019', 'Bilan Marketing 2019'),
(3, 'Bilan Finance 2019', 'Bilan Finance 2019');

------------------- TABLE Constituer -------------------------
insert into Constituer (IdBilan, IdRap) values (1, 2),(2, 1),(3, 3);

------------------- TABLE Conmmentaire -------------------------
insert into db_lagardere.commentaire (idRap, IdUser,DateCom, ContenuCom)
values (1, 1,'2020/03/01 13:50:55','Commentaire_création_rapport1')
,(1, 3,'2020/03/01 16:50:26', 'Commentaire_edition_rapport1')
,(2, 1,'2019/03/31 10:30:11', 'Commentaire_création_rapport2')
,(2, 3,'2019/03/31 13:50:28', 'Commentaire_edition_rapport2')
,(2, 2,'2019/03/31 14:00:34', 'Commentaire_soumis_rapport2')
,(2, 1,'2019/03/31 14:10:42', 'Commentaire_validation_rapport2')
,(2, 1,'2019/03/31 14:15:45', 'Commentaire_cloture_rapport2')
,(3, 1,'2020/03/03 11:30:45', 'Commentaire_création_rappor'),
(,3, 2,'2020/03/01 13:20:19', 'Commentaire_soumis_rapport3');