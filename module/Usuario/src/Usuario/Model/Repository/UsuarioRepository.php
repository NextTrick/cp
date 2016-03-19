<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Repository;

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
