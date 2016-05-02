<?php
namespace Common\Helpers;

class Util
{
    public static function getIpClient()
    {
        $ipKeys = array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED', 
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        );
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = trim($ip);
                    // attempt to validate IP
                    if (self::validateIp($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    public static function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | 
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }
    
    public static function passwordHash($password)
    {
        return hash('sha256', hash('sha512', $password));
    }
    
    public static function passwordEncrypt($password, $email)
    {
        return Crypto::encrypt($password, $email);
    }
    
    public static function generateToken($data)
    {
        return hash('sha256', hash('sha512', $data . microtime()));
    }
    
    public static function arrayChangeKeyCaseRecursive(array $data, $case = null) {
        $case = empty($case) ? CASE_LOWER : $case;
        $data = array_change_key_case($data, $case);
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $data[$key] = self::arrayChangeKeyCaseRecursive($val, $case);
            }
        }
        return $data;
    }
    
    public static function checkDate($month, $day, $year)
    {
        if (is_numeric($month) && is_numeric($day) && !(is_numeric($year))) {
            return false;
        }
        
        if (checkdate((int)$month, (int)$day, (int)$year)) {
            return true;
        }
        
        return false;
    }
}
