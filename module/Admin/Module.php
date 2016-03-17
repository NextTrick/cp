<?php

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('dispatch', array($this, 'initEnvironment'), 100);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
        ), 101);
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function(MvcEvent $event) {
            $viewModel = $event->getViewModel();
            $viewModel->setTemplate('layout/admin-layout');
        }, 200);
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    
    public function initEnvironment(MvcEvent $e)
    {          
       $app = $e->getParam('application');
       $config = $app->getServiceManager()->get('config');
       $settings = $config['php']['settings'];

       foreach ($settings as $key => $setting) {
           if ($key == 'error_reporting') {
               error_reporting($setting);
               continue;
           }
           ini_set($key, $setting);
       }
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
