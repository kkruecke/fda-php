<?php
class MaudeFieldExtractorIterator extends \RegexIterator {

   /*
    *   Should FilterIterator (composed with SplFileObjectExtended) instead? 
    */   
   public function __construct(\FilterIterator $input_2RegexIter, array $indicies, string $regex, RegexIterator::ALL_MATCHES)  
   {
     parent::__construct($iter, $gexex, RegexIterator::ALL_MATCHES);

     $this->$indecies;

     $this->vecot.capacity(count($indecies));
   }

   public function current() : \Ds\Vector
   {
    //TODO: Put regex results from array into \Ds\Vector

   }
   // All other methods are not overriden. They are simply the base RegexIterator methods.
}
