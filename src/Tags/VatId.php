<?php

namespace MPhpMaster\ZATCA\Tags;

class VatId extends \MPhpMaster\ZATCA\Tag
{
    const TAG = 2;

    public function __construct(string $value)
    {
        parent::__construct(static::TAG, $value);
    }
}
