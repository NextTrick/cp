<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */
namespace Orden\Form;

use Orden\Model\Service\OrdenService;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceLocatorInterface;

class BuscarForm extends Form
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
        
        $filtrosBuscar = $this->getFiltrosBuscar();
        $cmbFiltro     = new Element\Select('cmbFiltro');
        $cmbFiltro->setAttributes(array('id' => 'cmbFiltro'));
        $cmbFiltro->setValueOptions($filtrosBuscar);
        $cmbFiltro->setEmptyOption('- Seleccione -');
        $cmbFiltro->setDisableInArrayValidator(true);
        $this->add($cmbFiltro);

        $filtroTipoComp = $this->getTipoComprobante();
        $cmbTipoDoc     = new Element\Select('cmbTipoComp');
        $cmbTipoDoc->setAttributes(array('id' => 'cmbTipoComp'));
        $cmbTipoDoc->setValueOptions($filtroTipoComp);
        $cmbTipoDoc->setEmptyOption('- Seleccione -');
        $cmbTipoDoc->setDisableInArrayValidator(true);
        $this->add($cmbTipoDoc);

        $filtroEstado = $this->getEstados();
        $cmbEstado    = new Element\Select('cmbEstado');
        $cmbEstado->setAttributes(array('id' => 'cmbEstado'));
        $cmbEstado->setValueOptions($filtroEstado);
        $cmbEstado->setEmptyOption('- Seleccione -');
        $cmbEstado->setDisableInArrayValidator(true);
        $this->add($cmbEstado);

        $filtroMetodoPago = $this->getMetodoPago();
        $cmbMetdoPago     = new Element\Select('cmbMetodoPago');
        $cmbMetdoPago->setAttributes(array('id' => 'cmbMetodoPago'));
        $cmbMetdoPago->setValueOptions($filtroMetodoPago);
        $cmbMetdoPago->setDisableInArrayValidator(true);
        $this->add($cmbMetdoPago);

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

    private function getEstados()
    {
        return array(
             OrdenService::ESTADO_PAGO_ERROR     => 'Error',
             OrdenService::ESTADO_PAGO_PAGADO    => 'Pagado',
             OrdenService::ESTADO_PAGO_PENDIENTE => 'Pendiente'
        );
    }

    private function getTipoComprobante()
    {
        return array(OrdenService::TIPO_COMPROBANTE_DNI => 'DNI', OrdenService::TIPO_COMPROBANTE_RUC => 'RUC');
    }

    private function getMetodoPago()
    {
        return array(OrdenService::METODO_PAGO_VISA => 'Visa', OrdenService::METODO_PAGO_PE => 'PE');
    }

    /**
     * Retorna un array que se utilizar en la busqueda de usuario
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function getFiltrosBuscar()
    {
        return array(
            'email'              => 'Correo',
            'comprobante_numero' => 'Nro. Comprobante',
            'fac_razon_social'   => 'R. Social',
            'nombres'            => 'Nombres',
        );
    }
}
