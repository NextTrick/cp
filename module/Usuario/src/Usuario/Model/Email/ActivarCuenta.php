<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Email;

class ActivarCuenta
{
    private $_sl;
    
    public function __construct($serviceLocator) {
        $this->_sl = $serviceLocator;
    }

    public function sendMail($data)
    {
        $config = $this->_sl->get('config');
        $developers = null;
        if (isset($config['emails']['developers'])) {
            $developers = $config['emails']['developers'];
        }
        
        if (isset($config['mail'])) {
            $config = $config['mail'];
        } else {
            throw new \Exception('No existe configuración');
        }
        
        try {
            $data['subject'] = 'Coney Park - Activación de tu cuenta';
            $data['toEmail'] = $data['email'];
            $data['bcc'] = $developers;
            $view = new \Zend\View\Model\ViewModel();
            $view->setTemplate('activar-cuenta');
            $view->setTerminal(true);
            $view->setVariable('data', $data);

            $email = new \Common\Helpers\Mail($config);
            $email->setDirTemplate(APP_PATH . '/module/Usuario/src/Usuario/Model/Email/view');
            $email->send($view, $data);
            return true;
        } catch (\Exception $e) {
            \Common\Helpers\Error::initialize()->logException($e);
        }
        return false;
    }
}