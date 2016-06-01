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

        $url = new Element\Text('url');
        $url->setAttributes(array(
            'id' => 'url'
        ));
        $this->add($url);
        
        $tipos = $this->_getContenidoService()->getTipos();
        $tipo = new Element\Select('tipo');
        $tipo->setAttributes(array('id' => 'tipo'));
        $tipo->setValueOptions($tipos);
        $tipo->setEmptyOption('- Seleccione -');
        $tipo->setDisableInArrayValidator(true);
        $this->add($tipo);
        
        $titulo = new Element\Text('titulo');
        $titulo->setAttributes(array(
                'id' => 'titulo',
                'maxlength' => '50',
            ));
        $this->add($titulo);
        
        $contenido = new Element\Textarea('contenido');
        $contenido->setAttributes(array(
                'id' => 'contenido',
                'rows' => 10,
                'cols' => 80,
            ));
        $this->add($contenido);

        $estado = new Element\Checkbox('estado');
        $estado->setUseHiddenElement(true);
        $estado->setCheckedValue('1');
        $estado->setUncheckedValue('0');
        $estado->setValue('0');
        $this->add($estado);
    }
    
    protected function _getContenidoService()
    {
        return $this->_sl->get('Cms\Model\Service\ContenidoService');
    }

//$adapter = $this->_sl->get('dbAdapter');
}
