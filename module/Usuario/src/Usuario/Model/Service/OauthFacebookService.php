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
        $this->_container = new Container('session_usuario');
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
                throw new \Exception($e->getMessage(), $e->getCode());
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }

            if (!isset($accessToken)) {
                if ($helper->getError()) {
                    throw new \Exception('HTTP/1.0 401 Unauthorized');
                } else {
                    throw new \Exception('HTTP/1.0 400 Bad Request');
                }
            }
        }

        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId($this->_config->app_id);
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
              $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
              $this->_container->offsetSet('access_token', $accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }
        }

        $fb->setDefaultAccessToken($accessToken);
        try {
            $response = $fb->get('/me?fields=name,email,first_name,last_name,gender');
            $data = $response->getGraphUser();
            if (!empty($data['id'])) {
                $criteria = array('where' => array('facebook_id' => $data['id']));
                $registrado = $this->getRepository()->findExists($criteria);
                $data = array(
                    'id' => $data['id'],
                    'email' => $data['email'],
                    'gateway' => LoginGatewayService::LOGIN_FACEBOOK,
                    'registrado' => $registrado,
                );
                if ($registrado == false) {
                    $this->_container->offsetSet('temp_registro', $data);
                }
                return $data;
            } else {
                return false;
            }
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function login()
    {
        try {
            $this->logout();
            $fb = new \Facebook\Facebook(array(
                'app_id' => $this->_config->app_id,
                'app_secret' => $this->_config->api_secret,
                'default_graph_version' => 'v2.5',
            ));

            $helper = $fb->getRedirectLoginHelper();
            $permissions = array('email'); // Optional permissions
            $loginUrl = $helper->getLoginUrl($this->_config->redirect_callback, $permissions);

            header("location: $loginUrl");
            exit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    
    public function isLoggedIn()
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

    public function getRepository()
    {
        return $this->_repository;
    }
}