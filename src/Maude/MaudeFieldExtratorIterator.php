<?php
namespace Maude;

class MaudeFieldExtratorIterator extends \Iterator {

    $this->vector; 
    $this->indecies;
    $this->regexIter;

    public function __construct(\Maude\SplFileObjectExtended $spl_file_object_ex, array $indices)
    {
        $this->regexIter = new RegexIterator($spl_file_object_ex,  '/([^|]*)\||\1$/', RegexIterator::ALL_MATCHES);

        $this->vector = new \Ds\Vector;  

        $this->vector.capacity(count($indecies));

        $this->indecies = $indecies;
    } 

    public function current() : \Ds\Vector
    {
      $a = parent::current();

      $i = 0; 

      for ($this->indecies as $index) {

          $this->vector[i++] = $a[$index];
      }

      return $this->vector;
    }

    // TODO: Forward other member methods to $this->regexIter
}

