<?php
namespace Maude;

interface Functor {

//--  public function __invoke(int $mdr_report_key) : bool;
    public function __invoke(\Ds\Vector $vector) : bool;
}

