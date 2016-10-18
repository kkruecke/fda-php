<?php
namespace Maude;

class MdrTableInserter implements DatabaseInsertIterator, \Iterator {

  public function insert(\Ds\Vector $vec) : void;

}
?>
