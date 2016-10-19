<?php
namespace Maude;

class TextTableFilterIterator  implements \FilterIterator {

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
