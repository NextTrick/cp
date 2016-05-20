<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsuarioForm extends Form
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
        $email = new Element\Text('email');
        $email->setAttributes(array(
                'id' => 'email',
                'maxlength' => '20',
            ));
        $this->add($email);
        
        $password = new Element\Text('password');
        $password->setAttributes(array(
                'id' => 'password',
                'maxlength' => '20',
            ));
        $this->add($password);
        
        $estado = new Element\Text('estado');
        $estado->setAttributes(array(
                'id' => 'estado',
                'maxlength' => '20',
            ));
        $this->add($estado);
        
        $imagen = new Element\Text('imagen');
        $imagen->setAttributes(array(
                'id' => 'imagen',
                'maxlength' => '20',
            ));
        $this->add($imagen);
        
        $nombres = new Element\Text('nombres');
        $nombres->setAttributes(array(
                'id' => 'nombres',
                'maxlength' => '20',
            ));
        $this->add($nombres);
        
        $paterno = new Element\Text('paterno');
        $paterno->setAttributes(array(
                'id' => 'paterno',
                'maxlength' => '20',
            ));
        $this->add($paterno);
        
        $materno = new Element\Text('materno');
        $materno->setAttributes(array(
                'id' => 'materno',
                'maxlength' => '20',
            ));
        $this->add($materno);
        
        $fecha_nac = new Element\Text('fecha_nac');
        $fecha_nac->setAttributes(array(
                'id' => 'fecha_nac',
                'maxlength' => '20',
            ));
        $this->add($fecha_nac);
        
        $paisId = new Element\Text('pais_id');
        $paisId->setAttributes(array(
                'id' => 'pais_id',
                'maxlength' => '20',
            ));
        $this->add($paisId);
        
        $departamentoId = new Element\Text('departamento_id');
        $departamentoId->setAttributes(array(
                'id' => 'departamento_id',
                'maxlength' => '20',
            ));
        $this->add($departamentoId);
        
        $provinciaId = new Element\Text('provincia_id');
        $provinciaId->setAttributes(array(
                'id' => 'provincia_id',
                'maxlength' => '20',
            ));
        $this->add($provinciaId);
        
        $distritoId = new Element\Text('distrito_id');
        $distritoId->setAttributes(array(
                'id' => 'distrito_id',
                'maxlength' => '20',
            ));
        $this->add($distritoId);
        

        $csrf = new Element\Csrf('token');

        $this->add($csrf);
        
    }
}
