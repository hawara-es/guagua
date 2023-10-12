<?php

declare(strict_types=1);

it('uses strict types')
    ->expect('Guagua')
    ->toUseStrictTypes();

it('uses a suffix for interfaces')
    ->expect('Guagua')
    ->interfaces()
    ->toHaveSuffix('Interface');
