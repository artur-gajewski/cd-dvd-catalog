<?php

namespace Dvd;

return array(
    'controllers' => array(
        'invokables' => array(
            'Dvd\Controller\Dvd' => 'Dvd\Controller\DvdController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'dvd' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dvd[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Dvd\Controller\Dvd',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'dvd' => __DIR__ . '/../view',
        ),
    ),
    
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);