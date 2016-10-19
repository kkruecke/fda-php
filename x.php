<?php
class X {
  static $instance; // x
  $i;

 public function __construct(int $in)
 {
     $x = $in;
 }

 static public function create()
 {
    if (!isset(self::$instance)) {
        self::$instance = new x(4);
    }
    return self::$instance;
 }

 public function get_x() : int  
 {
    return $this->x;
 }

}

$x = X::create();

echo $->get_x();
