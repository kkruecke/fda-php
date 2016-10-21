<?php
namespace Maude;
class DeviceFunctor extends Functor {

     use ExistsinDeviceTableTrait;
     public function __construct(\PDO $pdo) 
     {
        parent::__construct($iter);
        construct($pod); // ExistsinDeviceTableTrait
     }

     protected function __invoke(int $mdr_report_key) : bool
     {
         return is_new_record($mdr_report_key);
     }

}
