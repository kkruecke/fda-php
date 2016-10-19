<?php
namespace Maude;

class TextTableFilterIterator  implements AbstractMaudeLasikIterator, \Iterator {

     use ExistsInDeviceTableTrait;

     public function __construct(\PDO $pdo)
     {
          do_construct($pdo);
     }

     protected function is_new_record(\Ds\Vector $vec) : bool
     {
         return do_is_new_record($vec); 
     }
}
