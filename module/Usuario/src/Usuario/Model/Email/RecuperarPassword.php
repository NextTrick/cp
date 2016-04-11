<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Email;

class RecuperarPassword
{
    private $_sl;
    
    public function __construct($serviceLocator) {
        $this->_sl = $serviceLocator;
    }

    public function sendMail($data)
    {
        $config = $this->_sl->get('config');
        if (isset($config['mails']['recuperarPassword'])) {
            $config = $config['mails']['recuperarPassword'];
        } else {
            throw new \Exception('No existe configuración');
        }
        
        try {
            $data['toEmail'] = $data['email'];
            $view = new \Zend\View\Model\ViewModel();
            $view->setTemplate('recuperar-password');
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