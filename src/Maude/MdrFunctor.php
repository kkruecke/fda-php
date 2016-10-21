<?php
namespace Maude;

require_once("stdlib/algorithms.php");

class DeviceFunctor extends Functor {

     use ExistsInDeviceTableTrait;

     public function __construct(\PDO $pdo, \Iterator $iter)
     {
          parent::__construct($iter);

          do_construct($pdo);
     }

     protected function is_new_record(\Ds\Vector $vec) : bool
     {
         return do_is_new_record($vec); 
     }
}
