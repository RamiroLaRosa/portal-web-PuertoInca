
-- Volcando estructura para función sga-huanuco.fu_primera_letra_mayu
DELIMITER //
CREATE FUNCTION `fu_primera_letra_mayu`(`cadena` VARCHAR(45)) RETURNS VARCHAR(45) CHARSET utf8mb4 COLLATE utf8mb4_general_ci BEGIN DECLARE len INT; DECLARE i INT; DECLARE input VARCHAR(45); SET len = CHAR_LENGTH(cadena); SET input = LOWER(cadena); SET i = 0; WHILE (i < len) DO
 if (MID(input,i,1) = ' ' OR i = 0) THEN
 if (i < len) THEN SET input = CONCAT(
LEFT(input,i), UPPER(MID(input,i + 1,1)),
RIGHT(input,len - i - 1)); END if; END if; SET i = i + 1; END WHILE; RETURN input; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_buscar_datos_persona
DELIMITER //
CREATE PROCEDURE `sp_buscar_datos_persona`(in `vcodigo` VARCHAR(20), in `vpaterno` VARCHAR(60), in `vmaterno` VARCHAR(60), in `vnombres` VARCHAR(60)) BEGIN
SELECT `dni`, `idprograma`, `institucion`, `estudiante`, persona, fu_primera_letra_mayu(CONCAT(`paterno`, ' ', `materno`,', ',`nombres`)) `nombres`, SUBSTRING(`programa`,1,20) AS programa, CASE WHEN `estado`=11 THEN 'egresado' WHEN `estado`=12 THEN 'titulado' ELSE 'estudiando' END estado
,`programa` AS completoprograma
FROM `ts_cons_student`
WHERE 
 estudiante LIKE CONCAT('%',vcodigo,'%') COLLATE utf8mb4_unicode_ci AND
 paterno LIKE CONCAT('%',vpaterno,'%') COLLATE utf8mb4_unicode_ci AND
 materno LIKE CONCAT('%',vmaterno,'%') COLLATE utf8mb4_unicode_ci AND
 nombres LIKE CONCAT('%',vnombres,'%') COLLATE utf8mb4_unicode_ci
ORDER BY paterno,materno,nombres DESC
LIMIT 7; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_buscar_empresa
DELIMITER //
CREATE PROCEDURE `sp_buscar_empresa`(in `vcodigo` VARCHAR(100), in `vrazon` VARCHAR(200)) BEGIN
SELECT
	`empresa`,
	`ruc`,
	`razon_social`,
	`telefono`,
	`direccion`,
	`estado`
FROM
	`ts_empresas`
WHERE
	ruc LIKE CONCAT('%', vcodigo, '%') AND razon_social LIKE CONCAT('%', vrazon, '%')
ORDER BY
	empresa,
	razon_social DESC
LIMIT
	7; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_buscar_persona
DELIMITER //
CREATE PROCEDURE `sp_buscar_persona`(in `vcodigo` VARCHAR(20), in `vpaterno` VARCHAR(60), in `vmaterno` VARCHAR(60), in `vnombres` VARCHAR(60)) BEGIN
SELECT `persona`,`dni`, `idprograma`, `institucion`, `estudiante`, fu_primera_letra_mayu(CONCAT(`paterno`, ' ', `materno`,', ',`nombres`)) `nombres`, SUBSTRING(`programa`,1,20) AS programa, CASE WHEN `estado`=10 THEN 'estudiante' WHEN `estado`=11 THEN 'egresado' WHEN `estado`=12 THEN 'titulado' ELSE 'registro' END estado
,`programa` AS completoprograma
FROM `ts_cons_student`
WHERE 
 estudiante LIKE CONCAT('%',vcodigo,'%') COLLATE utf8mb4_unicode_ci AND
 paterno LIKE CONCAT('%',vpaterno,'%') COLLATE utf8mb4_unicode_ci AND
 materno LIKE CONCAT('%',vmaterno,'%') COLLATE utf8mb4_unicode_ci AND
 nombres LIKE CONCAT('%',vnombres,'%') COLLATE utf8mb4_unicode_ci
ORDER BY paterno,materno,nombres DESC
LIMIT 7; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_buscar_usuario
DELIMITER //
CREATE PROCEDURE `sp_buscar_usuario`(in `vcodigo` VARCHAR(20), in `vapellidos` VARCHAR(60)) BEGIN
SELECT id AS idusuario,id persona,nroidenti dni, fu_primera_letra_mayu(CONCAT(`apellido_pa`, ' ', `apellido_ma`,', ',`nombres`)) `nombres`
FROM usuarios
WHERE 
 nombres LIKE CONCAT('%',vcodigo,'%') COLLATE utf8mb4_unicode_ci AND CONCAT(apellido_pa,' ',apellido_ma) LIKE CONCAT('%',vapellidos,'%') COLLATE utf8mb4_unicode_ci
ORDER BY apellido_pa,apellido_ma,nombres DESC
LIMIT 3; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_historial_pagos_persona
DELIMITER //
CREATE PROCEDURE `sp_historial_pagos_persona`(in `vcodigo` VARCHAR(20)) BEGIN
SELECT dp.num_comprobante,(
SELECT CONCAT(a.anho,a.numero)
FROM semestres a
WHERE a.id=dp.semestre_id) periodo
	
		, CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE 
				
				co.descripcion END concepto
	
	,dp.monto_total, DATE_FORMAT(dp.fecha_pago, "%d/%m/%Y")fechapago
	,dp.user_id persona
FROM ts_det_pagos_personas dp
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
WHERE dp.user_id=vcodigo AND dp.estado=1; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_anio_solicitud_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_anio_solicitud_viaticos`() BEGIN
SELECT DISTINCT DATE_FORMAT(vs.fecha_pedido, '%Y') anio
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
ORDER BY 1 DESC; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_anular_documento
DELIMITER //
CREATE PROCEDURE `sp_w_anular_documento`(in `vdocument` VARCHAR(20)) BEGIN
/*
 estado=0 anulado
 estado=1 pagodo
 estado=2 pendiente 
 
 */ SET
	@existe := (
SELECT COUNT(DISTINCT num_comprobante)
FROM
			ts_pagos_personas
WHERE
			num_comprobante = vdocument
	); SET
	@cant := (
SELECT COUNT(DISTINCT num_comprobante)
FROM
			ts_pagos_personas
WHERE
			num_comprobante = vdocument AND fecha_pago BETWEEN DATE(NOW()) AND DATE(DATE_ADD(NOW(), INTERVAL 1 DAY))
	);

if @existe = 0 THEN
SELECT
	'error' descripcion,
	'no existe el documento' obs,
	0 estado,
	'error' class; ELSE if @cant = 0 THEN
SELECT
	'error' descripcion,
	'nota: los documentos solo de podran anular durante el dia, los documento que pertenece a fechas anteriores no se podran anular' obs,
	0 estado,
	'error' class; ELSE
UPDATE
	ts_pagos_personas SET
	estado = 0
WHERE
	num_comprobante = vdocument AND fecha_pago BETWEEN DATE(NOW()) AND DATE(DATE_ADD(NOW(), INTERVAL 1 DAY)) AND estado = 1;
UPDATE
	ts_det_pagos_personas SET
	estado = 0
WHERE
	num_comprobante = vdocument AND fecha_pago BETWEEN DATE(NOW()) AND DATE(DATE_ADD(NOW(), INTERVAL 1 DAY)) AND estado = 1;
SELECT
	'exito' descripcion,
	'registro anulado' obs,
	1 estado,
	'success' class; END if; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_autoriza_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_autoriza_viaticos`(
in `vanio` VARCHAR(20),
in `vsolicitud` VARCHAR(20),
in `vnota` VARCHAR(20),
in `vestado` VARCHAR(5)

) BEGIN
UPDATE ts_solicitudes_viaticos SET estado_autorizacion=vestado, nota_autorizacion=vnota,fecha_autorizacion= NOW()
WHERE DATE_FORMAT(fecha_pedido, '%Y')=vanio AND solicitud= vsolicitud;

	if vestado=0 THEN
SELECT 'exito' descripcion, CONCAT('la solicitud en pendiente')obs,1 estado,'success' class; END if; 
	if vestado=1 THEN
SELECT 'exito' descripcion, CONCAT('la solicitud fue autorizado')obs,1 estado,'success' class; END if; 
	if vestado=2 THEN
SELECT 'exito' descripcion, CONCAT('la solicitud fue cancelado')obs,1 estado,'success' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_buscar_persona
DELIMITER //
CREATE PROCEDURE `sp_w_buscar_persona`(in `vcodigo` VARCHAR(20), in `vpaterno` VARCHAR(60), in `vmaterno` VARCHAR(60), in `vnombres` VARCHAR(60)) BEGIN
SELECT id persona,nroidenti dni, fu_primera_letra_mayu(CONCAT(apellido_pa, ' ', apellido_ma,', ',nombres)) `nombres`
FROM usuarios
WHERE 
 nroidenti LIKE CONCAT('%',vcodigo,'%') COLLATE utf8mb4_unicode_ci AND
 apellido_pa LIKE CONCAT('%',vpaterno,'%') COLLATE utf8mb4_unicode_ci AND
 apellido_ma LIKE CONCAT('%',vmaterno,'%') COLLATE utf8mb4_unicode_ci AND
 nombres LIKE CONCAT('%',vnombres,'%') COLLATE utf8mb4_unicode_ci
ORDER BY apellido_pa,apellido_ma,nombres DESC
LIMIT 7; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_banco
DELIMITER //
CREATE PROCEDURE `sp_w_cb_banco`() BEGIN
SELECT
	`banco`,
	`descripcion`
FROM
	`ts_bancos`
WHERE
	estado = 1
ORDER BY
	banco; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_descuento
DELIMITER //
CREATE PROCEDURE `sp_w_cb_descuento`() BEGIN
SELECT CONCAT(`descuento`, '.', tipo_desc, '.', cantidad) descuento,
	`descripcion`
FROM
	ts_descuentos
WHERE
	estado = 1
ORDER BY
	descuento; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_medio_pago
DELIMITER //
CREATE PROCEDURE `sp_w_cb_medio_pago`() BEGIN
SELECT
	`medio_pago`,
	`descripcion`
