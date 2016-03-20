<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service;

use Zend\Session\Container;
use Abraham\TwitterOAuth\TwitterOAuth;

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
    
    public function login()
    {
        $accessToken = $this->_container->offsetGet('access_token');

        // twitter session with your credentials
        $twitter = new \Simplon\Twitter\Twitter($this->_config->consumer_key, $this->_config->consumer_secret);

        try {
            $oauthRequestTokenVo = $twitter->requestOauthRequestToken($this->_config->redirect_callback);

            echo "Twitter redirect url:\n";
            echo $twitter->getAuthenticationUrl($oauthRequestTokenVo->getOauthToken());
            echo "\n\n";
        } catch (\Simplon\Twitter\TwitterException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
        exit;
        try
        {
            // retrieve access tokens and profile data from user
            $oauthAccessTokenVo = $twitter->requestOauthAccessToken($this->_config->oauth_access_token, $this->_config->oauth_access_token_secret);

            var_dump($oauthAccessTokenVo);

           // var_dump result would look something like this:

            // class Simplon\Twitter\OauthAccessTokenVo#4 (5) {
            // protected $oauthToken =>
            // string(50) "3197060333-xxxx4chX0Sega3iMF0r55PP96BAGyXXXFTwjpgW"
            // protected $oauthTokenSecret =>
            // string(45) "FeIpfZ1qK4jTaKXXXXTaQAlfny0dFgBV4K15vbnFd3XX"
            // protected $userId =>
            // string(10) "1234567899"
            // protected $screenName =>
            // string(12) "foobar user"
            // protected $xAuthExpires =>
            // string(1) "0"
            // }
        }
        catch (\Simplon\Twitter\TwitterException $e)
        {
            var_dump($e->getMessage());
        }

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