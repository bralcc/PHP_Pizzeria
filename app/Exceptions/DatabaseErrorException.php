<?php
declare(strict_types= 1);
//DatabaseErrorException.php

namespace Exceptions;

class DatabaseErrorException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
