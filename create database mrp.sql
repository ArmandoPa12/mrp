create database mrp;

create table permiso
(
	id serial primary key,
	nombre varchar(40) not null
);

create table rol
(
	id serial primary key,
	nombre varchar(40) not null,
	funcion varchar(250) not null,
	responsabilidad varchar(250) not null
);

create table rol_permiso
(
	rol_id integer,
	permiso_id integer,
	primary key(rol_id,permiso_id),
	foreign key (rol_id) references rol(id) on delete cascade on update cascade,
	foreign key (permiso_id) references permiso(id) on delete cascade on update cascade
);
-- +++++++++++++++++++++++++++++++++++++++++
create table persona
(
	id serial primary key,
	nombre varchar(60) not null,
	apellido_p varchar(50),
	apellido_m varchar(50),
	correo varchar(250) not null,
	nacimiento date not null,
	celular VARCHAR(20) not null,
	imagen VARCHAR(250)
);

create table usuario
(
	id serial primary key,
	rol_id integer not null,
	persona_id integer,
	username varchar(100) not null,
	password varchar(255) not null,
	foreign key (rol_id) references rol(id)on delete cascade on update cascade,
	foreign key (persona_id) references persona(id)on delete cascade on update cascade
);
-- +++++++++++++++++++++
create table tipo_ubicacion
(
	id serial primary key,
	nombre varchar(100) not null
);
create table ubicacion
(
	id serial primary key,
	tipo_id integer,
	direccion varchar(200) not null,
	cant_estantes integer not null,
	foreign key (tipo_id) references tipo_ubicacion(id)on delete cascade on update cascade
);
create table estante
(
	id serial primary key,
	ubicacion_id integer,
	cant_fila integer not null,
	foreign key (ubicacion_id) references ubicacion(id)on delete cascade on update cascade
);


CREATE OR REPLACE FUNCTION actualizar_cant_estantes()
RETURNS TRIGGER AS $$
BEGIN
    -- Si se realiza una inserción
    IF TG_OP = 'INSERT' THEN
        UPDATE ubicacion
        SET cant_estantes = cant_estantes + 1
        WHERE id = NEW.ubicacion_id;
    -- Si se realiza una eliminación
    ELSIF TG_OP = 'DELETE' THEN
        UPDATE ubicacion
        SET cant_estantes = cant_estantes - 1
        WHERE id = OLD.ubicacion_id;
    -- Si se realiza una actualización
    ELSIF TG_OP = 'UPDATE' THEN
        -- Primero, restar de la ubicación anterior
        IF OLD.ubicacion_id IS DISTINCT FROM NEW.ubicacion_id THEN
            UPDATE ubicacion
            SET cant_estantes = cant_estantes - 1
            WHERE id = OLD.ubicacion_id;
            -- Luego, sumar a la nueva ubicación
            UPDATE ubicacion
            SET cant_estantes = cant_estantes + 1
            WHERE id = NEW.ubicacion_id;
        END IF;
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_actualizar_cant_estantes
AFTER INSERT OR UPDATE OR DELETE ON estante
FOR EACH ROW
EXECUTE FUNCTION actualizar_cant_estantes();
-- ++++++++++++++++
create table tipo_articulo
(
	id serial primary key,
	nombre varchar(100) not null
);
create table articulo
(
		id serial primary key,
		nombre varchar(100) not null,
		descripcion varchar(250) not null,
		fecha_creacion DATE not null,
		fecha_vencimiento date not null,
		cantidad int not null DEFAULT 0,
		tipo_id integer not null,
		serie varchar not null,
	    imagen VARCHAR(250),
		foreign key (tipo_id) references tipo_articulo(id) on delete cascade on update cascade
	);
	create table lista_materiales
	(
		id serial primary key,
		producto_id int not null,
		material_id int not null,
		cantidad int not null,
		foreign key (material_id) references articulo(id) on delete cascade on update cascade,
		foreign key (producto_id) references articulo(id) on delete cascade on update cascade
	);
