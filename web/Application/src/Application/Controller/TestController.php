<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Application\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;

class TestController extends SecurityAdminController
{
//    private $mguid = '{C47F7E4F-461C-4472-9BDB-5D1FF9D9F9A1}';//jludena
//    private $mguid = '{5C3E7CA9-6412-4CA5-9C8C-F0E0F02968DE}';//jludena2
    private $mguid = '{C55A121E-F07E-4D15-83F6-D02EA93364D4}';//mont
//    private $mguid = '{272DFF6A-57D1-4883-A28D-FCD880AE41A7}';//angel
//    private $cguid = '{54A0B670-9C39-464D-ABE2-79B62240043A}';//jludena
    private $cguid = '{28368642-029F-4072-85E3-EC3F601D5518}';//angel
    
    
    public function indexAction()
    {
        //{EBAB4CD7-EE8E-48DF-90C1-7C8F283EF3AE}
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'FirstName' => 'Juan Carlos',
            'LastName' => 'Ludeña ',
            'EMail' => 'jludena@idigital.pe',
            'Password' => '@1bT43#Q',
            'Type' => \TrueFi\Model\Service\UsuarioService::TIPO_CLIENTE,
        );
        $result = $service->newMember($data);
        var_dump($result);
        exit;
    }
    
    public function getPromotionsAction()
    {
        $service = $this->_getTrueFiPromocionService();

        $result = $service->getPromotions();
        var_dump($result);
        exit;
    }
    
    public function logonAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'EMail' => 'jludena@idigital.pe',
            'Password' => '123456',
        );
        $result = $service->logon($data);
        var_dump($result);
        exit;
    }
    
    public function activateMemberAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => $this->mguid,
        );
        $result = $service->activateMember($data);
        var_dump($result);
        exit;
    }
    
    public function deleteMemberAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => $this->mguid,
        );
        $result = $service->deleteMember($data);
        var_dump($result);
        exit;
    }
    
    public function recoverPasswordAction()
    {
        //{EBAB4CD7-EE8E-48DF-90C1-7C8F283EF3AE}
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
//            'EMail' => 'ing.angeljara@gmail.com',
            'EMail' => 'jludena@idigital.pe',
        );
        $result = $service->recoverPassword($data);
        var_dump($result);
        exit;
    }
    
    public function changePasswordAction()
    {
        //{EBAB4CD7-EE8E-48DF-90C1-7C8F283EF3AE}
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => '',
            'Password' => '',
            'OldPassword' => '',
        );
        $result = $service->changePassword($data);
        var_dump($result);
        exit;
    }
    
    public function getCardAction()
    {
        $service = $this->_getTrueFiTarjetaService();
        $data = array(
            'CGUID' => $this->cguid,
        );
        
        $result = $service->getCard($data);
        var_dump($result);
        exit;
    }
    
    public function addCardAction()
    {
        $service = $this->_getTrueFiTarjetaService();
        $data =  array('MGUID' => '{C47F7E4F-461C-4472-9BDB-5D1FF9D9F9A1}', 'Card' => '000-123456-3');
//        $data =  array('MGUID' => '{272DFF6A-57D1-4883-A28D-FCD880AE41A7}', 'Card' => '003-034796-5');
        
        $result = $service->addCard($data);
        var_dump($result);
        exit;
    }
    
    public function getMemberAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => $this->mguid,
        );
        $result = $service->getMember($data);
        var_dump($result);
        exit;
    }
    
    public function setMemberAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => $this->mguid,
            'Data' => array(
                'GENDER' => 'M',
                "CHILDS" => array(array("Name" => "Agostina", "Gender" => "F", "Birthdate" => "2003-10-04"))
            ),
        );
        $result = $service->setMember($data);
        var_dump($result);
        exit;
    }
    
    public function creditPurchaseAction()
    {
        $service = $this->_getTrueFiTarjetaService();
        $data = array(
            'CGUID' => $this->cguid,
            'EMoney' => '3.45',
        );
        $result = $service->creditPurchase($data);
        var_dump($result);
        exit;
    }
    
    public function denounceCardAction()
    {
        $service = $this->_getTrueFiTarjetaService();
        $data = array(
            'CGUID' => $this->cguid,
        );
        $result = $service->denounceCard($data);
        var_dump($result);
        exit;
    }
    
    public function removeCardAction()
    {
        $service = $this->_getTrueFiTarjetaService();
        $data = array(
            'Card' => $this->cguid,
        );
        $result = $service->removeCard($data);
        var_dump($result);
        exit;
    }
    
    public function syncTarjetasAction()
    {
        $service = $this->_getUsuarioService();
        $result = $service->syncTarjetasCliente(5, $this->mguid);
        var_dump($result);
        exit;
    }
    
    public function ecryAction()
    {
        $password = $this->getRequest()->getQuery('password', null);
        $email = $this->getRequest()->getQuery('email', null);
        $password1 = \Common\Helpers\Crypto::encrypt($password, $email);
        var_dump($password1);
        exit;
    }
    
    public function dcryAction()
    {
        $password = $this->getRequest()->getQuery('password', null);
        $email = $this->getRequest()->getQuery('email', null);
        $password1 = \Common\Helpers\Crypto::decrypt($password, $email);
        var_dump($password1);
        exit;
    }
    
    
    public function resetUsuariosAction()
    {
        $usuarios = $this->_getUsuarioService()->getRepository()->findAll();
        
        foreach ($usuarios as $row) {
            if (!empty($row['mguid'])) {
                $data = array(
                    'MGUID' => $row['mguid'],
                );
                $result = $this->_getTrueFiUsuarioService()->deleteMember($data);
                if ($result['success']) {
//                    $this->_getUsuarioService()
                }
            }
        }
        
        var_dump($usuarios);
        exit;
        
        echo 333;
        exit;
    }

    public function mailAcAction()
    {
        $data = array(
            'email' => 'montesinos2005ii@gmail.com',
        );
        $serviceLocator = $this->getServiceLocator();
        $email = new \Usuario\Model\Email\ActivarCuenta($serviceLocator);
        $data['codigo_activar'] = 'sasasffsagasfjhjyafsyfasyfsayfasf';
        $data['nombres_completo'] = 'Juan Carlos Ludeña';
        $result = $email->sendMail($data);
        var_dump($result);
        exit;
    }

    private function _getTrueFiPromocionService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\PromocionService');
    }
    
    private function _getTrueFiUsuarioService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\UsuarioService');
    }
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
    
    private function _getTrueFiTarjetaService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\TarjetaService');
    }
}
