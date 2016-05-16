<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class RecargasController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }

        $tarjetaCodigo = $this->params('codigo');
        $usuario = $this->_getUsuarioData();
        $view = new ViewModel();
        $view->setVariable('tarjetaCodigo', $tarjetaCodigo);
        $view->setVariable('usuarioId', $usuario->id);
        return $view;
    }
}
