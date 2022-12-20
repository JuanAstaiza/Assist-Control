create table perfil(
codigo serial primary key,
nombre varchar(50) not null,
descripcion varchar(2500) null
);

create table cargo (
codigo serial primary key,
nombre varchar(70) not null,
codperfil integer references perfil(codigo) on delete restrict on update cascade
);

create table pais (
codigo integer primary key,
nombre varchar(50) not null
);

create table departamento (
codigo serial primary key,
nombre varchar(100) not null,
codpais integer references pais(codigo) on delete restrict on update cascade
);

create table ciudad (
codigo serial primary key,
nombre varchar(100) not null,
coddepartamento integer references departamento(codigo) on delete restrict on update cascade
);

create table situacion (
codigo serial primary key,
nombre varchar(40)
);

create table tipovinculacion (
codigo serial primary key,
nombre varchar(100)
);

create table areaensenanza (
codigo serial primary key,
nombre varchar(100)
);

create table persona (
foto varchar(200) null,
cedula integer primary key,
fechaexpedicion date not null,
lugarexpedicion varchar(50) not null,
fechanacimiento date not null,
codciudad integer references ciudad(codigo) on delete restrict on update cascade,
primernombre varchar(35) not null,
segundonombre varchar(35) null,
primerapellido varchar(35) not null,
segundoapellido varchar(35) null,
direccionresidencia varchar(50) null,
genero boolean not null,
gruposanguineo integer not null,
profesion varchar(70),
codcargo integer references cargo(codigo) on delete restrict on update cascade,
codtipovinculacion integer references tipovinculacion(codigo) on delete restrict on update cascade,
codareaensenanza integer references areaensenanza(codigo) on delete restrict on update cascade,
email varchar(100) null,
codsituacion integer references situacion(codigo) on delete restrict on update cascade,
estado boolean not null,
telefono varchar(20),
fechaIngreso date,
fechaSalida date
);

create table turno (
cedulapersona integer references persona(cedula) on delete restrict on update cascade,
horainicio time not null,
horafin time not null,
dia integer not null,
descripcion varchar(2500) null
);

create table motivo (
codigo serial primary key,
nombre varchar(100) not null
);

create table permiso (
codigo serial primary key,
cedulapersona integer references persona(cedula) on delete restrict on update cascade,
fechasolicitud date not null,
fechainicio date not null,
fechafin date not null,
codmotivo integer references motivo(codigo) on delete restrict on update cascade,
descripcion varchar(2500) null,
anexo varchar(200) not null
);

create table horaextra (
codigo serial primary key,
cedulapersona integer references persona(cedula) on delete restrict on update cascade,
fechainicio date not null,
horainicio time not null,
fechafin date not null,
horafin time not null,
descripcion varchar(2500) null
);

create table registro (
codigo serial primary key,
cedulapersona integer references persona(cedula) on delete restrict on update cascade,
fecha timestamp not null,
tipo boolean not null
);

create table titulo (
codigo serial primary key,
cedulapersona integer references persona(cedula) on delete restrict on update cascade,
nombre varchar(100),
codniveleducativo integer
);


create table reporte_pdf (
codigo serial primary key,
img_banner varchar(200) not null,
direccion_sede varchar(100) not null,
pagina_web  varchar(100) not null,
telefono varchar(25) not null,
email varchar(100) not null
);

insert into reporte_pdf(img_banner, direccion_sede, pagina_web, telefono, email) values ('banner.jpg','carrera. 4 # 16-180 Sector Potrerillo.','www.iemoraosejo.edu.co','(2) 7219744 - (2) 7219743','luiseduardomoraosejo2011@gmail.com');