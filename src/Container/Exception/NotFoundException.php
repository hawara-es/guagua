<?php

declare(strict_types=1);

namespace Guagua\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
    //
}