--- +++++++++
create table proceso
(
	id serial primary key,
	nombre varchar(100) not null,
	descripcion varchar(150) not null
);
create table lista_proceso
(
	producto_id integer,
	proceso_id integer,
	lista_materiales_id integer null,
	paso integer not null,
	tiempo time not null,
	foreign key (producto_id) references articulo(id)on delete cascade on update cascade,
	foreign key (proceso_id) references articulo(id)on delete cascade on update cascade,
	foreign key (lista_materiales_id) references lista_materiales(id)on delete cascade on update cascade
);
create table ubicacion_articulo
(
	id serial primary key,
	estante_id integer,
	articulo_id integer,
	fila integer not null,
	cant_articulo integer not null,
	foreign key (estante_id) references estante(id)on delete cascade on update cascade,
	foreign key (articulo_id) references articulo(id)on delete cascade on update cascade
);

CREATE OR REPLACE FUNCTION actualizar_cant_estantes()
RETURNS TRIGGER AS $$
BEGIN
    -- Si se realiza una inserción
    IF TG_OP = 'INSERT' THEN
        UPDATE ubicacion
        SET cant_estantes = cant_estantes + 1
        WHERE id = NEW.ubicacion_id;
    -- Si se realiza una eliminación
    ELSIF TG_OP = 'DELETE' THEN
        UPDATE ubicacion
        SET cant_estantes = cant_estantes - 1
        WHERE id = OLD.ubicacion_id;
    -- Si se realiza una actualización
    ELSIF TG_OP = 'UPDATE' THEN
        -- Primero, restar de la ubicación anterior
        IF OLD.ubicacion_id IS DISTINCT FROM NEW.ubicacion_id THEN
            UPDATE ubicacion
            SET cant_estantes = cant_estantes - 1
            WHERE id = OLD.ubicacion_id;
            -- Luego, sumar a la nueva ubicación
            UPDATE ubicacion
            SET cant_estantes = cant_estantes + 1
            WHERE id = NEW.ubicacion_id;
        END IF;
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_actualizar_cant_estantes
AFTER INSERT OR UPDATE OR DELETE ON estante
FOR EACH ROW
EXECUTE FUNCTION actualizar_cant_estantes();

-- +++++++++
create table estado_orden_produccion
(
	id serial primary key,
	descripcion varchar(50)
);
create table orden_produccion
(
	id serial primary key,
	usuario_id_ge integer,
	usuario_id_tr integer,
	estado_produccion_id integer,
	fechar_hora timestamp not null,
	pdf_data varchar(250) null,
	file_name varchar(250) null,
	mime_type varchar(250) null,
	foreign key (usuario_id_ge) references usuario(id)on delete cascade on update cascade,
	foreign key (usuario_id_tr) references usuario(id)on delete cascade on update cascade,
	foreign key (estado_produccion_id) references estado_orden_produccion(id)on delete cascade on update cascade
);
-- +++++++++++++++++++++
create table proveedor
(
	id serial primary key,
	articulo_id integer,
	nombre varchar(100) not null,
	apellido varchar(100) not null,
	celular varchar(20) not null,
	empresa varchar(100) not null,
	foreign key (articulo_id) references articulo(id)on delete cascade on update cascade
);
-- +++++++
create table estado_orden_compra
(
	id serial primary key,
	descripcion varchar(50)
);
create table orden_compra
(
	id serial primary key,
	usuario_id_gen integer,
	usuario_id_ges integer,
	proveedor_id integer,
	estado_compra_id integer,
	fecha_hora timestamp not null,
	pdf_data varchar(250) null,
	file_name varchar(250) null,
	mime_type varchar(250) null,
	foreign key (usuario_id_gen) references usuario(id)on delete cascade on update cascade,
	foreign key (usuario_id_ges) references usuario(id)on delete cascade on update cascade,
	foreign key (estado_compra_id) references estado_orden_compra(id)on delete cascade on update cascade,
	foreign key (proveedor_id) references proveedor(id)on delete cascade on update cascade
);


