<?php
namespace WercDiscuss\Entity;

class DiscussMessages
{

    public $message_id;

    public $post_time;

    public $email;

    public $author_name;

    public $message;

    public function getPrimary()
    {
        return 'message_id';
    }

    public function exchangeArray($data)
    {
        $this->message_id = (! empty($data['message_id'])) ? (int) $data['message_id'] : null;
        $this->post_time = (! empty($data['post_time'])) ? $data['post_time'] : new \Zend\Db\Sql\Expression('NOW()');
        $this->email = (! empty($data['email'])) ? $data['email'] : null;
        $this->author_name = (! empty($data['author_name'])) ? $data['author_name'] : null;
        $this->message = (! empty($data['message'])) ? $data['message'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * not null values
     *
     * @return array
     */
    public function getArrayPostValues()
    {
        $return = array();
        $_array = $this->getArrayCopy();
        foreach ($_array as $name => $val) {
            if (null !== $val) {
                $return[$name] = $val;
            }
        }
        
        return $return;
    }
}
