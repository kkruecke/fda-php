<?php
namespace Maude;

class TextTableFilterIterator  implements Functor {

     use ExistsInDeviceTableTrait;

     public function __construct(\PDO $pdo, \Iterator $iter)
     {
          parent::__construct($iter);

          do_construct($pdo);
     }

     protected function __invoke(\Ds\Vector $vec) : bool
     {
         return do_is_new_record($vec); 
     }
}
