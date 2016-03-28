<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use Zend\Session\Container;

class OauthTwitterService
{
    protected $_repository = null;
    protected $_sl = null;
    protected $_config = null;
    protected $_container = null;

    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl = $serviceLocator;
        $this->_container = new Container('session_usuario');
        $this->_setCofig();
    }

    private function _setCofig()
    {
        $config = $this->_sl->get('config');
        $this->_config = (object)$config['social']['twitter'];
    }
    
    public function callback()
    {
        //If the oauth_token is old redirect to the connect page
        $oauthToken = $this->get('oauth_token');
        $oauthTokenSession = $this->_container->offsetGet('temp_oauth_token');
        $oauthTokenSecretSession = $this->_container->offsetGet('temp_oauth_token_secret');
        if (!empty($oauthToken) && $oauthTokenSession !== $oauthToken) {
            $this->logout();
            throw new \Exception('Falló la validación con Twitter, token invalido.');
        }

        //Create TwitteroAuth object with app key/secret and token key/secret from default phase
        $connection = new \TwitterOAuth\Api($this->_config->consumer_key, $this->_config->consumer_secret,
                $oauthTokenSession, $oauthTokenSecretSession);
        
        //Request access tokens from twitter
        $oauthVerifier = $this->get('oauth_verifier');
        $accessToken = $connection->getAccessToken($oauthVerifier);
        
        $this->_container->offsetSet('access_token', $accessToken);
        
        $this->_container->offsetUnset('temp_oauth_token');
        $this->_container->offsetUnset('temp_oauth_token_secret');
        
        //If HTTP response is 200 continue otherwise send to connect page to retry
        if ($connection->http_code == 200) {
            
            $url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
            $getfield = '?screen_name=' . $accessToken['screen_name'];
                
            $data = $connection->get($url. $getfield);
            if (!empty($data->id)) {
                $criteria = array('where' => array('facebook_id' => $data->id));
                $registrado = $this->getRepository()->findExists($criteria);
                $data = array(
                    'id' => $data->id,
                    'email' => null,
                    'gateway' => LoginGatewayService::LOGIN_TWITTER,
                    'registrado' => $registrado,
                );
                if ($registrado == false) {
                    $this->_container->offsetSet('temp_registro', $data);
                }
                return $data;
            } else {
                return false;
            }
        } else {
            $this->logout();
            throw new \Exception('Falló la validación con Twitter, error.');
        }
    }

    public function login()
    {
        try {
            //Build TwitterOAuth object with client credentials
            $twitter = new \TwitterOAuth\Api($this->_config->consumer_key, $this->_config->consumer_secret);

            //Get temporary credentials
            $requestToken = $twitter->getRequestToken($this->_config->redirect_callback);

            //Save temporary credentials to session
            $this->_container->offsetSet('temp_oauth_token', $requestToken['oauth_token']);
            $this->_container->offsetSet('temp_oauth_token_secret', $requestToken['oauth_token_secret']);

            switch ($twitter->http_code) {
              case 200:
                $url = $twitter->getAuthorizeURL($requestToken['oauth_token']);
                header("location: $url"); 
                break;
              default:
                $this->logout();
                throw new \Exception('Falló la validación con Twitter, intentelo nuevamenete.');
            }
        } catch (\Exception $e) {
            $this->logout();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function isLogin()
    {
        if ($this->_container->offsetExists('access_token')) {
            return true;
        }
        return false;
    }
    
    public function logout()
    {
        $this->_container->getManager()->getStorage()->clear();
    }
    
    private function get($name)
    {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
}