<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;

class TestController extends SecurityAdminController
{
    public function indexAction()
    {
        //{EBAB4CD7-EE8E-48DF-90C1-7C8F283EF3AE}
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'FirstName' => 'Juan Carlos',
            'LastName' => 'Ludeña ',
            'EMail' => 'jludena@idigital.pe',
            'Password' => '@1bT43#Q',
            'Type' => \TrueFi\Model\Service\UsuarioService::TIPO_CLIENTE,
        );
        $result = $service->newMember($data);
        var_dump($result);
        exit;
    }
    
    
    protected function _getTrueFiUsuarioService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\UsuarioService');
    }
}