FROM
	`ts_medios_pagos`
WHERE
	estado = 1
ORDER BY
	medio_pago; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_tipo_concepto
DELIMITER //
CREATE PROCEDURE `sp_w_cb_tipo_concepto`() BEGIN
SELECT
	`tipo_concepto`,
	`descripcion`
FROM
	`ts_tipos_conceptos`
WHERE
	tipo_concepto <> 1 AND estado = 1
ORDER BY
	tipo_concepto; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_tipo_documento
DELIMITER //
CREATE PROCEDURE `sp_w_cb_tipo_documento`() BEGIN
SELECT
	`tipo_documento`,
	`descripcion`
FROM
	`ts_tipos_documentos`
WHERE
	estado = 1
ORDER BY
	tipo_documento; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_tipo_documento2
DELIMITER //
CREATE PROCEDURE `sp_w_cb_tipo_documento2`() BEGIN
SELECT
	`tipo_documento`,
	`descripcion`
FROM
	`ts_tipos_documentos`
WHERE
	estado = 1 AND tipo_documento in(1, 2, 4)
ORDER BY
	tipo_documento; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cb_tipo_documento_usuario
DELIMITER //
CREATE PROCEDURE `sp_w_cb_tipo_documento_usuario`(in `vusuario` BIGINT) BEGIN SET @cant:= (
SELECT COUNT(*)
FROM ts_usuarios_ventas
WHERE user_id=vusuario);

if (@cant='0') THEN
SELECT '0' tipo_documento, 'vacio' descripcion,0 orden; ELSE
SELECT tipo_documento, dtipo_documento descripcion,orden
FROM (
SELECT t.tipo_documento,m.modulo,m.descripcion,t.descripcion dtipo_documento, IFNULL(t2.descripcion,'') tipo_documento_nc,s.serie,s.nro_inicio,s.nro_fin,s.nro_activo,s.nro_digitos,s.estado,t.orden
FROM ts_modulos m
INNER JOIN ts_usuarios_ventas us ON us.modulo=m.modulo AND us.local=m.local
INNER JOIN ts_series s ON s.modulo=m.modulo
INNER JOIN ts_tipos_documentos t ON t.tipo_documento=s.tipo_documento
LEFT JOIN ts_tipos_documentos t2 ON t2.tipo_documento=s.tipo_doc_nc
WHERE us.user_id=vusuario AND us.estado=1 AND m.estado=1 AND s.estado=1 AND t.tipo_documento in(1,2,4)
)x
ORDER BY orden; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cerrar_rendicion_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_cerrar_rendicion_viaticos`(in `vanio` VARCHAR(20), in `vsoli` VARCHAR(20)) BEGIN
/* update ts_series set nro_activo=vnroactivo	
 where modulo=vmodulo and tipo_documento=vtipdoc and serie=vseries;*/
/*	set @direncia:=(select diferencia from (
 select
 vs.anio,vs.solicitud 
 ,ifnull(dp.monto_deposito,0)monto_deposito
 ,ifnull((select sum(a.gasto) from ts_registros_viaticos a where a.solicitud=vs.solicitud and a.anio=vs.anio),0) gastos
 ,ifnull(dp.monto_deposito,0)-(ifnull((select sum(a.gasto) from ts_registros_viaticos a where a.solicitud=vs.solicitud and a.anio=vs.anio),0)) diferencia
 
 from ts_solicitudes_viaticos vs
 left join ts_depositos_viaticos dp on dp.solicitud=vs.solicitud and dp.anio=vs.anio 
 where  vs.estado in(1,2) and dp.estado=1
 )x where anio=vanio and solicitud=vsoli
 );*/ SET
	@estado :=(
SELECT
			estado
FROM
			ts_solicitudes_viaticos
WHERE
			anio = vanio AND solicitud = vsoli
	);

if(@estado = 1) THEN
UPDATE
	ts_solicitudes_viaticos SET
	estado = 2
WHERE
	anio = vanio AND solicitud = vsoli;
SELECT
	'exito' descripcion,
	'rendición de viatico cerrado' obs,
	1 estado; END if;

if(@estado = 2) THEN
UPDATE
	ts_solicitudes_viaticos SET
	estado = 1
WHERE
	anio = vanio AND solicitud = vsoli;
SELECT
	'exito' descripcion,
	'rendición de viatico vigente' obs,
	1 estado; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_conceptos
DELIMITER //
CREATE PROCEDURE `sp_w_conceptos`(
in `vtipo` VARCHAR(5),
in `vconcepto` VARCHAR(100) 
) BEGIN


		-- set @periodo:=(select concat(max(anho),max(numero)) from semesters);
		-- concat(a.descripcion,' ',(select concat(max(anho),max(numero)) from semestres))
SET @periodo:=(
SELECT MAX(id)
FROM semestres);
SELECT @periodo periodo,t.concepto,a.descripcion descripcion,t.monto,t.tipo_concepto
FROM ts_conceptos a
INNER JOIN ts_conceptos_tramites t ON t.concepto=a.concepto
WHERE a.estado=1 AND t.estado=1 AND t.tipo_concepto LIKE CONCAT('%',vtipo,'%') AND a.descripcion LIKE CONCAT('%',vconcepto,'%'); END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_consulta
DELIMITER //
CREATE PROCEDURE `sp_w_consulta`(in `vcodigo` VARCHAR(50), in `vdescr` VARCHAR(100)) BEGIN
SELECT
	`medio_pago`,
	`descripcion`
FROM
	`ts_medios_pagos`
WHERE
	medio_pago LIKE CONCAT('%', vcodigo, '%') AND descripcion LIKE CONCAT('%', vdescr, '%') AND estado = 1
ORDER BY
	medio_pago; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cuadre_caja
DELIMITER //
CREATE PROCEDURE `sp_w_cuadre_caja`(in `vusuario` VARCHAR(20), in `fechainicio` VARCHAR(12), in `fechafinal` VARCHAR(12)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE dp.nroidenti END END codigo
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social

 
,td.descripcion tipodoc,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%Y")fecha_pago, CASE WHEN dp.estado=0 THEN 0 ELSE dp.monto_total END monto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
INNER JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
WHERE dp.control_usuario=vusuario AND dp.fecha_pago BETWEEN fechainicio AND DATE(DATE_ADD(fechafinal, INTERVAL 1 DAY)) AND dp.estado in(1,0) /* estado 1 cancelado 0 pendiente*/
ORDER BY dp.fecha_pago,dp.concepto,dp.num_cuota,dp.num_parte; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cuadre_caja_cuadro
DELIMITER //
CREATE PROCEDURE `sp_w_cuadre_caja_cuadro`(in `vusuario` VARCHAR(20), in `fechainicio` VARCHAR(12), in `fechafinal` VARCHAR(12)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT tipodoc,medio_pago,banco, SUM(monto_total)total
FROM (
SELECT CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE dp.nroidenti END END codigo
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social

 
,td.descripcion tipodoc,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%Y")fecha_pago,dp.monto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
INNER JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
WHERE dp.control_usuario=vusuario AND dp.fecha_pago BETWEEN fechainicio AND DATE(DATE_ADD(fechafinal, INTERVAL 1 DAY)) AND dp.estado=1 /* estado 1 cancelado 0 pendiente*/
)x
GROUP BY tipodoc,medio_pago,banco
ORDER BY 1; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cuadre_grafico_caja
DELIMITER //
CREATE PROCEDURE `sp_w_cuadre_grafico_caja`(in `vusuario` VARCHAR(20), in `fechainicio` VARCHAR(12), in `fechafinal` VARCHAR(12)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT medio_pago, SUM(monto_total)total
FROM (
SELECT CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE dp.nroidenti END END codigo
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social

 
,td.descripcion tipodoc,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%Y")fecha_pago,dp.monto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
INNER JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
WHERE dp.control_usuario=vusuario AND dp.fecha_pago BETWEEN fechainicio AND DATE(DATE_ADD(fechafinal, INTERVAL 1 DAY)) AND dp.estado=1 /* estado 1 cancelado 0 pendiente*/
)x
GROUP BY medio_pago; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_cuadro_ingreso_programa
DELIMITER //
CREATE PROCEDURE `sp_w_cuadro_ingreso_programa`(in `fechainicio` VARCHAR(12), in `fechafinal` VARCHAR(12)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/ SET @numero=0;
SELECT @numero:=@numero+1 AS num,programa,estudiante,total
FROM (
SELECT IFNULL(et.idprograma,'')idprograma, IFNULL(et.programa,'sin resultado')programa, COUNT(DISTINCT et.estudiante)estudiante, IFNULL(SUM(dp.monto_total),'')total
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
LEFT JOIN ts_cons_student et ON et.persona=dp.user_id
/*inner join ts_tipos_documentos td on td.tipo_documento=dp.tipo_documento
inner join ts_conceptos co on co.concepto=dp.concepto 
inner join ts_medios_pagos mp on mp.medio_pago=dp.medio_pago
inner join ts_tipos_conceptos tm on tm.tipo_concepto=dp.tipo_concepto
inner join ts_bancos ba on ba.banco=dp.banco
*/
WHERE dp.fecha_pago BETWEEN fechainicio AND DATE(DATE_ADD(fechafinal, INTERVAL 1 DAY)) AND dp.estado=1 /* estado 1 cancelado 0 pendiente*/ AND dp.tipo_documento in(1,2,3,4)
GROUP BY et.idprograma,et.programa
)x
ORDER BY 3; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_detalle_registro_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_detalle_registro_viaticos`(in `vanio` VARCHAR(20), in `vsolic` VARCHAR(20)) BEGIN
SELECT vt.registro, DATE_FORMAT(vt.fecha_comprobante, '%d/%m/%Y') fecha_comprobante
,vt.comprobante,cv.descripcion concepto,dv.monto_deposito,vt.gasto,vt.nota
FROM ts_registros_viaticos vt
INNER JOIN ts_depositos_viaticos dv ON dv.anio=vt.anio AND dv.solicitud=vt.solicitud
INNER JOIN ts_conceptos_viaticos cv ON cv.conceptoviatico=vt.conceptoviatico
WHERE vt.anio=vanio AND vt.solicitud=vsolic AND vt.estado=1; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_concepto
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_concepto`(in `vcodigo` VARCHAR(15)) BEGIN
/*set @ultimocodigo:=lpad(vcodigo,10,'0'); */ SET @maxicodigo:= (
SELECT MAX(concepto)
FROM ts_conceptos); SET @cant:= (
SELECT COUNT(DISTINCT concepto)
FROM ts_conceptos
WHERE concepto=vcodigo AND estado in(1,2)); SET @concepto:= (
SELECT DISTINCT concepto
FROM ts_conceptos
WHERE concepto=vcodigo AND estado in(1,2));
if @cant>=1 THEN	
		if vcodigo=@maxicodigo THEN	
			/*select 'delete';*/
DELETE
FROM ts_conceptos_tramites
WHERE concepto=vcodigo;
DELETE
FROM ts_conceptos
WHERE concepto=vcodigo;
SELECT 'exito' descripcion, CONCAT('registro eliminado')obs,1 estado,'success' class; ELSE
			/*select 'update';*/
UPDATE ts_conceptos SET estado=0
WHERE concepto=vcodigo;
SELECT 'exito' descripcion, CONCAT('registro eliminado')obs,1 estado,'success' class; END if; ELSE
SELECT 'error' descripcion,'el registro no existe'obs,0 estado,'error' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_dat_empresa
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_dat_empresa`(in `vcodigo` VARCHAR(15)) BEGIN
/*set @ultimocodigo:=lpad(vcodigo,10,'0'); */ SET
	@maxicodigo := (
SELECT MAX(empresa)
FROM
			ts_empresas
	); SET
	@cant := (
SELECT COUNT(DISTINCT empresa)
FROM
			ts_empresas
WHERE
			empresa = vcodigo AND estado = 1
	); SET
	@ruc := (
SELECT DISTINCT ruc
FROM
			ts_empresas
WHERE
			empresa = vcodigo AND estado = 1
	); SET
	@empresa := (
SELECT DISTINCT empresa
FROM
			ts_empresas
WHERE
			empresa = vcodigo AND estado = 1
	);

