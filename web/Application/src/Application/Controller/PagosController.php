<?php
namespace Application\Controller;

use Admin\Model\Repository\OrdenRepository;
use Admin\Model\Service\DetalleOrdenService;
use Admin\Model\Service\OrdenService;
use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class PagosController extends SecurityWebController
{
    public function confirmacionAction()
    {
        $view = new ViewModel();
        $orden = $this->params()->fromRoute('orden');
        $ordenId = base64_decode($orden);

        $ordenData = $this->_getOrdenService()->getRepository()->getById($ordenId);

        if (empty($ordenData)) {
            $this->_toUrlRecargas();
        }
        
        $ordenDetalleData = $this->_getDetalleOrdenService()->getRepository()->getConfirmacionDatosByOrderId($ordenId);
        if ($ordenData['pago_estado'] == OrdenRepository::PAGO_ESTADO_PAGADO) {
            $template = 'exito.html';
            $view->ordenData = $ordenData;
            $view->ordenDetalleData = $ordenDetalleData;
        } else if ($ordenData['pago_estado'] == OrdenRepository::PAGO_ESTADO_ERROR
            || $ordenData['pago_estado'] == OrdenRepository::PAGO_ESTADO_EXPIRADO) {
            $template = 'error.html';
            $view->ordenData = $ordenData;
        } else {
            $this->_toUrlRecargas();
        }

        $view->setTemplate($template);

        return $view;
    }

    /**
     * @return OrdenService
     */
    private function _getOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\OrdenService');
    }

    /**
     * @return DetalleOrdenService
     */
    private function _getDetalleOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\DetalleOrdenService');
    }
}
