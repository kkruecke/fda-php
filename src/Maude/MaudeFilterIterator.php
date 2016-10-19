<?php
namespace Maude;

// Abstract base file class to be used by Device, Mdr and Text filter iterators that implement the is_new_record(\Ds\Vector) method.

abstract class MaudeFilterIterator extends FilterIterator {

    public function __construct(\Iterator $iterator)
    {
        parent::construct($iterator);
    } 

    public function accept() : bool
    {
       return is_new_record($this->current());
    }

    abstract protected function is_new_record(\Ds\Vector $vec) : bool; 
}
