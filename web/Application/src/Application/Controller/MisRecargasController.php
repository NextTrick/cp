<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class MisRecargasController extends SecurityWebController
{
    public function indexAction()
    {
        var_dump($this->_isLogin());
        exit;
        $view = new ViewModel();
        return $view;
    }
}
