<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Service;
use Cart\Model\Service\CartService;
use Common\Helpers\Crypto;
use \Common\Helpers\String;
use Orden\Model\Repository\OrdenRepository;
use PaymentProcessor\Model\Gateway\Processor\PagoEfectivoProcessor;
use PaymentProcessor\Model\Gateway\Processor\VisaProcessor;
use PaymentProcessor\Model\PaymentProcessor;
use Tarjeta\Model\Service\TarjetaService;
use Usuario\Model\Service\PerfilPagoService;
use Usuario\Model\Service\UsuarioService;
use Util\Model\Service\ErrorService;
use Util\Util\Util;
use Zend\View\Model\ViewModel;

class OrdenService
{
    protected $_repository = null;
    protected $_sl         = null;

    CONST TIPO_COMPROBANTE_BOLETA       = 1;
    CONST TIPO_COMPROBANTE_FACTURA      = 2;
    CONST TIPO_COMPROBANTE_NAME_BOLETA  = 'Boleta';
    CONST TIPO_COMPROBANTE_NAME_FACTURA = 'Factura';

    CONST TIPO_DOCUMENTO_RUC      = 1;
    CONST TIPO_DOCUMENTO_DNI      = 2;
    CONST TIPO_DOCUMENTO_NAME_RUC = 'RUC';
    CONST TIPO_DOCUMENTO_NAME_DNI = 'DNI';

    CONST METODO_PAGO_VISA        = 1;
    CONST METODO_PAGO_PE          = 2;
    CONST METODO_PAGO_MASTER      = 3;
    CONST METODO_PAGO_NAME_VISA   = 'VISA';
    CONST METODO_PAGO_NAME_PE     = 'PE';
    CONST METODO_PAGO_NAME_MASTER = 'Master Card';