if @cant >= 1 THEN if vcodigo = @maxicodigo THEN
/*select 'delete';*/
DELETE
FROM
	ts_empresas
WHERE
	empresa = vcodigo;
SELECT
	'exito' descripcion, CONCAT('ruc ', @ruc, ' eliminado') obs,
	1 estado,
	'success' class; ELSE
/*select 'update';*/
UPDATE
	ts_empresas SET
	estado = 0
WHERE
	empresa = vcodigo;
SELECT
	'exito' descripcion, CONCAT('ruc ', @ruc, ' eliminado') obs,
	1 estado,
	'success' class; END if; ELSE
SELECT
	'error' descripcion,
	'el registro no existe' obs,
	0 estado,
	'error' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_descuento
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_descuento`(in `vcodigo` VARCHAR(15)) BEGIN
/*set @ultimocodigo:=lpad(vcodigo,10,'0'); */ SET
	@maxicodigo := (
SELECT MAX(descuento)
FROM
			ts_descuentos
	); SET
	@cant := (
SELECT COUNT(DISTINCT descuento)
FROM
			ts_descuentos
WHERE
			descuento = vcodigo AND estado = 1
	); SET
	@descuento := (
SELECT DISTINCT descuento
FROM
			ts_descuentos
WHERE
			descuento = vcodigo AND estado = 1
	);

if @cant >= 1 THEN if vcodigo = @maxicodigo THEN
/*select 'delete';*/
DELETE
FROM
	ts_descuentos
WHERE
	descuento = vcodigo;
SELECT
	'exito' descripcion, CONCAT('registro eliminado') obs,
	1 estado,
	'success' class; ELSE
/*select 'update';*/
UPDATE
	ts_descuentos SET
	estado = 0
WHERE
	descuento = vcodigo;
SELECT
	'exito' descripcion, CONCAT('registro eliminado') obs,
	1 estado,
	'success' class; END if; ELSE
SELECT
	'error' descripcion,
	'el registro no existe' obs,
	0 estado,
	'error' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_estado_cuenta_estudiante
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_estado_cuenta_estudiante`(
in `vestudiante` VARCHAR(20),
in `vprograma` VARCHAR(10),
in `vcuota` VARCHAR(10),
in `vperiodo` VARCHAR(10) 
) BEGIN SET @mnumcuota:= SUBSTRING_INDEX(vcuota, '/', 1); SET @mnumparte:= SUBSTRING_INDEX(vcuota, '/', -1);
DELETE
FROM ts_estados_cuentas
WHERE semestre_id=vperiodo AND user_id=vestudiante AND num_cuota=@mnumcuota AND num_parte=@mnumparte AND estado=2;
SELECT 'exito' descripcion, CONCAT('registro eliminado')obs,1 estado,'success' class; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_modulo
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_modulo`(in `vcodigo` VARCHAR(15)) BEGIN
/*set @ultimocodigo:=lpad(vcodigo,10,'0'); */ SET
	@maxicodigo := (
SELECT MAX(modulo)
FROM
			ts_modulos
	); SET
	@cant := (
SELECT COUNT(DISTINCT modulo)
FROM
			ts_modulos
WHERE
			modulo = vcodigo
	); SET
	@moduloexiste := (
SELECT COUNT(DISTINCT modulo)
FROM
			ts_series
WHERE
			modulo = vcodigo
	);

if @cant >= 1 THEN if vcodigo = @maxicodigo THEN if @moduloexiste >= 1 THEN
/*select 'update';*/
UPDATE
	ts_modulos SET
	estado = 0
WHERE
	modulo = vcodigo;
SELECT
	'exito' descripcion, CONCAT('registro eliminado') obs,
	1 estado,
	'success' class; ELSE
/*select 'delete';*/
DELETE
FROM
	ts_modulos
WHERE
	modulo = vcodigo;
SELECT
	'exito' descripcion, CONCAT('registro eliminado') obs,
	1 estado,
	'success' class; END if; ELSE
/*select 'update';*/
UPDATE
	ts_modulos SET
	estado = 0
WHERE
	modulo = vcodigo;
SELECT
	'exito' descripcion, CONCAT('registro eliminado') obs,
	1 estado,
	'success' class; END if; ELSE
SELECT
	'error' descripcion,
	'el registro no existe' obs,
	0 estado,
	'error' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_modulo_usuario
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_modulo_usuario`(
in `vcodigo` BIGINT,
in `vmodulo` VARCHAR(12)

 
) BEGIN SET @cant:= (
SELECT COUNT(DISTINCT modulo)
FROM ts_series
WHERE modulo=vmodulo); SET @estado:= (
SELECT DISTINCT estado
FROM ts_usuarios_ventas
WHERE user_id=vcodigo AND modulo=vmodulo);
	 if @cant=0 THEN
DELETE
FROM ts_usuarios_ventas
WHERE user_id=vcodigo AND modulo=vmodulo;
SELECT 'exito' descripcion, CONCAT('Registro eliminado')obs,1 estado,'success' class; ELSE
		
			if(@estado=1) THEN
