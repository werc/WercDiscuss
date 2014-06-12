<?php
namespace WercDiscuss\Model;

use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\Adapter;

class DiscussTable implements AdapterAwareInterface
{

    protected $adapter;

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     *
     * @param array $postData            
     * @return int
     */
    public function insert($postData)
    {
        $articleId = (int) $postData['article_id'];
        $messageId = (int) $postData['message_id'];
        
        $sql = "CALL r_discuss_traversal('insert', {$articleId}, {$messageId});";
        $result = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $row = $result->current();
        
        return (int) $row->lastInsertId;
    }

    /**
     * @param array $postData
     * @return Ambiguous
     */
    public function deleteComment($postData)
    {
        $articleId = (int) $postData['article_id'];
        $messageId = (int) $postData['message_id'];
        
        $sql = "CALL r_discuss_traversal('delete', {$articleId}, {$messageId});";
        $result = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        
        return $result;
    }

    /**
     *
     * @param int $articleId            
     * @return ResultSet
     */
    public function fetchAll($articleId)
    {
        $sql = "CALL r_discuss_tree({$articleId})";
        $result = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        /*$this->adapter->getDriver()
            ->getConnection()
            ->disconnect();*/
        
        return $result;
    }
}
