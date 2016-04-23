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
    const NOMBRE_TIPO_PAGINA  = 'página';
    const NOMBRE_TIPO_SECCION = 'sección';


    public function __construct($repository, $serviceLocator)
    {
        $this->_repository = $repository;
        $this->_sl         = $serviceLocator;
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


    public static function getAllTipos()
    {
        return array(
            'tipoPagina'        => self::TIPO_PAGINA,
            'tipoSeccion'       => self::TIPO_SECCION,
            'nombreTipoPagina'  => ucfirst(self::NOMBRE_TIPO_PAGINA),
            'nombreTipoSeccion' => ucfirst(self::NOMBRE_TIPO_SECCION),
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
            'contenido' => 'Contenido',
        );
    }
}