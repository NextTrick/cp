<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UbigeoController extends AbstractActionController
{
    public function departamentoAction()
    {
        $codPais = $this->params()->fromQuery('cod_pais');
        $results = $this->_getUbigeoService()->getDepartamentos($codPais);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }
    
    public function provinciaAction()
    {
        $codPais = $this->params()->fromQuery('cod_pais');
        $codDepa = $this->params()->fromQuery('cod_depa');
        $results = $this->_getUbigeoService()->getProvincias($codPais, $codDepa);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }
    
    public function distritoAction()
    {
        $codPais = $this->params()->fromQuery('cod_pais');
        $codDepa = $this->params()->fromQuery('cod_depa');
        $codProv = $this->params()->fromQuery('cod_prov');
        $results = $this->_getUbigeoService()->getDistritos($codPais, $codDepa, $codProv);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }

    private function _getUbigeoService()
    {
        return $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
    }
}
