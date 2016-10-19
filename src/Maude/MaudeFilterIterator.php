<?php
namespace Maude;

// Abstract base file class to be used by Device, Mdr and Text filter iterators that implement the is_new_record(\Ds\Vector) method.

abstract class MaudeFilterIterator extends FilterIterator {

    public function __construct(\Iterator $iterator)
    {
        setFilterCriteria()
        parent::construct($iterator);
    } 

    abstract protected function bool apply_filter(\Ds\Vector $v) : bool;

    public function accept() : bool
    {
       return apply_filter($this->current());
    }

    abstract protected function is_new_record(\Ds\Vector $vec) : bool; 
}
