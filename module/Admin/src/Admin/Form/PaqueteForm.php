<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Form;

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
        $this->setAttribute('enctype', 'multipart/form-data');
    }

    protected function _addElements()
    {
        $referencia = new Element\Text('referencia');
        $referencia->setAttributes(array(
                'id' => 'referencia',
                'maxlength' => '32',
            ));
        $this->add($referencia);
        
        $titulo1 = new Element\Text('titulo1');
        $titulo1->setAttributes(array(
                'id' => 'titulo1',
                'maxlength' => '200',
            ));
        $this->add($titulo1);
        
        $titulo2 = new Element\Text('titulo2');
        $titulo2->setAttributes(array(
                'id' => 'titulo2',
                'maxlength' => '200',
            ));
        $this->add($titulo2);
        
        $tipos = $this->_getPaqueteService()->getTipos();
        $tipo = new Element\Select('tipo');
        $tipo->setAttributes(array('id' => 'tipo'));
        $tipo->setValueOptions($tipos);
        $tipo->setEmptyOption('- Seleccione -');
        $tipo->setDisableInArrayValidator(true);
        $this->add($tipo);
        
        $emoney = new Element\Text('emoney');
        $emoney->setAttributes(array(
                'id' => 'emoney',
                'maxlength' => '10',
            ));
        $this->add($emoney);
        
        $bonus = new Element\Text('bonus');
        $bonus->setAttributes(array(
                'id' => 'bonus',
                'maxlength' => '10',
            ));
        $this->add($bonus);
        
        $promotionBonus = new Element\Text('promotionbonus');
        $promotionBonus->setAttributes(array(
                'id' => 'promotionbonus',
                'maxlength' => '10',
            ));
        $this->add($promotionBonus);
        
        $tickets = new Element\Text('etickets');
        $tickets->setAttributes(array(
                'id' => 'etickets',
                'maxlength' => '10',
            ));
        $this->add($tickets);
        
        $gamepoints = new Element\Text('gamepoints');
        $gamepoints->setAttributes(array(
                'id' => 'tickets',
                'maxlength' => '10',
            ));
        $this->add($gamepoints);
        
        $image = new Element\File('imagen');
        $image->setAttribute('id', 'imagen');
        $this->add($image);
        
        $legal = new Element\Textarea('legal');
        $legal->setAttributes(array(
                'id' => 'legal',
                'maxlength' => '1000',
                'rows' => 3,
                'style' => 'width: 100%',
            ));
        $this->add($legal);
        
        $fechaCreacion = new Element\Text('fecha_creacion');
        $fechaCreacion->setAttributes(array(
                'id' => 'fecha_creacion',
                'maxlength' => '19',
            ));
        $this->add($fechaCreacion);
        
        $activo = new Element\Checkbox('activo');
        $activo->setUseHiddenElement(true);
        $activo->setCheckedValue('1');
        $activo->setUncheckedValue('0');
        $activo->setValue('0');
        $this->add($activo);
        
        $destacado = new Element\Checkbox('destacado');
        $destacado->setUseHiddenElement(false);
        $destacado->setAttribute('id', 'destacado');
        $destacado->setCheckedValue('1');
        $destacado->setUncheckedValue('0');
        $destacado->setValue('0');
        $this->add($destacado);

        $orden = new Element\Text('orden');
        $orden->setAttributes(array(
            'id' => 'orden',
            'maxlength' => '2',
        ));
        $this->add($orden);
    }
    
    protected function _getPaqueteService()
    {
        return $this->_sl->get('Admin\Model\Service\PaqueteService');
    }
}
