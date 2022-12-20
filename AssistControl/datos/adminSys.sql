create table si
(
    id serial primary key,
    nombre varchar(50) not null,
    descripcion varchar(2500) null,
    version numeric null,
    autor varchar(100) null,
    scriptBD varchar(50) not null
);

create table opcion
(
    id serial primary key,
    nombre varchar(50) not null,
    descripcion varchar(2500) null,
    ruta varchar(100) null,
    idSI int not null references si(id) on delete restrict on update cascade,
    idMenu int null references opcion(id) on delete restrict on update cascade
);

create table perfil
(
    id serial primary key,
    nombre varchar(50) not null,
    descripcion varchar(2500) null
);

create table perfilAcceso
(
    id serial primary key,
    idPerfil int not null references perfil(id) on delete restrict on update cascade,
    idOpcion int not null references opcion(id) on delete restrict on update cascade
);

create table pais
(
    codigo varchar(1000) primary key,
    nombre varchar(50) not null
);

create table departamento
(
    codigo varchar(1000) primary key,
    nombre varchar(50) not null,
    codPais varchar(3) not null references pais(codigo) on delete restrict on update cascade
);

create table ciudad
(
    codigo varchar(1000) primary key,
    nombre varchar(100) not null,
    codDepartamento varchar(2) not null references departamento(codigo) on delete restrict on update cascade
);

create table empresa
(
    id serial primary key,
    nit varchar(20) null,
    razonSocial varchar(100) not null,
    direccion varchar(100) null,
    codCiudad varchar(5) null references ciudad(codigo) on delete restrict on update cascade,
    url varchar(100) null,
    email varchar(100) null,
    css varchar(100) null,
    bd varchar(30) null,
    prefijo varchar(30) null,
    nivelauditoria varchar(1) null,
    idioma varchar(1) null
);

create table persona
(
    id serial primary key,
    nombres varchar(50) not null,
    apellidos varchar(50) not null,
    telefono varchar(20) null,
    email varchar(100) null,
    fechaNacimiento date null
);

create table usuario
(
    usuario varchar(20) primary key,
    clave varchar(100) not null,
    fechaIniciacion timestamp not null,
    fechaFinalizacion timestamp null,
    estado boolean not null,
    idPersona int not null references persona(id) on delete restrict on update cascade,
    idPerfil int not null references perfil(id) on delete restrict on update cascade,
    idEmpresa int not null references empresa(id) on delete restrict on update cascade
);

create table contrato
(
    id serial primary key,
    idSI integer not null references si(id) on delete restrict on update cascade,
    idEmpresa integer not null references empresa(id) on delete restrict on update cascade,
    fechaInicio date not null,
    fechaFin date null,
    valor int8 not null    
);

create table bitacoraauditoria
(
    id serial primary key,
    fecha timestamp not null,
    usuario varchar(20) not null,
    suceso varchar(1) not null,
    ip varchar(30) null,
    detalle text null,
    registroanterior text null,    
    archivo varchar(100) null,
    sesion int references bitacoraauditoria(id) on delete restrict on update cascade
);

create table pqr
(
    id serial primary key,
    tipo varchar(1) not null,
    fecha timestamp not null,
    archivo varchar(100) not null,
    asunto varchar(250) not null,
    descripcion varchar(2500) not null,
    usuario varchar(20) not null references usuario(usuario) on delete cascade on update cascade,
    detallesPlataforma varchar(100) not null
);

create table pqrEstados
(
    id serial primary key,
    idPqr int references pqr(id) on delete restrict on update cascade,
    fecha timestamp not null,
    usuario varchar(20) references usuario(usuario) on delete cascade on update cascade,
    estado varchar(1) not null,
    observaciones varchar(2500) null
);

create table pregunta
(
    id serial primary key,
    enunciado varchar(250) not null,
    tipo varchar(1)
);

create table alternativaRespuesta
(
    id serial primary key,
    texto varchar(250) not null,
    idPregunta int not null references pregunta(id) on delete restrict on update cascade
);

create table encuesta
(
    id serial primary key,
    nombre varchar(100) not null,
    objetivo varchar(250) null,
    descripcion varchar(2500) null
);

create table encuestaPregunta
(
    id serial primary key,
    idEncuesta int not null references encuesta(id) on delete restrict on update cascade,
    idPregunta int not null references pregunta(id) on delete restrict on update cascade
);

