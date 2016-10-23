<?php
namespace Maude;

// MaudeFilterIterator that is configured by functions derived from Functor interface 

class MaudeFilterIterator extends \FilterIterator {

    $this->functor; 

    public function __construct(\RegexIterator $iterator, Functor $functor)
    {
        parent::construct($iterator);
        $this->functor = $functor;
    } 

    public function accept() : bool
    {
       return $this->functor($this->current());
    }
}

