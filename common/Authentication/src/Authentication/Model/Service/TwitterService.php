<?php
namespace Authentication\Model\Service;
          
use ZendOAuthentication\Token\Access;
use Usuario\Model\Entity\UsuarioEntity;
use ZendService\Twitter\Twitter as ZendTwitter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Publicacion\Model\Entity\PublicacionEntity;

class TwitterService extends ZendTwitter implements ServiceLocatorAwareInterface
{      
    protected $_sl;
    
    public function login(Access $accesToken)
    {
        $response = $this->account->verifyCredentials();        
        $twitterResponse = $response->toValue();         
        $twitterToken = $accesToken->getToken() 
                . '_|_' 
                . $accesToken->getTokenSecret();
                                        
        $perfil = $this->_getPerfilService()
                ->getRelsByExternoIdExternoUsuarioId(\Usuario\Model\Repository\UsuarioRepository::EXTERNO_TWITTER_ID,
                $twitterResponse->id);
        
        if (empty($perfil)) {
            $usuario = new UsuarioEntity();
            $usuario->setExternoToken($twitterToken);
            //$usuario->setUsuario($twitterResponse->screen_name);
                                    
            // Buscar si nombre de usuario ya existe
            $dataUsuario = $this->_getUsuarioService()->getBy($twitterResponse->screen_name);            
            // Si ya existe debe mostrar el nombre
            if (count($dataUsuario) >= 1) {
                $twitterName = $hashtagName = \Util\Common\String::sanear_string($twitterResponse->name);
                $usuario->setUsuario($twitterName);
            } else {
                $usuario->setUsuario($twitterResponse->screen_name);
            } 
            
            $usuario->setNombre($twitterResponse->name);
            $usuario->setExternoUsuarioId($twitterResponse->id);
            $usuario->setImagen($twitterResponse->profile_image_url);
            $usuario->setExternoId(\Usuario\Model\Repository\UsuarioRepository::EXTERNO_TWITTER_ID);            
            $usuario->setLocalizacion($twitterResponse->location);
            $usuario = $this->_getUsuarioService()->save($usuario);
                   
            $perfil = new \Usuario\Model\Entity\PerfilEntity();
            $perfil->setPerfilTipoId(\Usuario\Model\Repository\PerfilTipoRepository::USUARIO_ID);
            $perfil->setUsuarioId($usuario->getId());            
            $perfil = $this->_getPerfilService()->save($perfil);             
            $perfil = $this->_getPerfilService()->getRelsById($perfil->getId());
        } else {
            $usuario = $perfil->getUsuario();
            if ($usuario->getCambioImagen() == 0) {
                $usuario->setImagen($twitterResponse->profile_image_url);    
            }
            $this->_getUsuarioService()->save($usuario);
        }
        
        $authService = $this->_getAuthenticationService();
        $authService->setCredentialColumns('id', 'externo_usuario_id');
        $authService->authenticate($perfil);
    }
    
    public function sendTweet($publicaciones, $filterHastag)
    {
        foreach ($publicaciones as $publicacion) {
            $tweet = $this->prepareTweet($publicacion->getTitulo(),
                    array($publicacion->getHashtag()->getNombre(), $filterHastag), 
                    $publicacion->getCodigo());
            
            $response = $this->statuses->update($tweet);  
            $jsonBody = $response->toValue();
            if(isset($jsonBody->errors)) {
                \Util\Common\Email::reportDebug($jsonBody, null, 'Error al enviar Tweets');
                break;
            }
        }
    }
    
    public function prepareTweet($string, $hashtag = array(), $url = '')
    {
        $string = \Util\Common\String::cut($string, 100, '...');
        
        if (!empty($url)) {
            if (strpos($url, 'http') === false) {            
                $config = $this->_sl->get('config');
                $url = $config['view_manager']['base_path'] . '/v/' . $url;
            }
        }
        
        
        $hashtagStr = '';
        foreach ($hashtag as $item) {
            $hashtagStr .= "#$item" . ' ';
        }
        
        $string = $hashtagStr . $string . ' ' . $url;
        
        return $string;        
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