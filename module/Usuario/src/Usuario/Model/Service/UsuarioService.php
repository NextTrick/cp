<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

class UsuarioService
{
    const DI_DNI = 1;
    const DI_PASAPORTE = 2;
    
    protected $_repository = null;
    protected $_sl = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getDocumentoIdentidadTipo()
    {
        return array(
            self::DI_DNI => 'DNI',
            self::DI_PASAPORTE => 'Pasaporte',
        );
    }

    public function registrarEnTrueFi($data)
    {
        return $this->_getTrueFiUsuarioService()->newMember($data);
    }

    public function getRepository()
    {
        return $this->_repository;
    }
    
    protected function _getTrueFiUsuarioService()
    {
        return $this->_sl->get('TrueFi\Model\Service\UsuarioService');
    }
}