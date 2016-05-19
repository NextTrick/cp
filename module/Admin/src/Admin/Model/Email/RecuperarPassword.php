<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Admin\Model\Email;

class RecuperarPassword
{
    private $_sl;
    
    public function __construct($serviceLocator) {
        $this->_sl = $serviceLocator;
    }

    public function sendMail($data)
    {
        $config = $this->_sl->get('config');

        if (isset($config['mail'])) {
            $config = $config['mail'];
        } else {
            throw new \Exception('No existe configuración');
        }
        
        try {
            $data['subject'] = 'Asunto: Admin Coney Park - Recuperar Contraseña';
            $data['toEmail'] = $data['email'];
            $view = new \Zend\View\Model\ViewModel();
            $view->setTemplate('recuperar-password');
            $view->setTerminal(true);
            $view->setVariable('data', $data);

            $email = new \Common\Helpers\Mail($config);
            $email->setDirTemplate(APP_PATH . '/module/Admin/src/Admin/Model/Email/view');
            $email->send($view, $data);
            return true;
        } catch (\Exception $e) {
            \Common\Helpers\Error::initialize()->logException($e);
        }
        return false;
    }
}