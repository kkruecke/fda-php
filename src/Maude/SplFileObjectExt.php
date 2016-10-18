<?<?php
namespace Maude;
 
class SplFileObjectExt extends \SplFileObject   { 

    private $line_no;

    public function __construct(string $filename, string $mode = 'r')
    {
       parent::__construct($filename, $mode);

       parent::setFlags(\SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

       $this->line_no = 1;
    }

    public functon current() : string
    {
      // TODO: Implement

    }

    public function rewind() : void 
    {
        parent::rewind();
        $this->line_no = 1;
    }

    public function key() : int  
    {
        return $this->line_no;
    }

    public function next() : void 
    {
        parent::next();

        if (parent::valid()) {

            ++$this->line_no; 
        }
    }
}
