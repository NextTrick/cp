<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;


class CartController extends SecurityWebController
{
    public function agregarAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }

        $result = array('success' => false);
        if ($this->request->isPost()) {
            $usuario = $this->_getUsuarioData();
            $numero = $this->request->getPost('numero');
            $nombre = $this->request->getPost('id');
         
            $data = array(
                'subtotal' => 0,
                'total' => 0,
                'cantidad' => 0,
            );
            $result = array(
                'success' => true,
                'data' => $data,
            );
        }
        
        $response = $this->getResponse();
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
}
