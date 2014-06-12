<?php
namespace WercDiscuss\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use WercDiscuss\Entity\DiscussMessages;
use Zend\Db\TableGateway\AbstractTableGateway;

class DiscussMessagesTable
{

    private $tableGateway;

    private $primary = 'message_id';

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Messages for admin area
     * 
     * @param int $articleId
     * @return ResultSet
     */
    public function fetchMessages($articleId)
    {
        $select = $this->tableGateway->getSql()->select();
        
        $select->columns(array(
            'message_id',
            'post_time',
            'email',
            'author_name',
            'message'
        ));
        $select->join('discuss', 'discuss.message_id = discuss_messages.message_id', array(), 'left');
        $select->where(array(
            'discuss.article_id' => $articleId
        ));
        $select->order('post_time DESC');
        
        /*
         * $sql = $this->tableGateway->getSql(); $sqlString = $sql->getSqlStringForSqlObject($select);
         */
        
        $resultSet = $this->tableGateway->selectWith($select);
        
        return $resultSet;
    }

    /**
     *
     * @return int
     */
    public function save(DiscussMessages $data)
    {
        $columns = $data->getArrayPostValues($data);
        
        if (false !== $this->selectOne($data->message_id)) {
            unset($columns['post_time']);
            $effectedRows = $this->tableGateway->update($columns, array(
                $this->primary => $data->message_id
            ));
            return $effectedRows;
        } else {
            return $this->tableGateway->insert($columns);
        }
    }

    /**
     *
     * @return object
     */
    public function selectOne($primary)
    {
        $rowset = $this->tableGateway->select(array(
            $this->primary => $primary
        ));
        $row = $rowset->current();
        
        return $row;
    }
}