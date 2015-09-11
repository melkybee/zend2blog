<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogEntry
 */
// module/BlogEntries/src/BlogEntries/Model/Entity/BlogEntry.php

namespace BlogEntries\Model\Entity;

class BlogEntry {

    protected $_id;
    protected $_entry;
    protected $_created;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getEntry() {
        return $this->_entry;
    }

    public function setEntry($entry) {
        $this->_entry = $entry;
        return $this;
    }

    public function getCreated() {
        return $this->_created;
    }

    public function setCreated($created) {
        $this->_created = $created;
        return $this;
    }

}

?>
