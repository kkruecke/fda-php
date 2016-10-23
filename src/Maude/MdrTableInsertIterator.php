<?php
namespace Maude;
use Iterator;

class MdrTableInsertIterator implements AbstractMaudeLasikIterator, \Iterator {

   private  $device_product_code;
   private  $device_key;

   public function __construct(\PDO $pdo)
   {
       parent::__construct($pdo, "INSERT INTO foi_device(mdr_report_key, device_product_code) values
	      (:mdr_report_key, :device_product_code )");
   }

   public function bindParameters()
   {
      // bind the parameters in each statement
      $this->insert_stmt->bindParam(':mdr_report_key', $this->mdr_report_key, \PDO::PARAM_INT);
        
      $this->insert_stmt->bindParam(':device_product_code', $this->device_product_code, \PDO::PARAM_STR);
   }

  protected function assignParameters(\Ds\Vector $vec) 
  {
    $this->mdr_report_key = $vec[0];
    $this->device_product_cod e= $vec[1];
  }

  public function insert(\Ds\Vector $vec) {} 

}
?>
