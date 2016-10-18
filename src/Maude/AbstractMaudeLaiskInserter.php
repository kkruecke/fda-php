<?php
namespace Maude;

class AbstractMaudeLasikInserter extends AbstractTableInserter {

  private $pdo;

  public function __construct(\PDO $pdo_in) 
  {
       $this->pdo = $pdo_in;

       $this->pdo->setExceptions(      );
  }

  public function next() : void 
  {

  }
   
  public function valid() : bool
  {
     return true;
  }

  public function rewind() : bool
  {

  } 
  
  public function current() : \PDOStatement;
  
  public function key() : int;


  public function insert(\Ds\Vector $vec) : void;

}
?>
