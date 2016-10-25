<?php
namespace Maude;
use \RegexIterator;

class MaudeRegexIterator extends \RegexIterator {

    private $vector;   // of string values
    private $indecies;

    public function __construct(SplFileObjectExtended $spl_file_object_ex, \Ds\Vector $indecies)
    {
        parent::__construct($spl_file_object_ex,  '/([^|]*)\||\1$/', RegexIterator::ALL_MATCHES);

        $this->vector = new \Ds\Vector;  
        
        $cnt = \count($indecies);

        $this->vector->allocate($cnt);

        $this->indecies = $indecies;
    } 

    public function current() : \Ds\Vector
    {
      $array = parent::current();
      
      $i = 0; 

      foreach ($this->indecies as $index) {
                   
          $this->vector->push( $array[1][$index] );
      }

      return $this->vector;
    }
}
