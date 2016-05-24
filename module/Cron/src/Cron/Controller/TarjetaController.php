<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Cron\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Console\Request as ConsoleRequest;
 
class TarjetaController extends AbstractActionController
{
 
    public function actualizarAction()
    {
        $request = $this->getRequest();
 
        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }
 
        $fInicio = time();
        echo 'Hora Ini: ' . date('Y-m-d H:i:s', $fInicio) . "\n";
        $this->_getTarjetaService()->cronTarjetas();
        $fFin = time();
        echo 'Hora Fin: ' . date('Y-m-d H:i:s', $fFin) . "\n";
        echo 'Tiempo Total: ' . number_format((($fFin-$fInicio)/60), 2, '.', ',') . "\n";
    }
    
    private function _getTarjetaService()
    {
        return $this->getServiceLocator()->get('Tarjeta\Model\Service\TarjetaService');
    }
}