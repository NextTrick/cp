<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Cart\Model\Service\CartService;
use Orden\Model\Repository\OrdenRepository;
use PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor;
use PaymentProcessor\Model\Gateway\Processor\VisaProcessor;
use PaymentProcessor\Model\PaymentProcessor;
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
        
        $view = new ViewModel();
        $view->setVariable('tokenCsrf', $tokenCsrf);
        $view->setVariable('cartModel', $cartModel);
        $view->setVariable('perfilPagos', $perfilPagos);
        $view->setVariable('distritos', $distritos);
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

                $row['cod_dist'] = empty($ubigeo['cod_dist']) ? null : $ubigeo['cod_dist'];
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
                        'cod_pais' => \Sistema\Model\Service\UbigeoService::COD_PAIS_PERU,
                        'cod_depa' => \Sistema\Model\Service\UbigeoService::COD_DEPA_LIMA,
                        'cod_prov' => \Sistema\Model\Service\UbigeoService::COD_PROV_LIMA,
                        'cod_dist' => $params['cod_dist'],
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
                $this->_savePerfilPago($comprobanteTipo, $usuario, $data);
                $return = $this->_pagar($metodoPago, $data);
                $result = $return;
            }
        }

        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }

    private function _pagar($metodoPago, $data)
    {
        $return = array('success' => true);

        $metodoPago = strtoupper($metodoPago);
        $usuario = $this->_getUsuarioData();
        $usuarioData = $this->_getUsuarioService()->getRepository()->getById($usuario->id);
        $cartModel = $this->_getCartService()->getCart();
        $monto = $cartModel->getAmountCart(true);
        $data['pago_estado'] = OrdenRepository::PAGO_ESTADO_PENDIENTE;
        $ordenId = $this->_getOrdenService()->getRepository()->save($data);

        $this->_saveDetalleOrden($ordenId);

        $paymentProcessordata = array(
            'id' => $ordenId, // ID DE LA ORDEN
            'perfilpago_nombres' => $usuarioData['nombres'], // NOMBRE DEL PERFIL DE PAGO
            'perfilpago_paterno' => $usuarioData['paterno'], // APELLIDO PATERNO DEL PERFIL DE PAGO
            'perfilpago_materno' => $usuarioData['materno'], // APELLIDO MATERNO DEL PERFIL DE PAGO
            'perfilpago_alias' => $usuarioData['nombres'], // ALIAS DEL PERFIL DE PAGO (para nuestro caso, el mismo de nombres)
            'perfilpago_pais' => 'PERU', // PAIS DEL PERFIL DE PAGO
            'perfilpago_departamento' => 'LIMA',  // DEPARTAMENTO DEL PERFIL DE PAGO
            'perfilpago_distrito' => 'LIMA', // DISTRITO DEL PERFIL DE PAGO
            'documento_tipo' => $usuarioData['di_tipo'], // TIPO COMPROBANTE
            'documento_numero' => $usuarioData['di_valor'], // NRO COMPROBANTE
            'usuario_email' => $usuarioData['email'],  // CORREO DE USUARIO LOGUEADO
            'usuario_id' => $usuarioData['id'], // ID DE USUARIO LOGUEADO
            'monto' => (string) $monto, // MONTO EN CON 2 DECIMALES
        );

        $paymentProcessor = new PaymentProcessor($metodoPago, $this->getServiceLocator());
        $response = $paymentProcessor->createCharge($paymentProcessordata);

        if (!empty($response['success'])) {
            switch ($metodoPago) {
                case PagoEfectivoProcessor::ALIAS :
                    $ordenUpdateData = array(
                        'pago_referencia' => $response['data']['reference'],
                        'pago_estado' => $response['data']['status'],
                        'pago_cip' => $response['data']['cip'],
                        'pago_token' => $response['data']['token'],
                        'pago_metodo' => OrdenService::METODO_PAGO_NAME_PE,
                    );
                    break;
                case VisaProcessor::ALIAS :
                    $ordenUpdateData = array(
                        'pago_referencia' => $response['data']['reference'],
                        'pago_estado' => $response['data']['status'],
                        'pago_metodo' => OrdenService::METODO_PAGO_NAME_VISA,
                    );
                    break;
            }
            $return['data']['redirect'] = $response['data']['redirect'];
        } else {
            $return['success'] = false;
            $ordenUpdateData = array(
                'pago_estado' => OrdenRepository::PAGO_ESTADO_ERROR,
                'pago_error' => $response['error']['code'],
                'pago_error_detalle' => $response['error']['message'],
            );

            if ($response['error']['code'] == ErrorService::GENERAL_CODE) {
                $return['message'] = ErrorService::GENERAL_MESSAGE;
            } else {
                $return['message'] = $response['error']['message'];
            }
        }

        $this->_getOrdenService()->getRepository()->save($ordenUpdateData, $ordenId);

        return $return;
    }

    private function _procesarPago($metodoPago, $ordenId, $data)
    {
        $data = array(
            'id' => $ordenId, // ID DE LA ORDEN
            'perfilpago_nombres' => $data['nombes'], // NOMBRE DEL PERFIL DE PAGO
            'perfilpago_paterno' => 'Jara', // APELLIDO PATERNO DEL PERFIL DE PAGO
            'perfilpago_materno' => 'Vilca', // APELLIDO MATERNO DEL PERFIL DE PAGO
            'perfilpago_alias' => 'NextTrick', // ALIAS DEL PERFIL DE PAGO (para nuestro caso, el mismo de nombres)
            'perfilpago_pais' => 'PERU', // PAIS DEL PERFIL DE PAGO
            'perfilpago_departamento' => 'LIMA',  // DEPARTAMENTO DEL PERFIL DE PAGO
            'perfilpago_distrito' => 'LIMA', // DISTRITO DEL PERFIL DE PAGO
            'comprobante_tipo' => 'DNI', // TIPO COMPROBANTE
            'comprobante_numero' => '11872911', // NRO COMPROBANTE
            'usuario_email' => 'ing.angeljara@gmail.com',  // CORREO DE USUARIO LOGUEADO
            'usuario_id' => 1, // ID DE USUARIO LOGUEADO
            'monto' => '20.00' // MONTO EN CON 2 DECIMALES
        );

        try {
            $alias = \PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor::ALIAS;
            $paymentProcessor = new PaymentProcessor($alias, $this->getServiceLocator());

            $response = $paymentProcessor->createCharge($data);

            //var_dump($response);
            return $this->redirect()->toUrl($response['data']['redirect']); exit;
        } catch (\Exception $e) {
            var_dump($e->getMessage(), $e->getTraceAsString()); exit;
        }

        echo 'fin'; exit;
    }

    private function _saveDetalleOrden($ordenId)
    {
        $cartModel = $this->_getCartService()->getCart();

        if (!empty($cartModel)) {
            foreach ($cartModel->getProductsCart() as $productos) {
                foreach ($productos as $producto) {
                    $ordenDetalleData = array(
                        'orden_id' => $ordenId,
                    );
                    $options = $this->_getValidOptions($producto);
                    $ordenDetalleData = $ordenDetalleData + $options;

                    $categoryCode = $producto->getCategoryCode();
                    $tarjetaId = Crypto::decrypt($categoryCode, Util::VI_ENCODEID);

                    $ordenDetalleData['paquete_id'] = $producto->getProductId();
                    $ordenDetalleData['tarjeta_id'] = $tarjetaId;
                    $ordenDetalleData['monto'] = $producto->getPrice(true);

                    $ordenDetalleId = $this->_getDetalleOrdenService()->getRepository()->save($ordenDetalleData);
                }
            }
        }

    }

    private function _getValidOptions($producto)
    {
        $options['emoney'] = $producto->getOption('emoney', true);
        $options['bonus'] = $producto->getOption('bonus', true);
        $options['promotionbonus'] = $producto->getOption('promotionbonus', true);
        $options['etickets'] = $producto->getOption('etickets', true);
        $options['gamepoints'] = $producto->getOption('gamepoints', true);

        foreach ($options as $key => $value) {
            $value = (float) $value;
            if (empty($value)) {
                unset($options[$key]);
            }
        }

        return $options;
    }

    private function _savePerfilPago($comprobanteTipo, $usuario, $data)
    {
        if ($comprobanteTipo == \Orden\Model\Service\OrdenService::TIPO_COMPROBANTE_FACTURA) {
            $criteria = array('where' => array(
                'documento_tipo' => \Orden\Model\Service\OrdenService::TIPO_DOCUMENTO_RUC,
                'documento_numero' => $data['documento_numero'],
                'usuario_id' => $usuario->id));

            $row = $this->_getPerfilPagoService()->getRepository()->findOne($criteria);
            if (!empty($row)) {
                $data['fecha_edicion'] = date('Y-m-d H:i:s');
                $this->_getPerfilPagoService()->getRepository()->save($data, $row['id']);
            } else {
                $data['fecha_creacion'] = date('Y-m-d H:i:s');
                $this->_getPerfilPagoService()->getRepository()->save($data);
            }
        }
    }

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
