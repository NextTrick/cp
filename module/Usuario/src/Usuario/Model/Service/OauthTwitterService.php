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
            throw new \Exception('Falló la validación con Twitter, token invalido.');
        }

        //Create TwitteroAuth object with app key/secret and token key/secret from default phase
        $connection = new \TwitterOAuth\Api($this->_config->consumer_key, $this->_config->consumer_secret,
                $oauthTokenSession, $oauthTokenSecretSession);
        
        //Request access tokens from twitter
        $oauthVerifier = $this->get('oauth_verifier');
        $accessToken = $connection->getAccessToken($oauthVerifier);
        
        $this->_container->offsetSet('access_token_tw', $accessToken);
        
        $this->_container->offsetUnset('temp_oauth_token');
        $this->_container->offsetUnset('temp_oauth_token_secret');
        
        //If HTTP response is 200 continue otherwise send to connect page to retry
        if ($connection->http_code == 200) {
            
            $url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
            $getfield = '?screen_name=' . $accessToken['screen_name'];
                
            $data = $connection->get($url. $getfield);
            if (!empty($data->id)) {
                $criteria = array('where' => array('twitter_id' => $data->id));
                $row = $this->getRepository()->findOne($criteria);
                $registrado = empty($row) ? false : true;
                $data = array(
                    'id' => $data->id,
                    'email' => null,
                    'gateway' => LoginGatewayService::LOGIN_TWITTER,
                    'registrado' => $registrado,
                );
                if ($registrado == false) {
                    $this->_container->offsetUnset('access_token_tw');
                    $this->_container->offsetSet('temp_registro', $data);
                } else {
                    //===============  Data Login ==============
                    $session = $this->getRepository()->getUsuarioByEmail($row['email']);
                    $this->_container->offsetSet('usuario', $session);
                }
                return $data;
            } else {
                return false;
            }
        } else {
            throw new \Exception('Falló la validación con Twitter, error.');
        }
    }

    public function login()
    {
        $this->logout();
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
                throw new \Exception('Falló la validación con Twitter, intentelo nuevamenete.');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function isLoggedIn()
    {
        $usuario = $this->getData();
        if ($this->_container->offsetExists('access_token_tw') && !empty($usuario)) {
            return true;
        }
        return false;
    }
    
    public function logout()
    {
        $this->_container->getManager()->getStorage()->clear();
    }
    
    public function getData()
    {
        if ($this->_container->offsetExists('usuario')) {
            return $this->_container->offsetGet('usuario');
        }
        return array();
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