DELETE
FROM ts_usuarios_ventas
WHERE user_id=vcodigo AND modulo=vmodulo;
SELECT 'exito' descripcion, CONCAT('Registro eliminado')obs,1 estado,'success' class; ELSE
DELETE
FROM ts_usuarios_ventas
WHERE user_id=vcodigo AND modulo=vmodulo;
SELECT 'exito' descripcion, CONCAT('Registro eliminado')obs,1 estado,'success' class; END if; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_registro_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_registro_viaticos`(in `vregistro` VARCHAR(20)) BEGIN
DELETE
FROM
	ts_registros_viaticos
WHERE
	registro = vregistro;
SELECT
	'exito' descripcion, CONCAT('se elimino correctamente') obs,
	1 estado,
	'success' class; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_eliminar_serie
DELIMITER //
CREATE PROCEDURE `sp_w_eliminar_serie`(in `vmodulo` VARCHAR(15), in `vtipdoc` VARCHAR(15), in `vseries` VARCHAR(15), in `vtidonc` VARCHAR(15)) BEGIN
/*set @ultimocodigo:=lpad(vcodigo,10,'0'); */ SET
	@maxiseries := (
SELECT MAX(serie)
FROM
			ts_series
WHERE
			modulo = vmodulo AND tipo_documento = vtipdoc AND tipo_doc_nc = vtidonc
	); SET
	@cant := (
SELECT COUNT(DISTINCT serie)
FROM
			ts_series
WHERE
			modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries
	); SET
	@nroactivos := (
SELECT
			nro_activo
FROM
			ts_series
WHERE
			modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries
	);

if @cant >= 1 THEN if vseries = @maxiseries THEN if @nroactivos = 1 THEN
/*select 'delete';*/
DELETE
FROM
	ts_series
WHERE
	modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries;
SELECT
	'exito' descripcion,
	'registro eliminado' obs,
	1 estado,
	'success' class; ELSE
/*select 'update';*/
UPDATE
	ts_series SET
	estado = 0
WHERE
	modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries;
SELECT
	'exito' descripcion,
	'registro eliminado' obs,
	1 estado,
	'success' class; END if; ELSE
/*select 'update';*/
UPDATE
	ts_series SET
	estado = 0
WHERE
	modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries;
SELECT
	'exito' descripcion,
	'registro eliminado' obs,
	1 estado,
	'success' class; END if; ELSE
SELECT
	'error' descripcion,
	'el registro no existe' obs,
	0 estado,
	'error' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_estado_cuenta_estudiante
DELIMITER //
CREATE PROCEDURE `sp_w_estado_cuenta_estudiante`(
in `vestudiante` VARCHAR(20),
in `vprograma` VARCHAR(100) 
) BEGIN
SELECT 
		es.semestre_id periodo,es.tipo_concepto,co.concepto,co.descripcion, CONCAT(es.num_cuota,'/',es.num_parte)cuota,1 cant
		,es.monto_total mbase,es.descuento,es.monto_total mtotal, DATE_FORMAT(es.fecha_vencimiento, '%d/%m/%Y') fechaven
FROM ts_estados_cuentas es
INNER JOIN ts_conceptos co ON co.concepto=es.concepto
WHERE es.user_id=vestudiante AND es.programa_id=vprograma AND es.estado=2; END//
DELIMITER ;

-- Volcando estructura para función sga-huanuco.sp_w_f_extraer_numero
DELIMITER //
CREATE FUNCTION `sp_w_f_extraer_numero`(`cadena1` VARCHAR(255)) RETURNS INT(11) BEGIN DECLARE posicion,
resultado,
longitud INT(11) DEFAULT 0; DECLARE cadena2 VARCHAR(255); SET
	longitud = LENGTH(cadena1); SET
	resultado = CONVERT(cadena1, signed);

if resultado = 0 THEN if cadena1 REGEXP('[0-9]') THEN SET
	posicion = 2;

checkstring : WHILE posicion <= longitud DO SET
	cadena2 = substr(
		cadena1
FROM
			posicion
	);

if CONVERT(cadena2, signed) != 0 THEN SET
	resultado = CONVERT(cadena2, signed); LEAVE checkstring; END if; SET
	posicion = posicion + 1; END WHILE; END if; END if; RETURN resultado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_genera_nc_serie
DELIMITER //
CREATE PROCEDURE `sp_w_genera_nc_serie`(
	IN `vtipo` VARCHAR(10),
	IN `vtiponc` VARCHAR(10)
) BEGIN
SELECT IFNULL(CASE WHEN s.tipo_documento = 3 THEN CONCAT(CASE
					s.tipo_doc_nc WHEN 1 THEN 'BN' WHEN 2 THEN 'FN' WHEN 4 THEN 'RN' END, LPAD(MAX(sp_w_f_extraer_numero(serie)) + 1, 2, '0')
			) END, CASE
			vtiponc WHEN 1 THEN CONCAT('BN', LPAD(sp_w_f_extraer_numero(0) + 1, 2, '0')) WHEN 2 THEN CONCAT('FN', LPAD(sp_w_f_extraer_numero(0) + 1, 2, '0')) WHEN 4 THEN CONCAT('RN', LPAD(sp_w_f_extraer_numero(0) + 1, 2, '0')) END
	) serie
FROM
	ts_series s
WHERE
	tipo_documento = vtipo AND tipo_doc_nc = vtiponc; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_genera_serie
DELIMITER //
CREATE PROCEDURE `sp_w_genera_serie`(
	IN `vtipo` VARCHAR(200)
) BEGIN
SELECT IFNULL(CASE WHEN s.tipo_documento = 3 THEN '' ELSE CONCAT(CASE
					s.tipo_documento WHEN 1 THEN 'B' WHEN 2 THEN 'F' WHEN 4 THEN 'R' END, LPAD(MAX(sp_w_f_extraer_numero(serie)) + 1, 3, '0')
			) END, CASE
			vtipo WHEN 1 THEN CONCAT('B', LPAD(sp_w_f_extraer_numero(0) + 1, 3, '0')) WHEN 2 THEN CONCAT('F', LPAD(sp_w_f_extraer_numero(0) + 1, 3, '0')) WHEN 4 THEN CONCAT('R', LPAD(sp_w_f_extraer_numero(0) + 1, 3, '0')) END
	) serie
FROM
	ts_series s
WHERE
	tipo_documento = vtipo; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_impresion_comprobante_caja
DELIMITER //
CREATE PROCEDURE `sp_w_impresion_comprobante_caja`(in `vusuario` VARCHAR(20)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT DISTINCT razon_social,comprobante,fecha_pago, SUM(monto_total) monto,fechapago
FROM (
SELECT CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE dp.nroidenti END END codigo
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social

 
,td.descripcion tipodoc,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%y")fecha_pago,dp.monto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
,dp.fecha_pago fechapago
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
INNER JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
 -- inner join ts_instituciones i on i.institucion=dp.institucion
WHERE dp.control_usuario=vusuario AND dp.fecha_pago BETWEEN DATE(NOW()) AND DATE(DATE_ADD(NOW(), INTERVAL 1 DAY)) AND dp.estado=1 /* estado 1 cancelado 0 pendiente*/
)x
GROUP BY razon_social,comprobante,fecha_pago
ORDER BY fechapago DESC
LIMIT 50; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insertar_pagos_persona
DELIMITER //
CREATE PROCEDURE `sp_w_insertar_pagos_persona`(
in `_vusuario` VARCHAR(20),
in `_vtipo_doc` VARCHAR(20),
in `_vcomproba` VARCHAR(20),

in `_vpersona` VARCHAR(20),
in `_vempresa` VARCHAR(20),

in `_vmontoba` VARCHAR(20),/*canbecera total*/
in `_vdescuen` VARCHAR(20),
in `_vmototal` VARCHAR(20),/*canbecera total*/

in `_vinstitu` VARCHAR(20),
in `_vperiodo` VARCHAR(20),/*falta agregar formulario*/
in `_vconcept` VARCHAR(20),
in `_vtipconc` VARCHAR(20),/*falta agregar formulario*/
in `_vnumcuot` VARCHAR(20),

in `_vdetallemonbase` VARCHAR(20),
in `_vdetallecantida` VARCHAR(20),
in `_vdetalledescuen` VARCHAR(20),
in `_vdetallefechave` VARCHAR(20),/*falta agregar formulario*/
in `_vdetallemototal` VARCHAR(20),


in `_vestudian` VARCHAR(20),
in `_vprograma` VARCHAR(20),
in `_vmediopag` VARCHAR(20),
in `_vtipbanco` VARCHAR(20),
in `_vnroopera` VARCHAR(20),
in `_vfecopera` VARCHAR(20),

in `_vmodulo` VARCHAR(20),
in `_vserie` VARCHAR(20),

in `_resolucio` VARCHAR(50) /* resolucion descuento*/




) BEGIN SET @usuar:=_vusuario; SET @tidoc:=_vtipo_doc; SET @compr:=_vcomproba; SET @perso:=_vpersona; SET @empre:=_vempresa; SET @montb:=_vmontoba; SET @descu:=_vdescuen; SET @mtota:=_vmototal; SET @mnumcuota:= SUBSTRING_INDEX(_vnumcuot, '/', 1); SET @mnumparte:= SUBSTRING_INDEX(_vnumcuot, '/', -1);


/*declare vcpagos int;
select _country_id=if(exists(select count(*) from ts_pagos_personas  where tipo_documento=vtipo_doc and num_comprobante=_vcomprobante), 1, 0);

 */
 
 
/*set @ticon:=(select tipo_concepto from ts_conceptos_tramites where concepto=_vconcept and estado=1)*/ SET @cant:= (
SELECT COUNT(*)
FROM ts_pagos_personas
WHERE tipo_documento=@tidoc AND num_comprobante=@compr AND estado=1);
 
 if @cant=0 THEN
INSERT INTO `ts_pagos_personas` 
		(`tipo_documento`, `num_comprobante`, `user_id`, `empresa`, `tipo_moneda`,
		 `monto_base`, `descuento`, `monto_total`, `tipo_documento_ref`,
		 `num_comprobante_ref`, `autorizacion_usuario`, `estado`, 
		 `fecha_emision`, `fecha_pago`, `control_fecha`, `creacion_usuario`, 
		 `creacion_estacion`, `control_usuario`, `control_estacion`) VALUES (_vtipo_doc, _vcomproba, _vpersona, _vempresa, 1, _vmontoba, _vdescuen, _vmototal, 0,
	 '', '', 1, NOW(), NOW(), NOW(), _vusuario, 'dbo', _vusuario, 'dbo'); SET @cantserie:= (
SELECT COUNT(*)
FROM ts_series
WHERE LOCAL=1 AND modulo=_vmodulo AND serie=_vserie AND tipo_documento=_vtipo_doc AND estado=1);
	 	 if @cantserie=1 THEN
UPDATE ts_series SET nro_activo = nro_activo+1
WHERE modulo=_vmodulo AND serie=_vserie AND tipo_documento=_vtipo_doc AND estado=1;
SELECT 'Documento registrado' descripcion,'Inserción correcta'obs,1 estado; END if; END if; SET @cantdetalle:= (
SELECT COUNT(*)
FROM ts_det_pagos_personas
WHERE tipo_documento=_vtipo_doc AND num_comprobante=_vcomproba AND user_id=_vpersona AND institucion=_vinstitu AND semestre_id=_vperiodo AND concepto=_vconcept AND tipo_concepto=_vtipconc AND num_cuota=@mnumcuota AND num_parte=@mnumparte AND estado=1);


if @cantdetalle=0 THEN
INSERT INTO `ts_det_pagos_personas`
 (
 `tipo_documento`, `num_comprobante`, `user_id`, `institucion`,
 `semestre_id`, `concepto`, `tipo_concepto`, `num_cuota`,
 `num_parte`, `monto_base`, `cantidad`, `descuento`, 
 `fecha_vencimiento`, `monto_total`, `nroidenti`, `programa_id`, 
 `estado`, `fecha_emision`, `fecha_pago`, `medio_pago`, 
 `banco`, `nro_operacion`,fecha_operacion,`motivo_nc`,`resolucion_descuento`, `creacion_usuario`,
	`creacion_estacion`, `control_fecha`,	`control_usuario`, `control_estacion`
	 
	) VALUES 
	(
	_vtipo_doc,_vcomproba,_vpersona,_vinstitu,	
	_vperiodo,_vconcept,_vtipconc,@mnumcuota,
	 @mnumparte,_vdetallemonbase,_vdetallecantida,_vdetalledescuen,
	_vdetallefechave,_vdetallemototal,_vestudian,_vprograma,
	 1, NOW(), NOW(),_vmediopag,
	_vtipbanco,_vnroopera,_vfecopera,0,_resolucio,_vusuario,
	'dbo', NOW(),_vusuario,'dbo'
	);
SELECT 'Documento registrado' descripcion,'Inserción correcta'obs,1 estado; ELSE
SELECT CONCAT('error') descripcion, CONCAT('El comprobante ',_vcomproba, ' ya existe') obs,0 estado; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_conceptos
DELIMITER //
CREATE PROCEDURE `sp_w_insert_conceptos`(in `vdescripcion` VARCHAR(200), in `vtipo_concept` VARCHAR(12), in `vmonto` VARCHAR(200)) BEGIN SET @codigo:=(
SELECT IFNULL(MAX(concepto),0)+1
FROM ts_conceptos); SET @ultimocodigo:= LPAD(@codigo,5,'0');
INSERT INTO `ts_conceptos`(`concepto`, `descripcion`, `estado`) VALUES (@ultimocodigo,vdescripcion,1);
INSERT INTO `ts_conceptos_tramites`(`concepto`, `tipo_concepto`, `monto`, `modeda`, `estado`) VALUES (@ultimocodigo,vtipo_concept,vmonto,1,1);
SELECT 'exito' descripcion,'se registro correctamente'obs,1 estado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_dat_empresa
DELIMITER //
CREATE PROCEDURE `sp_w_insert_dat_empresa`(in `vruc` VARCHAR(15), in `vrazon` VARCHAR(200), in `vtelefono` VARCHAR(12), in `vdireccion` VARCHAR(200)) BEGIN SET
	@cant := (
SELECT COUNT(DISTINCT ruc)
FROM
			ts_empresas
WHERE
			ruc = vruc AND estado = 1
	);

if @cant >= 1 THEN
SELECT
	'error' descripcion,
	'el numero de ruc ya existe' obs,
	0 estado; ELSE SET
	@codigo :=(
SELECT IFNULL(MAX(empresa), 0) + 1
FROM
			ts_empresas
	); SET
	@ultimocodigo := LPAD(@codigo, 10, '0');
INSERT INTO
	`ts_empresas`(
		`empresa`,
		`ruc`,
		`razon_social`,
		`telefono`,
		`direccion`,
		`estado`
	) VALUES
	(
		@ultimocodigo,
		vruc,
		vrazon,
		vtelefono,
		vdireccion,
		1
	);
SELECT
	'exito' descripcion,
	'se registro correctamente' obs,
	1 estado; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_deposito_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_insert_deposito_viaticos`(in `vsolicitud` VARCHAR(20), in `vanio` VARCHAR(20), in `vdfecha` VARCHAR(20), in `vmontodeposito` DECIMAL(18,2), in `vformpago` VARCHAR(5), in `vbanco` VARCHAR(5), in `vcuenta` VARCHAR(50), in `vnotadepo` VARCHAR(100), in `vestado` VARCHAR(5), in `vusuario` VARCHAR(50)) BEGIN SET
	@cant := (
SELECT COUNT(DISTINCT deposito)
FROM
			ts_depositos_viaticos
WHERE
			anio = vanio AND solicitud = vsolicitud
	); SET
	@codigo :=(
SELECT IFNULL(MAX(deposito), 0) + 1
FROM
			ts_depositos_viaticos
	); SET
	@fechadepo := DATE_FORMAT(STR_TO_DATE(vdfecha, '%d/%m/%y'), '%y-%m-%d');

