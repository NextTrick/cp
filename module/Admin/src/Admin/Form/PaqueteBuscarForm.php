<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */
namespace Admin\Form;

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaqueteBuscarForm extends Form
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
        $this->setAttribute('id', 'formBuscar');
        $this->setAttribute('method', 'post');
    }

    protected function _addElements()
    {
        $txtBuscar = new Element\Text('txtBuscar');
        $txtBuscar->setAttributes(array(
                'id'        => 'txtBuscar',
                'maxlength' => '20',
            ));
        $this->add($txtBuscar);
        
        $filtrosBuscar = $this->getPaqueteService()->getFiltrosBuscar();
        $cmbFiltro     = new Element\Select('cmbFiltro');
        $cmbFiltro->setAttributes(array('id' => 'cmbFiltro'));
        $cmbFiltro->setValueOptions($filtrosBuscar);
        $cmbFiltro->setEmptyOption('- Seleccione -');
        $cmbFiltro->setDisableInArrayValidator(true);
        $this->add($cmbFiltro);

        $filtroActivo = $this->getUsuarioService()->getEstados();
        $cmbActivo    = new Element\Select('cmbActivo');
        $cmbActivo->setAttributes(array('id' => 'cmbActivo'));
        $cmbActivo->setValueOptions($filtroActivo);
        $cmbActivo->setEmptyOption('- Seleccione -');
        $cmbActivo->setDisableInArrayValidator(true);
        $this->add($cmbActivo);

        $filtroTipo = $this->getPaqueteService()->getTipos();
        $cmbTipo    = new Element\Select('cmbTipo');
        $cmbTipo->setAttributes(array('id' => 'cmbTipo'));
        $cmbTipo->setValueOptions($filtroTipo);
        $cmbTipo->setEmptyOption('- Seleccione -');
        $cmbTipo->setDisableInArrayValidator(true);
        $this->add($cmbTipo);


        $filtroDestacado = $this->getPaqueteService()->getDestacado();
        $cmbDestacado    = new Element\Select('cmbDestacado');
        $cmbDestacado->setAttributes(array('id' => 'cmbDestacado'));
        $cmbDestacado->setValueOptions($filtroDestacado);
        $cmbDestacado->setEmptyOption('- Seleccione -');
        $cmbDestacado->setDisableInArrayValidator(true);
        $this->add($cmbDestacado);


    }

    private function getPaqueteService()
    {
        return $this->_sl->get('Admin\Model\Service\PaqueteService');
    }

    private function getUsuarioService()
    {
        return $this->_sl->get('Usuario\Model\Service\UsuarioService');
    }
}
