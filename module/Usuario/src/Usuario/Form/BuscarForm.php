<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Usuario\Form;

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
                'id' => 'txtBuscar',
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

        $filtroTipoDoc = $this->getTiposDocumento();
        $cmbTipoDoc    = new Element\Select('cmbTipoDoc');
        $cmbTipoDoc->setAttributes(array('id' => 'cmbTipoDoc'));
        $cmbTipoDoc->setValueOptions($filtroTipoDoc);
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

        $filtroPaises = $this->getPaises();
        $cmbPais      = new Element\Select('cmbPais');
        $cmbPais->setAttributes(array('id' => 'cmbPais'));
        $cmbPais->setValueOptions($filtroPaises);
        $cmbPais->setDisableInArrayValidator(true);
        $this->add($cmbPais);

        $cmbDepartamento = new Element\Select('cmbDepartamento');
        $cmbDepartamento->setAttributes(array('id' => 'cmbDepartamento'));
        $cmbDepartamento->setValueOptions(array());
        $cmbDepartamento->setEmptyOption('- Seleccione -');
        $cmbDepartamento->setDisableInArrayValidator(true);
        $this->add($cmbDepartamento);

        $cmbProvincia = new Element\Select('cmbProvincia');
        $cmbProvincia->setAttributes(array('id' => 'cmbProvincia'));
        $cmbProvincia->setValueOptions(array());
        $cmbProvincia->setEmptyOption('- Seleccione -');
        $cmbProvincia->setDisableInArrayValidator(true);
        $this->add($cmbProvincia);

        $cmbDistrito = new Element\Select('cmbDistrito');
        $cmbDistrito->setAttributes(array('id' => 'cmbDistrito'));
        $cmbDistrito->setValueOptions(array());
        $cmbDistrito->setEmptyOption('- Seleccione -');
        $cmbDistrito->setDisableInArrayValidator(true);
        $this->add($cmbDistrito);

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

    }

    protected function _getUbigeoService()
    {
        return $this->_sl->get('Sistema\Model\Service\UbigeoService');
    }

    private function getEstados()
    {
        return array('1' => 'Activo', '0' => 'Baja');
    }

    private function getTiposDocumento()
    {
        return array('1' => 'DNI', '2' => 'C. Extrangeria');
    }

    private function getPaises()
    {
        return $this->_getUbigeoService()->getPaises();
    }

    /**
     * Insertamos data en los inputs de Ubigeo
     * @param  array $params
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function setDataUbigeo($params)
    {
        $params['cmbPais'] = 'PE';
        if (!empty($params['cmbPais'])) {
            $dataDepa = $this->_getUbigeoService()->getDepartamentos($params['cmbPais']);
            $this->get('cmbDepartamento')->setValueOptions($dataDepa);
        }

        if (!empty($params['cmbPais']) && !empty($params['cmbDepartamento'])) {
            $dataProv = $this->_getUbigeoService()->getProvincias($params['cmbPais'],$params['cmbDepartamento']);
            $this->get('cmbProvincia')->setValueOptions($dataProv);
        }

        if (!empty($params['cmbPais']) && !empty($params['cmbDepartamento']) && !empty($params['cmbProvincia'])) {
            $dataDist = $this->_getUbigeoService()->getDistritos($params['cmbPais'], $params['cmbDepartamento'], $params['cmbProvincia']);
            $this->get('cmbDistrito')->setValueOptions($dataDist);
        }
    }

    /**
     * Retorna un array que se utilizar en la busqueda de usuario
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function getFiltrosBuscar()
    {
        return array(
            'email'   => 'Correo',
            'nombres' => 'Nombre',
            'paterno' => 'A. Paterno',
            'materno' => 'A. Materno',
        );
    }
}
