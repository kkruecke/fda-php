<?php
namespace Maude;

class AbstractTableIterator implements DatabaseInsertIterator, \Iterator {

  public function next() : void;
   
  public function valid() : bool
  {
     return true;
  }

  public function rewind() : bool
  
  public function current() : \PDOStatement;
  
  public function key() : int;


  public function insert(\Ds\Vector $vec) : void;

}
