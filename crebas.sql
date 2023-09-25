/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     24/09/2023 11:12:39 a.�m.                    */
/*==============================================================*/


drop table if exists Administrador;

drop table if exists Participante;

drop table if exists Qr;

/*==============================================================*/
/* Table: Administrador                                         */
/*==============================================================*/
create table administrador
(
   admcedula            varchar(254),
   admusuario           varchar(254),
   admcontrasena        varchar(254),
   primary key (admcedula)
);

/*==============================================================*/
/* Table: Participante                                          */
/*==============================================================*/
create table participante
(
   parcedula            varchar(254),
   parnombre            varchar(254),
   parfechanacimiento   varchar(254),
   partelefono          varchar(254),
   parcorreo            varchar(254),
   parUni               varchar(254),
   parGenero            varchar(2),
   qrvalido             boolean,
   primary key (parcedula)
);

/*==============================================================*/
/* Table: Qr                                                    */
/*==============================================================*/
create table qr
(
   qrid                 varchar(254),
   qrvalido             boolean,
   primary key (qrid)
);

