<?php
namespace Maude;

class AbstractTableIterator extends DatabaseInsertIterator, \Iterator {

  public function next() : void
  {
      return;
  }    
   
  public function valid() : bool
  {
     return true;
  }

  public function rewind() : bool
  {
     return true; 
  }    
  
  abstract public function current() : \PDOStatement;
  
  abstract public function key() : int;

  public function insert(\Ds\Vector $vec) : void;

}
