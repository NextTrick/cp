<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Cms\Model\Service;

class ContenidoService
{
    protected $_repository = null;
    protected $_sl = null;
    
    const TIPO_PAGINA = 1;
    const TIPO_SECCION = 2;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
    
    public function getTipos()
    {
        return array(
            self::TIPO_PAGINA => 'Página',
            self::TIPO_SECCION => 'Sección',
        );
    }
}