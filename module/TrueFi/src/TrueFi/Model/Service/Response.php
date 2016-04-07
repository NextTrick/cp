<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace TrueFi\Model\Service;

class Response
{
    public static function curl($url, $config, $jsonData)
    {
        $token = sha1($jsonData . $config->password);
        $client = new \Zend\Http\Client(null, array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => array(
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 60,
            ),
        ));

        $client->setUri($url);
        $client->setMethod('POST');
        $client->setParameterPost(array(
            'Token' => $token,
            'Data' => $jsonData,
        ));
        
        $responseData = array(
            'success' => false,
        );
        try {
            $responseHttp = $client->send();
            if ($responseHttp->isSuccess()) {
                $data = json_decode($responseHttp->getBody());
                $responseData['success'] = true;
                $responseData['data'] = $data;
            } else {
                $responseData['code'] = $responseHttp->getStatusCode();
                $responseData['message'] = $responseHttp->getReasonPhrase();
            }
        } catch (\Exception $e) {
            $responseData['code'] = $e->getCode();
            $responseData['message'] = $e->getMessage();
        }
        return $responseData;
    }
}