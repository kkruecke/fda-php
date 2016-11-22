<?php
namespace Maude;
use \Iterator;

interface DatabaseTableWriteIterator extends \Iterator { 

  public function next();
     
  public function valid() : bool;
  
  public function rewind();
  
  public function current() : \PDOStatement;
  
  public function key() : int;

  /*
    write() is more generic. It covers all DB changes--insertion, deletion, update.
    The client needs to ensure that it doesn't do a select.
   */
  public function write(\Ds\Vector $vec) : bool;
}
