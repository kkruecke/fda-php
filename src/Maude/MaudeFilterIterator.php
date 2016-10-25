<?php
namespace Maude;
use FilterIterator;

// MaudeFilterIterator that is configured by functions derived from Functor interface 

class MaudeFilterIterator extends FilterIterator {

    private $functor; 

    public function __construct(MaudeRegexIterator $iterator, Functor $functor)
    {
        parent::__construct($iterator);
        $this->functor = $functor;
    } 

    public function accept() : bool
    {
       return $this->functor($this->current());
    }
}

