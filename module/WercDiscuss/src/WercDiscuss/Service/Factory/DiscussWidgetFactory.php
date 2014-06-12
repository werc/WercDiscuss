<?php
namespace WercDiscuss\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercDiscuss\View\Helper\DiscussWidget;

class DiscussWidgetFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $helpers)
    {
        $services = $helpers->getServiceLocator();
        $helper = new DiscussWidget($services->get('discuss_service'));
    
        return $helper;
    }
}
