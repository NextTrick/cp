<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UbigeoController extends AbstractActionController
{
    public function departamentoAction()
    {
        $paisId = $this->params()->fromQuery('pais_id');
        $results = $this->_getUbigeoService()->getDepartamentos($paisId);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }
    
    public function provinciaAction()
    {
        $paisId = $this->params()->fromQuery('pais_id');
        $departamentoId = $this->params()->fromQuery('departamento_id');
        $results = $this->_getUbigeoService()->getProvincias($paisId, $departamentoId);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }
    
    public function distritoAction()
    {
        $paisId = $this->params()->fromQuery('pais_id');
        $departamentoId = $this->params()->fromQuery('departamento_id');
        $provinciaId = $this->params()->fromQuery('provincia_id');
        $results = $this->_getUbigeoService()->getDistritos($paisId, $departamentoId, $provinciaId);
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
