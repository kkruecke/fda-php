<?php
namespace Maude;
use FilterIterator;

// MaudeFilterIterator that is configured by functions derived from Functor interface 

class MaudeFilterIterator implements \FilterIterator {

    $this->functor; 

    public function __construct(MaudeFieldExtractorIterator $iterator, Functor $functor)
    {
        parent::construct($iterator);
        $this->functor = $functor;
    } 

    public function accept() : bool
    {
       return $this->functor($this->current());
    }
}

