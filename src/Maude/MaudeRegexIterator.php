<?php
namespace Maude;
use \RegexIterator;

class MaudeRegexIterator extends \RegexIterator {

    private $vector; 
    private $indecies;

    public function __construct(SplFileObjectExtended $spl_file_object_ex, \Ds\Vector $indecies)
    {
        parent::__construct($spl_file_object_ex,  '/([^|]*)\||\1$/', RegexIterator::ALL_MATCHES);

        $this->vector = new \Ds\Vector;  

        $this->vector->allocate(\count($indecies));

        $this->indecies = $indecies;
    } 

    public function current() : \Ds\Vector
    {
      $a = parent::current();

      $i = 0; 

      foreach ($this->indecies as $indx) {

          $this->vector[$i++] = $a[$indx];
      }

      return $this->vector;
    }
}
