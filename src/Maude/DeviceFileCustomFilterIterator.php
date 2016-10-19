<?php

namespace Maude;

class DeviceFileCustomFilterIterator implements \Iterator {

    private $spl_file_object_extended; 
                                 
    private $filter_iterator; 
                                 
    private $regexIter;
  
    private $current;
  
  
    public function __construct(\PDO $pdo, string $file_name)
    {
    $this->spl_file_object_extended =  new SplFileObjectExtended($file['name']);
    
    $this->filter_iterator = new DeviceTableFilterIterator($pdo, $this->spl_file_object_extended); 
    
    $this->regexIter = RegexIterator($iter, "[^|]*(\||$)" , RegexIterator::ALL_MATCHES)
    }    

    public function current() : \Ds\Vector
    { 
      $matches = $this->regexIter->current();

      $vec->push(???);
      $vec->push(???);

      $this->current = $vec;
    }

    //...add other \Iterator methods

}
    