if @cant >= 1 THEN
SELECT
	'error' descripcion,
	'ya esta registrado' obs,
	0 estado,
	'error' class; ELSE
INSERT INTO
	`ts_depositos_viaticos`(
		`deposito`,
		`solicitud`,
		`anio`,
		`fecha_deposito`,
		`monto_deposito`,
		`forma_pago`,
		`banco`,
		`cuenta`,
		`nota_deposito`,
		`estado`,
		`usuario`,
		creacion_fecha
	) VALUES
	(
		@codigo,
		vsolicitud,
		vanio,
		@fechadepo,
		vmontodeposito,
		vformpago,
		vbanco,
		vcuenta,
		vnotadepo,
		vestado,
		vusuario, NOW()
	);
SELECT
	'exito' descripcion, CONCAT('se registro correctamente') obs,
	1 estado,
	'success' class; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_descuentos
DELIMITER //
CREATE PROCEDURE `sp_w_insert_descuentos`(in `vdescripcion` VARCHAR(200), in `vtipo_desc` VARCHAR(12), in `vcantidad` VARCHAR(200)) BEGIN SET
	@codigo :=(
SELECT IFNULL(MAX(descuento), 0) + 1
FROM
			ts_descuentos
	); SET
	@ultimocodigo := LPAD(@codigo, 4, '0');
INSERT INTO
	ts_descuentos(
		`descuento`,
		`descripcion`,
		`tipo_desc`,
		`cantidad`,
		`estado`
	) VALUES
	(
		@ultimocodigo,
		vdescripcion,
		vtipo_desc,
		vcantidad,
		1
	);
SELECT
	'exito' descripcion,
	'se registro correctamente' obs,
	1 estado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_estado_cuenta
DELIMITER //
CREATE PROCEDURE `sp_w_insert_estado_cuenta`(
in `vusua` VARCHAR(20),
in `vinst` VARCHAR(5),
in `vperi` VARCHAR(12),
in `vestu` VARCHAR(12),
in `vprog` VARCHAR(12),
in `vnucu` VARCHAR(12),
in `vnupa` VARCHAR(12),
in `vtdoc` VARCHAR(12),
in `vncom` VARCHAR(20),
in `vtcon` VARCHAR(12),
in `vconc` VARCHAR(12),
in `vmbas` VARCHAR(12),
in `vdesc` VARCHAR(12),
in `vmtot` DECIMAL(18,2),
in `vfenv` VARCHAR(12),
in `vmontotalval` DECIMAL(18,2),
in `vnumero` INT
 
) BEGIN DECLARE cont INT DEFAULT 1; DECLARE numcuota VARCHAR(2); DECLARE numparte VARCHAR(2); DECLARE montottal DECIMAL(18,2);



	if vmtot=vmontotalval THEN
SELECT 'error' descripcion,'no se puede insertar cuando el monto es igual "fraccione el pago"'obs,0 estado; ELSE
	
		if vmtot>vmontotalval THEN
SELECT 'error' descripcion,'no se puede insertar cuando el monto es mayor al monto actual "fraccione el pago"'obs,0 estado; ELSE WHILE(cont <=vnumero) DO
			 
			 		
			 		if cont=1 THEN -- paga el monto deseado
SET numcuota=1; SET numparte=1; SET montottal=vmtot; ELSE -- monto pendiente
SET numcuota=1; SET numparte=2; SET montottal=(vmontotalval-vmtot); END if;
			
			 		 		
			 -- select cont,montottal monto;
INSERT INTO `ts_estados_cuentas`(
						 `institucion`, `semestre_id`, `user_id`, `programa_id`
						, `num_cuota`, `num_parte`, `tipo_documento`, `num_comprobante`
						, `tipo_concepto`,concepto, `monto_base`, `descuento`, `monto_total`
						, `fecha_vencimiento`, `estado`, `fecha_emision`, `fecha_pago`
						, `creacion_usuario`, `creacion_estacion`, `control_usuario`, `control_estacion`
						, `control_fecha`) VALUES (vinst,vperi,vestu,vprog
						,numcuota,numparte, NULL, NULL
						,vtcon,vconc,montottal,0,montottal
						, DATE_ADD(NOW(), INTERVAL 30 DAY) -- fecha de vencimiento
						,2,
NOW(), NULL
						,vusua,'dbo',vusua,'dbo'
						, NOW());
SELECT 'exito' descripcion,'se registro correctamente'obs,1 estado; SET cont = cont + 1; END WHILE; END if; END if; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_modulo
DELIMITER //
CREATE PROCEDURE `sp_w_insert_modulo`(in `vdescripcion` VARCHAR(200), in `vlocal` VARCHAR(12), in `vestacion` VARCHAR(200)) BEGIN SET
	@codigo :=(
SELECT IFNULL(MAX(modulo), 0) + 1
FROM
			ts_modulos
	);

/*set @ultimocodigo:=lpad(@codigo,4,'0');*/
INSERT INTO
	ts_modulos(
		`institucion`,
		`modulo`,
		`local`,
		`descripcion`,
		`estacion`,
		`estado`
	) VALUES
	(
		1,
		@codigo,
		vlocal, UPPER(vdescripcion),
		vestacion,
		1
	);
SELECT
	'exito' descripcion,
	'se registro correctamente' obs,
	1 estado; END//
DELIMITER ;


-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_modulo_usuario
DELIMITER //
CREATE PROCEDURE `sp_w_insert_modulo_usuario`(in `vusuario` BIGINT, in `vmodulo` VARCHAR(12)) BEGIN
INSERT INTO
	`ts_usuarios_ventas`(`user_id`, `local`, `modulo`, `estado`) VALUES
	(vusuario, 1, vmodulo, 1);
SELECT
	'exito' descripcion,
	'se registro correctamente' obs,
	1 estado; END//
DELIMITER ;


