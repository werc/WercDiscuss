<?php
namespace WercDiscuss\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use WercDiscuss\Model;

class DiscussMessagesFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \WercDiscuss\Entity\DiscussMessages());
        $tableGateway = new TableGateway('discuss_messages', $dbAdapter, null, $resultSetPrototype);
        $table = new Model\DiscussMessagesTable($tableGateway);
        
        return $table;
    }
}
