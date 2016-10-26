<?php
namespace Maude;
use FilterIterator;

// MaudeFilterIterator is configured by functions derived from Functor interface 

class MaudeFilterIterator extends FilterIterator {

    private $functor; 

    public function __construct(MaudeRegexIterator $iterator, MaudeFunctor $functor)
    {
        parent::__construct($iterator);
        $this->functor = $functor;
    } 

    public function accept() : bool
    {
       return  call_user_func($this->functor, $this->current()); // Pass \Ds\Vector to functor.
    }
}

