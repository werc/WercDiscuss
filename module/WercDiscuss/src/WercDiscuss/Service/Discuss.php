<?php
namespace WercDiscuss\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use WercDiscuss\Model\DiscussTable as DiscussTable;
use WercDiscuss\Form\Discuss as DiscussForm;
use WercDiscuss\Model\DiscussMessagesTable;
use WercDiscuss\Entity\DiscussMessages as DiscussMessagesEntity;

class Discuss implements ServiceManagerAwareInterface
{

    protected $discussModel;

    protected $discussForm;

    protected $discussMessages;

    public function setDiscussModel(DiscussTable $model)
    {
        $this->discussModel = $model;
    }

    public function getDiscussModel()
    {
        return $this->discussModel;
    }

    public function setDiscussForm(DiscussForm $form)
    {
        $this->discussForm = $form;
    }

    public function getDiscussForm()
    {
        return $this->discussForm;       
    }

    public function setDiscussMessages(DiscussMessagesTable $model)
    {
        $this->discussMessages = $model;
    }

    public function getDiscussMessages()
    {
        return $this->discussMessages;
    }

    /**
     *
     * @return boolean
     */
    public function addComment($post)
    {
        $form = $this->getDiscussForm();
        $form->setData($post);
        
        if (! $form->isValid()) {
            return false;
        }
        
        $postData = $form->getData();
        $primary = $this->getDiscussModel()->insert($postData);
        
        $entity = new DiscussMessagesEntity();
        $entity->exchangeArray(array_merge($postData, array(
            $entity->getPrimary() => $primary
        )));
        $result = $this->getDiscussMessages()->save($entity);
        
        $form->setData(array(
            'message' => ''
        ));
        
        return $result;
    }

    public function fetchDiscussMessages($articleId)
    {
        $result = $this->getDiscussMessages()->fetchMessages($articleId);
        return $result;
    }

    /**
     * @param array $post
     */
    public function deleteComment($post)
    {
        $result = $this->getDiscussModel()->deleteComment($post);
        return $result;
    }

    /**
     * @param array $post            
     */
    public function updateComment($post)
    {
        $form = $this->getDiscussForm();
        $form->remove('csrf');
        $form->setData($post);
        
        if (! $form->isValid()) {
            return false;
        }
        
        $postData = $form->getData();
        $entity = new DiscussMessagesEntity();
        $entity->exchangeArray($postData);
        $result = $this->getDiscussMessages()->save($entity);
        
        return $result;
    }

    /**
     *
     * @param int $articleId            
     * @return ResultSet
     */
    public function getCommentsTree($articleId)
    {
        $resultSet = $this->getDiscussModel()->fetchAll($articleId);
        return $resultSet;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $locator            
     * @return Discuss
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
