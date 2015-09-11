<?php

// module/BlogEntries/config/module.config.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'BlogEntries\Controller\BlogEntries' => 'BlogEntries\Controller\BlogEntriesController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'blogentries' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/blogentries[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BlogEntries\Controller\BlogEntries',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'blogentries' => __DIR__ . '/../view',
        ),
    ),
);
