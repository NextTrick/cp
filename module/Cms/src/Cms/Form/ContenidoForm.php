<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Cms\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContenidoForm extends Form
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
        $this->setAttribute('id', 'formContenido');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $codigo = new Element\Text('codigo');
        $codigo->setAttributes(array(
                'id' => 'codigo',
                'maxlength' => '20',
            ));
        $this->add($codigo);
        
        $tipo = new Element\Text('tipo');
        $tipo->setAttributes(array(
                'id' => 'tipo',
                'maxlength' => '20',
            ));
        $this->add($tipo);
        
        $titulo = new Element\Text('titulo');
        $titulo->setAttributes(array(
                'id' => 'titulo',
                'maxlength' => '20',
            ));
        $this->add($titulo);
        
        $contenido = new Element\Text('contenido');
        $contenido->setAttributes(array(
                'id' => 'contenido',
                'maxlength' => '20',
            ));
        $this->add($contenido);

        $estado = new Element\Checkbox('estado');
        $estado->setUseHiddenElement(true);
        $estado->setCheckedValue('1');
        $estado->setUncheckedValue('0');
        $estado->setValue('0');
        $this->add($estado);
    }
}
