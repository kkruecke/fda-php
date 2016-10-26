<?php
namespace Maude;

interface MaudeFunctor {

    public function __invoke(\Ds\Vector $vector) : bool;
}

