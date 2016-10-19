<?php
namespace Maude;

/*
 * Work further on design. This started as a Template Method pattern.
 */

class AbstractMaudeLasikInserter extends AbstractTableInserter {

  private $pdo;
  private \PDOStatement $stmt;

  abstract protected function bindParameters(\PDOStatement $stmt) : void;   // not implemented

  abstract protected function assignParameters(\Ds\Vector $vec) : void;     // not implemented

  /*
   * The ctor is a "template method" pattern that invokes the bindParameters, which derived classes must override
   * input: 
   * 1. PDO object
   * 2. SQL insertion string text
   * 
   */

  public function __construct(\PDO $pdo_in, string $insert_sql_str) 
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

  /* 
   * insert() is a "template method" pattern that invokes the assignParameters, which derived classes must override to assign the parameters for the 
   * prepared statement. 
   */
  public function insert(\Ds\Vector $vec) : void
  {
       assignParameters($vec);       
    
       $rc = $this->stmt->execute();
  }
}
?>
