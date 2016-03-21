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

class MainController extends SecurityAdminController
{
    public function indexAction()
    {
//        var_dump($_SESSION);
//        exit;
        return new ViewModel();
    }
}
