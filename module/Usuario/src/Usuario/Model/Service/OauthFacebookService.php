<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use Zend\Session\Container;

class OauthFacebookService
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
        $this->_config = (object)$config['social']['facebook'];
    }
    
    public function callback()
    {
        $fb = new \Facebook\Facebook(array(
            'app_id' => $this->_config->app_id,
            'app_secret' => $this->_config->api_secret,
            'default_graph_version' => 'v2.5',
        ));

        $helper = $fb->getRedirectLoginHelper();

        $accessToken = $this->_container->offsetGet('access_token');
        if (empty($accessToken)) {
            try {
                $accessToken = $helper->getAccessToken();
                $this->_container->offsetSet('access_token', $accessToken);
            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                throw new \Exception('Graph returned an error: ' . $e->getMessage());
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                throw new \Exception('Facebook SDK returned an error: ' . $e->getMessage());
            }

            if (!isset($accessToken)) {
                if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    //'Error: ' . $helper->getError()
                    //'Error Code: ' . $helper->getErrorCode()
                    //'Error Reason: ' . $helper->getErrorReason()
                    //'Error Description: ' . $helper->getErrorDescription()
                    throw new \Exception('Error ' . $helper->getErrorCode() . ' :' 
                            . $helper->getErrorDescription());
                } else {
                    header('HTTP/1.0 400 Bad Request');
                    throw new \Exception('HTTP/1.0 400 Bad Request');
                }
            }
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($this->_config->app_id);
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
              $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
              $this->_container->offsetSet('access_token', $accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                throw new \Exception('Error getting long-lived access token: ' . $e->getMessage());
            }
        }

        
        $fb->setDefaultAccessToken($accessToken);
        try {
            $response = $fb->get('/me?fields=name,email,first_name,last_name,gender');
            $userNode = $response->getGraphUser();
            return $userNode;
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            throw new \Exception('Graph returned an error: ' . $e->getMessage());
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            throw new \Exception('Facebook SDK returned an error: ' . $e->getMessage());
        }
    }

    public function login()
    {
        $fb = new \Facebook\Facebook(array(
            'app_id' => $this->_config->app_id,
            'app_secret' => $this->_config->api_secret,
            'default_graph_version' => 'v2.5',
        ));
        
        $helper = $fb->getRedirectLoginHelper();
        $permissions = array('email'); // Optional permissions
        $loginUrl = $helper->getLoginUrl($this->_config->redirect_callback, $permissions);
        
        header("location: $loginUrl");
        exit;
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

    public function getRepository()
    {
        return $this->_repository;
    }
}