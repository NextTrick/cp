<?php

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();        

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
        ), 101);
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function(MvcEvent $event) {
            $currentNamespaceController = $event->getRouteMatch()->getParam('controller');        
            $controllerPart = explode('\\', $currentNamespaceController);
            $currentModule = array_shift($controllerPart);


            if (!in_array($currentModule, array('Application'))) {
                $viewModel = $event->getViewModel();
                $viewModel->setTemplate('layout/admin-layout');
            }
        }, 200);
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $translatorI = new \Zend\I18n\Translator\Translator();
        $translatorI->setLocale('es_ES');

        $translator = new \Zend\Mvc\I18n\Translator($translatorI);
        $translator->addTranslationFile(
            'phpArray',
            './vendor/zendframework/zendframework/resources/languages/es/Zend_Validate.php',
            'default',
            'es'
        );

        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
        
        $this->bootstrapSession($e);
    }

    public function bootstrapSession($e)
    {
        $session = $e->getApplication()
                     ->getServiceManager()
                     ->get('Zend\Session\SessionManager');
        $session->start();

        $container = new \Zend\Session\Container('initialized');
        if (empty($container->init)) {
            $serviceManager = $e->getApplication()->getServiceManager();
            $request        = $serviceManager->get('Request');

            $session->regenerateId(true);
            $container->init          = 1;
            $container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
            $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');

            $config = $serviceManager->get('Config');
            if (!isset($config['session'])) {
                return;
            }

            $sessionConfig = $config['session'];
            if (isset($sessionConfig['validators'])) {
                $chain   = $session->getValidatorChain();

                foreach ($sessionConfig['validators'] as $validator) {
                    switch ($validator) {
                        case 'Zend\Session\Validator\HttpUserAgent':
                            $validator = new $validator($container->httpUserAgent);
                            break;
                        case 'Zend\Session\Validator\RemoteAddr':
                            $validator  = new $validator($container->remoteAddr);
                            break;
                        default:
                            $validator = new $validator();
                    }

                    $chain->attach('session.validate', array($validator, 'isValid'));
                }
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getControllerConfig()
    {        
        return include __DIR__ . '/config/controller.config.php';
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/viewhelper.config.php';
    }
    
    public function boforeDispatch(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $securityModeules = $serviceManager->get('security')->getModules();

        $currentNamespaceController = $e->getRouteMatch()->getParam('controller');
        $controllerPart = explode('\\', $currentNamespaceController);
        $currentModule = array_shift($controllerPart);
        $currentAction = $e->getRouteMatch()->getParam('action');

        if (in_array($currentModule, $securityModeules)) {
            $response = $e->getResponse();
            $serviceManager = $application->getServiceManager();
            $login = $serviceManager->get('Admin\Model\Service\LoginService');

            $access = $serviceManager->get('security')
                ->isAccessAllowed($currentNamespaceController, $currentAction);
            
            if ($login->getRepository()->isLoggedIn()) {
                if ($access === false) {
                    $response->setHeaders($response->getHeaders()
                        ->addHeaderLine('Location', BASE_URL . 'admin/error'));
                    $response->setStatusCode(405);
                    $e->stopPropagation();
                }
            } else {
                if ($access === false) {
                    $response->setHeaders($response->getHeaders()
                        ->addHeaderLine('Location', BASE_URL . 'admin/login'));
                    $response->setStatusCode(302);
                }

                $response->sendHeaders();
            }
        }
    }
}
