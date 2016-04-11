<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;

class TestController extends SecurityAdminController
{
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
        //{C47F7E4F-461C-4472-9BDB-5D1FF9D9F9A1}
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => '{C47F7E4F-461C-4472-9BDB-5D1FF9D9F9A1}',
        );
        $result = $service->activateMember($data);
        var_dump($result);
        exit;
    }
    
    public function deleteMemberAction()
    {
        //{C47F7E4F-461C-4472-9BDB-5D1FF9D9F9A1} jludena
        //{EBAB4CD7-EE8E-48DF-90C1-7C8F283EF3AE}
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => '{EBAB4CD7-EE8E-48DF-90C1-7C8F283EF3AE}',
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
            'EMail' => 'ing.angeljara@gmail.com',
//            'EMail' => 'jludena@idigital.pe',
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
            'CGUID' => '{2AC405C3-9056-45F9-8AFA-5559CF6F75CA}',
        );
        
        $result = $service->getCard($data);
        var_dump($result);
        exit;
    }
    
    public function addCardAction()
    {
        $service = $this->_getTrueFiTarjetaService();
        $data =  array("Number" => "003-034796-5", "Status" => "1");
        
        $result = $service->addCard($data);
        var_dump($result);
        exit;
    }
    
    public function getMemberAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => '{272DFF6A-57D1-4883-A28D-FCD880AE41A7}',
        );
        $result = $service->getMember($data);
        var_dump($result);
        exit;
    }
    
    public function setMemberAction()
    {
        $service = $this->_getTrueFiUsuarioService();
        $data = array(
            'MGUID' => '{272DFF6A-57D1-4883-A28D-FCD880AE41A7}',
//            'Data' => array('GENDER' => 'M'),
//            'Data' => array("cards" => array(
//                array("NUMBER" => "003-034796-5", "CGUID" => "{2AC405C3-9056-45F9-8AFA-5559CF6F75CA}", "STATUS" => "1")
//            )),
            'Data' => array("CHILDS" => array(
                    array("Name" => "Agostina", "Gender" => "F", "Birthdate" => "2003-10-04")
                )),
//            'Data' => array("cards" => array(
//                array("NUMBER" => "003-034796-5", "STATUS" => "0")
//            )),
        );
        $result = $service->setMember($data);
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
    
    private function _getTrueFiPromocionService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\PromocionService');
    }
    
    private function _getTrueFiUsuarioService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\UsuarioService');
    }
    
    private function _getTrueFiTarjetaService()
    {
        return $this->getServiceLocator()->get('TrueFi\Model\Service\TarjetaService');
    }
}
