<?php
namespace Maude;

class TextTableInserter implements DatabaseInsertIterator, \Iterator {

  public function insert(\Ds\Vector $vec) : void;

}
?>
