<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Cart\Model\Service\CartService;
use TrueFi\Model\Service\UsuarioService;
use Util\Model\Service\ErrorService;
use Zend\View\Model\ViewModel;
use Common\Helpers\Util;
use Common\Helpers\Crypto;
use Orden\Model\Service\OrdenService;

class CarritoController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        $usuario = $this->_getUsuarioData();
        $cartModel = $this->_getCartService()->getCart();
        
        $config = $this->getServiceLocator()->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }

        $cattidades = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05');

        $usuarioTarjetas = $this->_getTarjetaService()->getDdlTarjetas($usuario->id);
        
        $view = new ViewModel();
        $view->setVariable('cartModel', $cartModel);
        $view->setVariable('cattidades', $cattidades);
        $view->setVariable('usuarioTarjetas', $usuarioTarjetas);
        $view->setVariable('urlImg', $config['fileDir']['paquete_paquete']['down']);
        return $view;
    }

    public function modificarAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION);
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }

        if ($this->request->isPost()) {
            $productoId = $this->request->getPost('id');
            $cantidad = $this->request->getPost('cantidad');
            $tarjetaCode = $this->request->getPost('tarjeta');
            $oldTarjetaCode = $this->request->getPost('old_tarjeta');
            
            $criteria = array('where' => array('id' => $productoId));
            $paquete = $this->_getPaqueteService()->getRepository()->findOne($criteria);
            $tarjetaId = Crypto::decrypt($tarjetaCode, Util::VI_ENCODEID);
            $criteria2 = array('where' => array('id' => $tarjetaId));
            $tarjeta = $this->_getTarjetaService()->getRepository()->findOne($criteria2);
            if (!empty($paquete) && !empty($tarjeta)) {
                $producto = array(
                    'product_id' => $paquete['id'],
                    'product_name' => $paquete['titulo1'],
                    'product_name2' => $paquete['titulo2'],
                    'imagen' => $paquete['imagen'],
                    'quantity' => $cantidad,
                    'price' => $paquete['emoney'],
                    'category_code' => $tarjetaCode,
                    'category_nombre' => $tarjeta['nombre'],
                    'options' => array(
                        'emoney' => $paquete['emoney'],
                        'bonus' => $paquete['bonus'],
                        'promotionbonus' => $paquete['promotionbonus'],
                        'etickets' => $paquete['etickets'],
                        'gamepoints' => $paquete['gamepoints'],
                        'legal' => $paquete['legal'],
                    ),
                );
                
                if (empty($oldTarjetaCode)) {
                    //Reemplaza la cantidad a la tarjeta associada
                    $cartModel = $this->_getCartService()->addCart($producto, $tarjetaCode);
                } else {
                    //Adiciona la cantidad y remueve el producto asocciado a la tarjeta antigua
                    $cartModel = $this->_getCartService()->addCart($producto, $tarjetaCode, true);
                    $this->_getCartService()->removeCart($oldTarjetaCode);
                }
                
                if (!empty($cartModel)) {
                    $data = array(
                        'subtotal' => $cartModel->getAmountGroup(true),
                        'total' => $cartModel->getAmountCart(true),
                        'cantidad' => $cartModel->getQuantityGroup(),
                        'cantidadTotal' => $cartModel->getQuantityCart(),
                    );
                    
                    $result = array(
                        'success' => true,
                        'message' => null,
                        'data' => $data,
                    );
                }
            }
        }
        
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function eliminarAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION);
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }

        if ($this->request->isPost()) {
            $productoId = $this->request->getPost('id');
            $tarjetaCode = $this->request->getPost('tarjeta');
            
            if (!empty($productoId) && !empty($tarjetaCode)) {
                $success = $this->_getCartService()->removeCart($tarjetaCode, $productoId);
                if ($success) {
                    $result = array(
                        'success' => true,
                        'message' => null,
                    );
                }
            }
        }

        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function pagosAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        
        $usuario = $this->_getUsuarioData();
        $cartModel = $this->_getCartService()->getCart();
        
        $config = $this->getServiceLocator()->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }

        if (empty($cartModel)) {
            return $this->redirect()->toRoute('web-carrito', array('controller' => 'index'));
        }
        

        $codPais = \Sistema\Model\Service\UbigeoService::COD_PAIS_PERU;
        $codDepa = \Sistema\Model\Service\UbigeoService::COD_DEPA_LIMA;
        $codProv = \Sistema\Model\Service\UbigeoService::COD_PROV_LIMA;
        $distritos = $this->_getUbigeoService()->getDistritos($codPais, $codDepa, $codProv);

        $criteria = array(
            'where' => array('usuario_id' => $usuario->id),
            'columns' => array('id', 'fac_razon_social')
        );
        $perfilPagos = $this->_getPerfilPagoService()->getRepository()->findPairs($criteria);
        
        $validator = new \Zend\Validator\Csrf();
        $validator->setName('token_csrf');
        $tokenCsrf = $validator->getHash(true);
        
        $criteria2 = array('where' => array('id' => $usuario->id));
        $usuarioData = $this->_getUsuarioService()->getRepository()->findOne($criteria2);
        
        $view = new ViewModel();
        $view->setVariable('tokenCsrf', $tokenCsrf);
        $view->setVariable('cartModel', $cartModel);
        $view->setVariable('perfilPagos', $perfilPagos);
        $view->setVariable('distritos', $distritos);
        $view->setVariable('usuarioData', $usuarioData);
        $view->setVariable('urlImg', $config['fileDir']['paquete_paquete']['down']);
        return $view;
    }
    
    public function perfilPagoAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION);
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }
        
        if ($this->request->isPost()) {
            $usuario = $this->_getUsuarioData();
            $tokenCsrf = $this->request->getPost('token_csrf');
            $validator1 = new \Zend\Validator\Csrf();
            $validator1->setName('token_csrf');
            $isValidToken = $validator1->isValid($tokenCsrf);
            $result['token'] = $validator1->getHash(true);
            if (!$isValidToken) {
                $result['message'] = ERROR_TOKEN;
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            $perfilPagoId = $this->request->getPost('perfil_pago');
            $criteria = array(
                'where' => array('id' => $perfilPagoId, 'usuario_id' => $usuario->id),
                'columns' => array(
                    'fac_razon_social',
                    'fac_direccion_fiscal',
                    'fac_direccion_entrega_factura',
                    'documento_numero',
                    'distrito_id',
                ),
            );
            $row = $this->_getPerfilPagoService()->getRepository()->findOne($criteria);
            if (!empty($row)) {
                $ubigeo = array();
                if (!empty($row['distrito_id'])) {
                    $criteria = array('where' => array('id' => $row['distrito_id']));
                    $ubigeo = $this->_getUbigeoService()->getRepository()->findOne($criteria);
                }

                $row['distrito_id'] = empty($ubigeo['distrito_id']) ? null : $ubigeo['distrito_id'];
                unset($row['distrito_id']);

                $result['success'] = true;
                $result['message'] = null;
                $result['data'] = $row;
            }
        }
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function pagarAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION, 'paramsInvalid' => array());

        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }
        
        if ($this->request->isPost()) {
            $usuario = $this->_getUsuarioData();
            $tokenCsrf = $this->request->getPost('token_csrf');
            $validator1 = new \Zend\Validator\Csrf();
            $validator1->setName('token_csrf');
            $isValidToken = $validator1->isValid($tokenCsrf);
            $result['token'] = $validator1->getHash(true);
            if (!$isValidToken) {
                $result['message'] = ERROR_TOKEN;
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $perfilPagoId = $this->request->getPost('perfil_pago');
            $comprobanteTipo = $this->request->getPost('comprobante_tipo');
            $metodoPago = $this->request->getPost('metodo_pago');
            $params = $this->request->getPost();

            switch ($comprobanteTipo) {
                case \Orden\Model\Service\OrdenService::TIPO_COMPROBANTE_BOLETA:
                    $perfilPagoData = array(
                        'usuario_id' => $usuario->id,
                        'comprobante_tipo' => $comprobanteTipo,
                        'nombres' => $params['nombres'],
                        'paterno' => $params['paterno'],
                        'materno' => $params['materno'],
                        'documento_tipo' => \Orden\Model\Service\OrdenService::TIPO_DOCUMENTO_DNI,
                        'documento_numero' => $params['documento_numero'],
                    );
                    break;
                case \Orden\Model\Service\OrdenService::TIPO_COMPROBANTE_FACTURA:
                    $criteria = array('where' => array(
//                        'cod_pais' => \Sistema\Model\Service\UbigeoService::COD_PAIS_PERU,
                        'cod_depa' => \Sistema\Model\Service\UbigeoService::COD_DEPA_LIMA,
                        'cod_prov' => \Sistema\Model\Service\UbigeoService::COD_PROV_LIMA,
                        'distrito_id' => $params['distrito_id'],
                    ));
                    $row = $this->_getUbigeoService()->getRepository()->findOne($criteria);
                    $distritoId = empty($row) ? null : $row['id'];
                    $perfilPagoData = array(
                        'usuario_id' => $usuario->id,
                        'comprobante_tipo' => $comprobanteTipo,
                        'fac_razon_social' => $params['fac_razon_social'],
                        'fac_direccion_fiscal' => $params['fac_direccion_fiscal'],
                        'fac_direccion_entrega_factura' => $params['fac_direccion_entrega_factura'],
                        'documento_tipo' => \Orden\Model\Service\OrdenService::TIPO_DOCUMENTO_RUC,
                        'documento_numero' => $params['ruc'],
                        'distrito_id' => $distritoId,
                    );
                    break;
            }

            $paramsInvalid = array();
            foreach ($perfilPagoData as $key => $value) {
                $filter = new \Zend\Filter\StripTags();
                $value = $filter->filter($value);
                $valid = new \Zend\Validator\NotEmpty();
                $data[$key] = $value;
                if ($valid->isValid($value) == false) {
                    $paramsInvalid[] = $key;
                }
            }

            if (empty($data) || !empty($paramsInvalid)) {
                $result['paramsInvalid'] = $paramsInvalid;
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }

            if (!empty($data)) {
                $return = $this->_getOrdenService()->procesarPago($comprobanteTipo, $metodoPago, $usuario, $data);
                $result = $return;
            }
        }

        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }

    /**
     * @return OrdenService;
     */
    private function _getOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\OrdenService');
    }

    /**
     * @return DetalleOrdenService
     */
    private function _getDetalleOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\DetalleOrdenService');
    }
    
    private function _getUbigeoService()
    {
        return $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
    }
    
    private function _getPerfilPagoService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\PerfilPagoService');
    }

    /**
     * @return CartService;
     */
    private function _getCartService()
    {
        return $this->getServiceLocator()->get('Cart\Model\Service\CartService');
    }
    
    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
    
    private function _getTarjetaService()
    {
        return $this->getServiceLocator()->get('Tarjeta\Model\Service\TarjetaService');
    }

    /**
     * @return UsuarioService
     */
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
}
