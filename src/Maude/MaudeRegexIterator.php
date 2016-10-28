<?php
namespace Maude;
use \RegexIterator;

class MaudeRegexIterator extends \RegexIterator {

    private $vector;   // of string values
    private $indecies; /* These values come from config.xml, from <indecies><index>n</index>...</indecies> section:
                           <file>
                             <indecies>
                               <index>1</index>
                               <index>...</index>
                             </indecies>
                           </file>
                        */
 

    public function __construct(SplFileObjectExtended $spl_file_object_ex, \Ds\Vector $indecies)
    {
        //parent::__construct($spl_file_object_ex, '/([^|]*)\||([^|]*)$/', RegexIterator::ALL_MATCHES); original regex, which did not find text report from foitext.txt.
        parent::__construct($spl_file_object_ex, '/(?:((?:[^|]*))(?:\||$)?)/', RegexIterator::ALL_MATCHES);

        $this->indecies = $indecies;
        
        $this->vector = new \Ds\Vector();
        
        $this->vector->allocate($indecies->count());
    } 

    public function current() : \Ds\Vector
    {
      $array = parent::current();
      
      $this->vector->clear();

      foreach ($this->indecies as $index) {
                    
         $this->vector[] = $array[1][$index]; 
      }

      return $this->vector;
    }
}
