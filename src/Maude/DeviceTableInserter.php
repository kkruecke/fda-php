<?php
namespace Maude;

class DeviceTableInserter implements AbstractMaudeLasikIterator, \Iterator {

  private $pdo;
  private $insert_stmt;
  private $mdr_report_key;
  private $device_product_code;

  private $rc;

  public function __construct(\PDO $pdo_in) 
  {
      parent::__construct($pdo_in); // <-- needed? 

       $this->pdo = $pdo_in;

       $this->pdo->setExceptions(      );

      // SQL statement with named placeholders 
      $this->insert_stmt = $this->pdo->prepare("INSERT INTO foi_device(mdr_report_key, device_product_code) values
	      (:mdr_report_key, :device_product_code )");

      // bind the parameters in each statement
      $this->insert_stmt->bindParam(':mdr_report_key', $this->mdr_report_key, \PDO::PARAM_INT);
        
      $this->insert_stmt->bindParam(':device_product_code', $this->device_product_code, \PDO::PARAM_STR);

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


  public function insert(\Ds\Vector $vec) : void
  {
       $this->mdr_report_key = $vec[0];
       $this->device_product_code = $vec[1];

       $rc = $this->insert_stmt->execute();
  }


  public function insert(\Ds\Vector $vec) : void;

}
