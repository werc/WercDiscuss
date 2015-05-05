<?php
namespace WercDiscuss\View\Helper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercDiscuss\View\Helper\DiscussWidget;

class DiscussWidgetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $helpers)
    {
        $services = $helpers->getServiceLocator();
        return new DiscussWidget($services->get('WercDiscuss\Service\Discuss'));
    }
}
