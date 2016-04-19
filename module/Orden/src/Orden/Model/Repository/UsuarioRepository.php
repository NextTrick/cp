<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Repository;

use Zend\Db\Adapter\Adapter;

class UsuarioRepository extends \Common\Model\Repository\Zf2AbstractTableGateway
{
    protected $table = 'usuario_usuario';
    protected $cache;
    
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
    }
}
