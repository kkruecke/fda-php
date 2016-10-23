<?php
namespace Maude;

/*
 * Database insert iterator 
 */

class AbstractMaudeLasikInserter extends AbstractTableInserter {

  private $pdo;
  private \PDOStatement $stmt;
  private $rc;

  abstract protected function bindParameters(\PDOStatement $stmt);   // not implemented

  abstract protected function assignParameters(\Ds\Vector $vec);     // not implemented

  /*
   * The ctor is a "template method" pattern that invokes the bindParameters, which derived classes must override
   * input: 
   * 1. PDO object
   * 2. SQL insertion string text
   * 
   */

  public function __construct(\PDO $pdo_in, string $insert_sql_str) 
  {
       $this->rc = true;

       $this->pdo = $pdo_in;

       $this->stmt = $this->pdo->prepare($insert_str); 

       // template method pattern
       bindParameters($this->stmt);
  }

  public function next() 
  {
  }
   
  public function valid() : bool
  {
     return $rc;
  }

  public function rewind() : bool
  {
     return true;
  } 
  
  abstract public function current() : \PDOStatement; // TODO: <-- What should this return?
  
  public function key() : int;

  /* 
   * insert() is a "template method" pattern that invokes the assignParameters, which derived classes must override to assign the parameters for the 
   * prepared statement. 
   */
  public function insert(\Ds\Vector $vec)
  {
       assignParameters($vec);       
    
       $rc = $this->stmt->execute();
  }
}
?>
