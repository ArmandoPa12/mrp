
-- FUNCTION: public.actualizar_cant_estantes()

-- DROP FUNCTION IF EXISTS public.actualizar_cant_estantes();

CREATE OR REPLACE FUNCTION public.actualizar_cant_estantes()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
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
$BODY$;

ALTER FUNCTION public.actualizar_cant_estantes()
    OWNER TO postgres;

-- FUNCTION: public.actualizar_cantidad_articulo()

-- DROP FUNCTION IF EXISTS public.actualizar_cantidad_articulo();

CREATE OR REPLACE FUNCTION public.actualizar_cantidad_articulo()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
BEGIN
    -- Si se realiza una inserción
    IF TG_OP = 'INSERT' THEN
        UPDATE articulo
        SET cantidad = cantidad + NEW.cant_articulo
        WHERE id = NEW.articulo_id;
    -- Si se realiza una eliminación
    ELSIF TG_OP = 'DELETE' THEN
        UPDATE articulo
        SET cantidad = cantidad - OLD.cant_articulo
        WHERE id = OLD.articulo_id;
    -- Si se realiza una actualización
    ELSIF TG_OP = 'UPDATE' THEN
        UPDATE articulo
        SET cantidad = cantidad - OLD.cant_articulo + NEW.cant_articulo
        WHERE id = NEW.articulo_id;
    END IF;
    RETURN NULL;
END;
$BODY$;

ALTER FUNCTION public.actualizar_cantidad_articulo()
    OWNER TO postgres;