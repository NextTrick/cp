<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaqueteForm extends Form
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
        $this->setAttribute('id', 'formPaquete');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $nombre = new Element\Text('nombre');
        $nombre->setAttributes(array(
                'id' => 'nombre',
                'maxlength' => '200',
            ));
        $this->add($nombre);
        
        $coney_bonos = new Element\Text('coney_bonos');
        $coney_bonos->setAttributes(array(
                'id' => 'coney_bonos',
                'maxlength' => '10',
            ));
        $this->add($coney_bonos);
        
        $coney_bonos_plus = new Element\Text('coney_bonos_plus');
        $coney_bonos_plus->setAttributes(array(
                'id' => 'coney_bonos_plus',
                'maxlength' => '10',
            ));
        $this->add($coney_bonos_plus);
        
        $tickets = new Element\Text('tickets');
        $tickets->setAttributes(array(
                'id' => 'tickets',
                'maxlength' => '10',
            ));
        $this->add($tickets);
        
        $monto_total = new Element\Text('monto_total');
        $monto_total->setAttributes(array(
                'id' => 'monto_total',
                'maxlength' => '10',
            ));
        $this->add($monto_total);        
    }
}
