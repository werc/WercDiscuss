<?php
namespace WercDiscuss\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Discuss extends Form
{

    function __construct()
    {
        parent::__construct();
        
        $csrf = new Element\Csrf('csrf');
        $this->add($csrf);
        
        $messageId = new Element\Hidden('message_id');
        $messageId->setAttribute('id', 'messageid');
        $this->add($messageId);

        $articleId = new Element\Hidden('article_id');
        $this->add($articleId);
        
        $name = new Element\Text('author_name');
        $name->setAttributes(array(
                'required' => 'required',
                'class' => 'form-control'
        ));
        $this->add($name);
        
        $email = new Element\Email('email');
        $email->setAttributes(array(
            'required' => 'required',
            'class' => 'form-control'
        ));
        $this->add($email);
        
        $message = new Element\Textarea('message');
        $message->setAttributes(array('class'=> 'form-control', 'rows' => 5));
        $this->add($message);
        
        $button = new Element\Button('save');
        $button->setAttributes(array(
            'type' => 'submit',
            'class' => 'btn btn-important active'
        ));
        $this->add($button);
    }
}