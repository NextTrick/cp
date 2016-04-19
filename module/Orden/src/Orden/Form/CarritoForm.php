<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class CarritoForm extends Form
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
        $this->setAttribute('id', 'formCarrito');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $usuario_id = new Element\Text('usuario_id');
        $usuario_id->setAttributes(array(
                'id' => 'usuario_id',
                'maxlength' => '20',
            ));
        $this->add($usuario_id);
        
        $pago_referencia = new Element\Text('pago_referencia');
        $pago_referencia->setAttributes(array(
                'id' => 'pago_referencia',
                'maxlength' => '20',
            ));
        $this->add($pago_referencia);
        
        $pago_estado = new Element\Text('pago_estado');
        $pago_estado->setAttributes(array(
                'id' => 'pago_estado',
                'maxlength' => '20',
            ));
        $this->add($pago_estado);
        
        $pago_tarjeta = new Element\Text('pago_tarjeta');
        $pago_tarjeta->setAttributes(array(
                'id' => 'pago_tarjeta',
                'maxlength' => '20',
            ));
        $this->add($pago_tarjeta);
        
        $monto_total = new Element\Text('monto_total');
        $monto_total->setAttributes(array(
                'id' => 'monto_total',
                'maxlength' => '20',
            ));
        $this->add($monto_total);
        
        $estado = new Element\Text('estado');
        $estado->setAttributes(array(
                'id' => 'estado',
                'maxlength' => '20',
            ));
        $this->add($estado);
        
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
