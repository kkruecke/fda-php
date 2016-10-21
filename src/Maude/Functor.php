<?php
namespace Maude;

interface Functor {

  public function __invoke(int $mdr_report_key) : bool;
}

