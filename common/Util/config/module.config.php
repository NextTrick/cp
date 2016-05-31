<?php
namespace Util;

return array(        
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/exception',
        'template_map' => array(
            'layout/error'              => __DIR__ . '/../view/layout/error.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/exception'           => __DIR__ . '/../view/error/exception.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
