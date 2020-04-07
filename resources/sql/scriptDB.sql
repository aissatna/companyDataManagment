create table bilan
(
    idBilan        int auto_increment
        primary key,
    TitreBilan     varchar(100) not null,
    DescriptionBil varchar(255) null
);

create table type
(
    idType  int auto_increment
        primary key,
    NomType varchar(30) not null
);

create table indicateur
(
    IdInd      int auto_increment
        primary key,
    LibelleInd varchar(50)  not null,
    RequeteInd varchar(255) not null,
    IdType     int          null,
    constraint Indicateur_type_idType_fk
        foreign key (IdType) references type (idType)
            on delete cascade
);

create table rapport
(
    IdRap        int auto_increment
        primary key,
    TitreRap     varchar(100) not null,
    DateCreation date         not null,
    EtatRap      varchar(30)  not null,
    SyntheseRap  varchar(255) null,
    IdType       int          not null,
    constraint Rapport_type_idType_fk
        foreign key (IdType) references type (idType)
            on delete cascade
);

create table comporter
(
    IdRap   int          not null,
    IdInd   int          not null,
    Analyse varchar(255) not null,
    primary key (IdRap, IdInd),
    constraint Comporter_indicateur_IdInd_fk
        foreign key (IdInd) references indicateur (IdInd)
            on delete cascade,
    constraint Comporter_rapport_IdRap_fk
        foreign key (IdRap) references rapport (IdRap)
            on delete cascade
);

create table constituer
(
    IdBilan int not null,
    IdRap   int not null,
    primary key (IdBilan, IdRap),
    constraint Constituer_bilan_idBilan_fk
        foreign key (IdBilan) references bilan (idBilan)
            on delete cascade,
    constraint Constituer_rapport_IdRap_fk
        foreign key (IdRap) references rapport (IdRap)
            on delete cascade
);

create table typeuser
(
    IdTypeUser  int auto_increment
        primary key,
    NomTypeUser varchar(30) not null
);

create table user
(
    IdUser     int auto_increment
        primary key,
    PseudoUser varchar(30) not null,
    PwdUser    varchar(30) not null,
    IdTypeUser int         null,
    constraint User_PseudoUser_uindex
        unique (PseudoUser),
    constraint User_typeuser_IdTypeUser_fk
        foreign key (IdTypeUser) references typeuser (IdTypeUser)
            on delete cascade
);

create table commentaire
(
    IdRap      int          not null,
    IdUser     int          not null,
    DateCom    datetime     not null,
    ContenuCom varchar(255) not null,
    primary key (IdRap, IdUser, DateCom),
    constraint `Commentaire _rapport_IdRap_fk`
        foreign key (IdRap) references rapport (IdRap)
            on delete cascade,
    constraint `Commentaire _user_IdUser_fk`
        foreign key (IdUser) references user (IdUser)
            on delete cascade
);

create table demanderapport
(
    IdDem          int auto_increment
        primary key,
    ContenuDem     varchar(255) not null,
    DestinationDem varchar(30)  not null,
    EtatDem        varchar(30)  not null,
    IdUser         int          not null,
    constraint DemandeRapport_user_IdUser_fk
        foreign key (IdUser) references user (IdUser)
            on delete cascade
);


