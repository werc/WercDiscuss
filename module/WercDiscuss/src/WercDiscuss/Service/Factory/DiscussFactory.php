<?php
namespace WercDiscuss\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercDiscuss\Service\Discuss;

class DiscussFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Discuss();
        $service->setDiscussModel($serviceLocator->get('discuss_table'));
        $service->setDiscussMessages($serviceLocator->get('discuss_messages_table'));
        $service->setDiscussForm($serviceLocator->get('discuss_form'));
        
        return $service;
    }
}
