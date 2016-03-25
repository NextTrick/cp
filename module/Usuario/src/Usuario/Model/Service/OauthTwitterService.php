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
        $this->_container = new Container('usuario_web');
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
        $oauthTokenSession = $this->_container->offsetGet('oauth_token');
        $oauthTokenSecretSession = $this->_container->offsetGet('oauth_token_secret');
        if (!empty($oauthToken) && $oauthTokenSession !== $oauthToken) {
            $this->logout();
            throw new \Exception('Token invalido.');
        }

        //Create TwitteroAuth object with app key/secret and token key/secret from default phase
        $connection = new \TwitterOAuth\Api($this->_config->consumer_key, $this->_config->consumer_secret,
                $oauthTokenSession, $oauthTokenSecretSession);
        
        //Request access tokens from twitter
        $oauthVerifier = $this->get('oauth_verifier');
        $accessToken = $connection->getAccessToken($oauthVerifier);
        
        $this->_container->offsetSet('access_token', $accessToken);
        
        $this->_container->offsetUnset('oauth_token');
        $this->_container->offsetUnset('oauth_token_secret');
        
        //If HTTP response is 200 continue otherwise send to connect page to retry
        if ($connection->http_code == 200) {
            
            $url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
            $getfield = '?screen_name=' . $accessToken['screen_name'];
                
            $data = $connection->get($url. $getfield);
            $data['id'];
            $data['name'];

          //The user has been verified and the access tokens can be saved for future use
//          $_SESSION['status'] = 'verified';
//          header('Location: ./index.php');
            var_dump('ok');exit;
        } else {
            $this->logout();
            throw new \Exception('Error');
        }
    }

    public function login()
    {
        //Build TwitterOAuth object with client credentials
        $connection = new \TwitterOAuth\Api($this->_config->consumer_key, $this->_config->consumer_secret);

        //Get temporary credentials
        $requestToken = $connection->getRequestToken($this->_config->redirect_callback);

        //Save temporary credentials to session
        $token = $requestToken['oauth_token'];
        $this->_container->offsetSet('oauth_token', $token);
        $this->_container->offsetSet('oauth_token_secret', $requestToken['oauth_token_secret']);

        //If last connection failed don't display authorization link.
        switch ($connection->http_code) {
          case 200:
            //Build authorize URL and redirect user to Twitter
            $url = $connection->getAuthorizeURL($token);
            header("location: $url"); 
            break;
          default:
            //Show notification if something went wrong
            throw new \Exception('Could not connect to Twitter. Refresh the page or try again later.');
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
        $this->_container->offsetUnset('access_token');
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