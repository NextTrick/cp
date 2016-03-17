<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Common\Controller\SecurityAdminController;

class ErrorController extends SecurityAdminController
{   
    public function indexAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        var_dump($response->getMetadata());
        var_dump(111);exit;
        $data = array('msg' => 'Bienvenido al sistema');
        return new ViewModel($data);
    }
}