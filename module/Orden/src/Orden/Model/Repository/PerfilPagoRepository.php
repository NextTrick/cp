<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Repository;

use Zend\Db\Adapter\Adapter;

class PerfilPagoRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'usuario_perfil_pago';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
