<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */
namespace Admin\Form;

use Admin\Model\Service\OrdenService;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class DetalleOrdenBuscarForm extends Form
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
                'maxlength' => '65',
            ));
        $this->add($txtBuscar);
        
        $filtrosBuscar = $this->getCarritoService()->getFiltrosBuscar();
        $cmbFiltro     = new Element\Select('cmbFiltro');
        $cmbFiltro->setAttributes(array('id' => 'cmbFiltro'));
        $cmbFiltro->setValueOptions($filtrosBuscar);
        $cmbFiltro->setEmptyOption('- Seleccione -');
        $cmbFiltro->setDisableInArrayValidator(true);
        $this->add($cmbFiltro);

        $filtroPagoEstado = $this->getOrdenService()->getPagoEstados();
        $cmbPagoEstado    = new Element\Select('cmbPagoEstado');
        $cmbPagoEstado->setAttributes(array('id' => 'cmbPagoEstado'));
        $cmbPagoEstado->setValueOptions($filtroPagoEstado);
        $cmbPagoEstado->setEmptyOption('- Seleccione -');
        $cmbPagoEstado->setDisableInArrayValidator(true);
        $this->add($cmbPagoEstado);

        $filtroEstado = $this->getOrdenService()->getEstados();
        $cmbEstado    = new Element\Select('cmbEstado');
        $cmbEstado->setAttributes(array('id' => 'cmbEstado'));
        $cmbEstado->setValueOptions($filtroEstado);
        $cmbEstado->setEmptyOption('- Seleccione -');
        $cmbEstado->setDisableInArrayValidator(true);
        $this->add($cmbEstado);


        $txtFechaIni = new Element\Text('txtFechaIni');
        $txtFechaIni->setAttributes(array(
            'id'        => 'txtFechaIni',
            'maxlength' => '15',
        ));
        $this->add($txtFechaIni);

        $txtFechaFin = new Element\Text('txtFechaFin');
        $txtFechaFin->setAttributes(array(
            'id'        => 'txtFechaFin',
            'maxlength' => '15',
        ));
        $this->add($txtFechaFin);

    }

    private function getCarritoService()
    {
        return $this->_sl->get('Admin\Model\Service\DetalleOrdenService');
    }

    /**
     * @return OrdenService
     */
    private function getOrdenService()
    {
        return $this->_sl->get('Admin\Model\Service\OrdenService');
    }
}
