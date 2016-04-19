<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Model\Service;

class PaqueteService
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
    
    public function promocionesEnTrueFi()
    {
        return $this->_getTrueFiPaqueteService()->getPromotions();
    }
    
    protected function _getTrueFiPaqueteService()
    {
        return $this->_sl->get('TrueFi\Model\Service\PromocionService');
    }
}