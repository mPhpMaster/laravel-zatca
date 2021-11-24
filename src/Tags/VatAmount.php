<?php

namespace MPhpMaster\ZATCA\Tags;

class VatAmount extends \MPhpMaster\ZATCA\Tag
{
    const TAG = 5;

    public function __construct(string $value)
    {
        parent::__construct(static::TAG, $value);
    }
}
