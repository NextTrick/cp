<?php
namespace Authentication\Model\Service;
          
use ZendOAuthentication\Token\Access;
use Usuario\Model\Entity\UsuarioEntity;
use Google_Client;
use Google_Service_Oauth2;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GoogleService implements ServiceLocatorAwareInterface
{      
    private $_client;
    private $_auth2;
    protected $_sl;
    
    public function __construct($config) 
    {        
        
        $this->_client = new Google_Client();
        $this->_client->setClientId($config['client_id']);
        $this->_client->setClientSecret($config['client_secret']);
        $this->_client->setRedirectUri($config['auth_redirect']);
        
        $this->_client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $this->_client->addScope("https://www.googleapis.com/auth/plus.me");
   
        $this->_auth2 = new Google_Service_Oauth2($this->_client);
    }
    
    public function login()
    {
      $this->_client->authenticate($_GET['code']);
      $userData = $this->_auth2->userinfo->get();

        $userData->token = $this->_client->getAccessToken();     

        $perfil = $this->_getPerfilService()
                ->getRelsByExternoIdExternoUsuarioId(\Usuario\Model\Repository\UsuarioRepository::EXTERNO_GPLUS_ID,
                $userData->id);
                       
        if ($perfil == null) {  
            $perfil = $this->_getPerfilService()->getRelsByEmail($userData->email);
            if ($perfil == null) {
                $usuario = new UsuarioEntity();
                $usuario->setGoogleToken($userData->token); 
                $usuario->setUsuario($this->_getUsername($userData->email));            
                $usuario->setNombre($userData->name);
                $usuario->setExternoUsuarioId($userData->id);
                $usuario->setImagen($userData->picture);
                $usuario->setEmail($userData->email);
                $usuario->setExternoId(\Usuario\Model\Repository\UsuarioRepository::EXTERNO_GPLUS_ID);
                $usuario->setGenero($userData->gender);

                $usuario = $this->_getUsuarioService()->save($usuario);

                $perfil = new \Usuario\Model\Entity\PerfilEntity();
                $perfil->setPerfilTipoId(\Usuario\Model\Repository\PerfilTipoRepository::USUARIO_ID);
                $perfil->setUsuarioId($usuario->getId());            
                $perfil = $this->_getPerfilService()->save($perfil);     
                $perfil = $this->_getPerfilService()->getRelsById($perfil->getId());
            } else {
                $usuario = $perfil->getUsuario();
                $usuario->setGoogleToken($userData->token);                     
                $this->_getUsuarioService()->save($usuario);
            }
        } else {
            $usuario = $perfil->getUsuario();
            if ($usuario->getId() != 20) {
                if ($usuario->getCambioImagen() == 0) {
                    $usuario->setImagen($userData->picture);
                }
            }
            $this->_getUsuarioService()->save($usuario);
        }
   
        $authService = $this->_getAuthenticationService();
        $authService->setCredentialColumns('id', 'externo_usuario_id');
        $authService->authenticate($perfil);      
    }
    
    private function _getUsername($email)
    {
        $username = '';

        $array = explode('@', $email);
        $username = $array[0];                
  
        $i = 1;
        while (count($this->_getUsuarioService()->getBy($username)) >= 1) {
            $username = $username.$i++;
        }
        
        return $username;        
    }
    
    public function getLoginUrl()
    {
        return $this->_client->createAuthUrl();
    }    
    
    /**
     * 
     * @return \Authentication\Model\Service\AuthenticationService
     */
    protected function _getAuthenticationService()
    {
        return $this->_sl->get('Authentication\Model\Service\AuthenticationService');
    }
    
    /**
     * 
     * @return \Usuario\Model\Service\UsuarioService
     */
    protected function _getUsuarioService()
    {
        return $this->_sl->get('Usuario\Model\Service\UsuarioService');
    }
    
    /**
     * 
     * @return \Usuario\Model\Service\PerfilService
     */
    protected function _getPerfilService()
    {
        return $this->_sl->get('Usuario\Model\Service\PerfilService');
    }
    
    /**
     * Get service locator
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface;
     */
    public function getServiceLocator()
    {
        return $this->_sl;
    }
    
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->_sl = $serviceLocator;
    }
    
}