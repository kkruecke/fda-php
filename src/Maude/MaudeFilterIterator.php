<?php
namespace Maude;
use FilterIterator;

// MaudeFilterIterator is configured by functions derived from Functor interface 

class MaudeFilterIterator extends FilterIterator {

    private $functor; 
    use CounterTrait; 

    public function __construct(MaudeRegexIterator $iterator, MaudeFunctor $functor)
    {
        parent::__construct($iterator);
        $this->functor = $functor;

        $this->set_counters();
    } 

    public function accept() : bool
    {
       $bRc =  call_user_func($this->functor, $this->current()); // Pass \Ds\Vector to functor. Returns bool

       $this->advance_counters($bRc, "MaudeFilterIterator");
       
       return $bRc;
    }
 
}

