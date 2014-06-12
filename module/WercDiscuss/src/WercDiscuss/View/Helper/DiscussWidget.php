<?php
namespace WercDiscuss\View\Helper;

use Zend\View\Helper\AbstractHelper;
use WercDiscuss\Service\Discuss;

class DiscussWidget extends AbstractHelper
{

    protected $service;

    public function __construct(Discuss $service)
    {
        $this->service = $service;
    }

    public function __invoke($articleId, $formAction)
    {
        return $this->getView()->render('werc-discuss/_partials/discussion', array(
            'form' => $this->service->getDiscussForm(),
            'formAction' => $formAction,
            'comments' => $this->service->getCommentsTree($articleId),
            'articleId' => $articleId,
        ));
    }
}
