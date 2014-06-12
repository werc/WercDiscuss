<?php
namespace WercDiscuss\Form;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Filter\FilterChain;

class DiscussFilter extends InputFilter
{
    public function __construct()
    {
        $filterChain = new FilterChain();
        $filterChain->attachByName('StripTags')->attachByName('StringTrim');
        
        $name = new Input('author_name');
        $name->setFilterChain($filterChain);
        $name->setErrorMessage('Pole nesmí být prázdné.');
        $this->add($name);
        
        $email = new Input('email');
        $email->setFilterChain($filterChain);
        $email->getValidatorChain()->attach(new \Zend\Validator\EmailAddress());
        $this->add($email);
        
        $message = new Input('message');
        $message->setErrorMessage('Pole nesmí být prázdné.');
        $this->add($message);
    }
}
