<?php

class X {

  static $instance; // X
  private $i;

 public function __construct(int $in)
 {
     $i = $in;
 }

 static public function create() : X
 {
    if (!isset(self::$instance)) {
        self::$instance = new X(4);
    }

    return self::$instance;
 }

 public function get_i() : int
 {
     return $this->$i;
 }
}

$the_x = X::create();

echo "The value of \$the_x->get_i() is ". $the_x->get_i() . "\n";