-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into permiso(nombre)values('usuario.ver');
insert into permiso(nombre)values('usuario.crear');
insert into permiso(nombre)values('usuario.editar');
insert into permiso(nombre)values('usuario.eliminar');
insert into permiso(nombre)values('rol.ver');
insert into permiso(nombre)values('rol.crear');
insert into permiso(nombre)values('rol.editar');
insert into permiso(nombre)values('rol.eliminar');
insert into permiso(nombre)values('sucursal.ver');
insert into permiso(nombre)values('sucursal.crear');
insert into permiso(nombre)values('sucursal.editar');
insert into permiso(nombre)values('sucursal.eliminar');
insert into permiso(nombre)values('filas.ver');
insert into permiso(nombre)values('filas.crear');
insert into permiso(nombre)values('filas.editar');
insert into permiso(nombre)values('filas.eliminar');
insert into permiso(nombre)values('estantes.ver');
insert into permiso(nombre)values('estantes.crear');
insert into permiso(nombre)values('estantes.editar');
insert into permiso(nombre)values('estantes.eliminar');
insert into permiso(nombre)values('tipo-articulo.ver');
insert into permiso(nombre)values('tipo-articulo.crear');
insert into permiso(nombre)values('tipo-articulo.editar');
insert into permiso(nombre)values('tipo-articulo.eliminar');
insert into permiso(nombre)values('articulo.ver');
insert into permiso(nombre)values('articulo.crear');
insert into permiso(nombre)values('articulo.editar');
insert into permiso(nombre)values('articulo.eliminar');
insert into permiso(nombre)values('inventario.ver');
insert into permiso(nombre)values('inventario.crear');
insert into permiso(nombre)values('inventario.editar');
insert into permiso(nombre)values('inventario.eliminar');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into rol(nombre,funcion,responsabilidad) values('Administrador del sistema','Configurar y mantener el sistema MRP. Gestionar los permisos de usuario y la seguridad del sistema. Supervisar las actualizaciones y el mantenimiento del software.','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Planificador de Producción','Crear y mantener el plan maestro de producción. Determinar las necesidades de materiales basándose en las órdenes de producción. Coordinar con otros departamentos para asegurar el cumplimiento de los plazos de producción.','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Comprador','Gestionar las compras de materiales y componentes necesarios para la producción. Seleccionar y negociar con proveedores. Asegurar que los materiales se reciban a tiempo y cumplan con los estándares de calidad.','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Gestor de Inventario','Mantener los niveles de inventario óptimos para evitar tanto faltantes como excesos. Controlar el movimiento de materiales dentro y fuera del almacén. Asegurar la precisión de los registros de inventario.','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Supervisor de Producción','Supervisar las operaciones diarias de producción. Asegurar que la producción se realice según el plan establecido. Resolver problemas operativos y asegurar la calidad del producto.','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Ingeniero de Procesos','Diseñar y mejorar los procesos de producción. Asegurar que los procesos sean eficientes y cumplan con los estándares de calidad.','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Reponedor','Se encarga de reponer el inventario y articulos','responsabilidad');
insert into rol(nombre,funcion,responsabilidad) values('Carpintero','Se encarga de los procesos','responsabilidad');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into rol_permiso(rol_id,permiso_id)values(1,1);
insert into rol_permiso(rol_id,permiso_id)values(1,2);
insert into rol_permiso(rol_id,permiso_id)values(1,3);
insert into rol_permiso(rol_id,permiso_id)values(1,4);
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into persona(nombre,apellido_p,apellido_m,correo,nacimiento,celular,imagen)values('admin','root','root','a@g.com',now(),'70015141','raiz/iamgen'); --1
insert into persona(nombre,apellido_p,apellido_m,correo,nacimiento,celular,imagen)values('Jose','Garcia','Robles','b@g.com',now(),'70025252','raiz/iamgen2'); --2
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into usuario(persona_id,rol_id,username,password)values(1,1,'root','123456');
insert into usuario(persona_id,rol_id,username,password)values(2,2,'admin','123456');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into tipo_ubicacion(nombre)values('tienda');
insert into tipo_ubicacion(nombre)values('almacen');
insert into tipo_ubicacion(nombre)values('fabrica');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into ubicacion(tipo_id,direccion,cant_estantes)values(2,'avenida los cusis 3er anillo',0);
insert into ubicacion(tipo_id,direccion,cant_estantes)values(1,'avenida americana',0);
insert into ubicacion(tipo_id,direccion,cant_estantes)values(3,'avenida josefina',0);
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into estante(ubicacion_id,cant_fila)values(1,5);
insert into estante(ubicacion_id,cant_fila)values(1,2);
insert into estante(ubicacion_id,cant_fila)values(2,2);
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into tipo_articulo(nombre)values('Materia prima');
insert into tipo_articulo(nombre)values('Producto');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into articulo(nombre,descripcion,fecha_creacion,fecha_vencimiento,cantidad,tipo_id,serie,imagen)
values('madera','Es madera',now(),now(),15,1,'100001','root/imagen2'); -- 1
insert into articulo(nombre,descripcion,fecha_creacion,fecha_vencimiento,cantidad,tipo_id,serie,imagen)
values('clavos','Es clavo',now(),now(),20,1,'100002','root/imagen_clavo'); -- 2
insert into articulo(nombre,descripcion,fecha_creacion,fecha_vencimiento,cantidad,tipo_id,serie,imagen)
values('mesa','Es una mesa',now(),now(),20,2,'200001','root/imagen_mesa'); -- 3
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into lista_materiales(producto_id,material_id,cantidad)values(3,1,4);
insert into lista_materiales(producto_id,material_id,cantidad)values(3,2,4);
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into proceso(nombre,descripcion)values('cortado','estado para cortar');
insert into proceso(nombre,descripcion)values('pintado','estado para pintar');
insert into proceso(nombre,descripcion)values('secado','estado para secar');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into lista_proceso(producto_id,proceso_id,lista_materiales_id,paso,tiempo)values(3,1,1,1,'01:00:00');
insert into lista_proceso(producto_id,proceso_id,lista_materiales_id,paso,tiempo)values(3,2,2,2,'00:15:00');
insert into lista_proceso(producto_id,proceso_id,paso,tiempo)values(3,3,3,'00:30:00');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into ubicacion_articulo(estante_id,articulo_id,fila,cant_articulo)values(1,1,1,7);  -- revisar
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into estado_orden_produccion(descripcion)values('creado');
insert into estado_orden_produccion(descripcion)values('asignado');
insert into estado_orden_produccion(descripcion)values('proceso');
insert into estado_orden_produccion(descripcion)values('terminado');
insert into estado_orden_produccion(descripcion)values('cancelado');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into orden_produccion(usuario_id_ge,usuario_id_tr,estado_produccion_id,fechar_hora)values(1,2,1,now());
insert into orden_produccion(usuario_id_ge,usuario_id_tr,estado_produccion_id,fechar_hora)values(2,1,2,now());
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into proveedor(articulo_id,nombre,apellido,celular,empresa)values(2,'Jorge','Pereira','71100025','Ferrum');
insert into proveedor(articulo_id,nombre,apellido,celular,empresa)values(1,'Maria','Rufino','7185525','Barraca Maria');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into estado_orden_compra(descripcion)values('creado');
insert into estado_orden_compra(descripcion)values('enviado');
insert into estado_orden_compra(descripcion)values('recibido');
insert into estado_orden_compra(descripcion)values('cancelado');
-- +++++++++++++++++++++++++++++++++++++++++++++++
insert into orden_compra(usuario_id_gen,usuario_id_ges,proveedor_id,estado_compra_id,fecha_hora)values(1,2,1,1,now());
insert into orden_compra(usuario_id_gen,usuario_id_ges,proveedor_id,estado_compra_id,fecha_hora)values(2,1,1,2,now());
insert into orden_compra(usuario_id_gen,usuario_id_ges,proveedor_id,estado_compra_id,fecha_hora)values(1,2,2,3,now());
-- +++++++++++++++++++++++++++++++++++++++++++++++
-- +++++++++++++++++++++++++++++++++++++++++++++++
select * from orden_compra

select * from articulo



	




delete actualizar_cant_estantes ON estantes;
DROP TABLE IF EXISTS lista_proceso;
DROP TABLE IF EXISTS ubicacion_articulo;
DROP TABLE IF EXISTS orden_produccion;
DROP TABLE IF EXISTS orden_compra;
DROP TABLE IF EXISTS proveedor;
DROP TABLE IF EXISTS lista_materiales;
DROP TABLE IF EXISTS articulo;
DROP TABLE IF EXISTS tipo_articulo;
DROP TABLE IF EXISTS estante;
DROP TABLE IF EXISTS ubicacion;
DROP TABLE IF EXISTS tipo_ubicacion;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS persona;
DROP TABLE IF EXISTS rol_permiso;
DROP TABLE IF EXISTS rol;
DROP TABLE IF EXISTS permiso;
DROP TABLE IF EXISTS empresa;
DROP TABLE IF EXISTS estado_orden_produccion;
DROP TABLE IF EXISTS estado_orden_compra;
DROP TABLE IF EXISTS proceso;


