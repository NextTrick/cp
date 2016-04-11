<?php

namespace Common\Helpers;

class Crypto
{
    const ENCRYPTION_METHOD = 'AES-256-CTR';
    const SECRET_KEY = "Trs4238DAkdls63tPOdsdg724Pr7645";
    
    public static function encrypt($textToEncrypt, $iv)//$iv must be 16 bytes long
    {
        $iv = self::hextobin(md5(hash('sha256', trim($iv))));
        return openssl_encrypt($textToEncrypt, self::ENCRYPTION_METHOD,
                self::SECRET_KEY, 0, $iv);
    }
    
    public static function decrypt($textToDecrypt, $iv)//$iv must be 16 bytes long
    {
        $iv = self::hextobin(md5(hash('sha256', trim($iv))));
        return openssl_decrypt($textToDecrypt, self::ENCRYPTION_METHOD,
                self::SECRET_KEY, 0, $iv);
    }

    public static function hextobin($hexstr) 
    { 
        $n = strlen($hexstr); 
        $sbin="";   
        $i=0; 
        while($i<$n) 
        {       
            $a =substr($hexstr,$i,2);           
            $c = pack("H*",$a); 
            if ($i==0){$sbin=$c;} 
            else {$sbin.=$c;} 
            $i+=2; 
        } 
        return $sbin; 
    }
}
