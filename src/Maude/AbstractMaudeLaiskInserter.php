<?php
namespace Maude;

/*
 * Database insert iterator 
 */

class AbstractMaudeLasikInserter extends AbstractTableInserter, implements \Iterator {

  private $pdo;
  private \PDOStatement $stmt;
  private $rc;

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
       $this->rc = true;

       $this->pdo = $pdo_in;

       $this->stmt = $this->pdo->prepare($insert_str); 

       // template method pattern
       bindParameters($this->stmt);
  }
  
  public function current() : \PDOStatement
  {
    return $this->stmt;   
  }    
    
  public function key() : int
  {
         
  }

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
