<?php
namespace Maude;

class DeviceTableInserter implements DatabaseInsertIterator, \Iterator {

  public function insert(\Ds\Vector $vec) : void;

}
