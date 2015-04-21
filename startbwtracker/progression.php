<?php
/* */

class ProgressionModel {
    /* Simple Progression object model */
    private $id;
    private $type;
    private $name;
    private $position;
    private $description;
    private $goal;
    private $media;
 
    function __construct($id, $type, $name, $position, $description=NULL,
        $goal=888, $media=NULL) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->position = $position;
        $this->description = $description;
        $this->goal = $goal;
        $this->media = $media;
    }

    function __tostring() {
        return $this->id . ' ' . $this->type . ' ' . $this->name . ' ' .
            $this->position . "\n";
    }

    public function __get($name)
    {
        echo "Getting '$name'\n";
        $progressionProperties = get_object_vars($this);
        if (array_key_exists($name, $progressionProperties)) {
            return $this->$name;
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
    
    public function __set($name, $value)
    {
        $progressionProperties = get_object_vars($this);
        if (array_key_exists($name, $progressionProperties)) {
            echo "Setting '$name' to '$value'\n";
            $this->$name = $value;
        }
        else {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property in object vars: ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);
            return null;
        }
    }

    public function getvalues(){
        $values = array_values(get_object_vars($this));
        return $values;
    }
}
