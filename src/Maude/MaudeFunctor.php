<?php
namespace Maude;

interface MaudeFunctor {
    // provide means to override function call operator
    public function __invoke(\Ds\Vector $vector) : bool;
}

