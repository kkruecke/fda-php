<?php
namespace Maude;

trait CounterTrait {
  
    private $total_counter;
    private $accepted_counter;

   private function set_counters()
   {
        $this->total_counter = $this->accepted_counter = 0;
   }  

   private function advance_counters(bool $bAccepted)
   {
      ++$this->total_counter;

        if ($bAccepted)  ++$this->accepted_counter;

        if (($this->total_counter % 100000) == 0) {

            echo $this->total_counter . " rows have been read by ". get_class() . ". " . $this->accepted_counter . " have been accepted.\n";            
        }  
   }
}
?>
