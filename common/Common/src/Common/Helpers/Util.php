<?php
namespace Common\Helpers;

class Util
{
    const VI_ENCODEID = 'a1b3c5d7';
    
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
    
    public static function formatoMisTarjeas($rows)
    {
        foreach ($rows as $key => $row) {
            $row['show'] = 'lleno';
            $row['codigo'] = Crypto::encrypt($row['id'], self::VI_ENCODEID);
            $rows[$key] = $row;
        }
        
        $filas = 2;
        $columnas = 3;
        $totalRows = count($rows);
        if (!empty($rows)) {
            $filas1 = (int)($totalRows/$columnas);
            if ((float)($totalRows/$columnas) > (int)($totalRows/$columnas)) {
                $filas1 = (int)($totalRows/$columnas) + 1;
            }
            $filas = ($filas1 > $filas) ? $filas1 : $filas; 
        }
        $totalViews = $filas * $columnas; //total a mostrar en html
        
        $diferencia = $totalViews - $totalRows;
        if ($diferencia > 0) {
            $rows[] = array('show' => 'por_llenar');
            $diferencia = $diferencia - 1;
        }
        
        if ($diferencia > 0) {
            for ($i = 0; $i < $diferencia; $i++) {
                $rows[] = array('show' => 'vacio');
            }
        }
        
        return $rows;
    }
    
    public static function formatoRecargas($rows)
    {
        foreach ($rows as $key => $row) {
            $row['show'] = 'lleno';
            $rows[$key] = $row;
        }
        
        $filas = 1;
        $columnas = 3;
        $totalRows = count($rows);
        if (!empty($rows)) {
            $filas1 = (int)($totalRows/$columnas);
            if ((float)($totalRows/$columnas) > (int)($totalRows/$columnas)) {
                $filas1 = (int)($totalRows/$columnas) + 1;
            }
            $filas = ($filas1 > $filas) ? $filas1 : $filas;
        }
        $totalViews = $filas * $columnas; //total a mostrar en html
        
        $diferencia = $totalViews - $totalRows;

        if ($diferencia > 0) {
            for ($i = 0; $i < $diferencia; $i++) {
                $rows[] = array('show' => 'vacio');
            }
        }
        
        return $rows;
    }
    
    public static function formatSumaDecimal(array $data) {
        $suma = 0;
        foreach ($data as $value) {
            $suma = $suma + (float)$value;
        }

        return self::formatDecimal($suma);
    }
    
    public static function formatDecimal($number) 
    {
        return number_format($number, 2, '.', ',');
    }
    
    public static function noEmptyDecimal($number) 
    {
        $number = (float)$number;
        if (!empty($number)) {
            return true;
        }
        return false;
    }
}
