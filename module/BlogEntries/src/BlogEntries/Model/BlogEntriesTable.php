<?php

/**
 * Description of BlogEntriesTable
 */
// module/BlogEntries/src/BlogEntries/Model/BlogEntriesTable.php

namespace BlogEntries\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class BlogEntriesTable extends AbstractTableGateway {

    protected $table = 'blogentries';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll() {
        $resultSet = $this->select(function (Select $select) {
                    $select->order('created ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Entity\BlogEntry();
            $entity->setId($row->id)
                    ->setEntry($row->entry)
                    ->setCreated($row->created);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getBlogEntry($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $blogEntry = new Entity\BlogEntry(array(
                    'id' => $row->id,
                    'entry' => $row->entry,
                    'created' => $row->created,
                ));
        return $blogEntry;
    }

    public function saveBlogEntry(Entity\BlogEntry $blogEntry) {
        $data = array(
            'entry' => $blogEntry->getEntry(),
            'created' => $blogEntry->getCreated(),
        );

        $id = (int) $blogEntry->getId();

        if ($id == 0) {
            $data['created'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getBlogEntry($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }

    public function removeBlogEntry($id) {
        return $this->delete(array('id' => (int) $id));
    }

}