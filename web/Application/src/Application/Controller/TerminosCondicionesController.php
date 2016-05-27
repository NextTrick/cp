<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Util\Common\Email;

class TerminosCondicionesController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
}
