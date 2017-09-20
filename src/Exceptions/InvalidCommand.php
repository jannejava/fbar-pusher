<?php

namespace Eastwest\FBar\Exceptions;

use Exception;

class InvalidCommand extends Exception
{
    /**
     * @param string $reason
     *
     * @return \Eastwest\FBar\Exception\InvalidCommand
     */
    public static function create($reason)
    {
        return new static($reason);
    }
}
