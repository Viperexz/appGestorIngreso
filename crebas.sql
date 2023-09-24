/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     24/09/2023 11:12:39 a. m.                    */
/*==============================================================*/


drop table if exists Administrador;

drop table if exists Participante;

drop table if exists Qr;

/*==============================================================*/
/* Table: Administrador                                         */
/*==============================================================*/
create table Administrador
(
   admCedula            varchar(254),
   admUsuario           varchar(254),
   admContrasena        varchar(254)
);

/*==============================================================*/
/* Table: Participante                                          */
/*==============================================================*/
create table Participante
(
   parCedula            varchar(254),
   parNombre            varchar(254),
   parFechaNacimiento   varchar(254),
   parTelefono          varchar(254),
   parCorreo            varchar(254)
);

/*==============================================================*/
/* Table: Qr                                                    */
/*==============================================================*/
create table Qr
(
   qrID                 varchar(254),
   qrValido             bool
);

