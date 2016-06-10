<?php

namespace Application\Controller;

use Orden\Model\Service\OrdenService;
use TwitterOAuth\OAuth\Exception;
use Zend\Mvc\Controller\AbstractActionController;
use PaymentProcessor\Model\PaymentProcessor;
use Zend\View\Model\ViewModel;
use Util\Common\Email;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $mguid = $this->request->getQuery('mguid', null);

        if (empty($mguid)) {
            $mguid = $this->request->getQuery('cmguid', null);
        }

        if (!empty($mguid)) {
            return $this->redirect()->toRoute('web-activar-cuenta', array('controller' => 'registro', 'action' => 'activar-cuenta'), array('query' => array('mguid' => $mguid)));
        }
        
        if ($this->_getLoginGatewayService()->isLoggedIn()) {
            return $this->redirect()->toRoute('web-beneficios', array('controller' => 'beneficios'));
        } else {
            return $this->redirect()->toRoute('web-login/modalidad', array('controller' => 'login'));
        }
    }

    public function testEmailAction()
    {
        try {
            $body = 'cuerpo del mensaje 2';
            $to = 'ing.angeljara@gmail.com';
            $subject = 'Confirmar de cuenta';
//            $bcc = 'montesinos2005ii@gmail.com, jludena@idigital.pe'; // esto debe ser email del admin que esta en archivo config

            Email::send($subject, $body, $to, $html = false);

            //Email::reportDebug(array(1,2,3));
        } catch (\Exception $e) {
            var_dump($e->getMessage(), $e->getTraceAsString()); exit;
        }

        echo 'enviado ok'; exit;
    }
    
    
    
    public function testPeAction()
    {

        $id = 100 + rand(1,1000);
        $data = array(
            'id' => $id, // ID DE LA ORDEN
            'perfilpago_nombres' => 'Angel', // NOMBRE DEL PERFIL DE PAGO
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
    
    public function testVisaAction()
    {
        $id = 100 + rand(1,1000);
        $data = array(
            'id' => $id,
            'perfilpago_nombres' => 'Angel',
            'perfilpago_paterno' => 'Jara',
            'perfilpago_materno' => 'Vilca',
            'perfilpago_nombres' => 'NextTrick',
            'perfilpago_pais' => 'PERU',
            'perfilpago_departamento' => 'LIMA',
            'perfilpago_distrito' => 'LIMA',
            'perfilpago_direccion' => 'Av. Carcamo',
            'comprobante_tipo' => 'DNI',
            'comprobante_numero' => '11872911',
            'usuario_email' => 'ing.angeljara@gmail.com',
            'usuario_id' => 1,
            'monto' => '100.10'
        );
        
        try {            
            $alias = \PaymentProcessor\Model\Gateway\Processor\VisaProcessor::ALIAS;        
            $paymentProcessor = new PaymentProcessor($alias, $this->getServiceLocator());
                    
            $response = $paymentProcessor->createCharge($data);

            //var_dump($response);
            echo $response['data']['html']; exit;
        } catch (\Exception $e) {
            var_dump($e->getMessage(), $e->getTraceAsString()); exit;
        }

        echo 'fin'; exit;
    }
    
    public function phpinfoAction()
    {
        echo phpinfo(); exit;
    }
    
    protected function _getLoginGatewayService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\LoginGatewayService');
    }

    public function enviarOrdenMailAction()
    {
        echo __METHOD__; exit;
        $this->_getOrdenService()->enviarMailConfirmacion(221);
        echo 'Email Orden enviado'; exit;
    }

    /**
     * @return OrdenService
     */
    private function _getOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\OrdenService');
    }
}
