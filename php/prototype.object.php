<?php
  
  class Object {
    
    private $prototype = null;
    
    public function __construct() {
      $this->prototype = new Prototype;
    }
    
    public function __call($name, $arguments) {
      array_unshift($arguments, $this);
      return call_user_func_array($this->prototype->{$name}, $arguments);
    }
    
    public function __clone() {
      $this->prototype = clone $this->prototype;
    }
  }
 
  
  class Prototype {
    
    public function __set($name, $value) {
      $this->{$name} = $value;
    }
    
    public function __get($name) {
      return $this->{$name};
    }
    
    public function __isset($name) {
      return isset($this->{$name});
    }
    
    public function __unset($name) {
      unset($this->{$name});
    }
  }

?>