-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_registro_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_insert_registro_viaticos`(in `vsolicitud` VARCHAR(20), in `vanio` VARCHAR(20), in `vconcep` VARCHAR(20), in `vcompro` VARCHAR(40), in `vdfecha` VARCHAR(20), in `vgastos` DECIMAL(18,2), in `vnota` VARCHAR(50), in `vusuario` VARCHAR(50)) BEGIN SET
	@cant := (
SELECT COUNT(DISTINCT solicitud)
FROM
			ts_registros_viaticos
WHERE
			anio = vanio AND solicitud = vsolicitud
	); SET
	@codigo :=(
SELECT IFNULL(MAX(registro), 0) + 1
FROM
			ts_registros_viaticos
	); SET
	@fechacomprobante := DATE_FORMAT(STR_TO_DATE(vdfecha, '%d/%m/%y'), '%y-%m-%d');
INSERT INTO
	`ts_registros_viaticos`(
		`registro`,
		`solicitud`,
		`anio`,
		`conceptoviatico`,
		`comprobante`,
		`fecha_comprobante`,
		`gasto`,
		`nota`,
		`estado`,
		`fecha`,
		`usuario`
	) VALUES
	(
		@codigo,
		vsolicitud,
		vanio,
		vconcep,
		vcompro,
		@fechacomprobante,
		vgastos,
		vnota,
		1, NOW(),
		vusuario
	);
SELECT
	'exito' descripcion, CONCAT('se registro correctamente') obs,
	1 estado,
	'success' class; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_serie
DELIMITER //
CREATE PROCEDURE `sp_w_insert_serie`(in `vmodulo` VARCHAR(200), in `vtipdoc` VARCHAR(12), in `vseries` VARCHAR(200), in `vtdocnc` VARCHAR(200)) BEGIN
/*	 set @codigo:=(select ifnull(max(modulo),0)+1 from ts_series);	  */
/*set @ultimocodigo:=lpad(@codigo,4,'0');*/
INSERT INTO
	`ts_series`(
		`modulo`,
		`local`,
		`tipo_documento`,
		`serie`,
		`tipo_doc_nc`,
		`nro_inicio`,
		`nro_fin`,
		`nro_activo`,
		`nro_digitos`,
		`boleteada`,
		`estado`
	) VALUES
	(
		vmodulo,
		1,
		vtipdoc,
		vseries,
		vtdocnc,
		'1',
		'99999999',
		1,
		8,
		0,
		1
	);
SELECT
	'exito' descripcion,
	'se registro correctamente' obs,
	1 estado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_insert_solicitud_viatico
DELIMITER //
CREATE PROCEDURE `sp_w_insert_solicitud_viatico`(
in `vdni` VARCHAR(200),
in `vmsolci` VARCHAR(12),
in `vuborig` VARCHAR(200),
in `vubdest` VARCHAR(200), 
in `vfereal` VARCHAR(200), 
in `vfesali` VARCHAR(200), 
in `vfereto` VARCHAR(200), 
in `vnosali` VARCHAR(200), 
in `vususol` VARCHAR(200)


) BEGIN SET @codigo:=(
SELECT IFNULL(MAX(solicitud),0)+1
FROM ts_solicitudes_viaticos
WHERE anio= DATE_FORMAT(NOW(), '%Y')); SET @anio:= DATE_FORMAT(NOW(), '%Y');
						 

	 	 /*set @ultimocodigo:=lpad(@codigo,4,'0');*/
INSERT INTO `ts_solicitudes_viaticos`(`solicitud`, `anio`, `user_id`, `monto_solicitado`
, `ubigeo_origen`, `ubigeo_destino`, `fecha_realizar`, `fecha_salida`
, `fecha_retorno`, `nota_salida`, `usuario_solicitud`, `fecha_pedido`,estado
) VALUES (@codigo,@anio,vdni,vmsolci
,vuborig,vubdest,vfereal,vfesali
,vfereto,vnosali,vususol, NOW(),1
);
SELECT 'exito' descripcion, CONCAT('se registro correctamente')obs,1 estado,'success' class; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_listar_conceptos
DELIMITER //
CREATE PROCEDURE `sp_w_listar_conceptos`() BEGIN
SELECT c.concepto,c.descripcion,tc.descripcion tipo_concepto,ct.monto,c.estado
FROM ts_conceptos c
INNER JOIN ts_conceptos_tramites ct ON ct.concepto=c.concepto
INNER JOIN ts_tipos_conceptos tc ON tc.tipo_concepto=ct.tipo_concepto
WHERE c.estado in(1,2)
ORDER BY c.concepto; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_listar_descuentos
DELIMITER //
CREATE PROCEDURE `sp_w_listar_descuentos`() BEGIN
SELECT
	descuento,
	descripcion,
	tipo_desc,
	cantidad,
	estado
FROM
	ts_descuentos
WHERE
	descuento <> '0001' AND estado = 1
ORDER BY
	descuento DESC; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_listar_razon_social
DELIMITER //
CREATE PROCEDURE `sp_w_listar_razon_social`() BEGIN
SELECT
	empresa,
	ruc,
	razon_social,
	telefono,
	direccion,
	estado
FROM
	ts_empresas
WHERE
	estado = 1
ORDER BY
	empresa DESC; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_autoriza_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_autoriza_viaticos`(in `vanio` VARCHAR(20)) BEGIN
SELECT DATE_FORMAT(vs.fecha_pedido, '%Y')anio,vs.solicitud, CONCAT(us.apellido_pa,' ',us.apellido_ma,', ',us.nombres)personal,vs.monto_solicitado,vs.nota_salida
, DATE_FORMAT(vs.fecha_pedido, '%d/%m/%Y') fecha
, CASE IFNULL(vs.estado_autorizacion,0) WHEN 0 THEN '<div class="badge bg-info">pendiente</div>' WHEN 1 THEN '<div class="badge bg-success">aprobado</div>' WHEN 2 THEN '<div class="badge bg-danger">cancelado</div>' END estado_autorizacion
,vs.nota_autorizacion, CONCAT(usemo.apellido_pa,' ',usemo.apellido_ma,',',usemo.nombres)usuario_solicitud
, IFNULL(vs.estado_autorizacion,0) estadoautor
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
INNER JOIN usuarios usemo ON usemo.nroidenti=vs.usuario_solicitud
WHERE DATE_FORMAT(vs.fecha_pedido, '%Y') = vanio
ORDER BY fecha_pedido ; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_concepto_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_concepto_viaticos`() BEGIN
SELECT
	conceptoviatico,
	descripcion,
	estado
FROM
	ts_conceptos_viaticos
WHERE
	estado = 1; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_deposito_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_deposito_viaticos`(in `vanio` VARCHAR(20)) BEGIN
