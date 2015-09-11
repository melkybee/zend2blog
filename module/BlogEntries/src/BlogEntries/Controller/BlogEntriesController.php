<?php

/**
 * Description of BlogEntriesController
 */
// module/BlogEntries/src/BlogEntries/Controller/BlogEntriesController.php:

namespace BlogEntries\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogEntriesController extends AbstractActionController {

    protected $_blogEntriesTable;

    public function indexAction() {
        return new ViewModel(array(
                    'blogentries' => $this->getBlogEntriesTable()->fetchAll(),
                ));
    }

    public function addAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $new_entry = new \BlogEntries\Model\Entity\BlogEntry();
            if (!$entry_id = $this->getBlogEntriesTable()->saveBlogEntry($new_entry))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_entry_id' => $entry_id)));
            }
        }
        return $response;
    }

    public function removeAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post_data = $request->getPost();
            $entry_id = $post_data['id'];
            if (!$this->getBlogEntriesTable()->removeBlogEntry($entry_id))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
            }
        }
        return $response;
    }

    public function updateAction() {
        // update post
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post_data = $request->getPost();
            $entry_id = $post_data['id'];
            $entry_content = $post_data['content'];
            $blogentry = $this->getBlogEntriesTable()->getBlogEntry($entry_id);
            $blogentry->setEntry($entry_content);
            if (!$this->getBlogEntriesTable()->saveBlogEntry($blogentry))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
            }
        }
        return $response;
    }

    public function getBlogEntriesTable() {
        if (!$this->_blogEntriesTable) {
            $sm = $this->getServiceLocator();
            $this->_blogEntriesTable = $sm->get('BlogEntries\Model\BlogEntriesTable');
        }
        return $this->_blogEntriesTable;
    }

}