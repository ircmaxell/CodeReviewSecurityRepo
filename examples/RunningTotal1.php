<?php

class RunningTotalIterator extends ArrayIterator
{
    private $sum;

    public function rewind()
    {
        parent::rewind();
        if ($this->valid()) {
            $this->sum = parent::current();
        }
    }

    public function current()
    {
        return $this->sum;
    }

    public function next()
    {
        parent::next();
        if ($this->valid()) {
            $this->sum += parent::current();
        }
    }
}

$result = iterator_to_array(new RunningTotalIterator(array(23, 18, 5, 8, 10, 16)));
print_r($result);