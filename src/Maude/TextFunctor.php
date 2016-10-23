<?php
namespace Maude;

class TextTableFilterIterator  implements Functor {

     use ExistsInDeviceTableTrait;

     public function __construct(\PDO $pdo, \Iterator $iter)
     {
          parent::__construct($iter);

          construct($pdo);
     }

     protected function __invoke(int $mdr_report_key) : bool
     {
         return is_new_record($mdr_report_key); 
     }
}
