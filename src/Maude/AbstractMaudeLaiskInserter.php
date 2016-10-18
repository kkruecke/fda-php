<?php
namespace Maude;

/*
 * Work further on design. This started as a Template Method pattern.
 */

class AbstractMaudeLasikInserter extends AbstractTableInserter {

  private $pdo;
  private \PDOStatement $stmt;

  protected function bindParameters(\PDOStatement $stmt) : void;   // not implemented

  protected function assignParameters(\Ds\Vector $vec) : void;     // not implemented

  public function __construct(\PDO $pdo_in, string $insert_str) 
  {
       $this->pdo = $pdo_in;

       $this->pdo->setExceptions(???);

       $this->stmt = $this->pdo->prepare($insert_str); 

       // template method pattern
       bindParameters($this->stmt);
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

   // template method pattern
  public function insert(\Ds\Vector $vec) : void
  {
       assignParameters($vec);       
    
       $thi->stmt->execute();
  }
}
?>
