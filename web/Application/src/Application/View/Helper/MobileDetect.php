<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Junio 2016
 * Descripción :
 *
 */

namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;

class MobileDetect extends AbstractHelper
{
    public function __invoke()
    {
        return $this;
    }

    public function isMobile()
    {
        $detect = new \Detection\MobileDetect();
        return $detect->isMobile();
    }
    
    public function isTablet()
    {
        $detect = new \Detection\MobileDetect();
        return $detect->isTablet();
    }
    
    public function isDesktop()
    {
        $detect = new \Detection\MobileDetect();
        return !$detect->isMobile();
    }
}