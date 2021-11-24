<?php

namespace MPhpMaster\ZATCA\Tags;

class InvoiceTotalAmount extends \MPhpMaster\ZATCA\Tag
{
    const TAG = 4;

    public function __construct(string $value)
    {
        parent::__construct(static::TAG, $value);
    }
}
