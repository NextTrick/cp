<?php
namespace Authentication;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Util\Util\Util as ModelUtil;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array($this, 'initAuth'), 100);
              
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }        
    
    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/helper.config.php';
    }
    
    public function getControllerPluginConfig()
    {       
        return include __DIR__ . '/config/plugin.config.php';
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
    
    public function initAuth(MvcEvent $e)
    {  
        if(empty($_SERVER['REQUEST_URI'])) {
            return TRUE;
        }
        $app = $e->getApplication();
        $viewModel = $app->getMvcEvent()->getViewModel();
        $data = $this->getControllerInfo($e);
        $authService = $this->_getAuthenticationService($e);        
        $target = $app->getMvcEvent()->getTarget();
        $viewModel->actionName = $data['action'];
        $viewModel->controllerName = $data['controller'];
        $viewModel->moduleName = $data['module'];
        $viewModel->uriActual = !empty($_SERVER['HTTP_HOST'])?'http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] :'';
        $viewModel->isAuth = $authService->hasIdentity(); 
        $user = array();
        if (!$authService->hasIdentity()) {  
            $rol = 'invitado';
            if (!$this->initAcl($e, $rol)) {
                return $this->redirect($e);
            }
        } elseif ($authService->hasIdentity()) {
            $user = $authService->getIdentity(); 
            $rol = $user['rol_id'];
            $container = new Container('PPAGES');
            $container->user = $user;
            $viewModel->actionName = $data['action'];
            $viewModel->isAuth = true;
            
            $this->checkUserEmail($e, $user);            
            if (!$this->initAcl($e, $rol)) {
                return $this->redirect($e, '/access-denied');
            }
        }
        $viewModel->user = $user;
    }
    private function isCustomPartner($uri, $e)
    {
        $config  = $this->getConfigs($e);
        $response = array(
            'isCustomizable' => FALSE,
            'isCustomizablePhp' => FALSE,
            'uriStatic' => $config['servers']['static']['host'],
        );
        if (ModelUtil::isCustomFront($uri)) {
            $baseUrlPayPartner = $config['servers']['static']['host']. 'partners/' . $uri . '/';
            $response['isCustomizable'] = TRUE;
            $response['uriStatic'] = $baseUrlPayPartner;
            $response['isCustomizablePhp'] = ModelUtil::isCustomFront($uri);
        }
        return $response;
    }
    
    public function checkUserEmail($e, $user)
    {
        if (empty($user['email'])) {
            $routeMatch = $e->getRouteMatch()->getMatchedRouteName();            
            if ($routeMatch != 'profile-info') {
                $this->redirect($e, 'profile-info');
            }
        }
    }
    
    /**
     * 
     * @param MvcEvent $e
     * @return \Authentication\Model\Service\AuthenticationService
     */
    protected function _getAuthenticationService(MvcEvent $e)
    {
        return $e->getApplication()
                ->getServiceManager()
                ->get('Authentication\Model\Service\AuthenticationService');
    }
    
    public function initAcl(MvcEvent $e, $rol)
    {
        $info = $this->getControllerInfo($e);

        $aclService = $this->_getAclService($e);
        
        $aclService->setResource($info);
        $aclService->setRol($rol);
        
        return $aclService->validate();
    }
    
    /**     
     * @return \Authentication\Model\Service\AclService
     */
    protected function _getAclService($e)
    {
        return $e->getApplication()
                ->getServiceManager()
                ->get('Authentication\Model\Service\AclService');
    }
        
    protected function _getUserService($e)
    {
        return $e->getApplication()
                ->getServiceManager()
                ->get(Model\Service\AclService::SERVICE_USER);
    }
    
    public function redirect($e, $url = '/login')
    {
        $response = $e->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();

        return $response;
    }
    
    public function getControllerInfo($e)
    {
        $info = array();

        $matches = $e->getRouteMatch();

        $controllerPath = $matches->getParam('controller');
        $controllerArray = explode("\\", $controllerPath);
        
        $info['module'] = strtolower($controllerArray[0]);
        $info['controller'] = @strtolower($controllerArray[2]);
        $info['action'] = strtolower($matches->getParam('action'));

        return $info;   
    }
}
