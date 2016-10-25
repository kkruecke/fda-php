<?php
namespace Maude;
use \PDOStatement, \Iterator;

/*
 * Database insert iterator 
 */

abstract class AbstractMaudeLasikInsertIterator /*extends AbstractTableInsertIterator */ implements DatabaseTableInsertIterator {

  private $pdo;
  private $stmt;
  private $valid;

  abstract protected function bindParameters(\PDOStatement $stmt);   // derived classes must implemented this method

  abstract protected function assignParameters(\Ds\Vector $vec);     // derived classes must implemented this method

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

       $this->stmt = $this->pdo->prepare($insert_sql_str); 

       // template method pattern
       $this->bindParameters($this->stmt);
       
       $this->valid = true;
  }
  
  public function current() : PDOStatement
  {
    return $this->stmt;   
  }    
    
  public function key() : int
  {
    return 0; // Not meaning full, so we simply return 0.      / implements /*
  }
  
  public function next() 
  {
      return;
  }    
     
  public function valid() : bool
  {
      return $this->valid; // This is the result of $this->stmt->execute()
  }
  
  public function rewind() 
  {
      return;
  }

  /* 
   * insert() is a "template method" pattern that invokes the assignParameters, which derived classes must override to assign the parameters for the 
   * prepared statement. 
   */
  public function insert(\Ds\Vector $vec) : bool
  {
       assignParameters($vec);       
    
       $this->valid = $this->stmt->execute();
       
       return $this->valid;
              
  }
}
?>