create table programacionEncuesta
(
    id serial primary key,
    fechaInicio timestamp not null,
    fechaFin timestamp not null,
    idPerfil int null references perfil(id) on delete restrict on update cascade,
    idEncuesta int references encuesta(id) on delete restrict on update cascade
);

create table respuestaEncuesta
(
    id serial primary key,
    idProgramacionEncuesta int not null references programacionEncuesta(id) on delete restrict on update cascade,
	usuario varchar(20) null references usuario(usuario) on delete restrict on update cascade,
    idPregunta int references pregunta(id) on delete restrict on update cascade,
    alternativaRespuesta varchar(2500) not null,
    fecha timestamp not null
);

create table foro
(
    id serial primary key,
    asunto varchar(250) not null,
    descripcion varchar(250) not null,
    fecha timestamp not null,
    idForo int null references foro(id) on delete restrict on update cascade,
    usuario varchar(20) null references usuario(usuario) on delete restrict on update cascade
);

insert into si(nombre, descripcion, version, autor, scriptbd) values ('Administrador del SI',null,4.0,'Galo Munoz','admonSYS.sql');
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (100,'Sistemas','Sistemas de informacion gestionados por el administrador','admon/si.php',null,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (200,'Empresas','Empresas que tienen accesos al administrador de SI','admon/empresas.php',null,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (300,'Perfiles','Gestion de perfiles de usuarios','admon/perfiles.php',null,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (400,'Usuarios','Gestion de usuarios','admon/usuarios.php',null,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (500,'Configuracion','Otras configuraciones',null,null,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (505,'Paises','Gestion de paises','admon/paises.php',500,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (510,'Ciudades','Gestion de ciudades','admon/ciudades.php',500,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (515,'Departamentos','Gestion de departamentos','admon/departamentos.php',500,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (600,'Gestion de calidad','Gestion de calidad del software',null,null,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (610,'Banco de preguntas','Gestion del banco de preguntas con sus alternativas de respuesta','admon/gestioncalidad/bancoPreguntas.php',600,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (615,'Encuestas','Gestion de encuestas de verificacion de la calidad del software','admon/gestioncalidad/encuestas.php',600,1);
insert into opcion(id,nombre, descripcion, ruta, idMenu, idSI) values (700,'Auditoria','Bitacora de auditoria','admon/bitacoraAuditoria.php',null,1);
insert into perfil(nombre, descripcion) values ('Administrador de SI','Administrador de sistemas de informacion');
insert into perfilAcceso(idperfil, idopcion) values (1, 100);
insert into perfilAcceso(idperfil, idopcion) values (1, 200);
insert into perfilAcceso(idperfil, idopcion) values (1, 300);
insert into perfilAcceso(idperfil, idopcion) values (1, 400);
insert into perfilAcceso(idperfil, idopcion) values (1, 505);
insert into perfilAcceso(idperfil, idopcion) values (1, 510);
insert into perfilAcceso(idperfil, idopcion) values (1, 605);
insert into perfilAcceso(idperfil, idopcion) values (1, 610);
insert into perfilAcceso(idperfil, idopcion) values (1, 615);
insert into perfilAcceso(idperfil, idopcion) values (1, 700);
insert into pais (codigo, nombre) values ('57','Colombia');
insert into departamento(codigo, nombre, codPais) values  ('52','Narino','57');
insert into ciudad(codigo, nombre, codDepartamento) values ('52001','Pasto','52');
insert into empresa (nit, razonSocial, codCiudad, url, email, css, bd, prefijo,nivelauditoria) values ('98390288-2','Xnet Computacion','52001','http://www.xnet.com.co', 'mail@xnet.com.co','xnet.css', 'BASEDATOS', 'admon', '2');
insert into contrato(fechainicio, fechafin, valor, idEmpresa, idSI) values ('2013-02-12',null, 0, 1, 1);
insert into persona(nombres, apellidos, email) values ('Administrador','de Sistemas de Informacion','info@xnet.com.co');
insert into usuario(usuario, clave, estado, idPerfil, idPersona, fechaIniciacion, idEmpresa) values ('admin',md5('utilizar'), true, 1, 1,'2013-02-12',1);
