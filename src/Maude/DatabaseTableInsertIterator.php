<?php
namespace Maude;
use \Iterator;

interface DatabaseTableInsertIterator extends \Iterator { 

  public function next();
     
  public function valid() : bool;
  
  public function rewind();
  
  public function current() : \PDOStatement;
  
  public function key() : int;

  public function insert(\Ds\Vector $vec) : bool;
}
