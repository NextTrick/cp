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

class OrdenForm extends Form
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
        $this->setAttribute('id', 'formOrden');
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
        
        $comprobante_tipo = new Element\Text('comprobante_tipo');
        $comprobante_tipo->setAttributes(array(
                'id' => 'comprobante_tipo',
                'maxlength' => '20',
            ));
        $this->add($comprobante_tipo);
        
        $comprobante_numero = new Element\Text('comprobante_numero');
        $comprobante_numero->setAttributes(array(
                'id' => 'comprobante_numero',
                'maxlength' => '20',
            ));
        $this->add($comprobante_numero);
        
        $fac_razon_social = new Element\Text('fac_razon_social');
        $fac_razon_social->setAttributes(array(
                'id' => 'fac_razon_social',
                'maxlength' => '20',
            ));
        $this->add($fac_razon_social);
        
        $fac_ruc = new Element\Text('fac_ruc');
        $fac_ruc->setAttributes(array(
                'id' => 'fac_ruc',
                'maxlength' => '20',
            ));
        $this->add($fac_ruc);
        
        $fac_direccion_fiscal = new Element\Text('fac_direccion_fiscal');
        $fac_direccion_fiscal->setAttributes(array(
                'id' => 'fac_direccion_fiscal',
                'maxlength' => '20',
            ));
        $this->add($fac_direccion_fiscal);
        
        $fac_direccion_entrega_factura = new Element\Text('fac_direccion_entrega_factura');
        $fac_direccion_entrega_factura->setAttributes(array(
                'id' => 'fac_direccion_entrega_factura',
                'maxlength' => '20',
            ));
        $this->add($fac_direccion_entrega_factura);
        
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
        
        $ciudadania = new Element\Text('ciudadania');
        $ciudadania->setAttributes(array(
                'id' => 'ciudadania',
                'maxlength' => '20',
            ));
        $this->add($ciudadania);
        
        $doc_identidad = new Element\Text('doc_identidad');
        $doc_identidad->setAttributes(array(
                'id' => 'doc_identidad',
                'maxlength' => '20',
            ));
        $this->add($doc_identidad);
        
        $direccion = new Element\Text('direccion');
        $direccion->setAttributes(array(
                'id' => 'direccion',
                'maxlength' => '20',
            ));
        $this->add($direccion);
        
        $pais_id = new Element\Text('pais_id');
        $pais_id->setAttributes(array(
                'id' => 'pais_id',
                'maxlength' => '20',
            ));
        $this->add($pais_id);
        
        $distrito_id = new Element\Text('distrito_id');
        $distrito_id->setAttributes(array(
                'id' => 'distrito_id',
                'maxlength' => '20',
            ));
        $this->add($distrito_id);
        
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
        
        $monto = new Element\Text('monto');
        $monto->setAttributes(array(
                'id' => 'monto',
                'maxlength' => '20',
            ));
        $this->add($monto);
        
        $estado = new Element\Text('estado');
        $estado->setAttributes(array(
                'id' => 'estado',
                'maxlength' => '20',
            ));
        $this->add($estado);        
    }
}
