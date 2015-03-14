<?php
namespace WercDiscuss;

return array(
    'service_manager' => array(
        'invokables' => array(
            'discuss_form' => 'WercDiscuss\Form\Discuss'
        ),
        'factories' => array(
            'discuss_service' => 'WercDiscuss\Service\Factory\DiscussFactory',
            'discuss_table' => 'WercDiscuss\Service\Factory\DiscussTableFactory',
            'discuss_messages_table' => 'WercDiscuss\Service\Factory\DiscussMessagesFactory'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'discusswidget' => 'WercDiscuss\Service\Factory\DiscussWidgetFactory'
        )
    ),
    'view_manager' => array(
        'template_map' => include __DIR__ . '/../template_map.php',
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);
