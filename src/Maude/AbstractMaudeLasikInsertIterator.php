<?php
namespace Maude;
use \PDOStatement, \Iterator;

/*
 * Database insert iterator 
 */

abstract class AbstractMaudeLasikInsertIterator implements DatabaseTableInsertIterator {

  private $pdo;
  private $stmt;
  private $valid;
  private $lines_inserted;

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
       $this->lines_inserted = 0;
  }

  public function getInsertCount() : int
  {
       return $this->lines_inserted;
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
     //TODO: Override in the devied class and call this parent method: parent::valide(). In derive clas, if parent::valid() is false, log the result to a file.
      return $this->valid; // This is the result of $this->stmt->execute()
  }
  
  public function rewind() 
  {
      return;
  }

  /* 
   * write() is a "template method" pattern that invokes assignParameters(), which derived classes must override to assign the parameters for the 
   * prepared statement. 
   */
  public function write(\Ds\Vector $vec) : bool
  {
       $this->assignParameters($vec);       
    
       $this->valid = $this->stmt->execute();

       if ($this->valid) {

          $this->lines_inserted++;
       } 
       
       return $this->valid;
  }
}
?>
