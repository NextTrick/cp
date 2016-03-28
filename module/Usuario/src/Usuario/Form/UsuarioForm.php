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
        
        $cod_pais = new Element\Text('cod_pais');
        $cod_pais->setAttributes(array(
                'id' => 'cod_pais',
                'maxlength' => '20',
            ));
        $this->add($cod_pais);
        
        $cod_depa = new Element\Text('cod_depa');
        $cod_depa->setAttributes(array(
                'id' => 'cod_depa',
                'maxlength' => '20',
            ));
        $this->add($cod_depa);
        
        $cod_prov = new Element\Text('cod_prov');
        $cod_prov->setAttributes(array(
                'id' => 'cod_prov',
                'maxlength' => '20',
            ));
        $this->add($cod_prov);
        
        $cod_dist = new Element\Text('cod_dist');
        $cod_dist->setAttributes(array(
                'id' => 'cod_dist',
                'maxlength' => '20',
            ));
        $this->add($cod_dist);
        
        $fecha_creacion = new Element\Text('fecha_creacion');
        $fecha_creacion->setAttributes(array(
                'id' => 'fecha_creacion',
                'maxlength' => '20',
            ));
        $this->add($fecha_creacion);
        
        $fecha_edicion = new Element\Text('fecha_edicion');
        $fecha_edicion->setAttributes(array(
                'id' => 'fecha_edicion',
                'maxlength' => '20',
            ));
        $this->add($fecha_edicion);
        
    }
}
