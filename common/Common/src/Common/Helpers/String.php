<?php 
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Octubre 2015
 * Descripción :
 * 
 */

namespace Common\Helpers;

class String
{
    public static function xssClean($params)
    {
        if (is_array($params)) {
            foreach ($params as $key => $param) {
                $params[$key] = strip_tags($param);
            }
        } else {
            $params = strip_tags($params);
        }
        
        return $params;
    }

    public static function parseSlugName($name)
    {
        $name = self::clearText(self::removeSpecialText($name));
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($name));
        return $slug;
    }

    public static function clearText($string) {
        $string = trim($string);
        $string = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
        $string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
        $string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
        $string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
        $string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
        $string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string);
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
                array("\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "·", "$", "%", "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "< ", ";", ",", ":",
            "."), '', $string
        );

        return $string;
    }
    
    public static function removeSpecialText($string)
    {
        if (!empty($string)) {
            //reject overly long 2 byte sequences, as well as characters above U+10000 and replace with ?
            $string = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]' .
                    '|[\x00-\x7F][\x80-\xBF]+' .
                    '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*' .
                    '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})' .
                    '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S', '?', $string);

            //reject overly long 3 byte sequences and UTF-16 surrogates and replace with ?
            $string = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]' .
                    '|\xED[\xA0-\xBF][\x80-\xBF]/S', '?', $string);

            // Remove all none utf-8 symbols
            $string = htmlspecialchars_decode(htmlspecialchars($string, ENT_IGNORE, 'UTF-8'));        
            // remove non-breaking spaces and other non-standart spaces
            $string = preg_replace('~\s+~u', ' ', $string);        
            // replace controls symbols with "?"
            $string = preg_replace('~\p{C}+~u', '?', $string);
        }        
        
        return trim($string);
    }
}