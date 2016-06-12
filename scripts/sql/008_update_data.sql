UPDATE orden_orden SET `pago_estado` = 'EXPIRADO', `pago_error` = '595', pago_error_detalle = 'Sobrepasó el tiempo de expiración'
WHERE `pago_estado` = 'ERROR'
AND pago_metodo = 'PE';