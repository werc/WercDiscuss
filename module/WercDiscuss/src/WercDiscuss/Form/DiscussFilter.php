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
        $this->add($name);
        
        $email = new Input('email');
        $email->setFilterChain($filterChain);
        $email->getValidatorChain()->attach(new \Zend\Validator\EmailAddress(array(
            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
            'useMxCheck' => true
        )));
        $this->add($email);
        
        $message = new Input('message');
        $message->setFilterChain($filterChain);
        $this->add($message);
        
        $antispam = new Input('antispam');
        $antispam->getValidatorChain()->attach(new \Zend\Validator\Identical('wdiscuss'));
        $this->add($antispam);
    }
}
