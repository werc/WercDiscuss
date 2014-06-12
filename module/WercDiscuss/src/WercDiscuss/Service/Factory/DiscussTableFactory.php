<?php
namespace WercDiscuss\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercDiscuss\Model\DiscussTable;

class DiscussTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        
        $table = new DiscussTable();
        $table->setDbAdapter($dbAdapter);
        
        return $table;
    }
}
