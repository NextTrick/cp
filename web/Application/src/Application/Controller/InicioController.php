<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InicioController extends AbstractActionController
{
    public function indexAction()
    {
        session_start();
        var_dump($_SESSION);exit;
        echo 'Pantalla Inicio:';
        exit;
        $view = new ViewModel();
        return $view;
    }
}
