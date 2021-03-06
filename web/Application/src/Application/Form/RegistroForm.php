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
                'maxlength' => '65',
            ));
        $this->add($email);
        
        $password = new Element\Password('password');
        $password->setAttributes(array(
                'id' => 'password',
                'autocomplete' => 'off',
                'maxlength' => '32',
            ));
        $this->add($password);
        
        $passwordRep = new Element\Password('password_repeat');
        $passwordRep->setAttributes(array(
                'id' => 'password_repeat',
                'autocomplete' => 'off',
                'maxlength' => '32',
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
        $diTipo->setDisableInArrayValidator(true);
        $this->add($diTipo);
        
        
        $diValor = new Element\Text('di_valor');
        $diValor->setAttributes(array(
                'id' => 'di_valor',
                'maxlength' => '8'
            ));
        $this->add($diValor);

        $departamentos = $this->_getUbigeoService()->getPeDepartamentos();
        $codDepa = new Element\Select('departamento_id');
        $codDepa->setAttributes(array('id' => 'departamento_id'));
        $codDepa->setValueOptions($departamentos);
        $codDepa->setEmptyOption('- Seleccione -');
        $codDepa->setDisableInArrayValidator(true);
        $this->add($codDepa);
        
        $codProv = new Element\Select('provincia_id');
        $codProv->setAttributes(array('id' => 'provincia_id'));
        $codProv->setValueOptions(array());
        $codProv->setEmptyOption('- Seleccione -');
        $codProv->setDisableInArrayValidator(true);
        $this->add($codProv);
        
        $codDist = new Element\Select('distrito_id');
        $codDist->setAttributes(array('id' => 'distrito_id'));
        $codDist->setValueOptions(array());
        $codDist->setEmptyOption('- Seleccione -');
        $codDist->setDisableInArrayValidator(true);
        $this->add($codDist);
        
        $anio = new Element\Select('anio');
        $anio->setAttributes(array('id' => 'anio'));
        $anio->setValueOptions($this->_getAnios());
        $anio->setDisableInArrayValidator(true);
        $this->add($anio);
        
        $mes = new Element\Select('mes');
        $mes->setAttributes(array('id' => 'mes'));
        $mes->setValueOptions($this->_getMeses());
        $mes->setDisableInArrayValidator(true);
        $this->add($mes);
        
        $dia = new Element\Select('dia');
        $dia->setAttributes(array('id' => 'dia'));
        $dia->setValueOptions($this->_getDias());
        $dia->setDisableInArrayValidator(true);
        $this->add($dia);

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
    
    private function _getMeses()
    {
        return array(
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        );
    }
    
    private function _getAnios()
    {
        $anios = array();
        $anioActual = (int)date('Y');
        for ($anio = 1940; $anio < $anioActual; $anio++) {
            $anios[$anio] = $anio;
        }
        
        return $anios;
    }
    
    private function _getDias()
    {
        $anios = array();
        for ($dia = 1; $dia <= 31; $dia++) {
            $sDia = $dia < 10 ? str_pad($dia, 2, '0', STR_PAD_LEFT) : $dia;
            $anios[$sDia] = $sDia;
        }
        
        return $anios;
    }
    
    private function _getUsuarioService()
    {
        return $this->_sl->get('Usuario\Model\Service\UsuarioService');
    }
    
    private function _getUbigeoService()
    {
        return $this->_sl->get('Sistema\Model\Service\UbigeoService');
    }
}
