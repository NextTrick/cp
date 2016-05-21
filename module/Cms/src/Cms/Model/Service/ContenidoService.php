<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Cms\Model\Service;

class ContenidoService
{
    protected $_repository = null;
    protected $_sl         = null;
    
    const TIPO_PAGINA         = 1;
    const TIPO_SECCION        = 2;
    const TIPO_NAME_PAGINA  = 'página';
    const TIPO_NAME_SECCION = 'sección';
    
    const SECCION_LOGIN_INICIO_SESION = 'LOGIN_INICIO_SESION';


    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
    }

    public function getContenido($codigo)
    {
        $criteria = array('where' => array('codigo' => $codigo));
        $row = $this->_repository->findOne($criteria);
        if (isset($row['contenido'])) {
            return $row['contenido'];
        }
        return null;
    }

    public function getRepository()
    {
        return $this->_repository;
    }
    
    public function getTipos()
    {
        return array(
            self::TIPO_PAGINA  => 'Página',
            self::TIPO_SECCION => 'Sección',
        );
    }

    public static function getNameTipo($tipoPagina)
    {
        $result = self::TIPO_NAME_SECCION;
        
        if (!empty($tipoPagina) && self::TIPO_PAGINA == $tipoPagina) {
            return self::TIPO_NAME_PAGINA;
        }
        
        return $result;
    }


    public static function getAllTipos()
    {
        return array(
            'tipoPagina'        => self::TIPO_PAGINA,
            'tipoSeccion'       => self::TIPO_SECCION,
            'nombreTipoPagina'  => ucfirst(self::TIPO_NAME_PAGINA),
            'nombreTipoSeccion' => ucfirst(self::TIPO_NAME_SECCION),
        );
    }

    /**
     * Retorna un array que se utilizar en la busqueda
     * @return array
     * @author Diómedes Pablo A. <diomedex10@gmail.com>
     */
    public function getFiltrosBuscar()
    {
        return array(
            'codigo'    => 'Código',
            'titulo'    => 'Título',
        );
    }
}