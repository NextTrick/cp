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
        $orden = $this->params()->fromRoute('orden', base64_decode('XXXXXX'));
        $ordenId = base64_decode($orden);

        $ordenData = $this->_getOrdenService()->getRepository()->getConfirmacionMailDatosById($ordenId);

        if (!empty($ordenData)) {
            $ordenDetalleData = $this->_getDetalleOrdenService()->getRepository()->getConfirmacionDatosByOrderId($ordenId);
            if ($ordenData['pago_estado'] == OrdenRepository::PAGO_ESTADO_PAGADO) {
                $template = 'application/pagos/exito.phtml';
                $view->ordenData = $ordenData;
                $view->ordenDetalleData = $ordenDetalleData;
            } else if ($ordenData['pago_estado'] == OrdenRepository::PAGO_ESTADO_ERROR
                || $ordenData['pago_estado'] == OrdenRepository::PAGO_ESTADO_EXPIRADO) {
                $template = 'application/pagos/error.phtml';
                $view->ordenData = $ordenData;
            } else {
                $this->_toUrlRecargas();
            }
        } else {
            $template = 'application/pagos/error.phtml';
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
