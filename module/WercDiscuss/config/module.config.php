<?php
namespace WercDiscuss;

return array(
    'service_manager' => array(
        'factories' => array(
            'WercDiscuss\Service\Discuss' => 'WercDiscuss\Service\Factory\DiscussFactory',
            'WercDiscuss\Model\DiscussTable' => 'WercDiscuss\Service\Factory\DiscussTableFactory',
            'WercDiscuss\Model\DiscussMessagesTable' => 'WercDiscuss\Service\Factory\DiscussMessagesFactory'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'discusswidget' => 'WercDiscuss\View\Helper\Factory\DiscussWidgetFactory'
        )
    ),
    'view_manager' => array(
        'template_map' => include __DIR__ . '/../template_map.php',
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);
