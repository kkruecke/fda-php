<?<?php
namespace Maude;
 
class SplFileObjectExt extends \SplFileObject   { 

    private $position;

    public function __construct(string $filename, string $mode = 'r')
    {
       parent::__construct($filename, $mode);

       parent::setFlags(\SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

       $this->position = 1;
    }

    public function rewind() : void  // TODO: Isn't this what SplFileObject returns, anyway? Therefore can't I use it directly?
    {
        parent::rewind();
        $this->position = 1;
    }

    public function key() : int  // TODO: Isn't this what SplFileObject returns, anyway? Therefore can't I use it directly?
    {
        return $this->position;
    }

    public function next() : void // TODO: Isn't this what SplFileObject returns, anyway? Therefore can't I use it directly?
    {
        parent::next();

        if (parent::valid()) {

            ++$this->position; 
        }
    }
}
