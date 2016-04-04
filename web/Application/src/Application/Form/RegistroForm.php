<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegistroForm extends Form
{
    protected $_sl = null;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {   
        parent::__construct();
        
        $this->_sl = $serviceLocator;

        $this->_addForm();
        $this->_addElements();
    }
    
    protected function _addForm()
    {
        $this->setAttribute('id', 'formUsuario');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $gateway = new Element\Hidden('gateway');
        $gateway->setAttributes(array(
                'id' => 'gateway',
                'maxlength' => '20',
            ));
        $this->add($gateway);
        
        $email = new Element\Text('email');
        $email->setAttributes(array(
                'id' => 'email',
                'autocomplete' => 'off',
                'maxlength' => '30',
            ));
        $this->add($email);
        
        $password = new Element\Password('password');
        $password->setAttributes(array(
                'id' => 'password',
                'autocomplete' => 'off',
                'maxlength' => '100',
            ));
        $this->add($password);
        
        $passwordRep = new Element\Password('password_repeat');
        $passwordRep->setAttributes(array(
                'id' => 'password_repeat',
                'autocomplete' => 'off',
                'maxlength' => '100',
            ));
        $this->add($passwordRep);
        
        $nombres = new Element\Text('nombres');
        $nombres->setAttributes(array(
                'id' => 'nombres',
                'maxlength' => '30',
            ));
        $this->add($nombres);
        
        $paterno = new Element\Text('paterno');
        $paterno->setAttributes(array(
                'id' => 'paterno',
                'maxlength' => '30',
            ));
        $this->add($paterno);
        
        $materno = new Element\Text('materno');
        $materno->setAttributes(array(
                'id' => 'materno',
                'maxlength' => '30',
            ));
        $this->add($materno);

        $tipos = $this->_getUsuarioService()->getDocumentoIdentidadTipo();
        $diTipo = new Element\Select('di_tipo');
        $diTipo->setAttributes(array('id' => 'di_tipo'));
        $diTipo->setValueOptions($tipos);
        $diTipo->setEmptyOption('- Seleccione -');
        $diTipo->setDisableInArrayValidator(true);
        $this->add($diTipo);
        
        
        $diValor = new Element\Text('di_valor');
        $diValor->setAttributes(array(
                'id' => 'di_valor',
                'maxlength' => '11',
            ));
        $this->add($diValor);

        $pais = $this->_getUbigeoService()->getPaises();
        $codPais = new Element\Select('cod_pais');
        $codPais->setAttributes(array('id' => 'cod_pais'));
        $codPais->setValueOptions($pais);
        $codPais->setEmptyOption('- Seleccione -');
        $codPais->setDisableInArrayValidator(true);
        $this->add($codPais);
        
        $codDepa = new Element\Select('cod_depa');
        $codDepa->setAttributes(array('id' => 'cod_depa'));
        $codDepa->setValueOptions(array());
        $codDepa->setEmptyOption('- Seleccione -');
        $codDepa->setDisableInArrayValidator(true);
        $this->add($codDepa);
        
        $codDist = new Element\Select('cod_dist');
        $codDist->setAttributes(array('id' => 'cod_dist'));
        $codDist->setValueOptions(array());
        $codDist->setEmptyOption('- Seleccione -');
        $codDist->setDisableInArrayValidator(true);
        $this->add($codDist);
        
        $fechaNac = new Element\Text('fecha_nac');
        $fechaNac->setAttributes(array(
                'id' => 'fecha_nac',
                'maxlength' => '20',
            ));
        $this->add($fechaNac);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'token_csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
    }
    
    protected function _getUsuarioService()
    {
        return $this->_sl->get('Usuario\Model\Service\UsuarioService');
    }
    
    protected function _getUbigeoService()
    {
        return $this->_sl->get('Sistema\Model\Service\UbigeoService');
    }
}