SELECT DATE_FORMAT(vs.fecha_pedido, '%Y')anio,vs.solicitud, CONCAT(us.apellido_pa,' ',us.apellido_ma,', ',us.nombres)personal,vs.monto_solicitado
, DATE_FORMAT(vs.fecha_pedido, '%d/%m/%Y') fecha
, CASE IFNULL(vs.estado_autorizacion,0) WHEN 0 THEN '<div class="badge bg-info">pendiente</div>' WHEN 1 THEN '<div class="badge bg-success">aprobado</div>' WHEN 2 THEN '<div class="badge bg-danger">cancelado</div>' END estado_autorizacion
,vs.nota_autorizacion
, CASE IFNULL(dv.estado,0) WHEN 0 THEN '<div class="badge bg-info">pendiente</div>' WHEN 1 THEN '<div class="badge bg-success">depositado</div>' WHEN 2 THEN '<div class="badge bg-danger">cancelado</div>' END estado_deposito
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
INNER JOIN usuarios usemo ON usemo.nroidenti=vs.usuario_solicitud
LEFT JOIN ts_depositos_viaticos dv ON dv.solicitud=vs.solicitud AND dv.anio=vs.anio
WHERE DATE_FORMAT(vs.fecha_pedido, '%Y') = vanio AND vs.estado_autorizacion=1
ORDER BY fecha_pedido ; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_documento_anular
DELIMITER //
CREATE PROCEDURE `sp_w_lista_documento_anular`(in `vdocument` VARCHAR(20)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT DISTINCT comprobante,razon_social,concepto,fecha_pago,monto_total monto,fechapago,estado
FROM (
SELECT CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE dp.nroidenti END END codigo
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social

 
,td.descripcion tipodoc,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%y")fecha_pago,dp.monto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
,dp.fecha_pago fechapago
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
INNER JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
 -- inner join ts_instituciones i on i.institucion=dp.institucion
WHERE dp.num_comprobante=vdocument AND dp.fecha_pago BETWEEN DATE(NOW()) AND DATE(DATE_ADD(NOW(), INTERVAL 1 DAY)) AND dp.estado in(1,0) /* estado 1 cancelado 0 pendiente*/
)x
-- group by razon_social,comprobante,fecha_pago
ORDER BY fechapago DESC; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_modulos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_modulos`() BEGIN
SELECT
	`modulo`,
	`descripcion`, CASE WHEN (
SELECT COUNT(DISTINCT modulo)
FROM
				ts_series b
WHERE
				modulo = a.modulo AND estado = 1
		) = 1 THEN CASE WHEN estado = 1 THEN 'activo' ELSE 'inactivo' END ELSE CASE WHEN estado = 1 THEN 'disponible' ELSE 'inactivo' END END estado
FROM
	ts_modulos a
ORDER BY
	modulo; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_registro_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_registro_viaticos`(in `vanio` VARCHAR(20)) BEGIN
SELECT DATE_FORMAT(vs.fecha_pedido, '%Y')anio,vs.solicitud, CONCAT(us.apellido_pa,' ',us.apellido_ma,', ',us.nombres)personal,vs.monto_solicitado,dv.monto_deposito
, DATE_FORMAT(vs.fecha_pedido, '%d/%m/%Y') fecha
, CASE IFNULL(vs.estado_autorizacion,0) WHEN 0 THEN '<div class="badge bg-info">pendiente</div>' WHEN 1 THEN '<div class="badge bg-success">aprobado</div>' WHEN 2 THEN '<div class="badge bg-danger">cancelado</div>' END estado_autorizacion
,vs.nota_autorizacion
, CASE IFNULL(dv.estado,0) WHEN 0 THEN '<div class="badge bg-info">pendiente</div>' WHEN 1 THEN '<div class="badge bg-success">depositado</div>' WHEN 2 THEN '<div class="badge bg-danger">cancelado</div>' END estado_deposito
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
INNER JOIN usuarios usemo ON usemo.nroidenti=vs.usuario_solicitud
LEFT JOIN ts_depositos_viaticos dv ON dv.solicitud=vs.solicitud AND dv.anio=vs.anio
WHERE DATE_FORMAT(vs.fecha_pedido, '%Y') = vanio AND vs.estado_autorizacion=1 AND dv.estado=1
ORDER BY fecha_pedido ; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_rendicion_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_rendicion_viaticos`(in `vanio` VARCHAR(20)) BEGIN
SELECT DATE_FORMAT(vs.fecha_pedido, '%Y')anio,vs.solicitud, CONCAT(us.apellido_pa,' ',us.apellido_ma,', ',us.nombres)personal
, CASE vs.estado WHEN 1 THEN '<span class="badge light badge-success"><i class="fa fa-circle TEXT-success me-1"></i>vigente</span>' WHEN 2 THEN '<span class="badge light badge-danger"><i class="fa fa-circle TEXT-danger me-1"></i>cerrado</span>' END estado
, DATE_FORMAT(vs.fecha_pedido, '%d/%m/%Y') fecha
,vs.nota_salida 
, CONCAT('<span class="doller font-w600">', IFNULL(dp.monto_deposito,0),'</span>') monto_deposito
, CONCAT('<span class=" TEXT-danger font-w600">', IFNULL((
SELECT SUM(a.gasto)
FROM ts_registros_viaticos a
WHERE a.solicitud=vs.solicitud AND a.anio=vs.anio),0),'</span>') gastos
, CONCAT('<span class="doller font-w600">', IFNULL(dp.monto_deposito,0)-(IFNULL((
SELECT SUM(a.gasto)
FROM ts_registros_viaticos a
WHERE a.solicitud=vs.solicitud AND a.anio=vs.anio),0)),'</span>') diferencia


, CONCAT(usemo.apellido_pa,' ',usemo.apellido_ma,', ',usemo.nombres)usuario
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
INNER JOIN usuarios usemo ON usemo.nroidenti=vs.usuario_solicitud
LEFT JOIN ts_depositos_viaticos dp ON dp.solicitud=vs.solicitud AND dp.anio=vs.anio
WHERE vs.anio=vanio AND vs.estado in(1,2) AND dp.estado=1
ORDER BY fecha_pedido;

--  date_format(vs.fecha_pedido, '%y'
END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_series
DELIMITER //
CREATE PROCEDURE `sp_w_lista_series`() BEGIN
SELECT
	m.modulo,
	m.descripcion,
	t.descripcion tipo_documento, IFNULL(t2.descripcion, '') tipo_documento_nc,
	s.serie,
	s.nro_inicio,
	s.nro_fin,
	s.nro_activo,
	s.nro_digitos,
	s.estado,
	t.tipo_documento tdoc, IFNULL(t2.tipo_documento, '0') tdocnc, CASE
		s.estado WHEN 1 THEN 'activo' ELSE 'inactivo' END destado
FROM
	ts_modulos m
INNER JOIN ts_series s ON s.modulo = m.modulo
INNER JOIN ts_tipos_documentos t ON t.tipo_documento = s.tipo_documento
LEFT JOIN ts_tipos_documentos t2 ON t2.tipo_documento = s.tipo_doc_nc
ORDER BY
	m.modulo; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lista_solicitud_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_lista_solicitud_viaticos`(in `vanio` VARCHAR(20)) BEGIN
SELECT CONCAT(us.apellido_pa,' ',us.apellido_ma,',',us.nombres)personal
-- ,concat(ubo.departamento,'/',ubo.provincia,'/',ubo.distrito)origen
-- ,concat(ubd.departamento,'/',ubd.provincia,'/',ubd.distrito)destino
,ubo.provincia origen
,ubd.provincia destino
,vs.nota_salida
,
DATE_FORMAT(vs.fecha_pedido, '%y') fechaanio
, DATE_FORMAT(vs.fecha_pedido, '%d-%m-%y') fecha
, DATE_FORMAT(vs.fecha_realizar, '%d-%m-%y') fecha_realizar
, DATE_FORMAT(vs.fecha_salida, '%d-%m-%y') fecha_salida
, DATE_FORMAT(vs.fecha_retorno, '%d-%m-%y') fecha_retorno
,vs.monto_solicitado
, CASE vs.estado_autorizacion WHEN 1 THEN '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewbox="0 0 24 24" fill="none" stroke="#488206" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="m16 21v-2a4 4 0 0 0-4-4h5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>'
WHEN 2 THEN '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewbox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="m16 21v-2a4 4 0 0 0-4-4h5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg>'
ELSE
									 '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewbox="0 0 24 24" fill="none" stroke="#d0860c" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="m20 21v-2a4 4 0 0 0-4-4h8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
END estado_autorizacion
,vs.usuario_autorizacion, DATE_FORMAT(vs.fecha_autorizacion, '%d-%m-%y')fecha_autorizacion,vs.nota_autorizacion

, CASE IFNULL(dv.estado,0) WHEN 0 THEN CONCAT('<div class="badge bg-info"></div>') WHEN 1 THEN CONCAT('<div class="badge bg-success">',dv.monto_deposito,'</div>') WHEN 2 THEN CONCAT('<div class="badge bg-danger">1</div>') END deposito




,dv.cuenta,'0' estado_deposito,'agregar' fecha_deposito,'agregar' usuario_deposito
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
LEFT JOIN ts_depositos_viaticos dv ON dv.solicitud=vs.solicitud AND dv.anio=vs.anio
WHERE DATE_FORMAT(vs.fecha_pedido, '%Y') = vanio AND vs.estado in(1,2)
ORDER BY fecha_pedido DESC; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_lubigeo
DELIMITER //
CREATE PROCEDURE `sp_w_lubigeo`() BEGIN
SELECT
	id, CONCAT(departamento, ' / ', provincia, ' / ', distrito) distrito
FROM
	ubigeos
ORDER BY
	distrito; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_mostrar_deposito_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_mostrar_deposito_viaticos`(in `vanio` VARCHAR(20), in `vsolic` VARCHAR(20)) BEGIN
SELECT DATE_FORMAT(vs.fecha_pedido, '%Y')anio,vs.solicitud, CONCAT(us.apellido_pa,' ',us.apellido_ma,', ',us.nombres)personal
, DATE_FORMAT(vs.fecha_pedido, '%d/%m/%Y') fecha
,vs.nota_salida
, DATE_FORMAT(dp.fecha_deposito, '%d/%m/%Y') fecha_deposito
,nota_autorizacion 
,vs.monto_solicitado
,dp.monto_deposito
, IFNULL(dp.forma_pago,0)forma_pago
, IFNULL(dp.banco,0)banco
,dp.cuenta
,dp.nota_deposito
, CONCAT(usemo.apellido_pa,' ',usemo.apellido_ma,', ',usemo.nombres)usuario

, IFNULL(dp.estado,0) estado_deposito

/*,case ifnull(vs.estado_deposito,0)     when 0 then '<div class="badge bg-info">pendiente</div>' 
													when 1 then '<div class="badge bg-success">aprobado</div>' 
													when 2 then '<div class="badge bg-danger">cancelado</div>' 
end estado_deposito*/
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
INNER JOIN usuarios usemo ON usemo.nroidenti=vs.usuario_solicitud
LEFT JOIN ts_depositos_viaticos dp ON dp.solicitud=vs.solicitud AND dp.anio=vs.anio
WHERE DATE_FORMAT(vs.fecha_pedido, '%Y') = vanio AND vs.solicitud=vsolic
ORDER BY fecha_pedido; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_mostrar_registro_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_mostrar_registro_viaticos`(in `vanio` VARCHAR(20), in `vsolic` VARCHAR(20)) BEGIN
SELECT DATE_FORMAT(vs.fecha_pedido, '%Y')anio,vs.solicitud, CONCAT(us.apellido_pa,' ',us.apellido_ma,', ',us.nombres)personal
, DATE_FORMAT(vs.fecha_pedido, '%d/%m/%Y') fecha
,nota_autorizacion 
,vs.monto_solicitado
, IFNULL(dp.monto_deposito,0)monto_deposito
,(
SELECT SUM(a.gasto)
FROM ts_registros_viaticos a
WHERE a.solicitud=vs.solicitud AND a.anio=vs.anio) gastos
,dp.monto_deposito-(IFNULL((
SELECT SUM(a.gasto)
FROM ts_registros_viaticos a
WHERE a.solicitud=vs.solicitud AND a.anio=vs.anio),0)) diferencia


, CONCAT(usemo.apellido_pa,' ',usemo.apellido_ma,', ',usemo.nombres)usuario
FROM ts_solicitudes_viaticos vs
INNER JOIN usuarios us ON us.id=vs.user_id
INNER JOIN ubigeos ubo ON ubo.id=vs.ubigeo_origen
INNER JOIN ubigeos ubd ON ubd.id=vs.ubigeo_destino
INNER JOIN usuarios usemo ON usemo.nroidenti=vs.usuario_solicitud
LEFT JOIN ts_depositos_viaticos dp ON dp.solicitud=vs.solicitud AND dp.anio=vs.anio
WHERE vs.anio = vanio AND vs.solicitud=vsolic
ORDER BY fecha_pedido;
 

--  date_format(vs.fecha_pedido, '%y'
END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_reporte_comprobante_caja
DELIMITER //
CREATE PROCEDURE `sp_w_reporte_comprobante_caja`(in `vcomprobante` VARCHAR(20)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT *
FROM (
SELECT 
			i.ruc rucempresa
			,i.nombre nombreempresa
			,i.direccion direccionempresa
			,i.pagina_web paginaempresa,i.imagen
			,et.dni
			, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.dni END END ruc
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social, IFNULL(et.direccion,'') direccion,'' programa

 
,dp.tipo_documento,td.descripcion tipodoc
, SUBSTRING_INDEX(dp.num_comprobante, '-', 1) serie
, SUBSTRING_INDEX(dp.num_comprobante, '-', -1) compr
,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%y")fecha_pago, DATE_FORMAT(dp.fecha_pago, '%h:%i') fechapagohora
,dp.cantidad,dp.monto_base,dp.descuento,dp.monto_total
,(
SELECT SUM(monto_base)
FROM ts_det_pagos_personas a
WHERE a.num_comprobante=dp.num_comprobante)tmonto_base
,(
SELECT SUM(descuento)
FROM ts_det_pagos_personas a
WHERE a.num_comprobante=dp.num_comprobante)tdescuento
,(
SELECT SUM(monto_total)
FROM ts_det_pagos_personas a
WHERE a.num_comprobante=dp.num_comprobante)tmonto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
, CONCAT(us.apellido_pa,' ',us.apellido_ma,',',us.nombres)usuario_impresion
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
LEFT JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
INNER JOIN usuarios us ON us.nroidenti=dp.creacion_usuario
INNER JOIN ts_instituciones i ON i.institucion=dp.institucion
WHERE dp.num_comprobante=vcomprobante AND dp.estado=1 -- and dp.fecha_pago between date(now()) and date(date_add(now(), interval 1 day)) and dp.estado=1  /* estado 1 cancelado 0 pendiente*/
)x
ORDER BY comprobante; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_reporte_x_concepto
DELIMITER //
CREATE PROCEDURE `sp_w_reporte_x_concepto`(in `vconcepto` VARCHAR(20), in `fechainicio` VARCHAR(12), in `fechafinal` VARCHAR(12)) BEGIN
 
 
 
 /*
estado=0 anulado
estado=1 pagodo
estado=2 pendiente 

*/
SELECT CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.ruc
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CASE WHEN dp.nroidenti='' THEN et.dni ELSE et.estudiante END END ELSE CASE WHEN dp.nroidenti='' THEN et.dni ELSE dp.nroidenti END END codigo
 		 
 		, CASE dp.tipo_documento WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 3 THEN /*nota de creditos tipo 3*/ CASE (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.tipo_documento=pp.tipo_documento_ref AND pp1.num_comprobante=pp.num_comprobante_ref) WHEN 2 THEN (
SELECT em.razon_social
FROM ts_empresas em
WHERE em.empresa = pp.empresa) WHEN 1 THEN CONCAT(et.paterno,' ',et.materno,',',et.nombres) END ELSE CONCAT(et.paterno,' ',et.materno,',',et.nombres) END razon_social

 
,td.descripcion tipodoc,dp.num_comprobante comprobante

, CASE dp.tipo_documento WHEN 3 THEN CASE WHEN (
SELECT pp1.tipo_documento
FROM ts_pagos_personas pp1
WHERE pp1.num_comprobante = pp.num_comprobante_ref AND pp1.tipo_documento = pp.tipo_documento_ref)=1 THEN 'anular bol. nº ' + pp.num_comprobante_ref ELSE 'anular fac. nº ' + pp.num_comprobante_ref END ELSE CASE WHEN dp.tipo_concepto = 1 THEN CONCAT(co.descripcion, ' ', dp.num_cuota, '/', dp.num_parte) ELSE co.descripcion END END concepto



,tm.descripcion tipo_concepto, DATE_FORMAT(dp.fecha_pago, "%d/%m/%Y")fecha_pago,dp.monto_total
, CASE dp.estado WHEN 0 THEN 'anulado' WHEN 1 THEN 'pagado' ELSE 'pendiente' END estado
, IFNULL(dp.nro_operacion,'')nro_operacion
, IFNULL(dp.fecha_operacion,'')fecha_operacion
,mp.descripcion medio_pago,ba.descripcion banco
FROM ts_det_pagos_personas dp
INNER JOIN ts_pagos_personas pp ON pp.tipo_documento=dp.tipo_documento AND pp.num_comprobante=dp.num_comprobante
INNER JOIN ts_cons_student et ON et.persona=dp.user_id
INNER JOIN ts_tipos_documentos td ON td.tipo_documento=dp.tipo_documento
INNER JOIN ts_conceptos co ON co.concepto=dp.concepto
INNER JOIN ts_medios_pagos mp ON mp.medio_pago=dp.medio_pago
INNER JOIN ts_tipos_conceptos tm ON tm.tipo_concepto=dp.tipo_concepto
INNER JOIN ts_bancos ba ON ba.banco=dp.banco
WHERE dp.concepto=vconcepto AND dp.fecha_pago BETWEEN fechainicio AND DATE(DATE_ADD(fechafinal, INTERVAL 1 DAY)) AND dp.estado=1 /* estado 1 cancelado 0 pendiente*/
ORDER BY dp.fecha_pago; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_talonario
DELIMITER //
CREATE PROCEDURE `sp_w_talonario`(in `vusuario` BIGINT, in `vtipo` VARCHAR(10)) BEGIN
SELECT
	m.descripcion,
	s.tipo_documento, CONCAT(s.serie, '-', LPAD(nro_activo, 8, '00000000')) AS serie,
	s.nro_activo,
	s.modulo,
	s.serie idserie
FROM
	ts_modulos m
INNER JOIN ts_series s ON s.modulo = m.modulo AND s.local = m.local
INNER JOIN ts_usuarios_ventas v ON v.modulo = m.modulo AND v.`local` = m.local
WHERE
	v.user_id = vusuario AND s.tipo_documento = vtipo AND v.estado = 1 AND m.estado = 1 AND s.estado = 1
ORDER BY
	s.tipo_documento; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_tipo_conceptos
DELIMITER //
CREATE PROCEDURE `sp_w_tipo_conceptos`() BEGIN
SELECT tipo_concepto,descripcion
FROM ts_tipos_conceptos
WHERE tipo_concepto in(2,3)
ORDER BY tipo_concepto; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_update_deposito_viaticos
DELIMITER //
CREATE PROCEDURE `sp_w_update_deposito_viaticos`(in `vsolicitud` VARCHAR(20), in `vanio` VARCHAR(20), in `vdfecha` VARCHAR(20), in `vmontodeposito` DECIMAL(18,2), in `vformpago` VARCHAR(5), in `vbanco` VARCHAR(5), in `vcuenta` VARCHAR(50), in `vnotadepo` VARCHAR(100), in `vestado` VARCHAR(5), in `vusuario` VARCHAR(50)) BEGIN SET
	@cant := (
SELECT COUNT(DISTINCT deposito)
FROM
			ts_depositos_viaticos
WHERE
			anio = vanio AND solicitud = vsolicitud
	); SET
	@codigo :=(
SELECT IFNULL(MAX(deposito), 0) + 1
FROM
			ts_depositos_viaticos
	); SET
	@fechadepo := DATE_FORMAT(STR_TO_DATE(vdfecha, '%d/%m/%y'), '%y-%m-%d');
UPDATE
	ts_depositos_viaticos SET
	fecha_deposito = @fechadepo,
	monto_deposito = vmontodeposito,
	forma_pago = vformpago,
	banco = vbanco,
	cuenta = vcuenta,
	nota_deposito = vnotadepo,
	estado = vestado,
	usuario = vusuario,
	creacion_fecha = NOW()
WHERE
	solicitud = vsolicitud AND anio = vanio;
SELECT
	'exito' descripcion, CONCAT('se registro correctamente') obs,
	1 estado,
	'success' class; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_update_estado_serie
DELIMITER //
CREATE PROCEDURE `sp_w_update_estado_serie`(in `vmodulo` VARCHAR(20), in `vtipdoc` VARCHAR(20), in `vseries` VARCHAR(20), in `vnroactivo` VARCHAR(10)) BEGIN
UPDATE
	ts_series SET
	estado = vnroactivo
WHERE
	modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries;
SELECT
	'exito' descripcion,
	'el registro actualizado' obs,
	1 estado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_update_modulo
DELIMITER //
CREATE PROCEDURE `sp_w_update_modulo`(in `vmodulo` VARCHAR(200), in `vdescripcion` VARCHAR(200), in `vestacion` VARCHAR(200)) BEGIN
UPDATE
	ts_modulos SET
	`descripcion` = vdescripcion,
	`estacion` = vestacion
WHERE
	modulo = vmodulo;
SELECT
	'exito' descripcion,
	'el registro de actualizo' obs,
	1 estado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_update_serie
DELIMITER //
CREATE PROCEDURE `sp_w_update_serie`(in `vmodulo` VARCHAR(20), in `vtipdoc` VARCHAR(20), in `vseries` VARCHAR(20), in `vnroactivo` VARCHAR(10)) BEGIN
UPDATE
	ts_series SET
	nro_activo = vnroactivo
WHERE
	modulo = vmodulo AND tipo_documento = vtipdoc AND serie = vseries;
SELECT
	'exito' descripcion,
	'el registro actualizado' obs,
	1 estado; END//
DELIMITER ;

-- Volcando estructura para procedimiento sga-huanuco.sp_w_usuario_talonario
DELIMITER //
CREATE PROCEDURE `sp_w_usuario_talonario`() BEGIN
SELECT DISTINCT ua.nroidenti dni, CONCAT(
		ua.apellido_pa,
		' ',
		ua.apellido_ma,
		',',
		ua.nombres
	) nombres,
	ua.id AS idusuario,
	m.modulo,
	m.descripcion, CASE WHEN us.estado = 1 THEN 'activo' ELSE 'inactivo' END estado
FROM
	ts_usuarios_ventas us
LEFT JOIN ts_modulos m ON m.modulo = us.modulo AND us.local = m.local
LEFT JOIN ts_series s ON s.modulo = m.modulo
LEFT JOIN ts_tipos_documentos t ON t.tipo_documento = s.tipo_documento
LEFT JOIN usuarios ua ON ua.id = us.user_id
LEFT JOIN ts_tipos_documentos t2 ON t2.tipo_documento = s.tipo_doc_nc
WHERE
	m.estado = 1 AND us.estado in(1, 0) AND ua.estado = 1
ORDER BY
	m.modulo; END//
DELIMITER ;

-- Volcando estructura para vista sga-huanuco.ts_cons_student
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `ts_cons_student` (
	`persona` BIGINT(20) UNSIGNED NOT NULL,
	`dni` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`idprograma` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_general_ci',
	`institucion` INT(1) NOT NULL,
	`estudiante` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`paterno` VARCHAR(45) NULL COLLATE 'utf8mb4_unicode_ci',
	`materno` VARCHAR(45) NULL COLLATE 'utf8mb4_unicode_ci',
	`nombres` VARCHAR(45) NULL COLLATE 'utf8mb4_unicode_ci',
	`programa` VARCHAR(350) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`estado` INT(2) NULL,
	`direccion` TEXT NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista sga-huanuco.ts_cons_student
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `ts_cons_student`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ts_cons_student` AS
SELECT `u`.`id` AS `persona`,`u`.`nroidenti` AS `dni`, IFNULL(`pr`.`id`,'') AS `idprograma`,1 AS `institucion`,`u`.`nroidenti` AS `estudiante`,`u`.`apellido_pa` AS `paterno`,`u`.`apellido_ma` AS `materno`,`u`.`nombres` AS `nombres`, IFNULL(`pr`.`nombre`,'') AS `programa`, CASE WHEN `u`.`usertype_id` = 3 THEN 10 ELSE 9 END AS `estado`,`u`.`direccion` AS `direccion`
FROM (((`usuarios` `u`
LEFT JOIN `estudiantes` `st` ON(`st`.`user_id` = `u`.`id`))
LEFT JOIN `planes` `pl` ON(`pl`.`id` = `st`.`plan_id`))
LEFT JOIN `programas` `pr` ON(`pr`.`id` = `pl`.`program_id`))
WHERE `u`.`usertype_id` in (3,1,2);