    CONST ESTADO_PAGO_ERROR          = 1;
    CONST ESTADO_PAGO_PAGADO         = 2;
    CONST ESTADO_PAGO_PENDIENTE      = 3;
    CONST ESTADO_PAGO_EXPIRADO       = 4;
    CONST ESTADO_PAGO_NAME_ERROR     = 'Error';
    CONST ESTADO_PAGO_NAME_PAGADO    = 'Pagado';
    CONST ESTADO_PAGO_NAME_PENDIENTE = 'Pendiente';
    const ESTADO_PAGO_NAME_EXPIRADO  = 'Expirado';

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
    }

    public function getRepository()
    {
        return $this->_repository;
    }

    public function getDataCriteria($params)
    {
        $criteria = array(
            'whereLike'    => null,
            'limit'        => null,
            'where'        => null,
            'whereBetween' => null
        );

        if (!empty($params)) {
            $nameFilter = String::xssClean($params['cmbFiltro']);

            $paramsLike = array(
                $nameFilter => String::xssClean($params['txtBuscar']),
            );

            $paramsWhere = array(
                'comprobante_tipo' => String::xssClean($params['cmbTipoComp']),
                'pago_estado'      => String::xssClean($params['cmbPagoEstado']),
                'pago_tarjeta'     => String::xssClean($params['cmbMetodoPago']),
            );

            $betwween = array(
                'o.fecha_creacion' => array(
                    'min'=> String::xssClean($params['txtFechaIni']),
                    'max'=> String::xssClean($params['txtFechaFin'])
                    )
            );

            $criteria = array(
                'whereLike'    => $paramsLike,
                'limit'        => LIMIT_BUSCAR,
                'where'        => $paramsWhere,
                'whereBetween' => $betwween
            );
        }

        return $criteria;
    }
    

    public function procesarPago($comprobanteTipo, $metodoPago, $usuario, $data)
    {
        $this->_savePerfilPago($comprobanteTipo, $usuario, $data);

        $return = array('success' => true);

        $metodoPago = strtoupper($metodoPago);
        $usuarioData = $this->_getUsuarioService()->getRepository()->getById($usuario->id);
        $cartModel = $this->_getCartService()->getCart();
        $monto = $cartModel->getAmountCart(true);
        $data['pago_estado'] = OrdenRepository::PAGO_ESTADO_PENDIENTE;
        $data['fecha_creacion'] = $cDate = date('Y-m-d H:i:s');
        $data['monto'] = $monto;
        $ordenId = $this->getRepository()->save($data);
        $ordenCodigo = $this->setCodigo($ordenId);

        $this->_saveDetalleOrden($ordenId, $cDate);

        $dataAdicional = $this->getDataAdicional();

        $paymentProcessordata = array(
            'id' => $ordenCodigo, // CODIGO DE LA ORDEN
            'perfilpago_nombres' => $usuarioData['nombres'], // NOMBRE DEL PERFIL DE PAGO
            'perfilpago_paterno' => $usuarioData['paterno'], // APELLIDO PATERNO DEL PERFIL DE PAGO
            'perfilpago_materno' => $usuarioData['materno'], // APELLIDO MATERNO DEL PERFIL DE PAGO
            'perfilpago_alias' => $usuarioData['nombres'], // ALIAS DEL PERFIL DE PAGO (para nuestro caso, el mismo de nombres)
            'perfilpago_pais' => 'PERU', // PAIS DEL PERFIL DE PAGO
            'perfilpago_departamento' => 'LIMA',  // DEPARTAMENTO DEL PERFIL DE PAGO
            'perfilpago_distrito' => 'LIMA', // DISTRITO DEL PERFIL DE PAGO
            'perfilpago_direccion' => !empty($data['fac_direccion_entrega_factura'])
                ? empty($data['fac_direccion_entrega_factura']) : '',
            'documento_tipo' => $usuarioData['di_tipo'], // TIPO COMPROBANTE
            'documento_numero' => $usuarioData['di_valor'], // NRO COMPROBANTE
            'usuario_email' => $usuarioData['email'],  // CORREO DE USUARIO LOGUEADO
            'usuario_id' => $usuarioData['id'], // ID DE USUARIO LOGUEADO
            'monto' => (string) $monto, // MONTO EN CON 2 DECIMALES
            'data_adicional' => !empty($dataAdicional) ? $dataAdicional : '',
        );

        $paymentProcessor = new PaymentProcessor($metodoPago, $this->_sl);
        $response = $paymentProcessor->createCharge($paymentProcessordata);

        if (!empty($response['success'])) {
            switch ($metodoPago) {
                case PagoEfectivoProcessor::ALIAS :
                    $ordenUpdateData = array(
                        'pago_referencia' => $response['data']['reference'],
                        'pago_estado' => $response['data']['status'],
                        'pago_cip' => $response['data']['cip'],
                        'pago_token' => $response['data']['token'],
                        'pago_metodo' => self::METODO_PAGO_NAME_PE,
                    );
                    break;
                case VisaProcessor::ALIAS :
                    $ordenUpdateData = array(
                        'pago_referencia' => $response['data']['reference'],
                        'pago_estado' => $response['data']['status'],
                        'pago_metodo' => self::METODO_PAGO_NAME_VISA,
                    );
                    break;
            }
            $return['data']['redirect'] = $response['data']['redirect'];
            $this->_getCartService()->removeCart();
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

        $ordenUpdateData['pago_fecha_confirmacion'] = date('Y-m-d H:i:s');

        $this->getRepository()->save($ordenUpdateData, $ordenId);

        return $return;
    }

    public function getDataAdicional()
    {
        $cartModel = $this->_getCartService()->getCart();
        $dataAdicional = '';
        $tarjetaIds = array();
        if (!empty($cartModel)) {
            foreach ($cartModel->getProductsCart() as $productos) {
                foreach ($productos as $producto) {
                    $categoryCode = $producto->getCategoryCode();
                    $tarjetaId = Crypto::decrypt($categoryCode, \Common\Helpers\Util::VI_ENCODEID);
                    $tarjetaIds[] = $tarjetaId;
                }
            }
        }

        if (!empty($tarjetaIds)) {
            $tarjetasData = $this->_getTarjetaService()->getRepository()->getTarjetasByIds($tarjetaIds);

            if (!empty($tarjetasData)) {
                $tarjetasNumeros = array();
                foreach ($tarjetasData as $item) {
                    $tarjetasNumeros[] = $item['numero'];
                }

                $dataAdicional = implode(';', $tarjetasNumeros);
            }
        }

        return $dataAdicional;
    }

    public function setCodigo($ordenId)
    {
        $tempOrdenId = $ordenId + OrdenRepository::ORDER_BASE_CODE;
        $ordenCodigo = str_pad($tempOrdenId, 9, '0', STR_PAD_LEFT);

        $this->getRepository()->save(array('codigo' => $ordenCodigo), $ordenId);

        return $ordenCodigo;
    }

    private function _saveDetalleOrden($ordenId, $cDate)
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
                    $tarjetaId = Crypto::decrypt($categoryCode, \Common\Helpers\Util::VI_ENCODEID);

                    $ordenDetalleData['paquete_id'] = $producto->getProductId();
                    $ordenDetalleData['tarjeta_id'] = $tarjetaId;
                    $ordenDetalleData['monto'] = $producto->getPrice(true);
                    $ordenDetalleData['fecha_creacion'] = $cDate;
                    $ordenDetalleData['cantidad'] = $producto->getQuantity();

                    $this->_getDetalleOrdenService()->getRepository()->save($ordenDetalleData);
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


    public function procesarPaymentProcessorCallbackReponse($response)
    {
        $ordenId = 'XXXXX';
        if (!empty($response['data']['reference'])) {
            $reference = $response['data']['reference'];
            $ordenData = $this->getRepository()->getIdByPagoReference($reference);
            if (!empty($ordenData)) {
                $ordenId = $ordenData['id'];
                if ($ordenData['pago_estado'] != OrdenRepository::PAGO_ESTADO_PAGADO) {
                    if ($response['success']) {
                        $ordenUpdateData = array(
                            'pago_error' => $response['data']['errorCode'],
                            'pago_error_detalle' => $response['data']['errorDescription'],
                        );

                        if (!empty($response['data']['status'])) {
                            $ordenUpdateData['pago_estado'] = $response['data']['status'];
                        }

                        if (!empty($response['data']['confirmationDate'])) {
                            $ordenUpdateData['pago_fecha_confirmacion'] = date('Y-m-d H:i:s');
                        }

                        if (!empty($response['data']['pan'])) {
                            $ordenUpdateData['pan'] = $response['data']['pan'];
                        }

                        $this->getRepository()->save($ordenUpdateData, $ordenId);

                        if (!empty($response['data']['status'])) {
                            if ($response['data']['status'] == OrdenRepository::PAGO_ESTADO_PAGADO) {
                                $this->setCreditPurchase($ordenId);
                            }
                        }
                    } else {
                        $ordenUpdateData = array(
                            'pago_error' => $response['error']['code'],
                            'pago_error_detalle' => $response['error']['message'],
                        );

                        $this->getRepository()->save($ordenUpdateData, $ordenId);
                    }
                }
            }
        }

        return $ordenId;
    }

    public function setCreditPurchase($ordenId)
    {
        $tarjetaService = $this->_getTrueFiTarjetaService();
        $ordenDetalleData = $this->_getDetalleOrdenService()->getRepository()->getTarjetasByOrderId($ordenId);

        foreach ($ordenDetalleData as $ordenDetalle) {
            $cantidadRecargas = 0;
            $error = array();
            for ($i = 1; $i <= $ordenDetalle['cantidad']; $i++) {
                $serviceData = array(
                    'CGUID' => $ordenDetalle['tarjeta_cguid'],
                    'EMoney' => $ordenDetalle['emoney'],
                );

                $response = $tarjetaService->creditPurchase($serviceData);
                if ($response['success']) {
                    $cantidadRecargas++;
                } else {
                    $error[$i]['error'] =  $response['message'];
                }
            }

            $detalleOrdenData  = array(
                'recarga_cantidad' => $cantidadRecargas,
                'recarga_error' => json_encode($error),
            );

            $this->_getDetalleOrdenService()->getRepository()->save($detalleOrdenData, $ordenDetalle['id']);
            
            $this->_getTarjetaService()->cronTarjetas($ordenDetalle['tarjeta_cguid'], false);
        }

        $this->enviarMailConfirmacion($ordenId);
    }

    public function enviarMailConfirmacion($ordenId)
    {
        $ordenData = $this->getRepository()->getConfirmacionMailDatosById($ordenId);

        $ordenDetalleData = $this->_getDetalleOrdenService()->getRepository()->getConfirmacionDatosByOrderId($ordenId);

        $view = new ViewModel();
        $view->setTerminal(true)
            ->setTemplate('application/pagos/email/confirmacion.phtml')
            ->setVariables(array(
                'ordenData' => $ordenData,
                'ordenDetalleData' => $ordenDetalleData,
            ));

        $viewRenderer = $this->_sl->get('viewrenderer');
        $html = $viewRenderer->render($view);
        try {
            $body = $html;
            $to = $ordenData['usuario_email'];

            $config = $this->_sl->get('config');
            $subject = ASUTO_PAGO_CONFIRMACION;
            $bcc = $config['emails']['admin'];

            \Util\Common\Email::send($subject, $body, $to, true, $bcc);
        } catch (Exception $e) {
            \Util\Common\Email::reportException($e);
        }
    }

    /**
     * @return UsuarioService
     */
    private function _getUsuarioService()
    {
        return $this->_sl->get('Usuario\Model\Service\UsuarioService');
    }

    /**
     * @return PerfilPagoService
     */
    private function _getPerfilPagoService()
    {
        return $this->_sl->get('Usuario\Model\Service\PerfilPagoService');
    }

    /**
     * @return CartService;
     */
    private function _getCartService()
    {
        return $this->_sl->get('Cart\Model\Service\CartService');
    }

    /**
     * @return DetalleOrdenService
     */
    private function _getDetalleOrdenService()
    {
        return $this->_sl->get('Orden\Model\Service\DetalleOrdenService');
    }


    /**
     * @return \TrueFi\Model\Service\TarjetaService
     */
    private function _getTrueFiTarjetaService()
    {
        return $this->_sl->get('TrueFi\Model\Service\TarjetaService');
    }

    /**
     * @return TarjetaService
     */
    private function _getTarjetaService()
    {
        return $this->_sl->get('Tarjeta\Model\Service\TarjetaService');
    }
}