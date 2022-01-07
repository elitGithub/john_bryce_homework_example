<?php

namespace Elit1\ObjectOriented\Helpers;

class PreparedQMark2SqlValue
{
    private int $ctr;
    private mixed $vals;

    public function __construct ($vals)
    {
        $this->ctr = 0;
        $this->vals = $vals;
    }

    public function call ($matches)
    {
        /**
         * If ? is found as expected in regex used in function convert2sql
         * /('[^']*')|(\"[^\"]*\")|([?])/
         *
         */
        if ($matches[3] === '?') {
            $this->ctr++;
            return $this->vals[$this->ctr - 1];
        } else {
            return $matches[0];
        }
    }
}