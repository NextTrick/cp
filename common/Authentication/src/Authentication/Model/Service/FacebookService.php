<?php

namespace Authentication\Model\Service;

use ZendOAuthentication\Token\Access;
use \Facebook;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Engine4\Model\Engine4Users;
use Auth\Entity\AuthRoles;
use Authentication\Model\Service\AuthenticationService;
use Engine4\Model\Engine4UserFieldsValues;

class FacebookService extends Facebook implements ServiceLocatorAwareInterface 
{

    const PROFILE_PIC_URL = 'http://graph.facebook.com/%usuario/picture';

    protected $_sl;

    public function login()
    {
        $token = $this->getAccessToken();
        $this->setAccessToken($token);
        $userData = $this->api('/me');
        $userData['token'] = $token;  
        
        $userDbData = $this->getUsersService()->getByExternalId($userData['id']);
        if (empty($userDbData)) {            
            $userDbData['facebook_token'] = $token;
            $userDbData['external_id'] = $userData['id'];
            $tempUserDb = array();
            if (!empty($userData['email'])) {
                $tempUserDb = $this->getUsersService()->getByEmail($userData['email']);                    
                if (empty($tempUserDb)) {
                    $userDbData['email'] = $userData['email'];
                }
            }

            if (!empty($tempUserDb)) {
                $userDbData = array_merge((array) $tempUserDb, $userDbData);
                $this->getUsersService()->update($userDbData, array('user_id' => $userDbData['user_id']));
            } else {
                if (empty($userDbData['username'])) {
                    $name = str_replace(' ', '', $userData['name']);
                    $facebookName = \Util\Common\String::sanear_string($name);
                    $userDbData['username'] = $facebookName;
                    $userDbData['displayname'] = $facebookName;
                } else {    
                    $userDbData['username'] = str_replace(' ', '', $userData['username']);
                    $userDbData['displayname'] = $userData['name'];                  
                }

                $userDbData['username'] = $this->getUsersService()
                        ->generateUserName($userDbData['username']);
                                
                $date = new \DateTime('NOW');
                $userDbData['status'] = \Engine4\Entity\Engine4Users::STATUS_ACTIVE;
                $userDbData['creation_date'] = $date->format('Y-m-d H:i:s');
                $userDbData['rol_id'] = AuthRoles::ROL_ESTUDIANTE;
                $userDbData['level_id'] = \Engine4\Entity\Engine4Users::LEVEL_DEFAULT;                                          
                $userId = $this->getUsersService()->register($userDbData);

                if (!empty($userData['last_name'])) {
                    $userDbData['lastname'] = $userData['last_name'];
                }

                $this->getFieldsValuesService()->register($userDbData, $userId);
            }                                                                                              
        } else {            
            $userDbData = (array) $userDbData;            
            $userDbData['facebook_token'] = $token;
            $this->getUsersService()->update($userDbData, array('user_id' => $userDbData['user_id']));
        }
               
        $authService = $this->_getAuthenticationService();
        $authService->setCredentialColumns('external_id', 'facebook_token');
        $authService->authenticate($userDbData, AuthenticationService::ENCRYPTION_NO);
    }
    
    /**     
     * @return Engine4UserFieldsValues
     */
    public function getFieldsValuesService()
    {
        return $this->getServiceLocator()->get('Model\Engine4UserFieldsValues');
    }
    
    /**
     * @return Engine4Users
     */
    public function getUsersService() 
    {
        return $this->_sl->get('Model\Engine4Users');
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

    public function getLoginUrl($params = array()) 
    {
        $config = $this->_sl->get('config');
        $facebookConfig = $config['authentication']['facebook'];
        $redirectUrl = '';
        if ($params['redirect']) {
            $redirectUrl = '?redirect=' . $params['redirect'];
        }
        
        $params = array(
            'redirect_uri' => $facebookConfig['redirect_uri'] . $redirectUrl,
            'scope' => $facebookConfig['scope']
        );

        return parent::getLoginUrl($params);
    }    
}