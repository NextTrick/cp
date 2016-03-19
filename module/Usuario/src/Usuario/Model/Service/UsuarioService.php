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
    protected $_repository = null;
    protected $_sl = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}