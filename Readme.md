# WercDiscuss
WercDiscuss is a ZF2 module for inserting comments under article. Comments are displayed in a tree structure based on tree traversal.
Tree traversing is solved by mysql stored procedure. HTML and CSS uses [Bootstrap 3](http://getbootstrap.com/).


## Display comments and form
Just put view helper into .phtml view file:
```php
echo $this->discusswidget($articleId, $discussFormAction);
//$articleId = ID of article, $discussFormAction = URL of form action - comment insert 
```

## Insert comment
In controller action:
``` php
// discuss
$prg = $this->prg();
if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
    return $prg;
} elseif (is_array($prg)) {
    $return = $this->getDiscussService()->addComment($prg);
    if (! $return) {
        $this->flashMessenger()->addErrorMessage('Your comment was submitted.');
    } else {
        $this->flashMessenger()->addInfoMessage('Your comment was not submitted.');
    }
}
```
Note the `$this->getDiscussService()` calls **discuss_service** in controller. 
Use controller factory or just call `$this->getServiceLocator()->get('discuss_service');`.

## Delete, update comment
Methods for comment update or delete are ready in `WercDiscuss\Service\Discuss.php`. 
Just call them in admin section (of your CMS) for comment editing.
