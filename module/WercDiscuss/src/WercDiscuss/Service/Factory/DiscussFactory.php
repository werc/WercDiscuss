<?php
namespace WercDiscuss\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercDiscuss\Service\Discuss;

class DiscussFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $formDiscuss = $serviceLocator->get('FormElementManager')->get('WercDiscuss\Form\Discuss');
        
        $service = new Discuss();
        $service->setDiscussModel($serviceLocator->get('WercDiscuss\Model\DiscussTable'));
        $service->setDiscussMessages($serviceLocator->get('WercDiscuss\Model\DiscussMessagesTable'));
        $service->setDiscussForm($formDiscuss);
        
        return $service;
    }
}
