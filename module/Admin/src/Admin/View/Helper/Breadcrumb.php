<?php

/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Breadcrumb extends AbstractHelper implements ServiceLocatorAwareInterface
{
    protected $_iconBreadcrumb = 'fa fa-table';

    public function __invoke($layout)
    {
        $html = null;
        if (isset($layout->title)) {
            $html .= '<h1>';
            if (is_array($layout->title)) {
                foreach ($layout->title as $key => $title) {
                    if ($key == 0) {
                        $html .= ' ' . $title;
                    } else {
                        $html .= ' <small>' . $title . '</small>';
                    }
                }
            } else {
                $html .= ' ' . $layout->title;
            }
            $html .= '</h1> ';
        }
        
        if (isset($layout->breadcrumb)) {
            $html .= '<ol class="breadcrumb">';
            if (isset($layout->breadcrumb)) {
                $lastKey = count($layout->breadcrumb) - 1;
                foreach ($layout->breadcrumb as $key => $breadcrumb) {
                    $url = isset($breadcrumb['url']) ? $breadcrumb['url'] : null;
                    $text = ($key == 0) ? '<i class="' . $this->_iconBreadcrumb. '"></i> ' : null;
                    $text .= $breadcrumb['name'];

                    if (!empty($url)) {
                        $html .= '<li><a href="' . $url . '"> ' . $text . '</a></li>';
                    } else {
                        if ($lastKey == $key) {
                            $html .= '<li class="active"> ' . $text . '</li>';
                        } else {
                            $html .= '<li><a> ' . $text . '</a></li>';
                        }
                    }
                }
            } else {
                $html .= '<li class="active">' . $layout->breadcrumb . '</li>';
            }
            $html .= '</ol>';
        }
 
        return $html;
    }

    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
        return $this;
    }
}